/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// Itineraries

	if ( $( 'body' ).hasClass('single-itinerary') ) {

		$(document).ready(function(){

			$('body')
				.on('click', '.toggle-dates', function(e){

					if ( $( '.date-list' ).hasClass( 'all-dates' ) ) {
						
						$( '.date-range.hidden-dates' ).slideUp();
						$( '.date-list' ).removeClass( 'all-dates' );
					
					} else {
				
						$( '.date-range.hidden-dates' ).slideDown();
						$( '.date-list' ).addClass('all-dates');
				
					}

					return false;
				});

		});

	}
	

 } )( jQuery );