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
        /**
         * Filters to have fields returned in `custom_fields` instead of `acf`. For v2
         */
        add_filter( 'acf/rest_api/post/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/term/get_fields', array( $this, 'set_custom_field_base' ) );

        /**
         * Filters to have fields returned in `custom_fields` instead of `acf`. For v1.
         */
        add_filter( 'acf_to_wp_rest_api_post_data', array( $this, 'set_custom_field_base_v1' ), 10 );
        add_filter( 'acf_to_wp_rest_api_issue_data', array( $this, 'set_custom_field_base_v1' ), 10 );
        add_filter( 'acf_to_wp_rest_api_term_data', array( $this, 'set_custom_field_base_v1' ), 10 );


        add_filter( 'rest_prepare_department', array( $this, 'rest_prepare_department' ), 10, 2 );

        add_action( 'rest_api_init', array( $this, 'register_fields' ) );

        add_action( 'init', array( $this, 'register_custom_taxonomy' ), 25 );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register_fields () {
        register_api_field( 'post',
            'subhead',
            array(
            'get_callback'    => array( $this, 'slug_get_post_meta_cb' ),
            'update_callback' => null,
            'schema'          => null,
            )
        );
    }

    /**
     * Register the custom taxonomy
     *
     * @since 0.1.0
     */
    function register_taxonomy () {}

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
     * Change Base Label of Custom Fields
     *
     * Advanced Custom Fields fields are displayed within `acf` for v1.
     *
     * @link https://github.com/airesvsg/acf-to-wp-rest-api/issues/11#issuecomment-230176396
     *
     * @param array $data
     * @return modified array $data
     *
     * @since 0.1.0
     */
    function set_custom_field_base_v1 ( $data ) {
        if ( isset( $data['acf'] ) ) {
          $data['custom_fields'] = $data['acf'];
          unset( $data['acf'] );
        }

        return $data;
    }

    /**
     * Change response field to `custom_fields`.
     *
     * @since 0.1.0
     *
     * @param $response
     * @param $object
     * @return modified $response
     *
     * @link http://v2.wp-api.org/extending/custom-content-types/
     */
    function rest_prepare_department ( $response, $object ) {
        if ( $object instanceof WP_Term ) {
            if ( isset( $data['acf'] ) ) {
                $data['custom_fields'] = $data['acf'];
                unset( $data['acf'] );
            }
            $response->data['custom_fields'] = get_fields( $object->taxonomy . '_' . $object->term_id );
        }

        return $response;
    }
    
}

new Jacobin_Rest_API_Fields();
