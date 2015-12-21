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

		$(document).ready(function(){
			setTimeout(function(){

				var pageHeaderBottom = $pageHeader.outerHeight() + $pageHeader.offset().top;

				if ( $pageHeader && ($window.height() <= pageHeaderBottom) ){
					$contentCta.addClass('visible');

					$window.on('scroll', function(){
						var scrollTop = $window.scrollTop();
						if ( scrollTop > 0 ) {
							$contentCta.removeClass('visible');
						} else {
							$contentCta.addClass('visible');
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
