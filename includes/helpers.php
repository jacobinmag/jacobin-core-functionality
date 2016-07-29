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
 * Create Excerpt
 *
 * Auto-generates an excerpt if one hasn't been manually created.
 *
 * @since   0.1.0
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