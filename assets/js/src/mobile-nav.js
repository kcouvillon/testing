/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// MOBILE NAV

	$('body')
		.on('click', '.menu-toggle', function(event){
			event.preventDefault();

			var target = $(this).attr('href');

			$(target).toggleClass('open');
		});
	

 } )( jQuery, window );