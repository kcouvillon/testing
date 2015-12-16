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
		target, offset;

	if ( $contentCta.length ) {

		target = $contentCta.attr('href');
		offset = $contentCta.data('scroll-offset') || 0;

		$(document).ready(function(){
			setTimeout(function(){
				$contentCta.addClass('visible');
			}, 2500);
		});

		$window.on('scroll', function(){
			var scrollTop = $window.scrollTop(),
				top = $(target).offset().top + offset;

			if ( scrollTop >= (top - 1) ) {
				$contentCta.removeClass('visible');
			} else {
				$contentCta.addClass('visible');
			}
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
