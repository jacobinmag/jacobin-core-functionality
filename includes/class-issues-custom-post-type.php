<?php
/**
 * Jacobin Core Functionality Plugin
 * 
 * @package    Core_Functionality
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Issues
 *
 * This file registers the issues custom post type
 * and setups the various functions and items it uses.
 *
 * @since 0.1.0
 */
class Jacobin_Issues {

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {
        
        // Actions
        add_action( 'init',              array( $this, 'register'      )    );
        add_action( 'gettext',           array( $this, 'title_placeholder' )    );

        // Column Filters
        add_filter( 'manage_edit-issue_columns',        array( $this, 'issue_columns' )        );

        // Column Actions
        add_action( 'manage_issue_pages_custom_column', array( $this, 'custom_columns'      ), 10, 2 );
        add_action( 'manage_issue_posts_custom_column', array( $this, 'custom_columns'      ), 10, 2 );
    }

    /**
     * Register the custom post type
     *
     * @since 0.1.0
     */
    function register() {

        $labels = array( 
            'name'               => 'Issues',
            'singular_name'      => 'Issue',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Issue',
            'edit_item'          => 'Edit Issue',
            'new_item'           => 'New Issue',
            'view_item'          => 'View Issue',
            'search_items'       => 'Search Issues',
            'not_found'          => 'No Issues found',
            'not_found_in_trash' => 'No Issues found in Trash',
            'parent_item_colon'  => 'Parent Issue:',
            'menu_name'          => 'Issues',
        );

        $args = array( 
            'labels'              => $labels,
            'hierarchical'        => false,
            'supports'            => array( 'title', 'editor', 'thumbnail' ),   
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => array( 'slug' => 'issues', 'with_front'       => false ),
            'show_in_rest'        => true,
            'rest_base'           => 'issues',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'menu_icon'           => 'dashicons-book-alt', // https://developer.wordpress.org/resource/dashicons/
        );

        register_post_type( 'issue', $args );

    }

    /**
     * Change the default title placeholder text
     *
     * @since 0.1.0
     * @global array $post
     * @param string $translation
     * @return string Customized translation for title
     */
    function title_placeholder( $translation ) {

        global $post;
        if ( isset( $post ) && 'issue' == $post->post_type && 'Enter title here' == $translation ) {
            $translation = 'Enter Name Here';
        }
        return $translation;

    }
        
    /**
     * Issues custom columns
     *
     * @since 0.1.0
     * @param array $columns
     */
    function issue_columns( $columns ) {

        $columns = array(
            'cb'                  => '<input type="checkbox" />',
            'thumbnail'           => 'Thumbnail',
            'title'               => 'Name',
            'date'                => 'Date',
        );

        return $columns;
    }

    /**
     * Cases for the custom columns
     *
     * @since 0.1.0
     * @param array $column
     * @param int $post_id
     * @global array $post
     */
    function custom_columns( $column, $post_id ) {

        global $post;

        switch ( $column ) {
            case 'thumbnail':
                the_post_thumbnail( 'thumbnail' );
                break;
        }
    }
    
}
new Jacobin_Issues();