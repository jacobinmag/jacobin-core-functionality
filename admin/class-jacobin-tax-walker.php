<?php
/**
 * Jacobin Core Taxonomy Walker Class
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since      0.2.2
 * @license    GPL-2.0+
 */

if( !class_exists( 'Walker_Category_Checklist' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/template.php' );
}

/**
 * Jacobin_Core_Taxonomy_Walker
 * Limit to 2 levels deep
 *
 * @since 0.2.2
 *
 * @uses class Walker_Category_Checklist
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_category_checklist
 * @link https://developer.wordpress.org/reference/classes/walker_category_checklist/
 */
class Jacobin_Core_Taxonomy_Walker extends Walker_Category_Checklist {

}
