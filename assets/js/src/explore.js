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

			var results = $exploreResults.mixItUp({
				selectors: {
					target: '.tile',
					filter: '.single-filter',
				},
				animation: {
					duration: 350,
					effects: 'fade stagger(76ms)',
					easing: 'cubic-bezier(0.455, 0.03, 0.515, 0.955)'
				}
			});

		});


		// Click events for filters
		$('.explore-filters')
			.on('click', '.filter', function(event){
				event.preventDefault();

				var $this = $(this),
					filterList = $this.data('filter-list'),
					slug = $this.attr('href'),
					text = $this.text(),
					filters = '';

				if ( ! $this.hasClass('inactive') ) {
					
					$this.addClass('inactive');
					addFilter(filterList, text, slug);

					filters = getCurrentFilters();
					$exploreResults.mixItUp('filter', filters);

				}
			})
			.on('click', '.remove-filter', function(event){
				event.preventDefault();

				var slug = $(this).parent().data('related'),
					filters = '';

				removeFilter(slug);
				
				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);

			})
			.on('click', '.term-list-toggle', function(event){
				event.preventDefault();

				var $this = $(this),	
					target = $this.attr('href'),
					$filterMenu = $this.parents('.filter-menu');

				$filterMenu.find('.terms-list').addClass('hidden');
				$(target).removeClass('hidden');

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
















})(jQuery);