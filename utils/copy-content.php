<?php
/**
 * Jacobin Core Copy Content
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.14
 * @license    GPL-2.0+
 */

 /**
  * Copy Meta Fields
  * Copies meta field data from `_additional_content_*` fields to new custom fields
  *
  * @usage http://yourdomain.com/?run_jacobin_copy_custom_fields
  *
  * @since 0.1.14
  *
  */
 if ( isset( $_GET['run_jacobin_copy_custom_fields'] ) && ! get_option( 'jacobin_copy_custom_fields_complete' ) ) {
     add_action( 'init', 'jacobin_copy_custom_fields', 10 );
     add_action( 'init', 'jacobin_copy_custom_fields_finished', 20 );
 }

 function jacobin_copy_custom_fields() {
     $args = array(
         'post_type' => 'post',
         'posts_per_page' => -1,
         'post_status' => 'any'
     );

     $posts = get_posts( $args );

     foreach( $posts as $post ) {
         $old_meta = $post->post_excerpt;
         if( !empty( $old_meta ) ) {
             add_post_meta( $post->ID, 'subhead', $old_meta, true );
         }
     }

 }
 add_action( 'init', 'jacobin_copy_custom_fields', 10 );

 /**
  * Add `jacobin_copy_custom_fields_complete` Once Function is Run
  *
  * @since 0.1.14
  */
 function jacobin_copy_custom_fields_finished() {
     add_option( 'jacobin_copy_custom_fields_complete', 1 );
     die( "Script finished." );
 }
