<?php
/**
 * Jacobin Core Functionality Plugin
 * 
 * @package    Core_Functionality
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Departments
 *
 * This file registers the departments custom taxonomy
 * and setups the various functions and items it uses.
 *
 * @since 0.1.0
 */
class Jacobin_Department_Taxonomy {

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
            'name'                       => _x( 'Departments', 'Taxonomy General Name', 'jacobin-core' ),
            'singular_name'              => _x( 'Department', 'Taxonomy Singular Name', 'jacobin-core' ),
            'menu_name'                  => __( 'Departments', 'jacobin-core' ),
            'all_items'                  => __( 'All Departments', 'jacobin-core' ),
            'parent_item'                => __( 'Parent Department', 'jacobin-core' ),
            'parent_item_colon'          => __( 'Parent Department:', 'jacobin-core' ),
            'new_item_name'              => __( 'New Department Name', 'jacobin-core' ),
            'add_new_item'               => __( 'Add New Department', 'jacobin-core' ),
            'edit_item'                  => __( 'Edit Department', 'jacobin-core' ),
            'update_item'                => __( 'Update Department', 'jacobin-core' ),
            'view_item'                  => __( 'View Department', 'jacobin-core' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'jacobin-core' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'jacobin-core' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'jacobin-core' ),
            'popular_items'              => __( 'Popular Departments', 'jacobin-core' ),
            'search_items'               => __( 'Search Items', 'jacobin-core' ),
            'not_found'                  => __( 'Not Found', 'jacobin-core' ),
            'no_terms'                   => __( 'No items', 'jacobin-core' ),
            'items_list'                 => __( 'Items list', 'jacobin-core' ),
            'items_list_navigation'      => __( 'Departments list navigation', 'jacobin-core' ),
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
            'rest_base'                  => 'department',
            'rest_controller_class'      => 'WP_REST_Terms_Controller',
        );

        register_taxonomy( 'department', array( 'post' ), $args );

    }

    /**
     * Hide the Metabox from Post Edit Screen
     *
     * @since 0.1.0
     */
    function hide_metabox() {

        remove_meta_box( 'departmentdiv', 'post', 'side' );

    }
    
}

new Jacobin_Department_Taxonomy();