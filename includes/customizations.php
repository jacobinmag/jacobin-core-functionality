<?php
/**
 * Jacobin Core Customization Functions
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.4.9
 * @license    GPL-2.0+
 */

/**
 * Remove Image Sizes
 * WP generates a version for each registered image size when new media is added, this deregisters unneeded sizes.
 *
 * @since 0.4.9
 *
 * @return void
 */
function jacobin_core_remove_image_sizes() {
  remove_image_size( 'guest-author-32' );
  remove_image_size( 'guest-author-50' );
  remove_image_size( 'guest-author-64' );
  remove_image_size( 'guest-author-96' );
  remove_image_size( 'guest-author-128' );
}
add_action( 'init', 'jacobin_core_remove_image_sizes' );

/**
 * Custom Get Excerpt
 *
 * @since 0.4.13
 *
 * @param  int $post_id
 * @return string $excerpt
 */
function jacobin_core_custom_excerpt( $post ) {

  if( !empty( $post->post_excerpt ) ) {
    return $post->post_excerpt;
  }
  $excerpt = $post->post_content;
  $excerpt = apply_filters( 'get_the_excerpt', $excerpt );

  return $excerpt;
}
