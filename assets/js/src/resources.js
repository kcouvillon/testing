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

var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
if (!iOS){
	var old_form_location = false;
	var above_nav = false;
	var bottom_button_clicked = false;
	var bottom_day = 0;

	jQuery(window).load(function(){
		bottom_day = jQuery(document).height() - jQuery(window).height();
	});

	jQuery(document).ready(function(){
		//Get dynamic height of section nav id
		var nav_location = jQuery('.section-header').offset().top + jQuery('.section-header').outerHeight();
		jQuery('#btnRequestInfo').on('click', function () {
			if (jQuery(window).scrollTop() < nav_location && jQuery('#btnRequestInfo').hasClass('collapsed')){
				jQuery('html, body').animate({
					scrollTop: nav_location
				}, 500).promise().done(function(){
					console.log('toggle1');
					toggle_button();
				});
			}
			else {
				toggle_button();
			}
		});
	});

	function toggle_button(){
		console.log('toggle2');
		jQuery('#collapseForm').slideToggle('slow');
		jQuery('#btnRequestInfo .toggleLabel').toggle();
	}



	jQuery(document).ready(function(){

		jQuery(window).scroll(function(){
			if (jQuery(window).scrollTop() >= 774){
				above_nav = false;
			}

			if (jQuery(window).scrollTop() < 774 && !above_nav && jQuery('#collapseForm').css('display') == 'block') {
				jQuery('#collapseForm').hide();
				jQuery('#btnRequestInfo .toggleLabel').toggle();
				above_nav = true;
			}

			if (jQuery(window).scrollTop() <= (bottom_day - 100)){
				bottom_button_clicked = false;
				old_form_location = false;
			}
			else {
				bottom_button_clicked = true;
			}
			
			if (jQuery(window).scrollTop() == bottom_day && jQuery('#collapseForm').css('display') == 'none'){
				old_form_location = true;
				toggle_button();
			}


			if (jQuery(window).scrollTop() < bottom_day && jQuery('#collapseForm').css('display') == 'block' && old_form_location && bottom_button_clicked){
				jQuery('#collapseForm').hide();
				jQuery('#btnRequestInfo .toggleLabel').toggle();
			}
			
		});
	});
}

else {
	//If Request Info button was clicked animate down to bottom form
	jQuery(window).ready(function(){
		jQuery('#btnRequestInfo').on('click', function() {
			jQuery('html, body').animate({
				scrollTop: jQuery('#lead-form').offset().top
			});
		});
	});
}