<?php
/**
 * Jacobin Core Field Settings
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Register and Set-up Fields
 *
 *
 * @since 0.1.0
 */
class Jacobin_Field_Settings {

    /**
     * The single instance of Jacobin_Field_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {
        /**
         * Remove Metaboxes
         *
         * @since 0.1.0
         *
         * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
         */
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
        remove_meta_box( 'seriesdiv', 'post', 'side' );
        remove_meta_box( 'formatdiv', 'post', 'side' );
        remove_meta_box( 'formatdiv', 'issue', 'side' );
        remove_meta_box( 'authordiv', 'issue', 'side' );
        remove_meta_box( 'departmentdiv', 'post', 'side' );
        remove_meta_box( 'locationdiv', 'post', 'side' );
    }

}

new Jacobin_Field_Settings();
