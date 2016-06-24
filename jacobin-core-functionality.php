<?php
/**
 * Plugin Name:     Jacobin Core Functionality Plugin
 * Plugin URI:      https://github.com/misfist/jacobin-core-functionality
 * Description:     Contains the site's core functionality
 * Author:          Pea <pea@misfist.com>
 * Author URI:      https://github.com/misfist
 * Text Domain:     jacobin-core
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Core_Functionality
 */

if ( !defined( 'ABSPATH') ) {
    exit;
} // Disallow direct HTTP access.

/**
 * Plugin Directory
 *
 * @since 0.1.0
 */
define( 'JACOBIN_CORE_DIR', dirname( __FILE__ ) );


/**
 * Required files
 *
 * @since 0.1.0
 */
require_once( JACOBIN_CORE_DIR . '/includes/class-issues-custom-post-type.php' );
require_once( JACOBIN_CORE_DIR . '/includes/class-department-taxonomy.php' );
require_once( JACOBIN_CORE_DIR . '/includes/class-format-taxonomy.php' );
require_once( JACOBIN_CORE_DIR . '/includes/class-location-taxonomy.php' );