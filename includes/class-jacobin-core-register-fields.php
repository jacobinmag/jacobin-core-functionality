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

    public $post_types;

    /**
     * API Version
     *
     * @since 0.4.7
     *
     * @var string
     */
    public $version;

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct () {

      $this->version = get_option( 'acf_to_rest_api_request_version' );

      /**
       * Modify Responses
       */
      add_filter( 'rest_prepare_post', array( $this, 'modify_post_response_taxonomy' ), 10, 3 );
      add_filter( 'rest_prepare_post', array( $this, 'modify_post_response_department' ), 10, 3 );
      add_filter( 'rest_prepare_guest-author', array( $this, 'modify_guest_author_response' ), 10, 3 );

      add_action( 'init', array( $this, 'register_featured_image' ), 12 );

      /**
       * Register Fields
       */
      add_action( 'rest_api_init', array( $this, 'register_fields' ) );

      /**
       * Filter ACF_To_REST_API Response
       *
       * @since 0.3.8
       * @since 0.4.7
       */
      if( '2' == $this->version  ) {
        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'filter_issue_acf_response_v2' ), 10, 3 );
      } else {
        add_filter( 'acf/rest_api/issue/get_fields', array( $this, 'filter_issue_acf_response' ), 10, 2 );
      }

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
                'antescript',
                array(
                    'get_callback'    => array( $this, 'get_field' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'post',
                'postscript',
                array(
                    'get_callback'    => array( $this, 'get_field' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'post',
                'footnotes',
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
            register_rest_field( 'post',
                'translator',
                array(
                    'get_callback'    => array( $this, 'get_guest_authors' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'post',
                'interviewer',
                array(
                    'get_callback'    => array( $this, 'get_guest_authors' ),
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
                    'get_callback'    => array( $this, 'get_author' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'issue',
                'featured_image_secondary',
                array(
                    'get_callback'    => array( $this, 'get_featured_image_secondary' ),
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
            register_rest_field( 'issue',
                'featured_article',
                array(
                    'get_callback'    => array( $this, 'get_featured_post_post' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'issue',
              'issue_number',
              array(
                'get_callback'      => array( $this, 'get_field' ),
                'update_callback'   => null,
                'schema'            => null
              )
            );
            register_rest_field( 'issue',
              'issue_season',
              array(
                'get_callback'      => array( $this, 'get_field' ),
                'update_callback'   => null,
                'schema'            => null
              )
            );
            register_rest_field( 'issue',
              'volume_number',
              array(
                'get_callback'      => array( $this, 'get_field' ),
                'update_callback'   => null,
                'schema'            => null
              )
            );

            register_rest_field( 'department',
                'parent_slug',
                array(
                    'get_callback'    => array( $this, 'get_parent_slug' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'department',
                'featured_image',
                array(
                    'get_callback'    => array( $this, 'get_term_image' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
            register_rest_field( 'department',
                'featured_article',
                array(
                    'get_callback'    => array( $this, 'get_featured_post_term' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field( 'guest-author',
                'term_id',
                array(
                    'get_callback'    => array( $this, 'get_author_term_id' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

        }
    }

    /**
     * Register Featured Image
     * Register field for all public post types
     *
     * @since 0.2.9
     *
     * @param  array $post_types
     * @return void
     */
    public function register_featured_image() {

      $post_types = get_post_types( array( 'public' => true ), 'objects' );

      foreach( $post_types as $post_type ) {
        $post_type_name     = $post_type->name;
    		$show_in_rest       = ( isset( $post_type->show_in_rest ) && $post_type->show_in_rest ) ? true : false;
    		$supports_thumbnail = post_type_supports( $post_type_name, 'thumbnail' );

        if( $show_in_rest && $supports_thumbnail ) {

          register_rest_field( $post_type_name,
              'featured_image',
              array(
                  'get_callback'    => array( $this, 'get_featured_image' ),
                  'update_callback' => null,
                  'schema'          => null,
              )
          );
        }
      }

    }

    /**
     * Add Meta to Issue Response
     * Modify response from ACF_To_REST_API
     *
     * @link https://github.com/airesvsg/acf-to-rest-api/issues/9
     *
     * @since 0.4.7
     *
     * @param obj $data
     * @param obj $response
     * @return obj $data
     */
    public function filter_issue_acf_response( $data, $response ) {
      if ( $response instanceof WP_REST_Response ) {
          $data = $response->get_data();
      }

      if( isset( $data['acf']['article_issue_relationship'][0] ) ) {
        $issue_id = $data['acf']['article_issue_relationship'][0]->ID;
        if( $issue_id ) {
          $data['acf']['article_issue_relationship'][0]->issue_number = (int) get_post_meta( $issue_id, 'issue_number', true );
          $data['acf']['article_issue_relationship'][0]->issue_season = get_post_meta( $issue_id, 'issue_season', true );
          $data['acf']['article_issue_relationship'][0]->volume_number = (int) get_post_meta( $issue_id, 'volume_number', true );
        }
      }

      return $data;
    }

    /**
     * Add Meta to Issue Response
     * Modify response from ACF_To_REST_API v2
     *
     * @link https://github.com/airesvsg/acf-to-rest-api/issues/9
     *
     * @since 0.3.8
     *
     * @param obj $data
     * @param obj $request
     * @param obj $response
     * @return obj $data
     */
    public function filter_issue_acf_response_v2( $data, $request, $response ) {
      if ( $response instanceof WP_REST_Response ) {
          $data = $response->get_data();
      }

      if( isset( $data['acf']['article_issue_relationship'][0] ) ) {
        $issue_id = $data['acf']['article_issue_relationship'][0]->ID;
        if( $issue_id ) {
          $data['acf']['article_issue_relationship'][0]->issue_number = (int) get_post_meta( $issue_id, 'issue_number', true );
          $data['acf']['article_issue_relationship'][0]->issue_season = get_post_meta( $issue_id, 'issue_season', true );
          $data['acf']['article_issue_relationship'][0]->volume_number = (int) get_post_meta( $issue_id, 'volume_number', true );
        }
      }

      return $data;
    }

    /**
     * Modify Response Data Returned for Department
     * By default the REST API returns only the taxonomy ID in the post response.
     * We want to get more information in the response
     *
     * @since 0.1.14
     *
     * @param {array} $response
     * @param {obj} $post
     * @param {array} $request
     *
     * @return {array} $response
     */
     function modify_post_response_department ( $response, $post, $request ) {
         $_data = $response->data['departments'];

         foreach( $_data  as $department ) {
           $parent_term = get_term( $department->parent, 'department' );
           $department->{'parent_slug'} = ( !empty( $parent_term ) && !is_wp_error( $parent_term ) ) ? $parent_term->slug : false;

           $image = get_term_meta( $department->term_id, 'featured_image' );
           $image_id = ( !empty( $image ) && is_array( $image ) ) ? (int) $image[0] : false;

           $featured = get_term_meta(  $department->term_id, 'featured_article' );
           $featured_id = ( !empty( $featured ) && is_array( $featured ) ) ? (int) $featured[0][0] : false;

           $department->{"thumbnail"} = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
           $department->{"featured_article"} = ( !empty( $featured_id ) ) ? jacobin_get_post_data( $featured_id ) : false;
         }

         $response->data['departments'] = $_data;

         return $response;

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
     function modify_post_response_taxonomy ( $response, $post, $request ) {
         $_data = $response->data;

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

         $response->data = $_data;
         return $response;
     }

     /**
      * Modify guest-author response
      *
      * @since 0.2.6.1
      *
      * @link http://v2.wp-api.org/extending/linking/
      *
      * @param  array $response
      * @param  obj $post
      * @param  array $request
      * @return array $response
      */
     public function modify_guest_author_response( $response, $post, $request ) {

       $author_term = wp_get_post_terms( $post->ID, 'author', array( 'fields' => 'ids' ) );

       if( !empty( $author_term ) ) {
         $term_id = array_pop( $author_term );
         $response->add_link( 'author_posts', rest_url( '/wp/v2/posts?authors=' ) . $term_id  );
       }

       return $response;
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
    public function get_field ( $object, $field_name, $request ) {
      if( function_exists( 'get_field_object' ) ) {
        $field_object = get_field_object( $field_name, $object['id'] );
        if( 'wysiwyg' === $field_object['type'] ) {
          return apply_filters( 'the_content', get_post_meta( $object[ 'id' ], $field_name, true ) );
        }
        if( 'text' === $field_object['type'] ) {
          return apply_filters( 'the_title', get_post_meta( $object[ 'id' ], $field_name, true ) );
        }
      }
      return get_post_meta( $object[ 'id' ], $field_name, true );
    }

    // /**
    //  * Get term meta
    //  *
    //  * @since 0.1.0
    //  *
    //  * @param object $object
    //  * @param string $field_name
    //  * @param string $request
    //  * @return array meta
    //  *
    //  */
    // public function get_term_meta( $object, $field_name, $request ) {
    //     return get_term_meta( $object[ 'id' ] );
    // }

    /**
     * Get term id
     *
     * @since 0.2.6.1
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    public function get_author_term_id( $object, $field_name, $request ) {
      return wp_get_post_terms( $object[ 'id' ], 'author', array( 'fields' => 'ids' ) );
    }

    /**
     * Get Featured Image
     * Return feature image fields for post
     *
     * @since 0.2.9
     *
     * @param  obj $object post object
     * @param  string $field_name
     * @param  array $request
     * @return array image meta || false
     */
    public function get_featured_image( $object, $field_name, $request ) {
      $image_id = get_post_thumbnail_id( $object['id'] );
      return ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
    }

    /**
     * Get secondary featured image
     *
     * @since 0.1.0
     *
     * @uses  get_post_meta()
     *
     * @param obj $object
     * @param string $field_name
     * @param array $request
     * @return array image meta || false
     */
    public function get_featured_image_secondary ( $object, $field_name, $request ) {
        $image_id = get_post_meta( $object['id'], $field_name, true );
        return ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
    }

    /**
     * Get Term Image
     * Return image fields for taxonomy term
     *
     * @since 0.1.14
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array image meta || false
     *
     */
    public function get_term_image( $object, $field_name, $request ) {
        $image_id = get_term_meta( $object[ 'id' ], $field_name, true );
        return ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;
    }

    /**
     * Get Featured Post for Post Types
     *
     * @since 0.2.6.1
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    public function get_featured_post_post( $object, $field_name, $request ) {
        $featured = get_post_meta(  $object[ 'id' ], $field_name, true );
        $featured_id = ( !empty( $featured ) && is_array( $featured ) ) ? (int) $featured[0] : false;
        return ( !empty( $featured_id ) ) ? jacobin_get_post_data( $featured_id ) : false;
    }

    /**
     * Get Featured Post for Term
     *
     * @since 0.1.14
     *
     * @param object $object
     * @param string $field_name
     * @param string $request
     * @return array meta
     *
     */
    public function get_featured_post_term( $object, $field_name, $request ) {
        $featured = get_term_meta(  $object[ 'id' ], $field_name, true );
        $featured_id = ( !empty( $featured ) && is_array( $featured ) ) ? (int) $featured[0] : false;
        return ( !empty( $featured_id ) ) ? jacobin_get_post_data( $featured_id ) : false;
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
            'post__in'        => $meta,
            'posts_per_page'  => 20
        );

        $posts = get_posts( $args );

        if( empty( $posts ) ) {
            return false;
        }

        $articles = array_map( function( $post ) {
          return jacobin_get_post_data( $post->ID );
        }, $posts );

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
            'post__in'        => $meta,
            'posts_per_page'  => 20
        );

        $posts = get_posts( $args );

        if( empty( $posts ) ) {
            return false;
        }

        $articles = array_map( function( $post ) {
          return jacobin_get_post_data( $post->ID );
        }, $posts );

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
     * Get Author
     * @param  {obj} $object
     * @param  {string} $field_name
     * @param  {obj} $request
     * @return {array} get_guest_author_meta || false
     */
    public function get_author( $object, $field_name, $request ) {

        $interviewer = get_post_meta( $object['id'], $field_name, true );

        if( empty( $interviewer ) ) {
            return false;
        }

        $interviewer_id = (int) $interviewer;

        return jacobin_get_coauthor_meta( $interviewer_id );
    }

    /**
     * Get Guest Authors
     * Return array of guest author meta for specific field
     *
     * @since 0.2.5
     *
     * @uses jacobin_get_guest_author_meta_for_field()
     *
     * @param  obj $object
     * @param  string $field_name
     * @param  obj $request
     * @return array
     */
    public function get_guest_authors( $object, $field_name, $request ) {

      return jacobin_get_guest_author_meta_for_field( $object['id'], $field_name );

    }

    /**
     * Get Guest Author Meta Helper Function
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

    public function get_parent_slug( $object, $field_name, $request ) {
      $parent_id = $object['parent'];
      if( $parent_id ) {
        $parent = get_term( $parent_id, $object['taxonomy'] );
        return $parent->slug;
      }
      return false;
    }

}

new Jacobin_Rest_API_Fields();
