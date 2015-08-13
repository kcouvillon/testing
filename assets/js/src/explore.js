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
					onMixLoad: function(state){
						var filters = getQueryFilters();

						if ( filters ) {
							$exploreResults.mixItUp('filter', filters.filterString);
							
							// console.log('filters', filters);

							if ( filters.travelers ) {
								
								$(filters.travelers).each(function(){
									var $node = $( 'a.filter[href="#'+this+'"]' );
									if ( $node ) {
										addFilter( '.traveler-filters', $node.text(), '#'+this );
									}
								});

							}

							if ( filters.interests ) {

								$(filters.interests).each(function(){
									var $node = $( 'a.filter[href="#'+this+'"]' );
									if ( $node ) {
										addFilter( '.interests-filters', $node.text(), '#'+this );
									}
								});

							}

							if ( filters.destinations ) {

								$(filters.destinations).each(function(){
									var $node = $( 'a.filter[href="#'+this+'"]' );
									if ( $node ) {
										addFilter( '.destination-filters', $node.text(), '#'+this );
									}
								});

							}
						}
					},
					onMixEnd: function (state) {
						var $results = $('.results');

						// console.log(state);
						updateAvailableFilters(state);

						$results.each(function(){
							var $this = $(this),
								$parent = $this.parent();
						
							if ( $this.hasClass('fail') ) {
								$parent.addClass('no-results');
							} else {
								$parent.removeClass('no-results');
							}
						});
					},
					onMixFail: function (state) {
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

				addFilter(filterList, text, slug);
				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);
			})
			.on('click', '.remove-filter', function(event){

				event.preventDefault();

				var slug = $(this).parent().data('related'),
					filters = '';

				removeFilter(slug);
				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);
			})
			.on('click', 'a[href="#clear-filters"]', function(event){
				
				event.preventDefault();

				removeFilter('all');
				$exploreResults.mixItUp('filter', 'all');
				$('.terms-list-child').addClass('invisible');
				$('.terms-list-parent').removeClass('invisible');
				checkFilters();
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

	function addFilter (list, text, slug) {
		if ( ! $('.active-filter[data-related="'+slug+'"]').length > 0 ) {

			$(list).append('<span class="active-filter" data-related="' + slug + '">' + text + '<i class="icon icon-small-close remove-filter"></i></span>');
			$('a.filter[href="'+slug+'"]').addClass('inactive');
			checkFilters();
			updateQueryString();
		}
	}

	function removeFilter (slug) {
		if ( slug == 'all' ) {
			$('.active-filter').remove();
			$('.filter').removeClass('inactive');
		} else {
			$('.active-filter[data-related="' + slug + '"]').remove();
			$('.filter[href="' + slug + '"]').removeClass('inactive');
		}
		checkFilters();
		updateQueryString();
	}

	function getQueryFilters () {
		if ( !location.search )
			return false;

		var query 	 = location.search.substr(1).split('&'),
			queryObj = {
				filterString: ''
			};

		$(query).each(function(){
			var keyValue = this.split('=');
			queryObj[keyValue[0]] = keyValue[1].split(',');
			for ( var i=0; i < queryObj[keyValue[0]].length; i++ ) {
				queryObj.filterString += '.filter-' + queryObj[keyValue[0]][i];
			}
		});

		return queryObj;
	}

	function updateQueryString() {
		var queryObj = {
				travelers: [],
				interests: [],
				destinations: []
			},
			query = [];

		$('.current-filters .traveler-filters .active-filter').each(function(){
			queryObj.travelers.push( $(this).data('related').substr(1) );
		});
		$('.current-filters .interests-filters .active-filter').each(function(){
			queryObj.interests.push( $(this).data('related').substr(1) );
		});
		$('.current-filters .destination-filters .active-filter').each(function(){
			queryObj.destinations.push( $(this).data('related').substr(1) );
		});

		if ( queryObj.travelers.length > 0 ) {
			query.push( 'travelers=' + queryObj.travelers.join(',') );
		}
		if ( queryObj.interests.length > 0 ) {
			query.push( 'interests=' + queryObj.interests.join(',') );
		}
		if ( queryObj.destinations.length > 0 ) {
			query.push( 'destinations=' + queryObj.destinations.join(',') );
		}

		if ( Modernizr.history ) {
			query = '?' + query.join('&');
			history.pushState(null, null, query);
		}

	}

	function getCurrentFilters () {
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

	function checkFilters() {
		var $exploreTool = $('.explore-tool');

		if ( $('.explore-tool .active-filter').length > 0 ) {
			$exploreTool.addClass('has-filter');
		} else {
			$exploreTool.removeClass('has-filter');
		}
	}












})(jQuery);