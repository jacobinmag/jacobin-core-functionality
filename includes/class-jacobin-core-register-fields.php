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


        add_filter( 'rest_prepare_department', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_issue', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_location', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_filter( 'rest_prepare_series', array( $this, 'rest_prepare_term' ), 10, 2 );

        add_action( 'rest_api_init', array( $this, 'register_fields' ) );

        add_action( 'init', array( $this, 'register_taxonomy' ), 25 );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register_fields () {
        if ( function_exists( 'register_api_field' ) ) {

            register_api_field( 'post',
                'subhead',
                array(
                'get_callback'    => array( $this, 'get_post_meta_cb' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

            register_api_field( 'post',
                'authors',
                array(
                'get_callback'    => array( $this, 'get_authors' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

            register_api_field( 'post',
                'featured_image_secondary',
                array(
                'get_callback'    => array( $this, 'get_featured_image_secondary' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

        } elseif ( function_exists( 'register_rest_field' ) ) {

            register_rest_field( 'post',
                'authors',
                array(
                'get_callback'    => array( $this, 'get_post_meta_cb' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'subhead',
                array(
                'get_callback'    => array( $this, 'get_authors' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'featured_image_secondary',
                array(
                'get_callback'    => array( $this, 'get_featured_image_secondary' ),
                'update_callback' => null,
                'schema'          => null,
                )
            );

        }
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
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return string meta
     *
     */
    function get_post_meta_cb ( $object, $field_name, $request ) {
        return get_post_meta( $object[ 'id' ], $field_name );
    }

    /**
     * Get secondary featured image
     *
     * @since 0.1.0
     *
     * @uses  get_post_thumbnail_id()
     * @uses  get_post()
     * @uses  get_post_meta()
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array $authors
     *
     */
    function get_featured_image_secondary ( $object, $field_name, $request ) {

        $post_id = $object['id'];
        $image_id = get_post_thumbnail_id( $post_id );

        $post_data = get_post( $image_id );

        $featured_image_secondary['id'] = $post_data->ID;
        $featured_image_secondary['title'] = $post_data->post_title;
        $featured_image_secondary['alt_tag'] = get_post_meta( $image_id  , '_wp_attachment_image_alt', true );
        $featured_image_secondary['description'] = $post_data->post_content;
        $featured_image_secondary['caption'] = $post_data->post_excerpt;
        $featured_image_secondary['link'] = wp_get_attachment_url(  $image_id );

        return $featured_image_secondary;
    }

    /**
     * Get coauthors
     *
     * @since 0.1.0
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array $authors
     *
     */
    function get_authors ( $object, $field_name, $request ) {

        if ( function_exists( 'get_coauthors' ) ) {
            $coauthors = get_coauthors ( $object['id'] );
            $authors = [];
            $count = 0;

            foreach( $coauthors as $coauthor ) {

                $user_id = $coauthor->data->ID;
                $user_meta = get_userdata( $user_id );

                $authors[$count]['id'] = (int) $user_id;
                $authors[$count]['first_name'] = $user_meta->first_name;
                $authors[$count]['last_name'] = $user_meta->last_name ;
                $authors[$count]['name'] = $user_meta->display_name;
                $authors[$count]['description'] = $user_meta->desciption;
                $authors[$count]['link'] = $user_meta->desciption;

                $count++;

            }

            return $authors;
        }

    }

    /**
     * Get size information for all currently-registered image sizes.
     *
     * @global $_wp_additional_image_sizes
     * @uses   get_intermediate_image_sizes()
     * @return array $sizes Data for all currently-registered image sizes.
     */
    function get_image_sizes() {
        global $_wp_additional_image_sizes;

        $sizes = array();

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
                $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
                $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
                $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
                $sizes[ $_size ] = array(
                    'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                    'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                    'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                );
            }
        }

        return $sizes;
    }

    /**
     * Get size information for a specific image size.
     *
     * @uses   get_image_sizes()
     * @param  string $size The image size for which to retrieve data.
     * @return bool|array $size Size data about an image size or false if the size doesn't exist.
     */
    function get_image_size( $size ) {
        $sizes = get_image_sizes();

        if ( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        }

        return false;
    }

    /**
     * Get the width of a specific image size.
     *
     * @uses   get_image_size()
     * @param  string $size The image size for which to retrieve data.
     * @return bool|string $size Width of an image size or false if the size doesn't exist.
     */
    function get_image_width( $size ) {
        if ( ! $size = get_image_size( $size ) ) {
            return false;
        }

        if ( isset( $size['width'] ) ) {
            return $size['width'];
        }

        return false;
    }

    /**
     * Get the height of a specific image size.
     *
     * @uses   get_image_size()
     * @param  string $size The image size for which to retrieve data.
     * @return bool|string $size Height of an image size or false if the size doesn't exist.
     */
    function get_image_height( $size ) {
        if ( ! $size = get_image_size( $size ) ) {
            return false;
        }

        if ( isset( $size['height'] ) ) {
            return $size['height'];
        }

        return false;
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
    function rest_prepare_term ( $response, $object ) {
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
