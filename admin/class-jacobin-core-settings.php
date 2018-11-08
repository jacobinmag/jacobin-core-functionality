<?php
/**
 * Jacobin Core Field Settings
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since      0.5.3
 * @license    GPL-2.0+
 */

 class Core_Functionality_Settings {

	 public function __construct() {
		 add_action( 'admin_init', array( $this, 'setup_sections' ) );
		 add_action( 'admin_init', array( $this, 'setup_fields' ) );
	 }

	 /**
	  * Setup the Sections
	  *
	  * @since 0.5.3
	  *
	  * @uses add_settings_section
	  * @link https://developer.wordpress.org/reference/functions/add_settings_section/
	  *
	  * @return void
	  */
	 public function setup_sections() {
		 add_settings_section(
			 'frontend_settings_section',
			 __( 'Frontend Settings', 'jacobin-core' ),
			 array( $this, 'section_callback' ),
			 'general'
		 );
	 }

	 /**
	  * Section Callback
	  * Render the section
	  *
	  * @since 0.5.3
	  *
	  * @link
	  *
	  * @return void
	  */
	 public function section_callback( $args ) {
		 if( 'frontend_settings_section' === $args['id'] ) { ?>

			 <?php _e( 'Settings for the front-end display of post previews and revisions.', 'jacobin-core' ); ?>

		 <?php
		 }
	 }

	 /**
	  * Setup the Fields
	  *
	  * @since 0.5.3
	  *
	  * @uses add_settings_field()
	  * @uses register_setting()
	  *
	  * @link https://developer.wordpress.org/reference/functions/add_settings_field/
	  * @link https://developer.wordpress.org/reference/functions/register_setting/
	  *
	  * @return void
	  */
	 public function setup_fields() {
		 $fields = array(
			 array(
				 'uid' 					=> 'frontend_url',
				 'label' 				=> __( 'Frontend URL', 'jacobin-core' ),
				 'section' 			=> 'frontend_settings_section',
				 'type' 				=> 'url',
				 'placeholder' 	=> esc_attr( 'https://jacobinmag.com' ),
				 // 'helper' 				=> 'Does this help?',
				 'supplemental' 	=> __( 'The URL at which visitors see your site.', 'jacobin-core' ),
			 ),
			 array(
				 'uid' 					=> 'frontend_token',
				 'label' 				=> __( 'Token', 'jacobin-core' ),
				 'section' 			=> 'frontend_settings_section',
				 'type' 				=> 'text',
				 'placeholder' 	=> esc_attr( 'r4nd0MstR1n6' ),
				 'supplemental' => __( 'The token used to retrieve draft posts and revisions.', 'jacobin-core' ),
			 ),
		 );

		 foreach( $fields as $field ) {
			 add_settings_field(
				 $field['uid'],
				 $field['label'],
				 array( $this, 'field_callback' ),
				 'general',
				 $field['section'],
				 $field
			 );
			 register_setting( 'general', $field['uid'] );
		 }
	 }

	 /**
	  * Field Callback
	  * Render the fields
	  *
	  * @since 0.5.3
		*
	  * @return void
	  */
	 public function field_callback( $args ) {

		 $value = get_option( $args['uid'] );

		 if( ! $value ) {
			 $value = $args['default'];
		 }

		 switch( $args['type'] ){
			 case 'text':
			 case 'password':
			 case 'number':
			 case 'url':
				 printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" class="regular-text" />',
					 $args['uid'], $args['type'],
					 $args['placeholder'],
					 $value
				 );
				 break;
			 case 'textarea':
				 printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
					 $args['uid'],
					 $args['placeholder'],
					 $value
				 );
				 break;
			 case 'select':
			 case 'multiselect':
				 if( ! empty ( $args['options'] ) && is_array( $args['options'] ) ){
					 $attributes = '';
					 $options_markup = '';
					 foreach( $args['options'] as $key => $label ){
						 $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
					 }
					 if( $args['type'] === 'multiselect' ){
						 $attributes = ' multiple="multiple" ';
					 }
					 printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>',
						 $args['uid'],
						 $attributes,
						 $options_markup
					 );
				 }
				 break;
			 case 'radio':
			 case 'checkbox':
				 if( ! empty ( $args['options'] ) && is_array( $args['options'] ) ) {
					 $options_markup = '';
					 $iterator = 0;
					 foreach( $args['options'] as $key => $label ){
						 $iterator++;
						 $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
						 $args['uid'],
						 $args['type'],
						 $key,
						 checked( $value[ array_search( $key, $value, true ) ], $key, false ),
						 $label,
						 $iterator
					 );
				 }
				 printf( '<fieldset>%s</fieldset>', $options_markup );
			 }
			 break;
	 }

	 if( isset( $args['helper'] ) ) {
		 printf( '<span class="helper"> %s</span>', $args['helper'] );
	 }

	 if( isset( $args['supplemental'] ) ){
		 printf( '<p class="description">%s</p>', $args['supplemental'] );
	 }

	}

}
new Core_Functionality_Settings();
