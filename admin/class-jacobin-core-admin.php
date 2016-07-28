<?php

/**
 * Jacobin Core Field Settings
 * 
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since       0.1.7
 * @license    GPL-2.0+
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link 		https://codex.wordpress.org/Settings_API
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @author     Pea <pea@misfist.com>
 */
class Jacobin_Core_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.7
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.7
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The setting
	 *
	 * @since    0.1.7
	 * @access   private
	 * @var      string    $setting    The setting that will be registered.
	 */
	private $setting  = 'jacobin_settings';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.7
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->setting = $this->get_settings();

		// Modify custom post args
		add_filter( 'issue_register_args', array( $this, 'modify_issue_args' ), 'issue' );
		add_filter( 'timeline_register_args', array( $this, 'modify_timeline_args' ), 'timeline' );
		add_filter( 'chart_register_args', array( $this, 'modify_chart_args' ), 'chart' );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Create Settings Page Menu Item
	 * `add_options_page` puts a menu item in the “Settings” menu
	 *
	 * @since    0.1.7
	 *
	 * @param string $page_title 	The text to be displayed in the title tags of the page when the menu is selected
	 * @param string $menu_title 	The text to be used for the menu 
	 * @param string $capability 	The capability required for this menu to be displayed to the user. 
	 * @param string $menu_slug 	The slug name to refer to this menu by (should be unique for this menu). 
	 * @param callback $callback 	The function to be called to output the content for this page.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_options_page
	 */
	public function admin_menu() {}

	/**
	 * Add Settings Sections
	 *
	 * @since    0.1.7
	 *
	 * @uses add_settings_section()
	 *
	 * @param string $id 	String for use in the 'id' attribute of tag. This is the same as in `$section` in  `add_settings_field`
	 * @param string $title 	Title of the section. 
	 * @param callback $callback 	Function that fills the section with the desired content. The function should echo its output.
	 * @param string $page 	The menu page on which to display this section. Should match $menu_slug
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_setting
	 * @link https://developer.wordpress.org/plugins/settings/creating-and-using-options/#adding-settings-sections
	 */
	public function settings_section() {}

	/**
	 * Add Setting Fields
	 *
	 * @since    0.1.7
	 *
	 * @param string $id 	String for use in the 'id' attribute of tags. 
	 * @param string $title 	Title of the field. 
	 * @param callback $callback 	Function that fills the field 
	 * with the desired inputs as part of the larger form. Passed 
	 * a single argument, the $args array. Name and id of the 
	 * input should match the $id given to this function. The 
	 * function should echo its output. 
	 * @param string $page 	The menu page on which to display this 
	 * field. Should match `$menu_slug` from `add_theme_page()` or 
	 * from `do_settings_sections()`. 
	 * @param string $section 	The section of the settings page in which to show the box. Should match 
	 * @param array $args 	Additional arguments that are passed to the $callback function.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
	 * @link https://developer.wordpress.org/plugins/settings/creating-and-using-options/#adding-settings-fields
	 */
	public function settings_fields() {}

	/**
	 * Register settings
	 *
	 * @since    0.1.7
	 *
	 * @uses register_settings()
	 *
	 * @param string $option_group 	A settings group name. Must exist prior to the `register_setting` call. This must match the group name in `settings_fields()`.
	 * @param string $option_name 	The name of an option to sanitize and save. 
	 * @param callback $sanitize_callback 	A callback function that sanitizes the option's value.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_setting
	 * @link https://developer.wordpress.org/plugins/settings/creating-and-using-options/#registering-a-setting
	 */
	public function register_settings() {}

	/**
	 * Slug field
	 * Called by `add_settings_field` to render field
	 *
	 * @since    0.1.7
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
	 */
	public function post_slug_field_render() {}

	/**
	 * Tax rewrite field
	 * Called by `add_settings_field` to render field
	 *
	 * @since    0.1.7
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_settings_field
	 */
	public function tax_slug_field_render() {}

	/**
	 * Settings callback
	 * Called by `add_options_page` to output the content for the page.
	 *
	 * @since    0.1.7
	 */
	public function settings_section_callback() {}

	/**
	 * Create menu item
	 * Called by `add_options_page` to output the content for the page.
	 *
	 * @since    0.1.7
	 */
	public function settings_page_callback() {
		include( 'views/jacobin-core-admin-display.php' );
	}

	/**
	 * Get Settings
	 * Get the name of the settings
	 *
	 * @since    0.1.2
	 */
	public function get_settings() {
		return $this->setting;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.2
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jacobin_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jacobin_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jacobin-core-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.2
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jacobin_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jacobin_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jacobin-core-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Sanitize input
	 *
	 * @since    0.1.2
	 *
	 * @param string $string
	 * @return sanitized string $string
	 */
	public function sanitize_string( $string ) {
		return sanitize_text_field( $string );
	}

	/**
	 * Modify Issue CPT Args
	 * @access  public
	 * @since   0.1.0
	 * @return  $args array
	 */
	public function modify_issue_args( $args ) {

	    $args['menu_icon'] = 'dashicons-book';
	    
	    return $args;

	} // End modify_issue_args 

	/**
	 * Modify Timeline CPT Args
	 * @access  public
	 * @since    0.1.2
	 * @return  $args array
	 */
	public function modify_timeline_args( $args ) {

	    $args['menu_icon'] = 'dashicons-list-view';
	    
	    return $args;

	} // End modify_timeline_args

	/**
	 * Modify Chart CPT Args
	 * @access  public
	 * @since    0.1.2
	 * @return  $args array
	 */
	public function modify_chart_args( $args ) {

	    $args['menu_icon'] = 'dashicons-chart-line';
	    
	    return $args;

	} // End modify_timeline_args


}
