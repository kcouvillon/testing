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

		var $exploreResults = $('.explore-results .results'),
			showAllResults = true;

		// On document ready, instantiate .mixItUp()
		$(document).ready(function(){
			var filters = getQueryFilters(),
				filterString = ( filters ) ? filters.filterString : 'all';

			$exploreResults.mixItUp({
				selectors: {
					target: '.tile',
					filter: '.single-filter',
				},
				load: {
					filter: filterString
				},
				animation: {
					duration: 350,
					effects: 'fade',
					easing: 'cubic-bezier(0.455, 0.03, 0.515, 0.955)'
				},
				callbacks: {
					onMixLoad: function(state){

						$('.explore-filters').addClass('results-loaded');

						if ( filters ) {

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

						updateAvailableFilters(state);
						
						state.$targets.removeClass('preview-tile');

						state.$show.each(function(i){
							var $this = $(this);
							if ( $this.hasClass('type-collection') && i < 3 ) {
								$this.addClass('preview-tile');
							}
							if ( $this.hasClass('type-itinerary') && i < 9 ) {
								$this.addClass('preview-tile');
							}
						});

						$results.each(function(){
							var $this = $(this),
								$parent = $this.parent();
						
							if ( $this.hasClass('fail') ) {
								$parent.addClass('no-results');
							} else {
								$parent.removeClass('no-results');
							}
						});

						if ( $(state.$show[0]).hasClass('type-collection') ) {
							if ( state.$show.length <= 3 ) {
								$('.collections .toggle-results').hide();
							} else {
								$('.collections .toggle-results').show();
							}
							$('.collections-count').text( getResultsText(state, 'Collection', 'Collections') );

						} else if ( $(state.$show[0]).hasClass('type-itinerary') ) {
							if ( state.$show.length <= 9 ) {
								$('.itineraries .toggle-results').hide();
							} else {
								$('.itineraries .toggle-results').show();
							}
							$('.itineraries-count').text( getResultsText(state, 'Itinerary', 'Itineraries') );

						}

					},
					onMixFail: function (state) {

						if ( $(state.$hide[0]).hasClass('type-collection') ) {
							$('.collections-count').text( getResultsText(state, 'Collection', 'Collections') );

						} else if ( $(state.$hide[0]).hasClass('type-itinerary') ) {
							$('.itineraries-count').text( getResultsText(state, 'Itinerary', 'Itineraries') );

						}
					
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
				var slug = $(this).parent().data('related'),
					filters = '';

				removeFilter(slug);
				filters = getCurrentFilters();
				$exploreResults.mixItUp('filter', filters);

				return false;
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
			.on('click', 'a[href="#explore-results"]', function(event){
				event.preventDefault();
				var offsetTop = $('#explore-results').offset().top;
				$('html, body').animate({scrollTop: offsetTop+'px'});
			})
			.on('click', '.toggle-results', function(event){
				event.preventDefault();
				
				var $this = $(this),
					$parent = $this.parent(),
					offsetTop = $parent.offset().top;

				if ( $parent.hasClass( 'show-previews' ) ) {
					$this.text('Hide');
					$parent.addClass('show-all').removeClass('show-previews');
				} else {
					$this.text('See All');
					$parent.addClass('show-previews').removeClass('show-all');
					$('html, body').animate({scrollTop: offsetTop+'px'});
				}
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
			return '';

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

	function getResultsText (state, singular, plural) {
		
		var count = state.totalShow;

		if ( count === 0 ) {
			return '0 ' + plural;
		} else if ( count === 1 ) {
			return count + ' ' + singular;
		} else {
			return count + ' ' + plural;
		}

	}









})(jQuery);