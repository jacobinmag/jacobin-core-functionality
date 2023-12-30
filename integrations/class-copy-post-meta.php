<?php
/**
 * Jacobin Core User Utilities
 *
 * @package    Jacobin_Core
 * @since      0.5.25
 * @license    GPL-2.0+
 */

namespace Jacobin_Core;

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Copy Post Meta Multisite Command class.
 */
class Copy_Meta {

	/**
	 * Copy post meta from one field to another for each site in a WordPress multisite instance.
	 *
	 * ## OPTIONS
	 *
	 * <old_field>
	 * : The name of the old post meta field.
	 *
	 * <new_field>
	 * : The name of the new post meta field.
	 *
	 * [--dry-run]
	 * : Execute a dry run without updating the database.
	 *
	 * ## EXAMPLES
	 *
	 *     wp jacobin copy-meta copy_meta_field new_meta_field
	 *     wp jacobin copy-meta copy_meta_field new_meta_field --dry-run
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command associative arguments.
	 */
	public function __invoke( $args, $assoc_args ) {
		list( $old_field, $new_field ) = $args;

		$dry_run = isset( $assoc_args['dry-run'] );

		\WP_CLI::line( "Copying post meta from '{$old_field}' to '{$new_field}' for each site..." );

		$sites = get_sites();

		foreach ( $sites as $site ) {
			\switch_to_blog( $site->blog_id );

			$posts_chunked = array_chunk(
				\get_posts(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 200,
					)
				),
				200
			);

			foreach ( $posts_chunked as $posts ) {
				foreach ( $posts as $post ) {
					$old_value = \get_post_meta( $post->ID, $old_field, true );

					if ( $dry_run ) {
						\WP_CLI::line( "Dry run: Site {$site->blog_id}, Post {$post->ID} - Old Value: {$old_value}" );
					} else {
						\update_post_meta( $post->ID, $new_field, $old_value );
						\WP_CLI::line( "Site {$site->blog_id}, Post {$post->ID} - Copied '{$old_field}' to '{$new_field}'" );
					}
				}
			}

			\restore_current_blog();
		}

		\WP_CLI::success( 'Multisite post meta copy complete.' );
	}
}

// Register the command when WP_CLI is ready.
\WP_CLI::add_command( 'jacobin copy-meta', __NAMESPACE__ . '\Copy_Meta' );
