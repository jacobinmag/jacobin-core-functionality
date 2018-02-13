<?php
/**
 * Jacobin Core User Utilities
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.4.10
 * @license    GPL-2.0+
 */

/**
 * Delete Users
 *
 * @param  int  $site_id
 * @param  string $role
 * @param  int $reassign_to
 * @return void
 */
function jacobin_core_user_delete_init( $site_id = null, $role = null, $reassign_to = 3002 ) {

  if( is_multisite() && $site_id ) {
    switch_to_blog( $site_id );
  }

  if( !$role ) {
    wp_die( "You must select a role." );
  }

  // get users
  if( $users = jacobin_core_get_users( $role ) ) {

    $count = 1;
    $total = count( $users );

    foreach( $users as $user_id ) {

      if ( defined( 'WP_CLI' ) && WP_CLI ) {
        WP_CLI::line( "\n----------\nUser ID: {$user_id} - {$count} of {$total}\n" );
      } else {
        echo "\n----------\n";
        echo "User ID: {$user_id} - {$count} of {$total}\n";
      }

      if( $posts = jacobin_core_get_user_posts( $user_id ) ) {

        foreach( $posts as $post_id ) {

          // assign posts to different user
          jacobin_core_reassign_posts( $post_id, $user_id );

          // if ( defined( 'WP_CLI' ) && WP_CLI ) {
          //   WP_CLI::log( "\n----------\nReassigned: {$post_id} to {$reassign_to}\n" );
          // } else {
          //   echo "\n----------\n";
          //   echo "Reassigned: {$post_id} to {$reassign_to}\n";
          // }

        }

      } else {
        // No posts for user
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
          WP_CLI::line( "Skipping: No posts found for {$user_id}.\n" );
        } else {
          echo "Skipping: No posts found for {$user_id}.\n";
        }

        continue;
      }

      // delete user
      jacobin_core_delete_user( $user_id, $reassign_to );

      $count++;

    }

  } else {
    // No users for role
     wp_die( "There are no users for the role {$role}" );

  }

  if( is_multisite() && $site_id ) {
    restore_current_blog();
  }
}

/**
 * Get Users by Role
 *
 * @param  string $role
 * @return array $users || false
 */
function jacobin_core_get_users( $role ) {
  $args = array(
    'role'    => $role,
    'fields'  => 'ID',
    'number'  => -1
  );

  $user_query = new WP_User_Query( $args );

  if( $users = $user_query->get_results() ) {
    return $users;
  }

  return false;
}

/**
 * Jacobin Get User Posts
 *
 * @param   int $user_id
 * @return array $posts || false
 */
function jacobin_core_get_user_posts( $user_id ) {
  $user_id = (int) $user_id;
  $args = array(
    'author'          => $user_id,
    'posts_per_page'  => -1,
    'fields'          => 'ids'
  );

  $post_query = new WP_Query( $args );

  if( $posts = $post_query->get_posts() ) {
    return $posts;
  }

  return false;
}

/**
 * Reassign Post
 *
 * @param  int $post_id
 * @param  int $user_id
 * @return void
 */
function jacobin_core_reassign_posts( $post_id, $user_id ) {
  $coauthors = get_coauthors( $post_id );

  $post_id = (int) $post_id;
  $user_id = (int) $user_id;
  $arg = array(
      'ID'          => $post_id,
      'post_author' => $user_id,
      'post_status' => 'publish'
  );
  wp_update_post( $arg );

  global $coauthors_plus;

  foreach( $coauthors as $coauthor ) {
    $coauthors_plus->add_coauthors( $post_id, array( $coauthor->user_nicename ) );
  }

}

/**
 * Get the User's Sites
 *
 * @param  int $user_id
 * @return array of user site IDs || false
 */
function jacobin_core_get_user_sites( $user_id ) {
  $user_id = (int) $user_id;
  if( $sites = get_blogs_of_user( $user_id ) ) {
    return wp_list_pluck( $sites, 'userblog_id' );
  }

  return false;
}

/**
 * Delete the User
 *
 * @param  int $user_id
 * @param  int $reassign_to
 * @return void
 */
function jacobin_core_delete_user( $user_id, $reassign_to ) {
  $user_id = (int) $user_id;
  $reassign_to = (int) $reassign_to;

  if( !is_multisite() ) {
    wp_delete_user( $user_id, $reassign_to );

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::log( "\n----------\nUser Deleted: {$user_id} from site\n" );
    } else {
      echo "\n----------\n";
      echo "User Deleted: {$user_id} from site\n";
    }

    return;
  }


  $sites = jacobin_core_get_user_sites( $user_id );

  if( empty( $sites ) ) {
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::warning( "Skipping: {$user_id} doesn't below to any sites\n" );
    } else {
      echo "Skipping: {$user_id} doesn't below to any sites\n";
    }

    return;
  }

  if( count( $sites ) > 1 ) {

    wp_delete_user( $user_id, $reassign_to );

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::log( "\n----------\nUser Deleted: {$user_id} from site\n" );
    } else {
      echo "\n----------\n";
      echo "User Deleted: {$user_id} from site\n";
    }

  }

}

function jacobin_core_change_post_status( $site_id = null, $old_status, $new_status ) {
  if( is_multisite() && $site_id ) {
    switch_to_blog( $site_id );
  }

  $defaults = array(
    'post_type'       => 'post',
    'posts_per_page'  => -1,
    'fields'          => 'ids',
    'post_status'     => array( $old_status ),
  );

  $args = wp_parse_args( $args, $defaults );

  $query = new WP_Query( $args );

  if( $posts = $query->get_posts() ) {
    $count = 1;
    $total = count( $posts );

    foreach( $posts as $post_id ) {

      echo "{$post_id} found\n";

      $new_values = array(
        'ID'          => $post_id,
        'post_status' => $new_status
      );

      $new_post = wp_update_post( $new_values, true );

      if( !is_wp_error( $new_post ) ) {
        $count++;
      }

    }

  }

  echo "{$total} of {$count} updated.";

  if( is_multisite() && $site_id ) {
    restore_current_blog();
  }

}

/**
 * Get Posts without Guest Authors
 *
 * @param  int $site_id
 * @return array posts
 */
function jacobin_core_get_posts_without_guest_authors( $site_id = null ) {
    if( is_multisite() && $site_id ) {
      switch_to_blog( $site_id );
    }

    $taxonomy = 'author';

    $defaults = array(
      'post_type'       => 'post',
      'posts_per_page'  => -1,
      'fields'         => 'ids',
      'tax_query' => array(
          array(
              'taxonomy' => $taxonomy,
              'operator' => 'NOT EXISTS',
          ),
      ),
    );

    $args = wp_parse_args( $args, $defaults );

    $query = new WP_Query( $args );

    return $query->get_posts();

    if( is_multisite() && $site_id ) {
      restore_current_blog();
    }
}
