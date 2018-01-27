<?php
/**
 * Jacobin Core WP-CLI Integration
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.4.9
 * @license    GPL-2.0+
 */

/**
 * Run Add Featured Images Command
 *
 * Usage: `wp add-featured-images --site={id}`
 *
 * @uses jacobin_core_clean_post_images_init()
 * @uses WP_CLI
 *
 * @param array $args
 * @param array $assoc_args
 * @return void
 */
function jacobin_core_cli_add_featured_images( $args = array(), $assoc_args = array() ) {

  $defaults = array(
    'site'    => null
  );

  $assoc_args = wp_parse_args( $assoc_args, $defaults );

  jacobin_core_clean_post_images_init( $assoc_args['site'], $args );

}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'add-featured-images', 'jacobin_core_cli_add_featured_images' );
}
