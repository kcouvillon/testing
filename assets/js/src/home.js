/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// HOME PAGE STUFF

	if ( $( 'body' ).hasClass('home') ) {

		$(document).ready(function(){

			var $introHeader = $('#intro .section-header'),
				offset = $('#quick-access-menu').innerHeight(),
				winHeight = window.innerHeight - offset;

			$introHeader.css({
				minHeight: winHeight + 'px'
			});

		});

	}
	

 } )( jQuery, window );