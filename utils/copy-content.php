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
  * @usage wp eval 'jacobin_copy_custom_fields();'
  *
  * @since 0.1.14
  *
  */
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
