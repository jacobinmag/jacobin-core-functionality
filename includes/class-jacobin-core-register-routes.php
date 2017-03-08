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
        'args'        => array(
          'slug'    => array(
            'description' => esc_html__( 'The slug parameter is used to retrieve a set of featured content items', 'jacobin-core' ),
            'type'        => 'string',
            'enum'        => array(
              'home-feature',
              'home-1',
              'home-2',
              'home-3',
              'home-4',
              'home-5',
              'editors-picks'
            ),
          )
        )
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
    	) );

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
     * Get Home Feature
     *
     * @since 0.1.14
     *
     * @uses Jacobin_Rest_API_Routes::get_featured_content()
     *
     * @return array $posts
       */
    public function get_home_feature() {
        return $this->get_featured_content( 'options_home_feature' );
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
     *
     * @param array $request
     * @return array|WP_Error
     */
    public function get_featured_content( $request ) {

        $slug  = $request->get_param( 'slug' );

        $options = array(
          'home-feature'  => 'options_home_feature_featured_post_1',
          'home-1'        => 'options_home_1_featured_posts_5',
          'home-2'        => 'options_home_2_featured_posts_5',
          'home-3'        => 'options_home_3_featured_posts_5',
          'home-4'        => 'options_home_4_featured_posts_10',
          'home-5'        => 'options_home_5_featured_posts_15',
          'editors-picks' => 'options_editors_pick_featured_posts_5'
        );

        $option = get_option( $options[$slug] );

        if( empty( $option ) || is_wp_error( $option ) ) {
            return new WP_Error( 'rest_no_posts', __( 'No posts were found', 'jacobin-core' ), array( 'status' => 404 ) );
        }

        $posts_ids = array_map(
            function( $value ) {
                return (int) $value;
            },
            $option
        );

        $posts = array_map(
            function( $post_id ) {
                $post_detail = get_post( $post_id );

                $post = new stdClass();

                $post->{"id"} = $post_detail->ID;
                $post->{"date"} = $post_detail->post_date;
                $post->{"title"}["rendered"] = esc_attr( $post_detail->post_title );
                $post->{"subhead"} = get_post_meta( $post_id, 'subhead', true );
                $post->{"excerpt"}["rendered"] = esc_attr( $post_detail->post_excerpt );
                $post->{"slug"} = $post_detail->post_name;
                $post->{"authors"} = jacobin_get_authors_array( $post_id );
                $post->{"departments"} = jacobin_get_post_terms( $post_id, 'department' );

                $image_id = get_post_thumbnail_id( $post_id );
                $post->{"featured_image"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

                return $post;
            },
            $posts_ids
        );

    	return $posts;
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

}

new Jacobin_Rest_API_Routes();
