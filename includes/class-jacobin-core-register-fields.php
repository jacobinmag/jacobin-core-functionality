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
    function __construct () {
        add_filter( 'acf/rest_api/post/get_fields', array( $this, 'set_custom_field_base' ) );

        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'set_custom_field_base' ) );

        add_action( 'rest_api_init', function() {
            register_api_field( 'post',
                'subhead',
                array(
                'get_callback'    => array( $this, 'slug_get_post_meta_cb' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

        });

        add_action( 'init', array( $this, 'register_custom_taxonomy' ), 25 );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register () {}

    /**
     * Get post meta
     *
     * @since 0.1.0
     */
    function slug_get_post_meta_cb( $object, $field_name, $request ) {
        return get_post_meta( $object[ 'id' ], $field_name );
    }

    /**
     * Change Base Label of Custom Fields
     *
     * Advanced Custom Fields fields are displayed within `acf`.
     *
     * @link https://github.com/airesvsg/acf-to-rest-api/issues/41#issuecomment-222460783
     *
     * @param array $data
     * @return modified array $data
     *
     * @since 0.1.0
     */
    function set_custom_field_base ( $data ) {
        if ( method_exists( $data, 'get_data' ) ) {
            $data = $data->get_data();
        } else {
            $data = (array) $data;
        }

        if ( isset( $data['acf'] ) ) {
            $data['custom_fields'] = $data['acf'];
            unset( $data['acf'] );
        }
        return $data;
    }

    /**
     * Add REST API support to an already registered taxonomy.
     *
     * @since 0.1.0
     *
     * @link http://v2.wp-api.org/extending/custom-content-types/
     */
    
    function my_custom_taxonomy_rest_support() {
    global $wp_taxonomies;

    //be sure to set this to the name of your taxonomy!
    $taxonomy_name = 'planet_class';

    if ( isset( $wp_taxonomies[ $taxonomy_name ] ) ) {
    $wp_taxonomies[ $taxonomy_name ]->show_in_rest = true;
    $wp_taxonomies[ $taxonomy_name ]->rest_base = $taxonomy_name;
    $wp_taxonomies[ $taxonomy_name ]->rest_controller_class = 'WP_REST_Terms_Controller';
    }


    }
    
}

new Jacobin_Rest_API_Fields();
