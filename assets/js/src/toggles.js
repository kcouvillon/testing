/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
( function( $, window, undefined ) {

	'use strict';

	// Toggles

	$(document).ready(function(){

		var $programsContainer = $('.programs-container');

		if ( $programsContainer.length ) {
		
			$('.programs-container .toggle-all').click(function(){
				var text = $(this).text();
				if ( text == 'See All' ) {
					$programsContainer.addClass('show-all');
					$(this).text('Close');
				} else {
					$programsContainer.removeClass('show-all');
					$(this).text('See All');
				}
			});
		
		}

	});

})(jQuery, window);