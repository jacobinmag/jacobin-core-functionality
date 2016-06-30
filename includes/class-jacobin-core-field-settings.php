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

        //add_action( 'p2p_init', array( $this, 'relate_articles_to_issues' ) );

        add_filter( 'acf/update_value/name=related_articles', array( $this, 'related_posts' ), 10, 3 );

        add_filter( 'acf/update_value/name=rarticles_in_issue', array( $this, 'related_posts' ), 10, 3 );

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

    /**
     * Register Post Relationships.
     *
     * Set-up bi-directional post relationship
     *
     * @since  0.1.0
     */
    function relate_articles_to_issues () {

        /**
         * Relate Articles to Issues
         *
         * Set-up one to many relationship between issues and posts.
         *
         * @since  0.1.0
         */
        p2p_register_connection_type( array(
            'name'          => 'articles_in_issue',
            'from'          => 'post',
            'to'            => 'issue',
            'reciprocal'    => true,
            'cardinality'   => 'many-to-one',
            'title'         => array(
                'from'      => __( 'Issue', 'jacobin-core' ),
                'to'        => __( 'Articles in this Issue', 'jacobin-core' )
            ),
            'from_labels'   => array(
                'singular_name' => __( 'Article', 'jacobin-core' ),
                'search_items'  => __( 'Search articles', 'jacobin-core' ),
                'not_found'     => __( 'No articles found.', 'jacobin-core' ),
                'create'        => __( 'Add Article', 'jacobin-core' ),
            ),
            'to_labels'         => array(
                'singular_name' => __( 'Issue', 'jacobin-core' ),
                'search_items'  => __( 'Search issues', 'jacobin-core' ),
                'not_found'     => __( 'No issues found.', 'jacobin-core' ),
                'create'        => __( 'Add to Issue', 'jacobin-core' ),
            ),
            'admin_column'      => true,
            'admin_dropdown'    => 'any',
            'sortable'          => 'any',
        ) );

        /**
         * Featured Article for Issue
         *
         * Set-up one to one relationship between issue and post.
         *
         * @since  0.1.0
         */
        p2p_register_connection_type( array(
            'name'          => 'issue_feature',
            'from'          => 'post',
            'to'            => 'issue',
            'reciprocal'    => true,
            'cardinality'   => 'one-to-one',
            'title'         => array(
                'from'      => __( 'Featured in Issue', 'jacobin-core' ),
                'to'        => __( 'Featured Article', 'jacobin-core' )
            ),
            'from_labels'   => array(
                'singular_name' => __( 'Article', 'jacobin-core' ),
                'search_items'  => __( 'Search articles', 'jacobin-core' ),
                'not_found'     => __( 'No articles found.', 'jacobin-core' ),
                'create'        => __( 'Add Article', 'jacobin-core' ),
            ),
            'to_labels'         => array(
                'singular_name' => __( 'Issue', 'jacobin-core' ),
                'search_items'  => __( 'Search issues', 'jacobin-core' ),
                'not_found'     => __( 'No issues found.', 'jacobin-core' ),
                'create'        => __( 'Add Featured Article', 'jacobin-core' ),
            ),
            'admin_column'      => true,
            'admin_dropdown'    => 'any',
            'sortable'          => 'any',
        ) );
    }

    /**
     * Related Posts.
     *
     * Update post relationship on save.
     *
     * @since  0.1.0
     */
    function related_posts( $value, $post_id, $field ) {
    
        // vars
        $field_name = $field['name'];
        $global_name = 'is_updating_' . $field_name;
        
        // bail early if this filter was triggered from the update_field() function called within the loop below
        // - this prevents an inifinte loop
        if( !empty($GLOBALS[ $global_name ]) ) return $value;
        
        // set global variable to avoid inifite loop
        // - could also remove_filter() then add_filter() again, but this is simpler
        $GLOBALS[ $global_name ] = 1;
        
        // loop over selected posts and add this $post_id
        if( is_array($value) ) {
        
            foreach( $value as $post_id2 ) {
                
                // load existing related posts
                $value2 = get_field($field_name, $post_id2, false);
                
                // allow for selected posts to not contain a value
                if( empty($value2) ) {
                    
                    $value2 = array();
                    
                }
                
                // bail early if the current $post_id is already found in selected post's $value2
                if( in_array($post_id, $value2) ) continue;
                
                // append the current $post_id to the selected post's 'related_posts' value
                $value2[] = $post_id;
                
                // update the selected post's value
                update_field($field_name, $value2, $post_id2);
                
            }
        }
        
        // find posts which have been removed
        $old_value = get_field($field_name, $post_id, false);
        
        if( is_array($old_value) ) {
            
            foreach( $old_value as $post_id2 ) {
                
                // bail early if this value has not been removed
                if( is_array($value) && in_array($post_id2, $value) ) continue;
                
                // load existing related posts
                $value2 = get_field($field_name, $post_id2, false);
                
                // bail early if no value
                if( empty($value2) ) continue;
                
                // find the position of $post_id within $value2 so we can remove it
                $pos = array_search($post_id, $value2);
                
                // remove
                unset( $value2[ $pos] );
                
                // update the un-selected post's value
                update_field($field_name, $value2, $post_id2);
                
            }
        }
        
        // reset global varibale to allow this filter to function as per normal
        $GLOBALS[ $global_name ] = 0;
        
        // return
        return $value;
        
    }
    
}

new Jacobin_Field_Settings();
