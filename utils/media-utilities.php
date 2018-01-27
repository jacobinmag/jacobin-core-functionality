<?php
/**
 * Jacobin Core Media Utilities
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.4.9
 * @license    GPL-2.0+
 */

/**
 * Clean Up Post Media
 * Removes first image in post content, adds as featured image (if none exists) and deletes first image tag
 *
 * @since      0.4.9
 *
 * @uses jacobin_core_posts_without_featured_image()
 * @uses jacobin_core_find_media_in_post_content()
 * @uses jacobin_core_add_attachment_post()
 * @uses attachment_url_to_postid()
 * @uses set_post_thumbnail()
 *
 * @param  int $site
 * @param  array  $args
 * @return void
 */
function jacobin_core_clean_post_images_init( $site = null, $args = array() ) {

  if( is_multisite() && $site ) {
    switch_to_blog( $site );
  }

  // If posts
  if( $posts = jacobin_core_posts_without_featured_image( $args )  ) {

    $total = count( $posts );
    $count = 0;
    $no_image = 0;

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
    	WP_CLI::log( "\n----------\nPosts without featured image: {$total}\n----------\n" );
    } else {
      echo "\n----------\n";
      echo "Posts without featured image: {$total}";
      echo "\n----------\n";
    }

    foreach( $posts as $post_id ) {

      $count++;

      if ( defined( 'WP_CLI' ) && WP_CLI ) {
        WP_CLI::log( "\n----------\nPost ID: {$post_id} - {$count} of {$total}\n" );
      } else {
        echo "\n----------\n";
        echo "Post ID: {$post_id} - {$count} of {$total}\n";
      }

      //If image tag
      if( $url = jacobin_core_find_media_in_post_content( $post_id ) ) {

        if ( defined( 'WP_CLI' ) && WP_CLI ) {
          WP_CLI::success( "Image found: {$url}\n" );
        } else {
          echo "Image found: {$url}\n";
        }

        //If attachment id found
        if( $attachment_id = attachment_url_to_postid( $url ) ) {

          if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::success( "Attachment ID found: {$attachment_id}\n" );
          } else {
            echo "Attachment ID found: {$attachment_id}\n";
          }

          set_post_thumbnail( $post_id, $attachment_id );

          if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::success( "Featured image assigned: {$attachment_id}\n" );
          } else {
            echo "Featured image assigned: {$attachment_id}\n";
          }

        } else {

          if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::log( "No attachment ID found. Creating Post...\n" );
          } else {
            echo "No attachment ID found. Creating Post...\n";
          }

          jacobin_core_add_attachment_post( $url, $post_id );

        }


      } else {

        if ( defined( 'WP_CLI' ) && WP_CLI ) {
          WP_CLI::warning( "Skipping: No image found in post.\n" );
        } else {
          echo "Skipping: No image found in post.\n";
        }

        $no_image++;

        continue;

      }

    }

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::log( "\n----------\nPosts processed: {$count} - Posts without images: {$no_image}\n----------\n" );
    } else {
      echo "\n----------\nPosts processed: {$count} - Posts without images: {$no_image}\n----------\n";
    }

  } else {

     wp_die( 'No posts without featured images were found.' );

  }

  if( is_multisite() && $site ) {
    restore_current_blog();
  }

}

/**
 * Find the Posts with No Featured Image
 * Limits search to post ID for
 *
 * @param  array  $args
 * @return mixed array of post ids || false
 */
function jacobin_core_posts_without_featured_image( $args = array() ) {

  $defaults = array(
    'post_type'       => 'post',
    'posts_per_page'  => -1,
    'fields'         => 'ids',
    'meta_query' => array(
       array(
         'key' => '_thumbnail_id',
         'value' => '?',
         'compare' => 'NOT EXISTS'
       )
    ),
  );

  $args = wp_parse_args( $args, $defaults );

  $query = new WP_Query( $args );

  if( $query->have_posts() ) {

    while( $query->have_posts() ) {

      $total = count( $query->posts );

      return $query->posts;

    }

  }

  return false;

}

/**
 * Find First Media Item in Post Content
 *
 * @uses DOMDocument class
 * @link http://php.net/manual/en/class.domdocument.php
 *
 * @param  obj $post
 * @return string $url
 */
function jacobin_core_find_media_in_post_content( $post_id ) {
  $content = get_post_field( 'post_content', $post_id );

  if( class_exists( 'DomDocument' ) ) {
    // Set error level
    $internalErrors = libxml_use_internal_errors( true );

    $dom = new DomDocument();
    $dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

    $images = $dom->getElementsByTagName( 'img' );

    if( empty( $images ) ) {

      return false;
    }

    $image = $images[0];

    if( empty( $image ) ) {

      return false;
    }

    $url = $image->getAttribute('src');

    // Reset error level
    libxml_use_internal_errors( $internalErrors );

    return $url;
  }

  else {

    wp_die( "Finding an image tag requires DomDocument" );

  }

}

/**
 * Create Attachment Post
 *
 * @param string $url
 * @param int $parent_id
 */
function jacobin_core_add_attachment_post( $url, $parent_id ) {
  $wp_upload_dir = wp_upload_dir();

  $base_path = implode( '/', array_slice( explode( '/', $url ), -3, 3, true ) );
  $filename =  trailingslashit( $wp_upload_dir['basedir'] ) . $base_path;

  if( file_exists( $filename ) ) {

    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    $filetype = wp_check_filetype( basename( $filename ), null );

    $attachment = array(
      'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
      'post_mime_type' => $filetype['type'],
      'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      'post_content'   => '',
      'post_status'    => 'inherit'
    );

    $attachment_id = wp_insert_attachment( $attachment, $filename, $parent_id );

    $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
    wp_update_attachment_metadata( $attachment_id, $attachment_data );

    set_post_thumbnail( $parent_id, $attachment_id );

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::success( "Media post created: {$url} - {$attachment_id}\nFeatured image assigned: {$attachment_id}\n" );
    } else {
      echo "Media post created: {$url} - {$attachment_id}\n";
      echo "Featured image assigned: {$attachment_id}\n";
    }

  } else {

    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      WP_CLI::warning( "Media Post not created - File doesn't exist: {$filename}.\n" );
    } else {
      echo "Media Post not created - File doesn't exist: {$filename}.\n";
    }

    return;

  }
}
