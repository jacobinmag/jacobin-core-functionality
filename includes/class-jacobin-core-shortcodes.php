<?php
/**
 * Jacobin Core Register Shortcodes
 * 
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.3
 * @license    GPL-2.0+
 */

/**
 * Register Shortcodes
 *
 * @since 0.1.3
 *
 */
class Jacobin_Register_Shortcodes {

    /**
     * Initialize all the things
     *
     * @since 0.1.3
     *
     */
    function __construct() {

        add_action( 'init', array( $this, 'detect_shortcode_ui' ) );
        add_action( 'init', array( $this, 'register_shortcodes' ) );
    }

    /**
     * Detect if Shortcode UI is activated
     *
     * @since 0.1.3
     *
     */
    public function detect_shortcode_ui() {
        if ( !function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
            add_action( 'admin_notices', array( $this, 'shortcode_ui_notices' ) );
        }
    }

    /**
     * Show message if Shortcode UI not activated
     *
     * @since 0.1.3
     *
     */
    public function shortcode_ui_notices() {
        if ( current_user_can( 'activate_plugins' ) ) {
            ?>
            <div class="error message">
                <p><?php esc_html_e( 'Shortcode UI plugin must be active in order to take advantage of an improved shortcode user interface.', 'jacobin-core' ); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Register shortcodes
     *
     * @since 0.1.3
     *
     * @param string $shortcode_tag
     * @param function $shortcode_function
     *
     */
    public function register_shortcodes() {
        add_shortcode( 'embed-timeline', array( $this, 'embed_timeline_shortcode' ) );
        add_action( 'register_shortcode_ui', array( $this, 'embed_timeline_shortcode_ui' ) );
    }

    /**
     * Register Shortcode with Shortcode UI
     *
     * @since 0.1.3
     *
     * @param string $shortcode_tag
     * @param function $shortcode_function
     *
     */
    public function register_shortcode_ui() {}

    /**
     * Callback for the `embed_timeline` shortcode.
     *
     * It renders the shortcode based on supplied attributes.
     *
     * @example `[embed-timeline post_id="382"]` where post_id is the ID of timeline post
     *
     * @since 0.1.3
     *
     * @param string $attr
     * @param string $content
     * @param string $shortcode_tag
     */
    public function embed_timeline_shortcode( $attr, $content, $shortcode_tag ) {
        $attr = shortcode_atts( array(
            'post_id'     => '',
        ), $attr, $shortcode_tag );

        global $wpdb;

        // Output buffering here.
        ob_start();
        
        include_once ( 'views/embed-timeline.php' );

        return ob_get_clean();
    }

    /**
     * Embed Timeline Shortcode UI
     *
     * @since 0.1.3
     *
     */
    public function embed_timeline_shortcode_ui() {
        $fields = array(
            array(
                'label'    => esc_html__( 'Select Timeline', 'jacobin-core' ),
                'attr'     => 'post_id',
                'type'     => 'post_select',
                'query'    => array( 'post_type' => 'timeline' ),
                'multiple' => false,
            ),
        );

        /*
         * Define the Shortcode UI arguments.
         */
        $shortcode_ui_args = array(
            'label'         => esc_html__( 'Embed Timeline', 'jacobin-core' ),
            'listItemImage' => 'dashicons-list-view',
            'post_type'     => array( 'post' ),
            'attrs'         => $fields,
        );

        shortcode_ui_register_for_shortcode( 'embed-timeline', $shortcode_ui_args );
    }

}

new Jacobin_Register_Shortcodes();
