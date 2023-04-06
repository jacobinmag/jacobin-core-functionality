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

/**
 * Modify Image Link Output
 * 
 * @since 0.5.22
 * 
 * @link https://developer.wordpress.org/reference/hooks/wp_get_attachment_link_attributes/
 *
 * @param array $args
 * @param int $id
 * @return array $args
 */
function jacobin_get_attachment_link_attributes( $args, $id ) : array {
  $args['id'] = sprintf( '%s', $id );
  return $args;
}
// add_filter( 'wp_get_attachment_link_attributes', 'jacobin_get_attachment_link_attributes', 11, 2 );

/**
 * Modify Image Markup
 * Add `id` to `img` tag
 * 
 * @since 0.5.22
 * 
 * @link https://developer.wordpress.org/reference/hooks/wp_get_attachment_image_attributes/
 *
 * @param string[] $attr
 * @param \WP_Post $attachment
 * @return array  $attr
 */
function jacobin_get_attachment_image_attributes( $attr, $attachment ) : array {
  $attr['id'] = $attachment->ID;
  return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'jacobin_get_attachment_image_attributes', 10, 2 );
