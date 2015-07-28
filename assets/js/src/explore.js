/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// Explore
	// https://mixitup.kunkalabs.com/

	if ( $('body').hasClass('page-template-explore') ) {

		var $exploreResults = $('.explore-results .results');


		// On document ready, instantiate .mixItUp()
		$(document).ready(function(){

			$exploreResults.mixItUp({
				selectors: {
					target: '.tile',
					filter: '.single-filter',
				},
				animation: {
					duration: 350,
					effects: 'fade',
					easing: 'cubic-bezier(0.455, 0.03, 0.515, 0.955)'
				},
				callbacks: {
					onMixEnd: function (state) {
						updateAvailableFilters(state);
					}
				}
			});

		});

		// Click events
		$('.explore-tool')
			.on('click', '.filter', function(event){
				if ( $(this).hasClass('inactive') )
					return false;

				event.preventDefault();

				var $this = $(this),
					filterList = $this.data('filter-list'),
					slug = $this.attr('href'),
					text = $this.text(),
					filters = '';

				$this.addClass('inactive');
				addFilter(filterList, text, slug);

				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);
			})
			.on('click', '.remove-filter', function(event){

				var slug = $(this).parent().data('related'),
					filters = '';

				removeFilter(slug);
				
				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);

				return false;
			})
			.on('click', '.term-list-toggle', function(event){
				if ( $(this).hasClass('inactive') )
					return false;

				event.preventDefault();

				var $this = $(this),	
					target = $this.attr('href'),
					$filterMenu = $this.parents('.filter-menu');

				$filterMenu.find('.terms-list').addClass('invisible');
				$(target).removeClass('invisible');
			})
			.on('click', '.toggle', function(event){
				event.preventDefault();

				var target = $(this).data('target');

				$(target)
					.slideToggle()
					.toggleClass('closed open');
			})
			.on('click', '.explore-filters-toggle', function(event){
				event.preventDefault();

				var $this = $(this),
					$exploreFilters = $('.explore-filters');

				$exploreFilters.toggleClass('filter-menus-closed');
			});

	}

	function addFilter(list, text, slug){
		$(list).append('<span class="active-filter" data-related="' + slug + '">' + text + '<i class="icon icon-small-close remove-filter"></i></span>');
	}

	function removeFilter(slug){
		$('.active-filter[data-related="' + slug + '"]').remove();
		$('.filter[href="' + slug + '"]').removeClass('inactive');
	}

	function getCurrentFilters() {
		var terms = [];
		$('.current-filters .active-filter').each(function(){
			var term = $(this).data('related').substr(1);
			term = '.filter-' + term;
			terms.push(term);
		});

		if ( terms.length == 0 ) {
			terms[0] = 'all';
		}
		
		return terms.join('');
	}

	function getFiltersFromResults( elements ) {
		var filters = [];

		$(elements).each(function(){

		  var theseClasses = $(this).attr('class').split(' ');

		  $(theseClasses).each(function(){
		    if ( filters.indexOf( this.toString() ) < 0 && this.indexOf('filter') > -1 ) {

		      filters.push( this.toString() );

		    }
		  });

		});

		return filters;
	}

	function updateAvailableFilters(state) {

		var filters = getFiltersFromResults( state.activeFilter );

		$('.explore-filters .filter').each(function(){
			var $this = $(this),
				filter = 'filter-' + $this.attr('href').substr(1);

			if ( filters.indexOf(filter) < 0 ) {
				$this.addClass('inactive');
			} else {
				$this.removeClass('inactive');
			}
		});

		$('.terms-list-child').each(function(){
			var $this = $(this),
				parentHref = '#' + $this.attr('id'),
				parentLink = $('.explore-filters a[href="'+parentHref+'"]');
			
			if ( $(parentHref + ' .filter').not('.inactive').length < 1 ) {
				parentLink.addClass('inactive');
			} else {
				parentLink.removeClass('inactive');
			}
		});

	}












})(jQuery);