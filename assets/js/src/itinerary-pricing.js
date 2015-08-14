/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// Itinerary Pricing

	if ( $( 'body' ).hasClass('single-itinerary') ) {

		var templateTourPricing;

		$(document).ready(function(){

			templateTourPricing = $('#tour-pricing-template').html();
			Mustache.parse(templateTourPricing);
			$('#tour-pricing-form').submit(getTourPricing);

		});

	}

	function getTourPricing() {
		var query = getQueryString(),
			ajax = $.ajax({
				url: 'http://ws.local/itinerary-pricing.json',
				// url: 'http://www.educationaltravel.com/PricingHandler',
				// data: query,
				beforeSend: function(){
					$('.itinerary-pricing')
						.addClass('loading')
						.removeClass('has-data error');
				}
			});

		ajax.done(function(data){
			$('.itinerary-pricing')
				.addClass('has-data')
				.removeClass('loading error');

			renderQuote(data, query);
		});
		ajax.fail(function(){
			$('.itinerary-pricing')
				.addClass('error')
				.removeClass('has-data loading');
		});

		return false;
	}

	function getQueryString() {
		var string1 = $('#tour-pricing-form').serialize(),
			string2 = $('#tour-options-form').serialize(),
			query 	= [string1, string2]
			query 	= ( query[1] !== "" ) ? query.join('&') : query[0];

		return query;
	}

	function renderQuote(data, query) {
		var tourPricing;

		$.extend(data, {
			optionKey: function () {
				return data.options.indexOf(this);
			},
			round: function () {
				return function(text, render){
					return Math.round( render(text) );
				};
			},
			ifOptions: function () {
				if ( data.options.length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
		});
		tourPricing = Mustache.render(templateTourPricing, data);
		$('.tour-pricing-content').html(tourPricing);

		$('.tour-options input[type="checkbox"]').each(function(i){
			if ( query.indexOf('option_form'+i) > -1 ) {
				$(this).prop('checked', true);
			}
		});
	}
	

 } )( jQuery );