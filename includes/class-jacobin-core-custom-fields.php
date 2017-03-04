<?php
/**
 * Jacobin Core Register Custom Fields
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.2.0
 * @license    GPL-2.0+
 */

 /**
  * Register Custom Fields
  *
  * @since 0.2.0
  *
  */
 class Jacobin_Core_Custom_Fields {

     private $slug = '';

     /**
      * Initialize all the things
      *
      * @since 0.2.0
      *
      */
     function __construct() {

         if( function_exists( 'register_field_group' ) ) {
             $this->register_field_groups();
             $this->register_settings_fields();
         }
     }

     /**
      * Register Clone Fields
      * Register fields that will be used as clone-able fields
      *
      * @since 0.2.7
      *
      * @depends on ACF 5.5+
      * @link https://www.advancedcustomfields.com/resources/clone/
      *
      * @return void
      */
     public function register_clone_fields() {
       acf_add_local_field_group(array (
        	'key' => 'group_58b9cbbf18c46',
        	'title' => 'Featured Posts',
        	'fields' => array (
        		array (
        			'key' => 'field_58b9cbd0ce677',
        			'label' => 'Featured Posts (5 max)',
        			'name' => 'featured_posts',
        			'type' => 'relationship',
        			'instructions' => '',
        			'required' => 0,
        			'conditional_logic' => 0,
        			'wrapper' => array (
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'post_type' => array (
        				0 => 'post',
        			),
        			'taxonomy' => array (
        			),
        			'filters' => array (
        				0 => 'search',
        				1 => 'taxonomy',
        			),
        			'elements' => array (
        				0 => 'featured_image',
        			),
        			'min' => 1,
        			'max' => 5,
        			'return_format' => 'id',
        		),
        		array (
        			'key' => 'field_58b9ce520c8e2',
        			'label' => 'Featured Post (Single)',
        			'name' => 'featured_post',
        			'type' => 'relationship',
        			'instructions' => '',
        			'required' => 0,
        			'conditional_logic' => 0,
        			'wrapper' => array (
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'post_type' => array (
        				0 => 'post',
        			),
        			'taxonomy' => array (
        			),
        			'filters' => array (
        				0 => 'search',
        				1 => 'taxonomy',
        			),
        			'elements' => array (
        				0 => 'featured_image',
        			),
        			'min' => 1,
        			'max' => 1,
        			'return_format' => 'id',
        		),
        	),
        	'location' => array (
        		array (
        			array (
        				'param' => 'post_type',
        				'operator' => '==',
        				'value' => 'post',
        			),
        		),
        	),
        	'menu_order' => 0,
        	'position' => 'normal',
        	'style' => 'default',
        	'label_placement' => 'top',
        	'instruction_placement' => 'label',
        	'hide_on_screen' => '',
        	'active' => 0,
        	'description' => '',
        ));
     }

     /**
      * Register Field Groups
      *
      * @since 0.2.0
      *
      * @uses register_field_group()
      *
      * @return void
      */
     public function register_field_groups() {
       /**
        * Post Default Custom Fields
        */
       acf_add_local_field_group(array (
       	'key' => 'group_5771c00b7ae29',
       	'title' => __( 'Article Details', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_577c36bfea22d',
       			'label' => __( 'Subhead (DEK)', 'jacobin-core' ),
       			'name' => 'subhead',
       			'type' => 'textarea',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       			'maxlength' => '',
       			'rows' => 2,
       			'new_lines' => 'wpautop',
       			'readonly' => 0,
       			'disabled' => 0,
       		),
       		array (
       			'key' => 'field_57dc2f429f3be',
       			'label' => __( 'Translator', 'jacobin-core' ),
       			'name' => 'translator',
       			'type' => 'post_object',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'guest-author',
       			),
       			'taxonomy' => array (
       			),
       			'allow_null' => 0,
       			'multiple' => 0,
       			'return_format' => 'id',
       			'ui' => 1,
       		),
       		array (
       			'key' => 'field_57dd86962d2be',
       			'label' => __( 'Republication Information', 'jacobin-core' ),
       			'name' => '',
       			'type' => 'message',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'message' => __( 'If this is a reprinted article, please enter the publication name and source URL below.', 'jacobin-core' ),
       			'new_lines' => 'wpautop',
       			'esc_html' => 0,
       		),
       		array (
       			'key' => 'field_57dd862034e48',
       			'label' => __( 'Name', 'jacobin-core' ),
       			'name' => 'publication_name',
       			'type' => 'text',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       			'prepend' => '',
       			'append' => '',
       			'maxlength' => '',
       		),
       		array (
       			'key' => 'field_57dd864f34e49',
       			'label' => __( 'Source', 'jacobin-core' ),
       			'name' => 'publication_source',
       			'type' => 'url',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       		),
       		array (
       			'key' => 'field_577c36376ad8a',
       			'label' => __( 'Related Content', 'jacobin-core' ),
       			'name' => '',
       			'type' => 'tab',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'placement' => 'top',
       			'endpoint' => 0,
       		),
       		array (
       			'key' => 'field_577c36843f7ba',
       			'label' => __( 'In Issue', 'jacobin-core' ),
       			'name' => 'article_issue_relationship',
       			'type' => 'relationship',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'issue',
       			),
       			'taxonomy' => array (
       			),
       			'filters' => array (
       				0 => 'search',
       			),
       			'elements' => array (
       				0 => 'featured_image',
       			),
       			'min' => '',
       			'max' => '',
       			'return_format' => 'object',
       		),
       		array (
       			'key' => 'field_577c365d6ad8b',
       			'label' => __( 'Related Articles', 'jacobin-core' ),
       			'name' => 'related_articles',
       			'type' => 'relationship',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'post',
       			),
       			'taxonomy' => array (
       			),
       			'filters' => array (
       				0 => 'search',
       				1 => 'taxonomy',
       			),
       			'elements' => array (
       				0 => 'featured_image',
       			),
       			'min' => '',
       			'max' => '',
       			'return_format' => 'object',
       		),
       		array (
       			'key' => 'field_5769f8c1df896',
       			'label' => __( 'Gallery', 'jacobin-core' ),
       			'name' => '',
       			'type' => 'tab',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'placement' => 'top',
       			'endpoint' => 0,
       		),
       		array (
       			'key' => 'field_5771c0e375fa5',
       			'label' => __( 'Gallery', 'jacobin-core' ),
       			'name' => 'gallery',
       			'type' => 'gallery',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'min' => '',
       			'max' => '',
       			'preview_size' => 'thumbnail',
       			'library' => 'all',
       			'min_width' => '',
       			'min_height' => '',
       			'min_size' => '',
       			'max_width' => '',
       			'max_height' => '',
       			'max_size' => '',
       			'mime_types' => '',
       			'insert' => 'append',
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'post',
       			),
       		),
       	),
       	'menu_order' => 40,
       	'position' => 'normal',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       ));

       /**
        * Post Content Custom Fields
        */
        acf_add_local_field_group( array(
        	'key' => 'group_58ade90c4e2a0',
        	'title' => __( 'Interviewer', 'jacobin-core' ),
        	'fields' => array (
        		array (
        			'key' => 'field_58ade9120d132',
        			'label' => __( 'Interviewer Name', 'jacobin-core' ),
        			'name' => 'interviewer',
        			'type' => 'post_object',
        			'instructions' => '',
        			'required' => 0,
        			'conditional_logic' => 0,
        			'wrapper' => array (
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'post_type' => array(
        				0 => 'guest-author',
        			),
        			'taxonomy' => array(
        			),
        			'allow_null' => 0,
        			'multiple' => 1,
        			'return_format' => 'object',
        			'ui' => 1,
        		),
        	),
        	'location' => array(
        		array (
        			array (
        				'param' => 'post_taxonomy',
        				'operator' => '==',
        				'value' => 'format:interview',
        			),
        			array (
        				'param' => 'post_type',
        				'operator' => '==',
        				'value' => 'post',
        			),
        		),
        	),
        	'menu_order' => 0,
        	'position' => 'normal',
        	'style' => 'default',
        	'label_placement' => 'top',
        	'instruction_placement' => 'label',
        	'hide_on_screen' => '',
        	'active' => 1,
        	'description' => '',
        ));

       acf_add_local_field_group(array (
       	'key' => 'group_57dee289876c8',
       	'title' => __( 'Content Sections', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_57dee2924c6a4',
       			'label' => __( 'Sections', 'jacobin-core' ),
       			'name' => 'sections',
       			'type' => 'flexible_content',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'button_label' => __( 'Add Section', 'jacobin-core' ),
       			'min' => '',
       			'max' => '',
       			'layouts' => array (
       				array (
       					'key' => '57dee89925c60',
       					'name' => 'standard',
       					'label' => __( 'Text', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df284cac389',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57dee8a625c61',
       							'label' => __( 'Standard', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'repeater',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'collapsed' => '',
       							'min' => '',
       							'max' => '',
       							'layout' => 'block',
       							'button_label' => __( 'Add Content', 'jacobin-core' ),
       							'sub_fields' => array (
       								array (
       									'key' => 'field_57def573d812d',
       									'label' => 'Content',
       									'name' => 'content',
       									'type' => 'wysiwyg',
       									'instructions' => '',
       									'required' => 0,
       									'conditional_logic' => 0,
       									'wrapper' => array (
       										'width' => '',
       										'class' => '',
       										'id' => '',
       									),
       									'default_value' => '',
       									'tabs' => 'all',
       									'toolbar' => 'full',
       									'media_upload' => 1,
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57dee4dd217ce',
       					'name' => 'annotated_booklist',
       					'label' => __( 'Annotated Booklist', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df287aac38a',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57dee50a217cf',
       							'label' => __( 'Annotated Booklist', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'button_label' => __( 'Add Book', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57dee52f8f9d0',
       									'name' => 'content',
       									'label' => __( 'Booklist', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57dee572217d0',
       											'label' => __( 'Title', 'jacobin-core' ),
       											'name' => 'title',
       											'type' => 'text',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'placeholder' => '',
       											'prepend' => '',
       											'append' => '',
       											'maxlength' => '',
       										),
       										array (
       											'key' => 'field_57dee587217d1',
       											'label' => __( 'Author', 'jacobin-core' ),
       											'name' => 'author',
       											'type' => 'text',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'placeholder' => '',
       											'prepend' => '',
       											'append' => '',
       											'maxlength' => '',
       										),
       										array (
       											'key' => 'field_57dee5bf217d2',
       											'label' => __( 'Featured Image', 'jacobin-core' ),
       											'name' => 'featured_media',
       											'type' => 'image',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'return_format' => 'array',
       											'preview_size' => 'thumbnail',
       											'library' => 'all',
       											'min_width' => '',
       											'min_height' => '',
       											'min_size' => '',
       											'max_width' => '',
       											'max_height' => '',
       											'max_size' => '',
       											'mime_types' => '',
       										),
       										array (
       											'key' => 'field_57dee5f1217d3',
       											'label' => __( 'Publisher', 'jacobin-core' ),
       											'name' => 'publisher',
       											'type' => 'text',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'placeholder' => '',
       											'prepend' => '',
       											'append' => '',
       											'maxlength' => '',
       										),
       										array (
       											'key' => 'field_57dee601217d4',
       											'label' => __( 'Publication Date', 'jacobin-core' ),
       											'name' => 'publication_date',
       											'type' => 'date_picker',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'display_format' => 'F j, Y',
       											'return_format' => 'm/d/Y',
       											'first_day' => 1,
       										),
       										array (
       											'key' => 'field_57dee634217d5',
       											'label' => __( 'Commentary', 'jacobin-core' ),
       											'name' => 'commentary',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57dee2a218aa8',
       					'name' => 'interview',
       					'label' => __( 'Interview', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57dee2c04c6a5',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57dee2fb4c6a6',
       							'label' => __( 'Questions & Answers', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => 'questions-block',
       								'id' => '',
       							),
       							'button_label' => __( 'Add Question', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57dee307ee72c',
       									'name' => 'content',
       									'label' => __( 'Question', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57dee34d4c6a7',
       											'label' => __( 'Question', 'jacobin-core' ),
       											'name' => 'question',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => '',
       											'conditional_logic' => '',
       											'wrapper' => array (
       												'width' => '',
       												'class' => 'small',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => '',
       										),
       										array (
       											'key' => 'field_57dee3834c6a8',
       											'label' => __( 'Answer', 'jacobin-core' ),
       											'name' => 'answer',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57dee70e6307e',
       					'name' => 'glossary',
       					'label' => __( 'Glossary', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df2893ac38b',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57dee75e63081',
       							'label' => __( 'Glossary', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'button_label' => __( 'Add Glossary Item', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57dee762c45ab',
       									'name' => 'content',
       									'label' => __( 'Glossary', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57dee79063082',
       											'label' => __( 'Term', 'jacobin-core' ),
       											'name' => 'term',
       											'type' => 'text',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'placeholder' => '',
       											'prepend' => '',
       											'append' => '',
       											'maxlength' => '',
       										),
       										array (
       											'key' => 'field_57dee7ae63083',
       											'label' => __( 'Definition', 'jacobin-core' ),
       											'name' => 'content',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57deed52bb981',
       					'name' => 'listicle',
       					'label' => __( 'Listicle', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df289cac38c',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57deed5cbb982',
       							'label' => __( 'Listicle', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'button_label' => __( 'Add List Item', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57deed655068c',
       									'name' => 'content',
       									'label' => __( 'Listicle', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57deee58bb983',
       											'label' => __( 'List Content', 'jacobin-core' ),
       											'name' => 'content',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       										array (
       											'key' => 'field_57deee65bb984',
       											'label' => __( 'Featured Image', 'jacobin-core' ),
       											'name' => 'featured_media',
       											'type' => 'image',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'return_format' => 'array',
       											'preview_size' => 'thumbnail',
       											'library' => 'all',
       											'min_width' => '',
       											'min_height' => '',
       											'min_size' => '',
       											'max_width' => '',
       											'max_height' => '',
       											'max_size' => '',
       											'mime_types' => '',
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57deef316fcce',
       					'name' => 'passages',
       					'label' => __( 'Passages', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df28a4ac38d',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57deef326fccf',
       							'label' => __( 'Passages', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'button_label' => __( 'Add Passage Item', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57dee762c45ab',
       									'name' => 'content',
       									'label' => __( 'Passages', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57deef326fcd0',
       											'label' => __( 'Quote', 'jacobin-core' ),
       											'name' => 'content',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       										array (
       											'key' => 'field_57deef326fcd1',
       											'label' => __( 'Citation', 'jacobin-core' ),
       											'name' => 'citation',
       											'type' => 'text',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'placeholder' => '',
       											'prepend' => '',
       											'append' => '',
       											'maxlength' => '',
       										),
       										array (
       											'key' => 'field_57deef9e6fcd2',
       											'label' => __( 'Commentary', 'jacobin-core' ),
       											'name' => 'commentary',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       				array (
       					'key' => '57def14c7e894',
       					'name' => 'roundtable',
       					'label' => __( 'Roundtable', 'jacobin-core' ),
       					'display' => 'block',
       					'sub_fields' => array (
       						array (
       							'key' => 'field_57df28b5ac38e',
       							'label' => __( 'Title', 'jacobin-core' ),
       							'name' => 'title',
       							'type' => 'text',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'default_value' => '',
       							'placeholder' => '',
       							'prepend' => '',
       							'append' => '',
       							'maxlength' => '',
       						),
       						array (
       							'key' => 'field_57def14c7e895',
       							'label' => __( 'Roundtable', 'jacobin-core' ),
       							'name' => 'section',
       							'type' => 'flexible_content',
       							'instructions' => '',
       							'required' => 0,
       							'conditional_logic' => 0,
       							'wrapper' => array (
       								'width' => '',
       								'class' => '',
       								'id' => '',
       							),
       							'button_label' => __( 'Add Roundtable Item', 'jacobin-core' ),
       							'min' => '',
       							'max' => '',
       							'layouts' => array (
       								array (
       									'key' => '57dee762c45ab',
       									'name' => 'content',
       									'label' => __( 'Roundtable', 'jacobin-core' ),
       									'display' => 'block',
       									'sub_fields' => array (
       										array (
       											'key' => 'field_57def14c7e896',
       											'label' => __( 'Name', 'jacobin-core' ),
       											'name' => 'name',
       											'type' => 'post_object',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'post_type' => array (
       												0 => 'guest-author',
       											),
       											'taxonomy' => array (
       											),
       											'allow_null' => 0,
       											'multiple' => 0,
       											'return_format' => 'id',
       											'ui' => 1,
       										),
       										array (
       											'key' => 'field_57def14c7e897',
       											'label' => __( 'Statement', 'jacobin-core' ),
       											'name' => 'content',
       											'type' => 'wysiwyg',
       											'instructions' => '',
       											'required' => 0,
       											'conditional_logic' => 0,
       											'wrapper' => array (
       												'width' => '',
       												'class' => '',
       												'id' => '',
       											),
       											'default_value' => '',
       											'tabs' => 'all',
       											'toolbar' => 'full',
       											'media_upload' => 1,
       										),
       									),
       									'min' => '',
       									'max' => '',
       								),
       							),
       						),
       					),
       					'min' => '',
       					'max' => '',
       				),
       			),
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'post',
       			),
       		),
       	),
       	'menu_order' => 0,
       	'position' => 'normal',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       ));

       /**
        * Post Secondary Image
        */
       acf_add_local_field_group(array (
       	'key' => 'group_5771caab0d24c',
       	'title' => __( 'Featured Image (Secondary)', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_5771cab68c3bc',
       			'label' => __( 'Featured Image', 'jacobin-core' ),
       			'name' => 'featured_image_secondary',
       			'type' => 'image',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'return_format' => 'array',
       			'preview_size' => 'thumbnail',
       			'library' => 'all',
       			'min_width' => '',
       			'min_height' => '',
       			'min_size' => '',
       			'max_width' => '',
       			'max_height' => '',
       			'max_size' => '',
       			'mime_types' => '',
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'post',
       			),
       		),
       	),
       	'menu_order' => 500,
       	'position' => 'side',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       	'local' => 'php',
       ));

       /**
        * Post Taxonomy Fields
        */
       acf_add_local_field_group(array (
       	'key' => 'group_57df5d71bea6c',
       	'title' => __( 'Taxonomy', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_577c3d9dc2b83',
       			'label' => __( 'Series', 'jacobin-core' ),
       			'name' => 'series',
       			'type' => 'taxonomy',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'taxonomy' => 'series',
       			'field_type' => 'select',
       			'allow_null' => 0,
       			'add_term' => 1,
       			'save_terms' => 1,
       			'load_terms' => 1,
       			'return_format' => 'object',
       			'multiple' => 0,
       		),
       		array (
       			'key' => 'field_5769f5d4f7ed2',
       			'label' => __( 'Format', 'jacobin-core' ),
       			'name' => 'format',
       			'type' => 'taxonomy',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'taxonomy' => 'format',
       			'field_type' => 'select',
       			'allow_null' => 0,
       			'add_term' => 0,
       			'save_terms' => 1,
       			'load_terms' => 1,
       			'return_format' => 'object',
       			'multiple' => 0,
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'post',
       			),
       		),
       	),
       	'menu_order' => 1,
       	'position' => 'side',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       ));

       /**
        * Paywall Boolean
        */
       acf_add_local_field_group(array (
       	'key' => 'group_57cb51cb228d7',
       	'title' => __( 'Paywall', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_57cb51d4de8da',
       			'label' => __( 'Paywall', 'jacobin-core' ),
       			'name' => 'paywall',
       			'type' => 'true_false',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'message' => '',
       			'default_value' => 0,
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'post',
       			),
       		),
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'issue',
       			),
       		),
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'page',
       			),
       		),
       	),
       	'menu_order' => 5,
       	'position' => 'side',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       ));

       /**
        * Department Taxonomy Term Meta Fields
        */
       acf_add_local_field_group(array (
       	'key' => 'group_5771c00b6a407',
       	'title' => __( 'Department Details', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_5761b03bee6a6',
       			'label' => __( 'Featured Article', 'jacobin-core' ),
       			'name' => 'featured_article',
       			'type' => 'relationship',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'post',
       			),
       			'taxonomy' => array (
       			),
       			'min' => '',
       			'max' => 1,
       			'filters' => array (
       				0 => 'search',
       			),
       			'elements' => '',
       			'return_format' => 'id',
       		),
       		array (
       			'key' => 'field_5832647946492',
       			'label' => __( 'Image', 'jacobin-core' ),
       			'name' => 'featured_image',
       			'type' => 'image',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'return_format' => 'url',
       			'preview_size' => 'thumbnail',
       			'library' => 'all',
       			'min_width' => '',
       			'min_height' => '',
       			'min_size' => '',
       			'max_width' => '',
       			'max_height' => '',
       			'max_size' => '',
       			'mime_types' => '',
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'taxonomy',
       				'operator' => '==',
       				'value' => 'department',
       			),
       		),
       	),
       	'menu_order' => 0,
       	'position' => 'normal',
       	'style' => 'seamless',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       	'local' => 'php',
       ));

       /**
        * Chart Custom Post Type Fields
        */
       acf_add_local_field_group( array (
       	'key' => 'group_579a3a3ac715e',
       	'title' => __( 'Charts', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_579a3a3f8b89b',
       			'label' => __( 'Code', 'jacobin-core' ),
       			'name' => 'chart_code',
       			'type' => 'acf_code_field',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       			'mode' => 'javascript',
       			'theme' => 'neo',
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'chart',
       			),
       		),
       	),
       	'menu_order' => 0,
       	'position' => 'acf_after_title',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => array (
       		0 => 'excerpt',
       		1 => 'custom_fields',
       		2 => 'format',
       		3 => 'page_attributes',
       		4 => 'featured_image',
       		5 => 'categories',
       		6 => 'tags',
       	),
       	'active' => 1,
       	'description' => '',
       	'local' => 'php',
       ));

       /**
        * Issue Post Type Custom Fields
        */
       acf_add_local_field_group(array (
       	'key' => 'group_5771c00b6d7c6',
       	'title' => __( 'Issue Details', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_57d77a965c5fa',
       			'label' => __( 'Cover Artist', 'jacobin-core' ),
       			'name' => 'cover_artist',
       			'type' => 'post_object',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'guest-author',
       			),
       			'taxonomy' => array (
       			),
       			'allow_null' => 0,
       			'multiple' => 0,
       			'return_format' => 'object',
       			'ui' => 1,
       		),
       		array (
       			'key' => 'field_577c37f0e7b8b',
       			'label' => __( 'Subhead (DEK)', 'jacobin-core' ),
       			'name' => 'subhead',
       			'type' => 'textarea',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       			'maxlength' => '',
       			'rows' => 2,
       			'new_lines' => 'wpautop',
       			'readonly' => 0,
       			'disabled' => 0,
       		),
       		array (
       			'key' => 'field_57cb88a7b0567',
       			'label' => __( 'Issue Number', 'jacobin-core' ),
       			'name' => 'issue_number',
       			'type' => 'text',
       			'instructions' => '',
       			'required' => 1,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'default_value' => '',
       			'placeholder' => '',
       			'prepend' => '',
       			'append' => '',
       			'maxlength' => '',
       		),
       		array (
       			'key' => 'field_5761b4a265e4e',
       			'label' => __( 'Featured Article', 'jacobin-core' ),
       			'name' => 'featured_article',
       			'type' => 'relationship',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'post',
       			),
       			'taxonomy' => array (
       			),
       			'filters' => array (
       				0 => 'search',
       				1 => 'taxonomy',
       			),
       			'elements' => array (
       				0 => 'featured_image',
       			),
       			'min' => '',
       			'max' => 1,
       			'return_format' => 'object',
       		),
       		array (
       			'key' => 'field_577c3793def91',
       			'label' => __( 'Articles in Issue', 'jacobin-core' ),
       			'name' => 'article_issue_relationship',
       			'type' => 'relationship',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'post_type' => array (
       				0 => 'post',
       			),
       			'taxonomy' => array (
       			),
       			'filters' => array (
       				0 => 'search',
       				1 => 'taxonomy',
       			),
       			'elements' => array (
       				0 => 'featured_image',
       			),
       			'min' => '',
       			'max' => '',
       			'return_format' => 'object',
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'issue',
       			),
       		),
       	),
       	'menu_order' => 0,
       	'position' => 'normal',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => '',
       	'active' => 1,
       	'description' => '',
       ));

       /**
        * Timeline Post Type Custom Fields
        */
       acf_add_local_field_group( array (
       	'key' => 'group_57991c7567f52',
       	'title' => __( 'Timeline', 'jacobin-core' ),
       	'fields' => array (
       		array (
       			'key' => 'field_579a6ea91ec20',
       			'label' => __( 'Date Format', 'jacobin-core' ),
       			'name' => 'date_format',
       			'type' => 'checkbox',
       			'instructions' => __( 'Select the data elements to include in the display.', 'jacobin-core' ),
       			'required' => 1,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'choices' => array (
       				'month' => __( 'Month', 'jacobin-core' ),
       				'day' => __( 'Day', 'jacobin-core' ),
       				'year' => __( 'Year', 'jacobin-core' ),
       			),
       			'default_value' => array (
       				0 => 'month',
       				1 => 'day',
       				2 => 'year',
       			),
       			'layout' => 'horizontal',
       			'toggle' => 1,
       			'return_format' => 'value',
       		),
       		array (
       			'key' => 'field_57991caac53db',
       			'label' => __( 'Items', 'jacobin-core' ),
       			'name' => 'timeline_items',
       			'type' => 'repeater',
       			'instructions' => '',
       			'required' => 0,
       			'conditional_logic' => 0,
       			'wrapper' => array (
       				'width' => '',
       				'class' => '',
       				'id' => '',
       			),
       			'collapsed' => 'field_57991cc3c53dc',
       			'min' => '',
       			'max' => '',
       			'layout' => 'row',
       			'button_label' => __( 'Add Item', 'jacobin-core' ),
       			'sub_fields' => array (
       				array (
       					'key' => 'field_57991cc3c53dc',
       					'label' => __( 'Date', 'jacobin-core' ),
       					'name' => 'date',
       					'type' => 'date_picker',
       					'instructions' => '',
       					'required' => 0,
       					'conditional_logic' => 0,
       					'wrapper' => array (
       						'width' => '',
       						'class' => '',
       						'id' => '',
       					),
       					'display_format' => 'F j, Y',
       					'return_format' => 'Ymd',
       					'first_day' => 1,
       				),
       				array (
       					'key' => 'field_57991d02c53dd',
       					'label' => __( 'Content', 'jacobin-core' ),
       					'name' => 'content',
       					'type' => 'wysiwyg',
       					'instructions' => '',
       					'required' => 0,
       					'conditional_logic' => 0,
       					'wrapper' => array (
       						'width' => '',
       						'class' => '',
       						'id' => '',
       					),
       					'default_value' => '',
       					'tabs' => 'all',
       					'toolbar' => 'basic',
       					'media_upload' => 1,
       				),
       			),
       		),
       	),
       	'location' => array (
       		array (
       			array (
       				'param' => 'post_type',
       				'operator' => '==',
       				'value' => 'timeline',
       			),
       		),
       	),
       	'menu_order' => 0,
       	'position' => 'acf_after_title',
       	'style' => 'default',
       	'label_placement' => 'top',
       	'instruction_placement' => 'label',
       	'hide_on_screen' => array (
       		0 => 'custom_fields',
       		1 => 'format',
       		2 => 'page_attributes',
       		3 => 'featured_image',
       	),
       	'active' => 1,
       	'description' => '',
       	'local' => 'php',
       ));

     }

     /**
      * Register Settings Fields
      *
      * @uses acf_add_local_field_group()
      *
      * @link https://www.advancedcustomfields.com/resources/options-page/
      *
      * @return void
      */
     public function register_settings_fields() {
       /**
        * Featured Content Options Page Fields
        */
       acf_add_local_field_group( array (
         'key' => 'group_58b9cc9382667',
         'title' => __( 'Home Page', 'jacobin-core' ),
         'fields' => array (
           array (
             'key' => 'field_58b9ced60cd1b',
             'label' => __( 'Featured Article', 'jacobin-core' ),
             'name' => 'home_feature',
             'type' => 'clone',
             'instructions' => '',
             'required' => 0,
             'conditional_logic' => 0,
             'wrapper' => array (
               'width' => '',
               'class' => '',
               'id' => '',
             ),
             'clone' => array (
               0 => 'field_58b9ce520c8e2',
             ),
             'display' => 'seamless',
             'layout' => 'block',
             'prefix_label' => 0,
             'prefix_name' => 1,
           ),
           array (
             'key' => 'field_58b9cca81a06d',
             'label' => __( 'Section 1', 'jacobin-core' ),
             'name' => 'home_1',
             'type' => 'clone',
             'instructions' => '',
             'required' => 0,
             'conditional_logic' => 0,
             'wrapper' => array (
               'width' => '',
               'class' => '',
               'id' => '',
             ),
             'clone' => array (
               0 => 'field_58b9cbd0ce677',
             ),
             'display' => 'seamless',
             'layout' => 'block',
             'prefix_label' => 1,
             'prefix_name' => 1,
           ),
           array (
             'key' => 'field_58b9ccf51a06e',
             'label' => __( 'Section 2', 'jacobin-core' ),
             'name' => 'home_2',
             'type' => 'clone',
             'instructions' => '',
             'required' => 0,
             'conditional_logic' => 0,
             'wrapper' => array (
               'width' => '',
               'class' => '',
               'id' => '',
             ),
             'clone' => array (
               0 => 'field_58b9cbd0ce677',
             ),
             'display' => 'seamless',
             'layout' => 'block',
             'prefix_label' => 1,
             'prefix_name' => 1,
           ),
           array (
             'key' => 'field_58b9cd2a1a06f',
             'label' => __( 'Section 3', 'jacobin-core' ),
             'name' => 'home_3',
             'type' => 'clone',
             'instructions' => '',
             'required' => 0,
             'conditional_logic' => 0,
             'wrapper' => array (
               'width' => '',
               'class' => '',
               'id' => '',
             ),
             'clone' => array (
               0 => 'field_58b9cbd0ce677',
             ),
             'display' => 'seamless',
             'layout' => 'block',
             'prefix_label' => 1,
             'prefix_name' => 1,
           ),
         ),
         'location' => array (
           array (
             array (
               'param' => 'options_page',
               'operator' => '==',
               'value' => 'featured-content',
             ),
           ),
         ),
         'menu_order' => 5,
         'position' => 'normal',
         'style' => 'default',
         'label_placement' => 'top',
         'instruction_placement' => 'label',
         'hide_on_screen' => '',
         'active' => 1,
         'description' => '',
       ));


       acf_add_local_field_group( array (
         'key' => 'group_editorspick056',
         'title' => __( 'Editor\'s Picks', 'jacobin-core' ),
         'fields' => array (
           array (
             'key' => 'field_5849024645d08',
             'label' => __( '', 'jacobin-core' ),
             'name' => 'editors_pick',
             'type' => 'clone',
             'instructions' => '',
             'required' => 0,
             'conditional_logic' => 0,
             'wrapper' => array (
               'width' => '',
               'class' => '',
               'id' => '',
             ),
             'clone' => array (
               0 => 'field_58b9cbd0ce677',
             ),
             'display' => 'seamless',
             'layout' => 'block',
             'prefix_label' => 1,
             'prefix_name' => 1,
           ),
         ),
         'location' => array (
           array (
             array (
               'param' => 'options_page',
               'operator' => '==',
               'value' => 'featured-content',
             ),
           ),
         ),
         'menu_order' => 10,
         'position' => 'normal',
         'style' => 'default',
         'label_placement' => 'top',
         'instruction_placement' => 'label',
         'hide_on_screen' => '',
         'active' => 1,
         'description' => '',
       ));


     }

     /**
      * Get Page ID
      *
      * @since 0.2.0
      *
      * @uses get_page_by_path()
      *
      * @param  string $slug
      * @return int $page->ID
      */
     public function get_page_id( $slug ) {
         $page = get_page_by_path( $slug );
       	if ( $page ) {
       		return (int) $page->ID;
       	} else {
       		return null;
        }
     }
 }

 new Jacobin_Core_Custom_Fields();
