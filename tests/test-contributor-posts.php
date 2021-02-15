<?php
/**
 * Class ContributorPosts
 *
 * @package Jacobin_Core_Functionality
 */

/**
 * Sample test case.
 */
class ContributorPosts extends WP_UnitTestCase {

	/**
	 * REST namespace
	 *
	 * @var string
	 */
	public $namespace = 'jacobin/contributor-posts';

		/**
	 * Request string
	 *
	 * @var string
	 */
	public $request_string;

	/**
	 * REST Server
	 *
	 * @var obj
	 */
	protected $server;

	/**
	 * Number of posts
	 *
	 * @var integer
	 */
	public $expected_post_count = 21;

	/**
	 * Number of coauthors
	 *
	 * @var integer
	 */
	public $expected_coauthor_count = 3;

	/**
	 * Coauthor IDs
	 *
	 * @var array
	 */
	public $expected_coauthor_ids = array();

	/**
	 * Post IDs expected to be returned
	 *
	 * @var array
	 */
	public $expected_post_ids;

	/**
	 * ID to searh
	 *
	 * @var integar
	 */
	public $search_coauthor_id;

	/**
	 * Construct
	 */
	function __construct() {}

	/**
	 * Set it up
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		/** @var WP_REST_Server $wp_rest_server */
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server;

		do_action( 'rest_api_init' );

		$this->force_activate( 'co-authors-plus/co-authors-plus.php' );

		$this->create_coauthors();

		$this->search_coauthor_id = (int) $this->expected_coauthor_ids[0];

		// $this->create_posts();

