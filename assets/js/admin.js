/**
 * Add JS to ACF Actions
 *
 * @see https://www.advancedcustomfields.com/resources/adding-custom-javascript-fields/
 */
(function( $ ) {
	'use strict';

	// Make sure `acf` is defined
	if( 'undefined' !== acf ) {

		/* Post Edit Screen */
		// Move post edit screen elements
		acf.add_action('ready', function( $el ) {

			var $publish = $('.acf-field-postexpert .acf-input');
			var $excerpt = $('#postexcerpt #excerpt');
			var $coauthors = $('#coauthorsdiv');
			var $featuredImage = $('#postimagediv');
			var $secondaryImage = $('#acf-group_featured_image_secondary');
			var $editorLabel = $( '.acf-field-content-label' );
			var $postEditor = $( '#postdivrich' );

			$publish.append( $excerpt );
			$('#postexcerpt').remove();

			$editorLabel.append( $postEditor );

			$coauthors.insertAfter( '#submitdiv' );
			$secondaryImage.insertAfter( $featuredImage );

		});

		/* Featured Content Screen */
		acf.add_action('ready', function( $el ) {
			var $items = $( '#home-sections .acf-relationship .values ul li' );
			addClasses( $items );
		});

		acf.add_action('change', function( $el ) {
			var $items = $( '#home-sections .acf-relationship .values ul li' );
			addClasses( $items );
		});

	}

	function addClasses( list ) {
		var $items = $( list );

		$items.removeClass().addClass( 'list-item' );
		$items.addClass(function( index ) {
			return "item-" + ( index );
		});

	}

})( jQuery );
