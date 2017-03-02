<?php
/**
 * Jacobin Core Helper functions
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Get Post Fields
 *
 * @since 0.1.14
 *
 * @uses get_post()
 * @uses jacobin_get_image_meta()
 * @uses jacobin_get_authors_array()
 * @uses jacobin_the_excerpt()
 *
 * @param  int $post_id
 * @return array $post_data || false
 */
function jacobin_get_post_data( $post_id ) {
    $post_id = (int) $post_id;

    $post = get_post( $post_id );

    if( empty( $post ) ) {
        return false;
    }

    $post_data = array(
        'id'        => $post_id,
        'title'     => array(
            'rendered'  => $post->post_title,
        ),
        'date'      => $post->post_date,
        'slug'      => $post->post_name,
        'content'   => array(
            'rendered'  => $post->post_content,
        ),
        'excerpt'   => array(
            'rendered'    => jacobin_the_excerpt( $post_id ),
        )
    );

    $image_id = get_post_thumbnail_id( $post_id );

    $post_data['featured_image'] = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

    return $post_data;

}

/**
 * Get Related Post Fields
 * Fields are different than for post listings based on ticket #169
 * @link https://github.com/positiondev/jacobin/issues/169#event-968394659
 *
 * @since 0.2.3
 *
 * @uses get_post()
 * @uses get_post_meta()
 * @uses jacobin_get_image_meta()
 * @uses jacobin_get_authors_array()
 * @uses jacobin_get_post_terms()
 *
 * @param  int $post_id
 * @return array $post_data || false
 */
function jacobin_get_related_post_data( $post_id ) {
    $post_id = (int) $post_id;

    $post = get_post( $post_id );

    if( empty( $post ) ) {
        return false;
    }

    $post_data = array(
        'id'        => $post_id,
        'title'     => array(
            'rendered'  => $post->post_title,
        ),
        'date'      => $post->post_date,
        'slug'      => $post->post_name,
        'subhead'   => get_post_meta( $post_id, 'subhead', true ),
        'authors'   => jacobin_get_authors_array( $post_id ),
        'departments' => jacobin_get_post_terms( $post_id, 'department' ),
    );

    $image_id = get_post_thumbnail_id( $post_id );

    $post_data['featured_image'] = ( !empty( $image_id ) ) ? jacobin_get_image_meta( $image_id ) : false;

    return $post_data;

}

/**
 * Get Image Meta
 *
 * @since 0.1.14
 *
 * @uses get_post()
 * @uses get_post_meta()
 * @uses wp_get_attachment_url()
 * @uses wp_get_attachment_metadata()
 *
 * @param  int $image_id
 *
 * @return array $meta || false
 */
function jacobin_get_image_meta( $image_id ) {
    $image_id = (int) $image_id;

    $image_data = get_post( $image_id );

    if( empty( $image_data ) ) {
      return false;
    }

    $meta = array(
        'id'            => $image_id,
        'title'         => array(
            'rendered'  => $image_data->post_title
        ),
        'alt_text'      => get_post_meta( $image_id  , '_wp_attachment_image_alt', true ),
        'description'   => $image_data->post_content,
        'caption'       => $image_data->post_excerpt,
        'link'          => wp_get_attachment_url( $image_id ),
        'media_details' => wp_get_attachment_metadata( $image_id ),
    );

    if( empty( $meta ) ) {
        return false;
    }

    return $meta;
}

/**
 * Get Co-author Meta
 * Returns meta array for co-author
 *
 * @since 0.1.14
 *
 * @uses get_post_meta()
 * @uses get_author_posts_url()
 *
 * @param  int $author_id
 *
 * @return array $meta || false
 */
function jacobin_get_coauthor_meta( $author_id  ) {

    $user_id = (int) $author_id;

    $author_term = wp_get_post_terms( $user_id, 'author' );

    $meta = array(
        'id'            => $user_id,
        'name'          => get_post_meta( $user_id, 'cap-display_name', true ),
        'first_name'    => get_post_meta( $user_id, 'cap-first_name', true ),
        'last_name'     => get_post_meta( $user_id, 'cap-last_name', true ),
        'description'   => get_post_meta( $user_id, 'cap-description', true ),
        'website'       => esc_url( get_post_meta( $user_id, 'cap-website', true ) ),
        'term_id'       => ( !is_wp_error( $author_term ) ) ? $author_term[0]->term_id : false,
    );

    if( empty( $meta ) ) {
        return false;
    }

    return $meta;
}

/**
 * Get Guest Author Meta
 * Return guest author meta for a specific field (i.e. coauthors plus is used for other fields like 'translator', 'interviewer', 'editor', 'cover_artist')
 *
 * @since 0.2.5
 *
 * @uses get_post_meta()
 * @uses jacobin_get_coauthor_meta()
 *
 * @param  int $post_id
 * @param  string $field
 * @return array of meta || false
 */
function jacobin_get_guest_author_meta_for_field( $post_id, $field ) {
  $author_ids = get_post_meta( (int) $post_id, $field );

  if( empty( $author_ids ) ) {
    return false;
  }

  $author_ids = $author_ids[0];

  $authors = array_map( function( $author_id ) {

    return jacobin_get_coauthor_meta( $author_id );

  }, $author_ids );

  return $authors;

}

/**
 * Get Author Meta
 * Returns meta array for WP author user
 *
 * @since 0.1.14
 *
 * @uses get_userdata()
 * @uses get_author_posts_url()
 *
 * @param int $author_id
 *
 * @return array $meta || false
 */
