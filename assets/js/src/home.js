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
				offset = $introHeader.offset().top,
				winHeight = $(window).height() - offset;

			$introHeader.css({
				minHeight: winHeight + 'px'
			});

		});

	}
	

 } )( jQuery, window );