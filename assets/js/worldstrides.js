/*! WorldStrides - v0.1.0 - 2015-06-23
 * http://www.worldstrides.com
 * Copyright (c) 2015; * Licensed GPLv2+ */
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