function jacobin_get_author_meta( $author_id ) {
    $author_id = (int) $author_id;

    $user_meta = get_userdata( $author_id );

    if( empty( $user_meta ) ) {
        return false;
    }

    $meta = array(
        'id'            => $author_id,
        'name'          => $user_meta->display_name,
        'first_name'    => $user_meta->first_name,
        'last_name'     => $user_meta->last_name,
        'description'   => $user_meta->description,
        'website'       => $user_meta->user_url,
        'link'          => get_author_posts_url( $author_id )
    );

    return $meta;
}

/**
 * Get Authors Array
 * Gets an array of co-authors
 *
 * @since 0.1.14
 *
 * @uses get_coauthors()
 * @uses jacobin_get_author_meta()
 * @uses jacobin_get_coauthor_meta()
 *
 * @param  int $object_id
 *
 * @return array $authors || false
 */
function jacobin_get_authors_array( $object_id ) {

    $object_id = (int) $object_id;

    if ( function_exists( 'get_coauthors' ) ) {
        global $coauthors_plus;

        $coauthors = get_coauthors( $object_id );

        $authors = array_map( function( $coauthor ) {

          $user_id = $coauthor->ID;

          if( array_key_exists( 'data', $coauthor ) && 'wpuser' == $coauthor->data->type ) {

              return jacobin_get_author_meta( $user_id );

          }
          elseif( 'guest-author' == $coauthor->type ) {

              return jacobin_get_coauthor_meta( $user_id );

          }

        }, $coauthors );


        return $authors;
    }

    return false;
}

/**
 * Create Excerpt
 *
 * Auto-generates an excerpt if one hasn't been manually created.
 *
 * @since   0.1.0
 *
 * @uses get_post()
 *
 * @param   int $post_id
 * @param   int $word_count
 * @param   bool $line_breaks
 * @return  string $the_excerpt
 *
 */
function jacobin_the_excerpt( $post_id, $word_count = 35, $line_breaks = TRUE ) {
    $post = get_post( $post_id );

    if( $post->post_excerpt ) {
        return $post->post_excerpt;
    } else {
        $the_excerpt = $post->post_content;
        $the_excerpt = apply_filters( 'the_excerpt', $the_excerpt );
        $the_excerpt = $line_breaks ? strip_tags( strip_shortcodes( $the_excerpt ), '<p><br>' ) : strip_tags( strip_shortcodes( $the_excerpt ) );
        $words = explode( ' ', $the_excerpt, $word_count + 1 );
        if( count( $words ) > $word_count ) {
          array_pop( $words );
          array_push( $words, '…' );
          $the_excerpt = implode( ' ', $words );
          $the_excerpt = $line_breaks ? $the_excerpt . '</p>' : $the_excerpt;
        }
        $the_excerpt = trim( $the_excerpt );
        return $the_excerpt;
    }
}

/**
 * Get Timeline Date Format
 *
 * Extract date format from timeline post type
 *
 * @since   0.1.5
 *
 * @uses get_post_meta()
 *
 * @param   int $post_id
 * @return  string $date_format
 *
 */
function jacobin_timeline_date_format( $post_id ) {
    $date = get_post_meta( $post_id, 'date_format' );

    /**
     * If there is no date, then just return the default 'F j, Y'
     * i.e. January 1, 2024
     */
    if( !$date ) {
      return 'F j, Y';
    }

    $date = $date[0];

    /**
     * If `month` && `day`, but not `year`
     *
     * @return string 'F jS'
     * e.g. January 1st
     */
    if( in_array( 'month', $date ) && in_array( 'day', $date ) && !in_array( 'year', $date ) ) {

      return 'F jS';

    /**
     * If `day`, but not `month`
     * Note: if `day` and `year` are selected, 'l' is still returned because Saturday 2024 doesn't make sense.
     *
     * @return string 'l'
     * e.g. Saturday
     */
    } elseif( in_array( 'day', $date ) && !in_array( 'month', $date ) ) {

      return 'l';

    }

    /**
     * Build date format
     *
     * @return string $date_format
     */
    $date_format = '';

    if( in_array( 'month', $date ) ) {
      $date_format .= 'F ';
    }

    if( in_array( 'day', $date ) ) {
      $date_format .= 'j, ';
    }

    if( in_array( 'year', $date ) ) {
      $date_format .= 'Y';
    }

    return $date_format;

}

/**
 * Get Post Terms
 * Return post terms with parent slug
 *
 * @uses get_term()
 * @link https://codex.wordpress.org/Function_Reference/get_term
 * @uses array_map()
 * @link http://php.net/manual/en/function.array-map.php
 *
 * @since 0.2.1.2
 *
 * @param  int $post_id
 * @param  string $taxonomy
 *
 * @return array of obj $terms
 */
function jacobin_get_post_terms( $post_id = null, $taxonomy ) {

  if( !$post_id || !$taxonomy ) {
    return;
  }

  $post_id = (int) $post_id;

  $term_ids = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );

  $terms = array_map(
      function( $id ) use ( $taxonomy ) {
        $term = get_term( $id, $taxonomy );

        $parent_term = get_term( (int) $term->parent, $taxonomy );
        $term->{'parent_slug'} = ( !is_wp_error( $parent_term ) ) ? $parent_term->slug: false;

        return $term;
      },
      $term_ids
  );

  return $terms;
}
