/*! WorldStrides - v0.1.0 - 2015-06-26
 * http://www.worldstrides.com
 * Copyright (c) 2015; * Licensed GPLv2+ */
( function( $, window, undefined ) {
	'use strict';

	// RESOURCES PAGE BEHAVIOR

	var resourceTarget = document.querySelectorAll( '.resource-target' );
	var resourceQuestion = document.querySelectorAll( '.resource-question a' );

	$(document).ready(function() {

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

	});

 } )( jQuery );