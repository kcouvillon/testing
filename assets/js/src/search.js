/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// Header

	var $form = $('.quick-access .search-form'),
		$input = $form.find('.search-field');

	$( '[href="#search"]' ).click(function(e){
		
		e.preventDefault();

		if ( $form.hasClass('visible') ) {

			$form
				.slideUp(300)
				.removeClass('visible');

		} else {

			$form.slideDown({
				duration: 300,
				done: function(){
					$form.addClass('visible');
					$input.focus();
				}
			});

		}

	});
	
	$( '[href="#close-search"]' ).click(function(e){
		
		e.preventDefault();
		
		$form
			.slideUp(300)
			.removeClass('visible');
	});



 })(jQuery);

