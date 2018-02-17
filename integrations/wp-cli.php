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

/**
 * Run Delete Media from Post Content Command
 *
 * Usage: `wp delete-post-media --site={id}`
 *
 * @since 1.4.12
 *
 * @uses jacobin_core_delete_media_init()
 * @uses WP_CLI
 *
 * @param array $args
 * @param array $assoc_args
 * @return void
 */
function jacobin_core_cli_delete_post_media( $args = array(), $assoc_args = array() ) {

  $defaults = array(
    'site'      => null,
  );

  $assoc_args = wp_parse_args( $assoc_args, $defaults );

  jacobin_core_delete_media_init( $assoc_args['site'] );

}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'delete-post-media', 'jacobin_core_cli_delete_post_media' );
}

/**
 * Run Delete Users Command
 *
 * Usage: `wp delete-users --site={id} --role={role} --reassign={user_id}`
 *
 * @uses jacobin_core_user_delete_init()
 * @uses WP_CLI
 *
 * @param array $args
 * @param array $assoc_args
 * @return void
 */
function jacobin_core_cli_delete_users( $args = array(), $assoc_args = array() ) {

  $defaults = array(
    'site'      => null,
    'role'      => null,
    'reassign'  => null
  );

  $assoc_args = wp_parse_args( $assoc_args, $defaults );

  jacobin_core_user_delete_init( $assoc_args['site'], $assoc_args['role'], $assoc_args['reassign'] );

}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'delete-users', 'jacobin_core_cli_delete_users' );
}
