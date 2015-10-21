/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( jQuery) {
	'use strict';

	// for the /register/ page
	jQuery('#have-username-label')
	.css('cursor','pointer')
	.click( function() {
		jQuery('#have-username').trigger( 'click' );
	});

	jQuery('#have-username')
	.change( function() {
		jQuery('#payment-trip-id-li').toggle();
		var regform = jQuery('form#register-form');
		var noidaction = regform.attr('data-no-id-action')
		var haveidaction = regform.attr('data-have-id-action')
		if( regform.attr('action') === noidaction ) {
			regform.attr('action', haveidaction);
		} else {
			regform.attr('action', noidaction);
		}
	});



 } )( jQuery );	
