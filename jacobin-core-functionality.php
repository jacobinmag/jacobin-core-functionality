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
 * Version:         0.5.23
 *
 * @package         Core_Functionality
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Directory
 *
 * @since 0.1.0
 */
define( 'JACOBIN_CORE_DIR', dirname( __FILE__ ) );
define( 'JACOBIN_CORE_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once 'includes/helpers.php';
require_once 'includes/customizations.php';

// Load plugin libraries
require_once 'includes/lib/class-jacobin-core-post-type.php';
require_once 'includes/lib/class-jacobin-core-taxonomy.php';

// Load plugin class files
require_once 'includes/class-jacobin-core.php';
require_once 'includes/class-jacobin-core-register-cpt.php';
require_once 'includes/class-jacobin-core-custom-fields.php';
require_once 'includes/class-jacobin-core-register-fields.php';
require_once 'includes/class-jacobin-core-register-routes.php';
require_once 'includes/class-jacobin-core-field-settings.php';
require_once 'includes/class-jacobin-core-shortcodes.php';

// Load admin files
require_once 'admin/class-jacobin-core-admin.php';

// Load utility files
require_once 'utils/copy-content.php';
require_once 'utils/media-utilities.php';
require_once 'utils/user-utilities.php';
require_once 'utils/revision-management.php';
require_once 'integrations/wp-cli.php';



/**
 * Returns the main instance of Jacobin_Core to prevent the need to use globals.
 *
 * @since  0.1.0
 * @return object Jacobin_Core
 */
function Jacobin_Core() {
	$instance = Jacobin_Core::instance( __FILE__, '0.5.23' );

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

Jacobin_Core()->register_post_type(
	'timeline',
	__( 'Timelines', 'jacobin-core' ),
	__( 'Timeline', 'jacobin-core' )
);

Jacobin_Core()->register_post_type(
	'chart',
	__( 'Charts', 'jacobin-core' ),
	__( 'Chart', 'jacobin-core' )
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
	'post',
	array(
		'rest_base' => 'departments',
	)
);

Jacobin_Core()->register_taxonomy(
	'format',
	__( 'Formats', 'jacobin-core' ),
	__( 'Format', 'jacobin-core' ),
	'post',
	array(
		'rest_base' => 'formats',
	)
);

Jacobin_Core()->register_taxonomy(
	'location',
	__( 'Locations', 'jacobin-core' ),
	__( 'Location', 'jacobin-core' ),
	'post',
	array(
		'rest_base' => 'locations',
	)
);

Jacobin_Core()->register_taxonomy(
	'series',
	__( 'Series', 'jacobin-core' ),
	__( 'Series', 'jacobin-core' ),
	'post'
);

/**
 * Register Internal Status Taxonomy
 */
Jacobin_Core()->register_taxonomy(
	'status-internal',
	__( 'Status', 'jacobin-core' ),
	__( 'Status', 'jacobin-core' ),
	array(
		'post',
		'issue',
	),
	array(
		'show_in_rest' => false,
		'rest_base'    => 'statuses-internal',
		'public'       => false,
	)
);
