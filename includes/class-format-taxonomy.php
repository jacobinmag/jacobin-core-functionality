<?php
/**
 * Jacobin Core Functionality Plugin
 * 
 * @package    Core_Functionality
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Formats
 *
 * This file registers the formats custom taxonomy
 * and setups the various functions and items it uses.
 *
 * @since 0.1.0
 */
class Jacobin_Format_Taxonomy {

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {
        
        // Actions
        add_action( 'init', array( $this, 'register' ) );

        add_action( 'admin_menu' , array( $this, 'hide_metabox' ) );
    }

    /**
     * Register the custom taxonomy
     *
     * @since 0.1.0
     */
    function register() {

        $labels = array(
            'name'                       => _x( 'Formats', 'Taxonomy General Name', 'jacobin-core' ),
            'singular_name'              => _x( 'Format', 'Taxonomy Singular Name', 'jacobin-core' ),
            'menu_name'                  => __( 'Formats', 'jacobin-core' ),
            'all_items'                  => __( 'All Formats', 'jacobin-core' ),
            'parent_item'                => __( 'Parent Format', 'jacobin-core' ),
            'parent_item_colon'          => __( 'Parent Format:', 'jacobin-core' ),
            'new_item_name'              => __( 'New Format Name', 'jacobin-core' ),
            'add_new_item'               => __( 'Add New Format', 'jacobin-core' ),
            'edit_item'                  => __( 'Edit Format', 'jacobin-core' ),
            'update_item'                => __( 'Update Format', 'jacobin-core' ),
            'view_item'                  => __( 'View Format', 'jacobin-core' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'jacobin-core' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'jacobin-core' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'jacobin-core' ),
            'popular_items'              => __( 'Popular Formats', 'jacobin-core' ),
            'search_items'               => __( 'Search Items', 'jacobin-core' ),
            'not_found'                  => __( 'Not Found', 'jacobin-core' ),
            'no_terms'                   => __( 'No items', 'jacobin-core' ),
            'items_list'                 => __( 'Items list', 'jacobin-core' ),
            'items_list_navigation'      => __( 'Formats list navigation', 'jacobin-core' ),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
            'rest_base'                  => 'format',
            'rest_controller_class'      => 'WP_REST_Terms_Controller',
        );

        register_taxonomy( 'format', array( 'post' ), $args );

    }

    /**
     * Hide the Metabox from Post Edit Screen
     *
     * @since 0.1.0
     */
    function hide_metabox() {

        remove_meta_box( 'formatdiv', 'post', 'side' );

    }
    
}

new Jacobin_Format_Taxonomy();