/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( window, undefined ) {
	'use strict';

	// RESOURCES PAGE BEHAVIOR

	var resourceQuestion = document.querySelectorAll( '.resource-question a' );

	jQuery(resourceQuestion).on('click', function(e) {
		e.preventDefault();
		jQuery(this)
			.closest( '.resource-question' )
			.toggleClass( 'open' )
			.children( '.entry-content' )
			.slideToggle( 'fast' );
	});


 } )( this );