<?php
/**
 * Plugin Name:     Jacobin Core Functionality Plugin
 * Plugin URI:      https://github.com/misfist/jacobin-core-functionality
 * Description:     Contains the site's core functionality
 *
 * Author:          Pea <pea@misfist.com>
 * Author URI:      https://github.com/misfist
 *
 * Text Domain:     jacobin-core
 * Domain Path:     /languages
 *
 * Version:         0.1.1
 *
 * @package         Core_Functionality
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-jacobin-core.php' );
require_once( 'includes/class-jacobin-core-settings.php' );
require_once( 'includes/class-jacobin-core-register-fields.php' );

// Load plugin libraries
require_once( 'includes/lib/class-jacobin-core-admin-api.php' );
require_once( 'includes/lib/class-jacobin-core-post-type.php' );
require_once( 'includes/lib/class-jacobin-core-taxonomy.php' );

/**
 * Returns the main instance of Jacobin_Core to prevent the need to use globals.
 *
 * @since  0.1.0
 * @return object Jacobin_Core
 */
function Jacobin_Core () {
	$instance = Jacobin_Core::instance( __FILE__, '0.1.1' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Jacobin_Core_Settings::instance( $instance );
	}

	return $instance;
}


Jacobin_Core();

/**
 * Register Custom Post types
 *
 * @since  0.1.0
 */
Jacobin_Core()->register_post_type( 
    'issue', 
    __( 'Issues', 'jacobin-core' ), 
    __( 'Issue', 'jacobin-core' )
);

/**
 * Register Custom Taxonomy
 *
 * @since  0.1.0
 */
Jacobin_Core()->register_taxonomy(
    'department',
    __( 'Departments', 'jacobin-core' ),
    __( 'Department', 'jacobin-core' ),
    'post'
);

Jacobin_Core()->register_taxonomy(
    'format',
    __( 'Formats', 'jacobin-core' ),
    __( 'Format', 'jacobin-core' ),
    'post'
);

Jacobin_Core()->register_taxonomy(
    'location',
    __( 'Locations', 'jacobin-core' ),
    __( 'Location', 'jacobin-core' ),
    'post'
);
