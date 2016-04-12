/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
( function( $, window, undefined ) {

	'use strict';

	// Content CTAs

	var $body = $(document.body),
		$window = $(window),
		$contentCta = $('.content-cta'),
		$pageHeader = $('.primary-section'),
		target, offset;

	if ( $contentCta.length ) {

		target = $contentCta.attr('href');
		offset = $contentCta.data('scroll-offset') || 0;

		jQuery(document).ready(function(){
			setTimeout(function(){

				var pageHeaderBottom = jQuery('.primary-section').outerHeight() + jQuery('.primary-section').offset().top;

				if ( jQuery('.primary-section') && (jQuery(window).height() <= pageHeaderBottom) ){
					jQuery('.content-cta').addClass('visible');

					jQuery(window).scroll(function(){
						console.log('scrolling');
						var scrollTop = jQuery(window).scrollTop();
						if ( scrollTop > 0 ) {
							console.log('remove class');
							jQuery('.content-cta').removeClass('visible');
						} else {
							console.log('Add class');
							jQuery('.content-cta').addClass('visible');
						}
					});

				}
			}, 2500);
		});		

		$body.on('click', '.content-cta', function(e){
			e.preventDefault();
			var top = $(target).offset().top;
			if ( offset ) {
				top = top + parseInt(offset);
			}
			$('html, body').animate({ scrollTop: top });
		});

	}

})(jQuery, window);
