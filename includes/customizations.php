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
