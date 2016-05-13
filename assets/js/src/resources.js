/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// RESOURCES PAGE BEHAVIOR

	var resourceTarget = document.querySelectorAll( '.resource-target' ),
		resourceQuestion = document.querySelectorAll( '.resource-question > .entry-header > a' ),
		sectionNav = document.querySelectorAll( '.section-nav' ),
		resourceNav = document.querySelectorAll( '.resource-nav' ),
		resourceTitle = document.querySelectorAll( '.section-resource-questions h2'),
		pageWidth = $(window).width();

	$(document).ready(function() {

		// Resource Landing Page

		$(resourceTarget).first().addClass('active');

		$(resourceQuestion).on('click', function(e) {
			e.preventDefault();
			$(this)
				.closest( '.resource-question' )
				.toggleClass( 'open' )
				.children( '.entry-content' )
				.slideToggle( 'fast' );
		});

		$(resourceTarget).on({
			focus: function() {
				$(this).closest('.resource-target').addClass('active').siblings('.resource-target').removeClass('active');
			},
			click: function(e) {
				e.preventDefault();
				$(this).closest('.resource-target').addClass('active').siblings('.resource-target').removeClass('active');
			}
		}, "> a");

		// Resource Taxonomy Pages

		$( sectionNav ).scrollToFixed({
			marginTop: ( $('.quick-access').css('display') == 'block' ) ? $('.quick-access').outerHeight() : 0
		});



		setTimeout(function() {
			$( '.resource-nav ul > li:first-child > a').trigger("click");
		}, 1);

		$( resourceNav ).on( 'click', 'a', function(e) {
			e.preventDefault();
			$( '.active' ).removeClass('active');
			$( this ).addClass('active');
			var filter = $( this ).attr('data-filter');
			var title = $( this ).text();

			$( resourceTitle ).text("questions about " + title);

			$( '.resource-type-' + filter + '' )
			.fadeIn('fast').siblings('.resource-question:not(.resource-type-' + filter + ')').fadeOut('fast');

		});
	});

 } )( jQuery );



jQuery('#btnRequestInfo').on('click', function () {

	console.log(jQuery(window).scrollTop());
	if (jQuery(window).scrollTop() < 774 && jQuery('#btnRequestInfo').hasClass('collapsed')){
		console.log(jQuery(window).scrollTop() + " and " + jQuery('#btnRequestInfo').hasClass('collapsed'));
		jQuery('html, body').animate({
			scrollTop: 774
		}, 500).promise().done(function(){
			toggle_button();
		});
	}
	else {
		toggle_button();
	}

});

function toggle_button(){
	jQuery('#collapseForm').slideToggle('slow');
	jQuery('#btnRequestInfo .toggleLabel').toggle();
}

jQuery(document).ready(function(){
	var above_nav = false;
	jQuery(window).scroll(function(){
		if (jQuery(window).scrollTop() >= 774){
			above_nav = false;
			console.log(above_nav);
		}

		if (jQuery(window).scrollTop() < 774 && !above_nav && jQuery('#collapseForm').css('display') == 'block') {
			jQuery('#collapseForm').hide();
			jQuery('#btnRequestInfo .toggleLabel').toggle();
			above_nav = true;
		}

	});
});
