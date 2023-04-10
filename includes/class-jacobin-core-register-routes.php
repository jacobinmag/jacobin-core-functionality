<?php
/**
 * Jacobin Core Register Routes with REST API
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.14
 * @license    GPL-2.0+
 */

/**
 * Register Fields with REST API
 *
 * This file registers fields with REST API.
 *
 * @since 0.1.0
 */
class Jacobin_Rest_API_Routes {

	/**
	 * Namespace
	 *
	 * @since 0.2.7
	 *
	 * @var string
	 */
	private $namespace = 'jacobin';

	/**
	 * Date format
	 * 
	 * @since 0.5.18
	 *
	 * @var string
	 */
	public $date_format = 'Y-m-d\TH:i:s';

	/**
	 * Initialize all the things
	 *
	 * @since 0.1.14
	 */
	function __construct () {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register Routes
	 *
	 * @uses register_rest_route()
	 * @link https://developer.wordpress.org/reference/functions/register_rest_route/
	 * @return void
	 */
	public function register_routes () {

		register_rest_route( $this->namespace, '/featured-content', array(
			  'methods'     => 'GET',
			  'callback'    => array( $this, 'get_featured_content' ),
			  'args'                => array(
			  'slug'    => array(
				  'description' => esc_html__( 'The slug parameter is used to retrieve a set of featured content items', 'jacobin-core' ),
				  'type'        => 'string',
				  'enum'        => array(
				  'home-content',
				  'editors-picks',
				  'section-topics',
				  ),
				  'required'    => true
			  ),
			  'permission_callback' => '__return_true',
			),
		) );
  
		register_rest_route( $this->namespace, '/featured-content/(?P<slug>[a-zA-Z0-9-]+)', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_featured_content' ),
			'args' => array(
				'slug' => array(
					'validate_callback' => function( $param, $request, $key ) {
						return ( is_string( $param ) );
					}
				),
			),
			'permission_callback' => '__return_true',
		) );
  
		register_rest_route( $this->namespace, '/guest-author', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_guest_author' ),
			'args' => array(
				'slug' => array(
					'description' => esc_html__( 'The author term slug parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'string',
					'validate_callback' => function( $param, $request, $key ) {
						return ( is_string( $param ) );
					}
				),
				'term_id' => array(
					'description' => esc_html__( 'The author term ID parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'number',
						'validate_callback' => function( $param, $request, $key ) {
							return ( is_numeric( $param ) );
						}
					),
				'id' => array(
					'description' => esc_html__( 'The guest author id parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'number',
					'validate_callback' => function( $param, $request, $key ) {
						return ( is_numeric( $param ) && 'guest-author' == get_post_type( $param ) );
					}
				),
			),
			'permission_callback' => '__return_true',
		) );
  
		register_rest_route( $this->namespace, '/guest-author/(?P<id>\d+)', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_guest_author' ),
			'args' => array(
				'term_id' => array(
					'validate_callback' => function( $param, $request, $key ) {
						return ( is_numeric( $param ) );
					}
				),
			),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/featured-content/(?P<slug>[a-zA-Z0-9-]+)', array(
		register_rest_route( $this->namespace, '/guest-authors', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_featured_content' ),
			'callback'    => array( $this, 'get_guest_authors' ),
			'args' => array(
					'slug' => array(
				'per_page' => array(
					'description' => esc_html__( 'The number of items to return', 'jacobin-core' ),
					'type'        => 'number',
						'validate_callback' => function( $param, $request, $key ) {
							return ( is_string( $param ) );
							return ( is_numeric( $param ) );
						}
					),
				),
			),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/guest-author', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_guest_author' ),
			'args' => array(
				'slug' => array(
					'description' => esc_html__( 'The author term slug parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'string',
						'validate_callback' => function( $param, $request, $key ) {
							return ( is_string( $param ) );
						}
				),
				'term_id' => array(
					'description' => esc_html__( 'The author term ID parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'number',
						'validate_callback' => function( $param, $request, $key ) {
							return ( is_numeric( $param ) );
						}
				),
				'id' => array(
					'description' => esc_html__( 'The guest author id parameter is used to retrieve a guest author', 'jacobin-core' ),
					'type'        => 'number',
						'validate_callback' => function( $param, $request, $key ) {
							return ( is_numeric( $param ) && 'guest-author' == get_post_type( $param ) );
						}
				),
			),
			'permission_callback' => '__return_true',
		) );

		register_rest_route( $this->namespace, '/guest-author/(?P<id>\d+)', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_guest_author' ),
			'args' => array(
				'term_id' => array(
					'validate_callback' => function( $param, $request, $key ) {
						return ( is_numeric( $param ) );
					}
				),
			),
			'permission_callback' => '__return_true',
		) );
	  
		register_rest_route( $this->namespace, 'search', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_search' ),
			'permission_callback' => '__return_true',
		) );

	  /**
	   * Article Contributors
	   * 
	   * @since 0.5.12
	   */
		register_rest_route( $this->namespace, '/post-contributors/(?P<id>\d+)', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_contributors' ),
			'args' => array(
				'id' => array(
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
			},
			'required' => true
				),
			),
			'permission_callback' => '__return_true',
	  ) );

