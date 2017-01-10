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
         * Filters to have fields returned in `custom_fields` instead of `acf`.
         */
        add_filter( 'acf/rest_api/post/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/term/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/timeline/get_fields', array( $this, 'set_custom_field_base' ) );
        add_filter( 'acf/rest_api/chart/get_fields', array( $this, 'set_custom_field_base' ) );

        /**
         * Modify Responses
         */
        add_filter( 'rest_prepare_post', array( $this, 'modify_taxonomy_response' ), 10, 3 );

        add_filter( 'rest_prepare_post', array( $this, 'modify_department_taxonomy_response' ), 10, 3 );


        /**
         * Register Fields
         */
        add_action( 'rest_api_init', array( $this, 'register_fields' ) );

    }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register_fields () {
        if ( function_exists( 'register_rest_field' ) ) {

            register_rest_field( 'post',
                'subhead',
                array(
                    'get_callback'    => array( $this, 'get_field' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'authors',
                array(
                    'get_callback'    => array( $this, 'get_authors' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'issue',
                'authors',
                array(
                    'get_callback'    => array( $this, 'get_authors' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'issue',
                'cover_artist',
                array(
                    'get_callback'    => array( $this, 'get_guest_author' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'translator',
                array(
                    'get_callback'    => array( $this, 'get_guest_author' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'post',
                'interviewer',
                array(
                    'get_callback'    => array( $this, 'get_interviewer' ),
                    'update_callback' => null,
                    'schema'          => null
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

            register_rest_field( 'post',
                'related_articles',
                array(
                    'get_callback'    => array( $this, 'get_related_articles' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'issue',
                'articles',
                array(
                    'get_callback'    => array( $this, 'get_issue_articles' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'department',
                'featured_image',
                array(
                    'get_callback'    => array( $this, 'get_featured_image' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'department',
                'featured_article',
                array(
                    'get_callback'    => array( $this, 'get_featured_post' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

        }
    }

    /**
     * Modify Response Data Returned for Department
     * By default the REST API returns only the taxonomy ID in the post response.
     * We want to get more information in the response
     *
     * @since 0.1.14
     *
     * @param {array} $data
     * @param {obj} $post
     * @param {array} $request
     *
     * @return {array} $data
     */
    function modify_department_taxonomy_response ( $data, $post, $request ) {
        $_data = $data->data['departments'];

        foreach( $_data  as $department ) {
            $image = get_term_meta( $department->term_id, 'featured_image' );
            $image_id = ( !empty( $image ) && is_array( $image ) ) ? (int) $image[0] : false;

            $featured = get_term_meta(  $department->term_id, 'featured_article' );
            $featured_id = ( !empty( $featured ) && is_array( $featured ) ) ? (int) $featured[0][0] : false;

            $department->{"thumbnail"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
            $department->{"featured_article"} = ( !empty( $featured_id ) ) ? jacobin_get_post_data( $featured_id ) : false;
        }

        $data->data['departments'] = $_data;

        return $data;

    }

    /**
     * Modify Response Data Returned for Taxonomies
     * By default the REST API returns only the taxonomy ID in the post response.
     * We want to get more information in the response
     *
     * @since 0.1.12
     *
     * @param {array} $data
     * @param {obj} $post
     * @param {array} $request
     *
     * @return {array} $data
     */
    function modify_taxonomy_response ( $data, $post, $request ) {
        $_data = $data->data;

        $taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

        foreach( $taxonomies as $taxonomy => $details ) {
            $label = strtolower( str_replace( ' ', '_', $details->labels->name ) );

            if( isset( $_data[$label] ) ) {
                $args = array(
                    'orderby'   => 'parent'
                );

                $_data[$label] = wp_get_post_terms( $post->ID, $taxonomy, $args );

            }
        }

        $data->data = $_data;
        return $data;
    }

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
    function get_field ( $object, $field_name, $request ) {
        return get_post_meta( $object[ 'id' ], $field_name, true );
    }

    /**
     * Get term meta
     *
     * @since 0.1.0
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    function get_term_meta( $object, $field_name, $request ) {
        return get_term_meta( $object[ 'id' ] );
    }

    /**
     * Get Featured Image
     *
     * @since 0.1.14
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    function get_featured_image( $object, $field_name, $request ) {
        $image = get_term_meta( $object[ 'id' ], 'featured_image' );
        $image_id = ( !empty( $image ) && is_array( $image ) ) ? (int) $image[0] : false;
        return ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
    }

    /**
     * Get Featured Post
     *
     * @since 0.1.14
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    function get_featured_post( $object, $field_name, $request ) {
        $featured = get_term_meta(  $object[ 'id' ], 'featured_article' );
        $featured_id = ( !empty( $featured ) && is_array( $featured ) ) ? (int) $featured[0][0] : false;
        return ( !empty( $featured_id ) ) ? jacobin_get_post_data( $featured_id ) : false;
    }

    /**
     * Get secondary featured image
     *
     * @since 0.1.0
     *
     * @uses  get_post_meta()
     * @uses  get_post()
     * @uses  get_post_meta()
     *
     * @param {object} $object
     * @param {string} $field_name
     * @param {string} $request
     * @return {array} $authors
     */
    public function get_featured_image_secondary ( $object, $field_name, $request ) {

        $post_id = $object['id'];
        $image_id = get_post_meta( $post_id, $field_name, true );

        if( !empty( $image_meta ) ) {

            $image_id = (int) $image_id;

            $featured_image_secondary = jacobin_get_image_meta( $image_id );

            return $featured_image_secondary;
        }

        return false;

    }

    /**
     * Get issue articles
     *
     * @since 0.1.0
     *
     * @uses  get_post_meta()
     * @uses  get_post()
     * @uses  jacobin_the_excerpt()
     * @uses  jacobin_get_authors_array()
     *
     * @param {object} $object
     * @param {string} $field_name
     * @param {string} $request
     * @return {array} $articles
     *
     */
    public function get_issue_articles ( $object, $field_name, $request ) {
        $meta = get_post_meta( $object['id'], 'article_issue_relationship', true );
        $articles = [];

        $args = array(
            'post__in' => $meta
        );

        $posts = get_posts( $args );

        if( !empty( $posts ) ) {
            foreach( $posts as $post ) {

                $article = array(
                    'id'        => (int) $post->ID,
                    'title'     => array(
                        'rendered'  => $post->post_title,
                    ),
                    'slug'      => $post->post_name,
                    'content'   => array(
                        'rendered'  => $post->post_content,
                    ),
                    'excerpt'   => array(
                        'rendered'    => jacobin_the_excerpt( $post->ID ),
                    )
                );

                $image_id = get_post_thumbnail_id( $post->ID );

                $image_id = ( !empty( $image_id ) ) ? (int) $image_id : false;

                $image_meta = jacobin_get_image_meta( $image_id );

                $article['featured_image'] = $image_meta;

                $article['authors'] = jacobin_get_authors_array( $post->ID );

                array_push( $articles, $article );

            }

        }
        return $articles;
    }

    /**
     * Get related articles
     *
     * @since 0.1.13
     *
     * @uses  get_post_meta()
     * @uses  get_post()
     * @uses  jacobin_the_excerpt()
     * @uses  jacobin_get_authors_array()
     *
     * @param {object} $object
     * @param {string} $field_name
     * @param {string} $request
     * @return {array} $articles
     *
     */
    public function get_related_articles ( $object, $field_name, $request ) {
        $meta = get_post_meta( $object['id'], 'related_articles', true );
        $articles = [];

        $args = array(
            'post__in' => $meta
        );

        $posts = get_posts( $args );

        if( !empty( $posts ) ) {
            foreach( $posts as $post ) {

                $article = array(
                    'id'        => (int) $post->ID,
                    'title'     => array(
                        'rendered'  => $post->post_title,
                    ),
                    'slug'      => $post->post_name,
                    'date'      => $post->post_date,
                    'content'   => array(
                        'rendered'  => $post->post_content,
                    ),
                    'excerpt'   => array(
                        'rendered'    => jacobin_the_excerpt( $post->ID ),
                    ),
                );

                $article['authors'] = jacobin_get_authors_array( $post->ID );

                $image_id = ( !empty( get_post_thumbnail_id( $post->ID ) ) ) ? (int) get_post_thumbnail_id( $post->ID ) : false;

                $image_meta = jacobin_get_image_meta( $image_id );

                $article['featured_image'] = $image_meta;

                $article['departments'] = wp_get_post_terms( $post->ID, 'department', array( 'orderby'   => 'parent' ) );

                array_push( $articles, $article );

            }

        }
        return $articles;
    }

    /**
     * Get coauthors
     *
     * @since 0.1.0
     *
     * @param {object} $object
     * @param {string} $field_name
     * @param {string} $request
     * @return {array} $authors
     *
     */
    public function get_authors ( $object, $field_name, $request ) {
        return jacobin_get_authors_array( $object['id'] );
    }

    /**
     * Get guest author
     *
     * @since 0.1.7
     *
     * @param   {object} $object
     * @param   {string} $field_name
     * @param   {string} $request
     * @return  {array} $guest_author details
     *
     */
    public function get_guest_author( $object, $field_name, $request ) {

        $guest_author_id = get_post_meta( $object['id'], $field_name, true );

        if( empty( $guest_author_id ) ) {
            return false;
        }

        return $this->get_guest_author_meta( $guest_author_id );

    }

    /**
     * Get interviewer
     * @param  {obj} $object
     * @param  {string} $field_name
     * @param  {array} $request
     * @return {array} get_guest_author_meta || false
     */
    public function get_interviewer( $object, $field_name, $request ) {

        $interviewer = get_post_meta( $object['id'], 'interviewer', true );

        if( empty( $interviewer ) || !is_array( $interviewer )  ) {
            return false;
        }

        $interviewer_id = (int) $interviewer[0];

        return jacobin_get_coauthor_meta( $interviewer_id );

    }

    /**
     * Get Guest Author Meta
     * Guest author is a custom post type created by the Co-authors Plus plugin
     * @since 0.1.7
     *
     * @link https://github.com/Automattic/Co-Authors-Plus
     *
     * @param {int} $user_id
     * @return {array} $user_details
     */
    public function get_guest_author_meta( $user_id ) {

        $user_id = is_array( $user_id ) ? $user_id[0] : $user_id;
        $user_id = (int) $user_id;

        $user_details = jacobin_get_coauthor_meta( $user_id );

        if( !empty( $user_details ) ) {
            return $user_details;
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
    public function set_custom_field_base ( $data ) {
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
    public function rest_prepare_term ( $response, $object ) {
        if ( $object instanceof WP_Term && function_exists( 'get_fields' ) ) {
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
