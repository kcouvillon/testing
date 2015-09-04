/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// MARKETO FORM BEHAVIOR

	$(document).ready(function() {
		var marketoTitle = '';

		setTimeout( checkRows, 2000 );
		
		$(document).on( 'change', '#Title', function() {
			checkRows();
		});

	});

	function checkRows() {
		var marketoTitle = document.querySelector('#Title');
		var marketoFormRow = document.querySelectorAll( '.mktoFormRow' );

		$(marketoFormRow).each(function() {
			if( $(this).children('.mktoPlaceholder').length ) {
				$(this).addClass('hidden');
				console.log('hide');
			} else {
				$(this).removeClass('hidden');
				console.log('show');
			}
		});
	}

 } )( jQuery );