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

  // Get all the posts
  // Find `[caption]` shortcode or image tag in `post_content`
  // If no featured image assigned, assign first image in `post_content`
  // Remove first image in `post_content` - set marker

  $paged = 1;

  $defaults = array(
    'post_type'       => 'post',
    'posts_per_page'  => 50,
    'paged'           => $paged
  );

  $args = wp_parse_args( $args, $defaults );

  $query = new WP_Query( $args );

  $max_num_pages = $query->max_num_pages;

  if( $query->have_posts() ) {

    echo "{$query->found_posts} posts were found.\n\n";

    while( $query->have_posts() && $max_num_pages > $paged ) {

      echo "\nSTEP {$paged}/{$max_num_pages}:\n";

      foreach( $query->posts as $post ) {

        var_dump( $post->ID );

      }

      $paged++;

    }

  }

  if( is_multisite() && $site ) {
    restore_current_blog();
  }

}

/**
 * Find First Media Item in Post Content
 * @param  obj $post
 * @return string $url
 */
function jacobin_core_find_media_in_post_content( $post ) {
  //Look for caption
  //Look for image tag
  //Return image url
}

/**
 * Find Attachment ID for Media Item
 *
 * @param  string $url
 * @return int $attachment_id
 */
function jacobin_core_find_attachment_id( $url ) {
  //See if there is an attachment post for url
  //Return attachment ID
}

/**
 * Attach Media Item to Post
 *
 * @param  obj $post
 * @param  int $attachment_id
 * @return void
 */
function jacobin_core_attach_featured_image( $post, $attachment_id ) {
  //Check if post has featured image
  //If no featured image, attach to post
}

/**
 * Delete First Media Item in Post Content
 *
 * @param  obj $post
 * @return void
 */
function jacobin_core_delete_first_media_in_post_content( $post ) {
  //Check if already deleted flag is set (we only want to do this once!)
  //If there is a caption shortcode, delete the first one, set flag and stop
  //If there is an image tag, delete the first one, set flag and stop
}
