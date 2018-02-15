<?php
/**
 * Jacobin Core Performance Functions
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.4.12
 * @license    GPL-2.0+
 */

/**
 * Modify the number of revisions that are kept
 * Alternative to defining in wp-config.php `define( 'WP_POST_REVISIONS', 3 );`
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_revisions_to_keep/
 *
 * @since 0.4.12
 *
 * @return int
 */
add_filter( 'wp_revisions_to_keep', function() {
  return 10;
} );

/**
 * Add Weekly Cron
 *
 * @link https://developer.wordpress.org/reference/hooks/cron_schedules/
 *
 * @since 0.4.12
 *
 * @param  array $schedules
 * @return  array $schedules modified array
 */
function jacobin_core_weekly_cron( $schedules ) {
    $schedules['weekly'] = array(
        'interval' => 604800,
        'display'  => __( 'Once Weekly' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'jacobin_core_weekly_cron' );

/**
 * Setup Revision Schedule
 * Sets up `jacobin_core_revision_cron`
 *
 * @since 0.4.12
 *
 * @uses wp_next_scheduled()
 * @uses wp_schedule_event()
 *
 * @return void
 */
function jacobin_core_revision_schedule() {
    if ( !wp_next_scheduled( 'jacobin_core_revision_cron' ) ) {
        wp_schedule_event( time(), 'weekly', 'jacobin_core_revision_cron' );
    }
}
add_action( 'wp', 'jacobin_core_revision_schedule' );

/**
 * Setup Revision Delete
 *
 * @since 0.4.12
 *
 * @uses jacobin_core_revision_cron
 * @uses jacobin_core_get_revisions()
 *
 * @return void
 */
function jacobin_core_revision_delete() {

  if( is_multisite() ) {

    $site_args = array(
      'fields'  => 'ids'
    );
    $site_query = new WP_Site_Query( $site_args );

    $sites = $site_query->get_sites();

    foreach( $sites as $site ) {
      switch_to_blog( $site );

      if( $revisions = jacobin_core_get_revisions() ) {

        foreach( $revisions as $revision ) {

          wp_delete_post( $revision, true );

        }

      }

    } //end foreach()
    restore_current_blog();

  } //end is_multisite()
  else {

    if( $revisions = jacobin_core_get_revisions() ) {

      foreach( $revisions as $revision ) {

        wp_delete_post( $revision, true );

      }

    }

  }

}
add_action( 'jacobin_core_revision_cron', 'jacobin_core_revision_delete' );

/**
 * Get Revisions
 *
 * @since 0.4.12
 *
 * @param  array $args
 * @return array post IDs
 */
function jacobin_core_get_revisions( $args = array() ) {

  $defaults = array(
    'post_type'       => 'revision',
    'post_status'     => 'any',
    'fields'          => 'ids',
    'posts_per_page'  => -1,
    'date_query'      => array(
      array(
        'before' => '-90 days',
        'column' => 'post_date',
      ),
    ),
  );

  $args = wp_parse_args( $args, $defaults );

  $query = new WP_Query( $args );

  return $query->get_posts();

}
