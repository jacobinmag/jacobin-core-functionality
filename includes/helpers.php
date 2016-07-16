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