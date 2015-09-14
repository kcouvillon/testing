/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */

( function( $, window, undefined ) {
	'use strict';

	// General

	$('#colophon')
		.on('click', '.menu > li > a .icon', function(event){
			event.preventDefault();
			console.log(event);

			var $this = $(this),
				$target = $this.parent().siblings('.sub-menu');

			if ( $this.hasClass('active') || $target.hasClass('open') ) {
				$target
					.slideUp()
					.removeClass('open');
				$this
					.removeClass('active');
			} else {
				$target
					.slideDown()
					.addClass('open');
				$this
					.addClass('active');
			}
		});





})(jQuery);