	  /**
	   * Contributor's Posts
	   * 
	   * @since 0.5.13
	   */
		register_rest_route( $this->namespace, '/contributor-posts/(?P<id>\d+)', array(
			'methods'     => 'GET',
			'callback'    => array( $this, 'get_contributor_posts' ),
			'args' => array(
				'id' => array(
					'validate_callback' => function ($param, $request, $key) {
						return is_numeric($param);
					},
					'required' => true
				),
			),
			'permission_callback' => '__return_true',
		));

	}

	/**
	 * Get Editor's Picks
	 *
	 * @since 0.1.14
	 *
	 * @uses Jacobin_Rest_API_Routes::get_featured_content()
	 *
	 * @return array $posts
	 */
	public function get_editors_picks() {
		return $this->get_featured_content( 'options_editors_pick' );
	}

	/**
	 * Get Home Featured Content
	 *
	 * @since 0.1.14
	 *
	 * @uses Jacobin_Rest_API_Routes::get_featured_content()
	 *
	 * @return array $posts
	   */
	public function get_home_feature() {
		return $this->get_featured_content( 'options_featured_article' );
	}

	/**
	 * Get Home Content
	 *
	 * @since 0.1.16
	 *
	 * @uses Jacobin_Rest_API_Routes::get_featured_content()
	 *
	 * @return array $posts
	 */
	public function get_home_content( $request ) {
		return $this->get_featured_content( 'options_home_content' );
	}

	/**
	 * Get Featured Content
	 *
	 * @since 0.1.14
	 * @since 0.4.12
	 * @since 0.4.13
	 *
	 * @param array $request
	 * @return mixed array || WP_Error
	 */
	public function get_featured_content( $request ) {

		$slug  = $request->get_param( 'slug' );
		$posts_per_page = $request->get_param( 'per_page' );
		$page = $request->get_param( 'page' );

		$options = array(
			'home-content'      => 'options_home_content',
			'editors-picks'     => 'options_editors_pick',
			'section-topics'    => 'options_section_topics'
		);

		/* Response at /wp-json/jacobin/featured-content/home-content */
		if( 'options_section_topics' === $options[$slug] ) {

			$response['home_content_1'] = wp_kses_post( get_option( 'options_home_content_1' ) );
			$response['home_content_2'] = wp_kses_post( get_option( 'options_home_content_2' ) );
			$response['home_content_3'] = wp_kses_post( get_option( 'options_home_content_3' ) );
			$response['home_content_tag'] = get_term_by( 'id', intval( get_option( 'options_home_content_tag' ) ), 'post_tag' );
			$response['home_content_category'] = get_term_by( 'id', intval( get_option( 'options_home_content_category' ) ), 'category' );
			$response['home_content_series'] = get_term_by( 'id', intval( get_option( 'options_home_content_series' ) ), 'series' );

			return $response;

		}

		$option = get_option( $options[$slug] );

		if( empty( $option ) || is_wp_error( $option ) ) {
			return new WP_Error( 'rest_no_posts_set', __( 'No posts were set', 'jacobin-core' ), array( 'status' => 404 ) );
		}

		$posts_ids = array_map(
			function( $value ) {
				return (int) $value;
			},
			$option
		);

		$args = array(
		  'post__in'    => $posts_ids,
		  'orderby'     => 'post__in'
		);

		if( isset( $posts_per_page ) ) {
		  $args['posts_per_page'] = $posts_per_page;
		}

		if( isset( $page ) ) {
		  $args['paged'] = $page;
		}

		$posts = get_posts( $args );

		if( empty( $posts ) ) {
		  return new WP_Error( 'rest_no_posts', __( 'No posts were found', 'jacobin-core' ), array( 'status' => 404 ) );
		}

		$response = array_map(
			function( $post ) {
				$post_id = $post->ID;

				$post_data = new stdClass();

				$post_data->{"id"} = $post->ID;
				$post_data->{"date"} = date( $this->date_format, strtotime( $post->post_date ) );
				$post_data->{"title"}["rendered"] = get_the_title( $post_id );
				$post_data->{"subhead"} = apply_filters( 'meta_content', get_post_meta( $post_id, 'subhead', true ) );
				$post_data->{"excerpt"}["rendered"] = jacobin_core_custom_excerpt( $post );
				$post_data->{"slug"} = $post->post_name;
				$post_data->{"authors"} = jacobin_get_authors_array( $post_id );
				$post_data->{"departments"} = jacobin_get_post_terms( $post_id, 'department' );
				$post_data->{"categories"} = jacobin_get_post_terms( $post_id, 'category' );

				$image_id = get_post_thumbnail_id( $post_id );
				$post_data->{"featured_image"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

				return $post_data;
			},
			$posts
		);

		return $response;
	}

	/**
	 * Get Guest Author Meta
	 * Retrieves Guest Author by slug, id or term_id (associated `author` term id)
	 *
	 * @since 0.2.5
	 *
	 * @uses jacobin_get_coauthor_meta()
	 * 
	 * @param obj $request
	 * @return array coauthor_meta
	 */
	public function get_guest_author( $request ) {

	  $author_id = $request->get_param( 'id' );

	  if( $author_id ) {
		return jacobin_get_coauthor_meta( $author_id  );
	  }

	  $term_id = $request->get_param( 'term_id' );
	  $slug = $request->get_param( 'slug' );

	  $args = array(
		'posts_per_page' => 1,
		'post_type' => 'guest-author',
	  );

	  if( $term_id ) {

		$args['tax_query'][] = array(
		  'taxonomy'  => 'author',
		  'terms'     => intval( $term_id ),
		  'field'     => 'term_id'
		);

	  } elseif( $slug ) {

		$args['name'] = $slug;

	  } else {
		return new WP_Error( 'rest_param_invalid', __( 'No valid parameter provided.', 'jacobin-core' ), array( 'status' => 400 ) );
	  }

	  $author_post = get_posts( $args );

	  if( empty( $author_post ) ) {
		return new WP_Error( 'rest_no_posts', __( 'No guest author with this term_id or slug was found.', 'jacobin-core' ), array( 'status' => 404 ) );
	  }

	  $author_id = $author_post[0]->ID;

	  return jacobin_get_coauthor_meta( $author_id  );
	}

	/**
	 * Relevanssi Search
	 * Custom endpoint do search using Relevanssi search plugin
	 * 
	 * @uses relevanssi_do_query()
	 * 
	 * @link https://www.relevanssi.com/knowledge-base/relevanssi_do_query/
	 *
	 * Usage:   /wp-json/jacobin/search/?s=sanders
	 *          /wp-json/jacobin/search/?s=sanders&per_page=5
	 *          /wp-json/jacobin/search/?s=sanders&per_page=5&page=2
	 *
	 * @param obj $request
	 * @return mixed array || WP_Error
	 */
	public function get_search( $request ) {
	  $parameters = $request->get_query_params();

	  $posts_per_page = ( isset( $parameters['per_page'] ) ) ? (int) $parameters['per_page'] : get_option( 'posts_per_page' );
	
	  $args = array(
		's'               => $parameters['s'],
		'posts_per_page'  => $posts_per_page
	  );

	  if( isset( $parameters['page'] ) ) {
		$args['paged'] = (int) $parameters['page'];
	  }

	  if( function_exists( 'relevanssi_do_query' ) ) {
		$query = new WP_Query();
		$query->parse_query( $args );

		relevanssi_do_query( $query );
	  } else {
		$query = new WP_Query( $args );
	  }

	  /**
	   * No posts
	   */
	  if( empty( $query->posts ) ) {
		/**
		 * Return empty array if no posts found
		 * 
		 * @since 0.5.9
		 */
		$data = $query->posts;
		// return new WP_Error( 'no_posts', __( 'No post found', 'core-functionality' ) , array( 'status' => 404 ) );
		$response = new WP_REST_Response( $data, 200 );
		return $response;
	  }

	  $max_pages = $query->max_num_pages;
	  $total = $query->found_posts;

	  /**
	   * If page number requested is greater than the total number of pages, bail
	   */
	  if( isset( $parameters['page'] ) && $parameters['page'] > $max_pages ) {
		return new WP_Error( 'rest_post_invalid_page_number', __( 'The page number requested is larger than the number of pages available.', 'core-functionality' ), array( 'status' => 400 ) );
	  }

	  $posts = $query->posts;
	  $controller = new WP_REST_Posts_Controller( 'post' );
  
	  foreach ( $posts as $post ) { 
		$response = $controller->prepare_item_for_response( $post, $request );
		$data[] = $controller->prepare_response_for_collection( $response );
	  };
	
	  $response = new WP_REST_Response( $data, 200 );
	  $response->header( 'X-WP-Total', $total );
	  $response->header( 'X-WP-TotalPages', $max_pages );

	  return $response;
	
	}

	/**
	 * Article Contributors
	 * Get the articles contributors
	 * 
	 * Usage:   /wp-json/jacobin/post-contributors/{:id}
	 * 
	 * @since 0.5.12
	 * 
	 * @param obj $request
	 * @return array $response
	 */
	public function get_contributors( $request ) {
	  if( !function_exists( 'get_coauthors' ) ) {
		return $response = new WP_REST_Response( [], 200 );
	  }

	  $response_data = [];

	  $parameters = $request->get_params();

	  $post_id = intval( $parameters['id'] );
	  
	  if( $authors_data = get_coauthors( $post_id ) ) {
		$authors = wp_list_pluck( $authors_data, 'display_name' );

		foreach( $authors as $author ) {
		  $response_data[$author][] = 'author';
		}
	  }

	  if( $interviewer_ids = get_post_meta( (int) $post_id, 'interviewer', true ) ) {
		$interviewers_data = jacobin_get_guest_author_meta_for_field( $post_id, 'interviewer' );
		$interviewers = wp_list_pluck( $interviewers_data, 'display_name' );

		foreach( $interviewers as $interviewer ) {
		  $response_data[$interviewer][] = 'interviewer';
		}
	  }

	  if( $translator_ids = get_post_meta( (int) $post_id, 'translator', true ) ) {
		$translators_data = jacobin_get_guest_author_meta_for_field( $post_id, 'translator' );
		$translators = wp_list_pluck( $translators_data, 'display_name' );

		foreach( $translators as $translator ) {
		  $response_data[$translator][] = 'translator';
		}
	  }
  
	  $response = new WP_REST_Response( $response_data, 200 );

	  return $response;
	}

	/**
	 * Contributor posts
	 * Get the contributor's articles
	 * 
	 * Usage:   /wp-json/jacobin/contributor-posts/{:id}
	 *          /wp-json/jacobin/contributor-posts/{:id}?per_page=5
	 *          /wp-json/jacobin/contributor-posts/{:id}?per_page=5&page=2
	 * 
	 * 1. The subhead/dek
	 * 2. The list of authors for the post (Right now it's just a single post_author ID that doesn't actually seem to correspond to who the author is). In that list I'll at least need each author's ID, slug, and name.
	 * 3. The interviewer (ID, slug, and name)
	 * 4. The translator (ID, slug, and name)
	 * 5. The format (ID, slug, and name)
	 * 6. The tags (ID, slug, and name)

	 * As for information we don't need:
	 * 1. post_content
	 * 2. post_excerpt

	 * @since 0.5.15
	 * 
	 * @param obj $request
	 * @return array $response
	 */
	public function get_contributor_posts( $request ) {
	  if( !function_exists( 'get_coauthors' ) ) {
		return $response = new WP_REST_Response( [], 200 );
	  }

	  global $coauthors_plus;

	  if( !isset( $coauthors_plus ) ) {
		return $response = new WP_REST_Response( [], 200 );
	  }

	  $parameters = $request->get_params();

	  $user_id = intval( $parameters['id'] );

	  $coauthor_data = $coauthors_plus->get_coauthor_by( 'id', $user_id );
	  $author_name = $coauthor_data->user_nicename;

	  $defaults = array(
		'post_type'       => 'post',
		'posts_per_page'  => 500,
		'fields'          => 'ids'
	  );

	  $author_args = array_merge( $defaults, [ 'author_name' => $author_name ] );

	  // Get post ID for which $user_id is author
	  $author_query = new WP_Query( $author_args );

	  $pattern =  sprintf( ':"%d";', $user_id );

	  $meta_query = array(
		'relation' => 'OR',
		array(
			'key'     => 'interviewer',
			'value'   => $pattern,
			'compare' => 'LIKE',
		),
		array(
			'key'     => 'translator',
			'value'   => $pattern,
			'compare' => 'LIKE',
		),
	  );

	  // Get post IDs for which $user_id is `translator` or `interviewer`
	  $contributor_args = array_merge( $defaults, [ 'meta_query' => $meta_query ] );

	  $contributor_query = new WP_Query( $contributor_args );

	  // Merge the ID and remove duplicates
	  $post_ids = array_unique( array_merge( $author_query->posts, $contributor_query->posts ) );

	  /**
	   * Get all the posts
	   */
	  $posts_per_page = ( isset( $parameters['per_page'] ) ) ? (int) $parameters['per_page'] : get_option( 'posts_per_page' );

	  $args = array(
		  'post__in'		=> $post_ids,
		  'posts_per_page'	=> $posts_per_page
	  );

	  if( isset( $parameters['page'] ) ) {
		$args['paged'] = (int) $parameters['page'];
	  }

	  $posts_query = new WP_Query( $args );

	  $max_pages = $posts_query->max_num_pages;
	  $total = $posts_query->found_posts;

	  $response_data = [];

	  if( !empty( $posts_query->posts ) ) {
		$response_data = array_map(
			function( $post ) {
				$post_id = $post->ID;

				$post_data = new stdClass();

				$post_data->{"coauthor"} = $coauthor_data;
				$post_data->{"id"} = $post->ID;
				$post_data->{"date"} = date( $this->date_format, strtotime( $post->post_date ) );
				$post_data->{"title"}["rendered"] = get_the_title( $post_id );
				$post_data->{"subhead"} = apply_filters( 'meta_content', get_post_meta( $post_id, 'subhead', true ) );
				$post_data->{"excerpt"}["rendered"] = jacobin_core_custom_excerpt( $post );
				$post_data->{"slug"} = $post->post_name;
				$post_data->{"authors"} = jacobin_get_authors_array( $post_id );
				$post_data->{"departments"} = jacobin_get_post_terms( $post_id, 'department' );
				$post_data->{"locations"} = jacobin_get_post_terms( $post_id, 'location' );
				$post_data->{"categories"} = jacobin_get_post_terms( $post_id, 'category' );
				$post_data->{"tags"} = jacobin_get_post_terms( $post_id, 'post_tag' );
				$post_data->{"formats"} = jacobin_get_post_terms( $post_id, 'format' );

				$post_data->{"interviewer"} = false;
				$post_data->{"translator"} = false;
				
				if( $interviewer_ids = get_post_meta( (int) $post_id, 'interviewer', true ) ) {
					$post_data->{"interviewer"} = jacobin_get_guest_author_meta_for_field( $post_id, 'interviewer' );
				}
			
				if( $translator_ids = get_post_meta( (int) $post_id, 'translator', true ) ) {
					$post_data->{"translator"} = jacobin_get_guest_author_meta_for_field( $post_id, 'translator' );
				}

				$image_id = get_post_thumbnail_id( $post_id );
				$post_data->{"featured_image"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

				return $post_data;
			},
			$posts_query->posts
		);		  
	  }

	  $response = new WP_REST_Response( $response_data, 200 );
	  $response->header( 'X-WP-Total', (int) $total );
	  $response->header( 'X-WP-TotalPages', (int) $max_pages );

	  return $response;

	}

}
new Jacobin_Rest_API_Routes();