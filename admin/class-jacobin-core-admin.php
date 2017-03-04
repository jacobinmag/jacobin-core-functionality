<?php
/**
 * Jacobin Core Field Settings
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since       0.1.4
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
	 * @since    0.1.4
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.4
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Setting Name
	 * Used for page name and setting name
	 *
	 * @since    0.1.4
	 * @access   private
	 * @var      string    $setting_name    The setting that will be registered.
	 */
	private $setting_name = 'featured_content';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.4
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		}

		/**
		 * Add JS to admin head for ACF
		 */
		add_action( 'acf/input/admin_head', array( $this, 'admin_head' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Modify custom post args
		add_filter( 'issue_register_args', array( $this, 'modify_issue_args' ), 'issue' );
		add_filter( 'timeline_register_args', array( $this, 'modify_timeline_args' ), 'timeline' );
		add_filter( 'chart_register_args', array( $this, 'modify_chart_args' ), 'chart' );

		/**
		 * Modify Taxonomy Levels
		 *
		 * @since 0.2.2
		 */
		//add_filter( 'wp_terms_checklist_args', array( $this, 'terms_checklist_args' ) );

	}

	/**
	 * Add an Options Page using ACF
	 *
	 * @since 0.1.14
	 *
	 * @uses acf_add_options_page()
	 */
	public function add_options_page() {
		if( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page( array(
				'page_title' 	=> __( 'Featured Content', 'jacobin-core' ),
				'menu_title'	=> __( 'Featured Content', 'jacobin-core' ),
				'menu_slug' 	=> 'featured-content',
				'capability'	=> 'edit_posts',
				'icon_url' 		=> 'dashicons-star-filled',
				'position' 		=> 50,
				'redirect'		=> false
			) );
		}
	}

	/**
	 * Get Settings
	 * Get the name of the settings
	 *
	 * @since    0.1.2
	 */
	public function get_setting_name() {
		return $this->setting_name;
	}

	/**
	 * Add Script to ACF Admin Head
	 *
	 * @since 0.2.7
	 *
	 * @link https://www.advancedcustomfields.com/resources/acfinputadmin_head/
	 *
	 * @return void
	 */
	public function admin_head() {
		?>
		 <script type="text/javascript">
		 (function($) {

				 $(document).ready(function(){

						 $('.acf-field-postexpert .acf-input').append( $('#postexcerpt #excerpt') );
						 $('#postexcerpt').remove();

						 $('#coauthorsdiv').insertAfter( '#submitdiv' );

				 });

		 })(jQuery);
		 </script>
		 <style type="text/css"></style>
	 <?php
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
	 * Sanitize Input
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
	}

	/**
	 * Modify Timeline CPT Args
	 * @access  public
	 * @since    0.1.2
	 * @return  $args array
	 */
	public function modify_timeline_args( $args ) {
	    $args['menu_icon'] = 'dashicons-list-view';
	    return $args;
	}

	/**
	 * Modify Chart CPT Args
	 * @access  public
	 * @since    0.1.2
	 * @return  $args array
	 */
	public function modify_chart_args( $args ) {
	    $args['menu_icon'] = 'dashicons-chart-line';
	    return $args;
	}

	/**
	 * Modify Taxonomy Args
	 * Specify a custom Walker class for taxonomy metaboxes
	 *
	 * @access  public
	 *
	 * @since    0.2.2
	 *
	 * @uses class Jacobin_Core_Taxonomy_Walker
	 * @uses wp_terms_checklist_args
	 * @link http://wpfilte.rs/wp_terms_checklist_args/
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function terms_checklist_args( $args ) {
		// if ( isset( $args['taxonomy'] ) && 'department' == $args['taxonomy'] ) {
		// 	$args['walker'] = new Jacobin_Core_Taxonomy_Walker;
		// }
		return $args;
	}

}
