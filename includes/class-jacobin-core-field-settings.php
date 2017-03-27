<?php
/**
 * Jacobin Core Field Settings
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

/**
 * Register and Set-up Fields
 *
 *
 * @since 0.1.0
 */
class Jacobin_Field_Settings {

    /**
     * The single instance of Jacobin_Field_Settings.
     * @var     object
     * @access  private
     * @since   1.0.0
     */
    private static $_instance = null;

    /**
     * Initialize all the things
     *
     * @since 0.1.0
     */
    function __construct() {
        /**
         * Remove Metaboxes
         *
         * @since 0.1.0
         *
         * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
         */
        add_action( 'admin_menu', array( $this, 'remove_meta_boxes' ) );

        add_action( 'acf/input/admin_head', array( $this, 'modify_interview_question_field_height' ) );

        add_filter( 'acf/fields/flexible_content/no_value_message', array( $this, 'modify_acf_flexible_content_message' ) );

        add_filter( 'acf/fields/relationship/query/name=translator', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=interviewer', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=name', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=cover_artist', array( $this, 'relationship_options_filter' ), 10, 3 );

        add_filter( 'acf/fields/relationship/query/name=article_issue_relationship', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=related_articles', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=featured_article', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=home_content', array( $this, 'relationship_options_filter' ), 10, 3 );
        add_filter( 'acf/fields/relationship/query/name=editors_pick', array( $this, 'relationship_options_filter' ), 10, 3 );

     }

    /**
     * Register the custom fields
     *
     * @since 0.1.0
     */
    function register() {}


    /**
     * Filter out unpublished posts
     * Relationship fields will only show posts where `post_status = publish`
     *
     * @since 0.2.8
     *
     * @access public
     *
     * @param  array $options
     * @param  string $field
     * @param  obj $the_post
     * @return array $options
     */
    public function relationship_options_filter( $options, $field, $the_post ) {

    	$options['post_status'] = array( 'publish' );

    	return $options;
    }

    /**
     * Remove standard WordPress metaboxes for custom taxonomies.
     *
     * @since  0.1.0
     */
    function remove_meta_boxes() {
        remove_meta_box( 'seriesdiv', 'post', 'side' );
        remove_meta_box( 'formatdiv', 'post', 'side' );
        remove_meta_box( 'formatdiv', 'issue', 'side' );
        remove_meta_box( 'authordiv', 'issue', 'side' );
    }

    /**
     * Descrease height of interview question editor box
     *
     * @return null
     */
    public function modify_interview_question_field_height() {

        if( 'post' == get_post_type() ) { ?>
            <style>
        		.small .acf-editor-wrap iframe,
            .small .acf-editor-wrap .wp-editor-area {
        			height: 150px !important;
        			min-height: 150px;
        		}
        	</style>
            <?php
        }

    }

    public function modify_acf_flexible_content_message( $no_value_message ) {
        $no_value_message = __( 'Click the "%s" button below to add a section', 'jacobin-core' );

        return $no_value_message;
    }

}

new Jacobin_Field_Settings();
