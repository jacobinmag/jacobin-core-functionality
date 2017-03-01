<?php
/**
 * Jacobin Core Register CPT
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.7
 * @license    GPL-2.0+
 */

/**
 * Register Existing Custom Post Types and Taxonomies with REST API
 *
 * @since 0.1.7
 */
class Jacobin_Register_Rest_Api_Support {

    /**
     * The single instance of Jacobin_Field_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

    /**
     * Array of custom post types
     * @var     array
     * @access  public
     * @since   1.0.7
     */
    private $custom_post_types;

    /**
     * Array of custom taxonomy
     * @var     array
     * @access  public
     * @since   1.0.7
     */
    private $custom_taxonomies;

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {
        $this->custom_post_types = array(
            'guest-author'
        );
        $this->custom_taxonomies = array(
            'author'
        );

        add_action( 'init', array( $this, 'register_post_types' ), 100 );
        add_action( 'init', array( $this, 'modify_taxonomy' ), 100 );
    }

    public function register_post_types() {
        global $wp_post_types;

      	foreach( $this->custom_post_types as $post_type_name ) {
            if( isset( $wp_post_types[ $post_type_name ] ) ) {
          		$wp_post_types[$post_type_name]->show_in_rest = true;
          		$wp_post_types[$post_type_name]->rest_base = $post_type_name;
          		$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
          	}
        }
    }

    /**
     * Modify Registered Taxonomy
     *
     * @since 0.2.5.2
     *
     * @uses get_taxonomy()
     * @uses register_taxonomy()
     *
     * @return object
     */
    public function modify_taxonomy() {
      $taxonomy = get_taxonomy( 'author' );
      $taxonomy->public = true;
      $taxonomy->publicly_queryable = true;
      $taxonomy->query_var = 'author_term';
      $taxonomy->show_in_rest = true;
      $taxonomy->rest_base = 'authors';
      $taxonomy->rest_controller_class = 'WP_REST_Terms_Controller';

      register_taxonomy( 'author', array( 'guest-author', 'post', 'issue', 'chart', 'page', 'timeline' ), (array) $taxonomy );

    }

}

new Jacobin_Register_Rest_Api_Support ();
