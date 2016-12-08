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
        add_action( 'rest_api_init', array( $this, 'register_route' ) );
    }

    public function register_route () {
    	register_rest_route( 'jacobin', '/featured-content/editors-pick/', array(
    		'methods'     => 'GET',
    		'callback'    => array( $this, 'get_editors_pick' ),
    	) );
    }

    /**
     * Get Featured Content - Editor's Pick
     *
     * @param array $data Options for the function.
     * @return string|false Post title for the latest,  * or false if none.
     */
    public function get_editors_pick( $data ) {
        $option = get_option( 'options_editors_pick' );
        $post_id = ( !empty( $option ) ) ? (int) $option[0] : '' ;
        $post = get_post( $post_id );

    	if ( empty( $post ) ) {
    		return false;
    	}

        $image_id = ( !empty( get_post_thumbnail_id( $post_id ) ) ) ? (int) get_post_thumbnail_id( $post_id ) : false;

        $post->{"featured_image"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

        $post->{"authors"} = jacobin_get_authors_array( $post_id );

    	return $post;
    }

}

new Jacobin_Rest_API_Routes();
