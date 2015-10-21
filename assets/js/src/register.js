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
		if( jQuery('#have-username').prop('checked') ) {
			jQuery('form#register-form').attr('action',jQuery('form#register-form').attr('data-have-id-action'));
		} else {
			jQuery('form#register-form').attr('action',jQuery('form#register-form').attr('data-no-id-action'));
		}
	});

 } )( jQuery );	
