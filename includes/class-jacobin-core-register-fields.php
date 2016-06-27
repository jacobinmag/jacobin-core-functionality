<?php
/**
 * Jacobin Core Register Fields with REST API
 * 
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Register Fields with REST API
 *
 * This file registers fields with REST API.
 *
 * @since 0.1.0
 */
class Jacobin_Rest_API_Fields {

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {

        add_action( 'admin_menu', array( $this, 'remove_meta_boxes' ) );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register() {}

    /**
     * Remove standard WordPress metaboxes for custom taxonomies.
     *
     * @since  0.1.0
     */
    function remove_meta_boxes() {
        remove_meta_box( 'formatdiv', 'post', 'normal' );
        remove_meta_box( 'departmentdiv', 'post', 'normal' );
        remove_meta_box( 'locationdiv', 'post', 'normal' );
    }
    
}

new Jacobin_Rest_API_Fields();