		$this->request = $this->namespace . '/' . $this->search_coauthor_id;	
	}

	/**
	 * Shut it down
	 *
	 * @return void
	 */
    public function tearDown() {
        parent::tearDown();

        global $wp_rest_server;
        $wp_rest_server = null;
    }

	/**
	 * Activate dependencies
	 *
	 * @param string $plugin
	 * @return void
	 */
	function force_activate( $plugin ) {	
		if( ! is_plugin_active( $plugin ) ) {
			activate_plugin( $plugin );
		}
	}

	/**
	 * Create coauthors
	 *
	 * @return void
	 */
	function create_coauthors() {
		global $coauthors_plus;

		for ( $i = 1; $i <= $this->expected_coauthor_count; $i++ ) {
			$coauthor = $coauthors_plus->guest_authors->create( array(
				'display_name' 	=> "Guest Author {$i}",
				'user_login' 	=> "guest-author-{$i}",
				'user_email' 	=> "guestauthor{$i}@email.com",
				'first_name' 	=> "First {$i}",
				'last_name' 	=> "Last {$i}",
				'website' 		=> "https://fakesite{$i}.com",
				'description' 	=> "Guest {$i} bio.",
			) );
			$this->expected_coauthor_ids[] = $coauthor;
		}

	}

	/**
	 * Create posts
	 *
	 * @return void
	 */
	function create_posts() {
		global $coauthors_plus;

		$posts = [];
		$expected_post_ids = [];
		$is_expected = false;

		for( $i = 1; $i <= $this->expected_post_count; $i++ ) {

			switch( $i ) {
				//author matches - true
				case $i >= 1 && $i <= 3 :
					$author = (array) $this->search_coauthor_id;
					$interviewer = (array) $this->expected_coauthor_ids[1];
					$translator = (array) $this->expected_coauthor_ids[2];
					$is_expected = true;
					break;
				//interviewer matches
				case $i > 3 && $i <= 6 :
					$author = (array) $this->expected_coauthor_ids[1];
					$interviewer = (array) $this->search_coauthor_id;
					$translator = (array) $this->expected_coauthor_ids[2];
					$is_expected = true;
					break;
				//translator matches
				case $i > 6 && $i <= 9 :
					$author = (array) $this->expected_coauthor_ids[2];
					$interviewer = (array) $this->expected_coauthor_ids[1];
					$translator = (array) $this->search_coauthor_id;
					$is_expected = true;
					break;
				//no matches
				case $i > 9 && $i <= 12 :
					$author = (array) $this->expected_coauthor_ids[1];
					$interviewer = (array) $this->expected_coauthor_ids[2];
					$translator = (array) $this->expected_coauthor_ids[1];
					break;
				//Multiple authors, one author matches
				case $i > 12 && $i <= 15 :
					$author = array(
						$this->expected_coauthor_ids[2],
						$this->search_coauthor_id
					);
					$interviewer = (array) $this->expected_coauthor_ids[1];
					$translator = (array) $this->expected_coauthor_ids[2];
					$is_expected = true;
					break;
				//author and interviewer match
				case $i > 15 && $i <= 18 :
					$author = array(
						$this->expected_coauthor_ids[1],
						$this->search_coauthor_id
					);
					$interviewer = array(
						$this->expected_coauthor_ids[2],
						$this->search_coauthor_id
					);
					$translator = (array) $this->expected_coauthor_ids[2];
					$is_expected = true;
					break;
				//interview and translator match
				case $i > 18 && $i <= 21 :
					$author = (array) $this->expected_coauthor_ids[1];
					$interviewer = array(
						$this->expected_coauthor_ids[2],
						$this->search_coauthor_id
					);
					$translator = array(
						$this->expected_coauthor_ids[1],
						$this->search_coauthor_id
					);
					$is_expected = true;
					break;
			}

			$post_id = $this->factory->post->create( array( 
				'post_title' => "Test Post {$i}",
			) );

			// $coauthor_data = $coauthors_plus->get_coauthor_by( 'id', (int) $author );
			// $author_name = $coauthor_data->user_nicename;

			// $coauthors_plus->add_coauthors( $post_id, $author );

			$coauthors_plus->add_coauthors( $post_id, $author, false, 'ID' );

			$fields = array(
				'meta_input' 			=> array(
					'interviewer' 			=> $interviewer,
					'translator' 			=> $translator
				)
			);

			$this->factory->post->update_object( $post_id, $fields );

			$posts[] = $post_id;


			if( $is_expected ) {
				$expected_post_ids[] = $post_id;
			}

		}

		$this->expected_post_ids = array_unique( $expected_post_ids );
	}

	/**
	 * Get an array of coauthor IDs
	 *
	 * @param array $args
	 * @return array $return
	 */
	function get_coauthor_ids( $args = array() ) {
		global $coauthors_plus;
	
		$defaults = array(
			'optioncount'        		=> false,
			'show_fullname'      		=> false,
			'hide_empty'         		=> false,
			'echo'               		=> false,
			'style'              		=> 'list',
			'html'               		=> false,
			'number'           	 		=> 200,
			'guest_authors_only' 		=> false,
			'authors_with_posts_only' 	=> false,
		);
	
		$args = wp_parse_args( $args, $defaults );

		$return = [];
	
		$term_args = array(
			'orderby'      => 'name',
			'number'       => (int) $args['number'],
			/*
			 * Historically, this was set to always be `0` ignoring `$args['hide_empty']` value
			 * To avoid any backwards incompatibility, inventing `authors_with_posts_only` that defaults to false
			 */
			'hide_empty'   => (boolean) $args['authors_with_posts_only'],
		);
		$author_terms = get_terms( $coauthors_plus->coauthor_taxonomy, $term_args );
	
		$authors = array();
		foreach ( $author_terms as $author_term ) {
			if ( false === ( $coauthor = $coauthors_plus->get_coauthor_by( 'user_login', $author_term->name ) ) ) {
				continue;
			}
	
			$authors[ $author_term->name ] = $coauthor;
	
			// only show guest authors if the $args is set to true
			if ( ! $args['guest_authors_only'] ||  $authors[ $author_term->name ]->type === 'guest-author' ) {
				$authors[ $author_term->name ]->post_count = $author_term->count;
			}
			else {
				unset( $authors[ $author_term->name ] );
			}
		}
	
		$authors = apply_filters( 'coauthors_wp_list_authors_array', $authors );
	
		// remove duplicates from linked accounts
		$linked_accounts = array_unique( array_column( $authors, 'linked_account' ) );
		foreach ( $linked_accounts as $linked_account ) {
			unset( $authors[$linked_account] );
		}
	
		foreach ( (array) $authors as $author ) {
			$return[] = (int) $author->ID;
		}
	
		return $return;
	}

	/**
	 * Test that correct coauthors were created
	 *
	 * @return void
	 */
	function test_creates_correct_coauthor_ids() {
		$actual_coauthor_ids = $this->get_coauthor_ids();

		$this->assertEqualSets( $this->expected_coauthor_ids, $actual_coauthor_ids );
	}

	// /**
	//  * Test that correct number of posts created
	//  *
	//  * @return void
	//  */
	// function test_creates_correct_number_of_posts() {
	// 	$actual_post_count = wp_count_posts();

	// 	$this->assertSame( $this->expected_post_count, (int) $actual_post_count->publish, "Test that correct number of posts created" );
	// }

	/**
	 * Test the route exists
	 *
	 * @return void
	 */
	public function test_register_route() {

		$route = '/jacobin/contributor-posts/(?P<id>\d+)';
		
		$request  = new WP_REST_Request( 'GET', $this->request );

		var_dump( $request );

		$response = $this->server->dispatch( $request );

		$this->assertEquals( 200, $response->get_status() );

		// $data = $response->get_data();
		// $this->assertArrayHasKey( 'ID', $data );
		// // $this->assertEquals( 'shawn', $data[ 'name' ] );
		// $routes = $this->server->get_routes();

		// $this->assertArrayHasKey( $this->namespace, $routes );
	}

	// /**
	//  * Test that expected number of posts match
	//  *
	//  * @return void
	//  */
	// function test_creates_correct_number_of_matching_posts() {
	// 	$posts = wp_remote_get( $this->request );

	// 	$actual_matching_post_count = count( $posts );
	// 	$expected_matching_post_count = count( $this->expected_post_ids );

	// 	$this->assertSame( $expected_matching_post_count, $actual_matching_post_count, "Test that expected number of posts match." );
	// }

	// /**
	//  * Test that returned post ID match expected post IDs
	//  *
	//  * @return void
	//  */
	// function test_returns_post_ids_where_coauthor_is_author_interviewer_or_translator() {
	// 	$posts = wp_remote_get( $this->request );
	// 	$actual_post_ids = wp_list_pluck( $posts, 'ID' );

	// 	$this->assertEqualSets( $this->expected_post_ids, $actual_post_ids );
	// }
}
