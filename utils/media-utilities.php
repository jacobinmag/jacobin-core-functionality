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
 * @param  int $site
 * @param  array  $args
 * @return void
 */
function jacobin_core_clean_post_images_init( $site = null, $args = array() ) {

  if( is_multisite() && $site ) {
    switch_to_blog( $site );
  }

  if( $posts = jacobin_core_posts_without_featured_image( $args ) ) {
    $total = count( $posts );

    echo "\n-----\n{$total} without featured images were found.\n-----\n";

    foreach( $posts as $post_id ) {

      echo "\n----------\n";
      echo "Results for {$post_id}.\n";

      if( $url = jacobin_core_find_media_in_post_content( $post_id ) ) {

        echo "Image {$url} was found in post {$post_id}.\n";

        if( $attachment_id = attachment_url_to_postid( $url ) ) {

          //set_post_thumbnail( $post_id, $attachment_id );

          echo "{$url}'s attachment id is {$attachment_id}\n";

        } else {

          echo "No attachment id was found for {$url} .\n";

          continue;

        }

      } else {

        echo "Post {$post_id} has no image tag.\n";

        continue;

      }

      echo "\n----------\n";

    }

    echo "\n----------\n";
    echo "{$total} posts were processed.";
    echo "\n----------\n";

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

    $posts = array();

    while( $query->have_posts() ) {

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

      echo "The first image tag in post {$post_id} doesn't seem to have a `src` attribute.\n";

      return false;
    }

    $url = $image->getAttribute('src');

    // Reset error level
    libxml_use_internal_errors( $internalErrors );

    return $url;
  }

  echo "Finding an image tag requires DomDocument";

  return;
}

// /**
//  * Find Attachment ID for Media Item
//  *
//  * @param  string $url
//  * @return int $attachment_id
//  */
// function jacobin_core_find_attachment_id( $url ) {
//   //See if there is an attachment post for url
//   //Return attachment ID
// }
//
// /**
//  * Attach Media Item to Post
//  *
//  * @param  obj $post
//  * @param  int $attachment_id
//  * @return void
//  */
// function jacobin_core_attach_featured_image( $post, $attachment_id ) {
//
//   if( ! has_post_thumbnail( $post ) ) {
//
//     set_post_thumbnail( $post, $attachment_id );
//
//     echo "Featured image was added for {$post->ID}";
//
//     return;
//
//   }
//
// }
//
// /**
//  * Delete First Media Item in Post Content
//  *
//  * @param  obj $post
//  * @return void
//  */
// function jacobin_core_delete_first_media_in_post_content( $post ) {
//   //Check if already deleted flag is set (we only want to do this once!)
//   if( get_post_meta( $post->ID, '_first_image_deleted', true ) ) {
//     return;
//   }
//
//   $content = $post->content;
//
//   if( has_shortcode( $content, 'caption' ) ) {
//
//   }
//   //Look for caption
//   //If there is a caption shortcode, delete the first one, set flag and stop
//   //If there is an image tag, delete the first one, set flag and stop
// }
