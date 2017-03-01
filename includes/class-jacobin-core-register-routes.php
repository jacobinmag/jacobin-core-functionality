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
        register_rest_route( 'jacobin', '/featured-content/home-feature/', array(
    		'methods'     => 'GET',
    		'callback'    => array( $this, 'get_home_feature' ),
    	) );

        register_rest_route( 'jacobin', '/featured-content/home-content/', array(
    		'methods'     => 'GET',
    		'callback'    => array( $this, 'get_home_content' ),
    	) );

    	register_rest_route( 'jacobin', '/featured-content/editors-picks/', array(
    		'methods'     => 'GET',
    		'callback'    => array( $this, 'get_editors_picks' ),
    	) );

      register_rest_route( 'jacobin', '/guest-author/(?P<id>\d+)', array(
    		'methods'     => 'GET',
    		'callback'    => array( $this, 'get_guest_author' ),
        'args' => array(
    			'id' => array(
    				'validate_callback' => function( $param, $request, $key ) {
    					return ( is_numeric( $param ) && 'guest-author' == get_post_type( $param ) );
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
    public function get_home_content() {
        return $this->get_featured_content( 'options_home_content' );
    }

    /**
     * Get Featured Content
     *
     * @since 0.1.14
     *
     * @param array $option_name
     * @return array|false
     */
    public function get_featured_content( $option_name ) {

        $option = get_option( $option_name  );

        if( empty( $option ) || is_wp_error( $option ) ) {
            return false;
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
     *
     * @since 0.2.5
     *
     * @uses jacobin_get_coauthor_meta()
     *
     * @param obj $data
     * @return array coauthor_meta
     */
    public function get_guest_author( $data ) {
      $author_id = $data['id'];

      return jacobin_get_coauthor_meta( $author_id  );
    }

}

new Jacobin_Rest_API_Routes();
