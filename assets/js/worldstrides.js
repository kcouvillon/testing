/*! WorldStrides - v0.1.0 - 2015-09-14
 * http://www.worldstrides.com
 * Copyright (c) 2015; * Licensed GPLv2+ */
( function( $, window, undefined ) {

	'use strict';

	// Collections

	var cur = -1,
		prv = -1,
		availableDates;

	$(document).ready(function(){

		if ( $('#jrange').index() > -1 ) {

			// https://github.com/bseth99/sandbox/blob/master/projects/jquery-ui/4-jquery-ui-datepicker-range.html
			
			$.datepicker._defaults.onAfterUpdate = null;
			var datepicker__updateDatepicker = $.datepicker._updateDatepicker;
			$.datepicker._updateDatepicker = function( inst ) {
				datepicker__updateDatepicker.call( this, inst );
				var onAfterUpdate = this._get(inst, 'onAfterUpdate');
				if (onAfterUpdate)
					onAfterUpdate.apply((inst.input ? inst.input[0] : null),
						[(inst.input ? inst.input.val() : ''), inst]);
			}

			// Instantiate MixItUp for filtering

			$('#mix-container').mixItUp({
				selectors: {
					target: '.tile',
				},
				animation: {
					duration: 350,
					effects: 'fade',
					easing: 'cubic-bezier(0.455, 0.03, 0.515, 0.955)'
				}
			});

			// Create the picker

			availableDates = parseAvailableDates('.program.tile');

			$('#jrange .datepicker')
				.datepicker({
					numberOfMonths: ( window.innerWidth < 768 ) ? 1 : 2,
					dateFormat: "yymmdd",
		            showButtonPanel: true,
		            defaultDate: new Date( availableDates.min ),
		            beforeShowDay: beforeShowDayFunc,
					onSelect: onSelectFunc,
					onAfterUpdate: onAfterUpdateFunc
				})
				.hide();
			 
			// Event handlers

			$('#jrange a[href="#open-calendar"]').on('click', function (e) {
				e.preventDefault();
				$('#jrange').addClass('open');
				$('#jrange .datepicker').show();
			});

			$('#jrange a[href="#clear-calendar"]').on('click', function (e) {
				e.preventDefault();
				
				prv = -1; cur = -1;
				
				$('#jrange').removeClass('open has-dates');
				$('#jrange .datepicker').hide();

				$('td').removeClass('date-range-selected');
				$('.mask-text').text('Choose by date');

				$('.program.tile').addClass('available');
				$('#mix-container').mixItUp('filter', '.available');
			});

		}

	});

	function parseAvailableDates( selector ) {
		
		var allDates = [];

		$(selector).each(function(i){
			var dates = $(this).data('dates');
			$(dates).each(function(){
				allDates.push(this[0], this[1]);
			});
		});

		allDates = allDates.sort();

		return {
			min: allDates[0],
			max: allDates[(allDates.length - 1)]
		};
	}

	function beforeShowDayFunc( date ) {
		var dateAsTime = date.getTime();

		if ( dateAsTime < availableDates.min || dateAsTime > availableDates.max ) {
			return [false, 'date-range-unselectable'];
		} else {
			return [true, ( (date.getTime() >= Math.min(prv, cur) && date.getTime() <= Math.max(prv, cur)) ? 'date-range-selected' : '')];
		}
	}

	function onSelectFunc( dateText, inst ) {
		var d1, d2;

		prv = +cur;
		cur = (new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)).getTime();

		if ( prv == -1 || prv == cur ) {
			prv = cur;
			d1 = $.datepicker.formatDate( 'M d', new Date(cur), {} );
			$('.mask-text').text('From '+d1);
		} else {
			d1 = $.datepicker.formatDate( 'M d', new Date(Math.min(prv,cur)), {} );
			d2 = $.datepicker.formatDate( 'M d', new Date(Math.max(prv,cur)), {} );
			$('.mask-text').text('From '+d1+' to '+d2);
		}
	}

	function onAfterUpdateFunc( dateText, inst ) {
		$('#jrange .ui-datepicker').prepend('<div class="calendar-title">Select a range from the available dates</div>');
		$('<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">Apply</button>')
			.appendTo($('#jrange div .ui-datepicker-buttonpane'))
			.on('click', function () { 

				$('#jrange').removeClass('open');
				$('#jrange .datepicker').hide();

				if ( prv !== -1 && cur !== -1 ) {
					
					$('#jrange').addClass('has-dates');
					
					$('.program.tile').each(function(i){
						var i = 0, 
							isAvailable = false,
							dates = $(this).data('dates');

						while( i < dates.length ) {
							if ( dates[i][0] >= Math.min(prv,cur) && dates[i][1] <= Math.max(prv,cur) ) {
								isAvailable = true;
								break;
							}
							i++;
						}

						if ( isAvailable ) {
							$(this).addClass('available');
						} else {
							$(this).removeClass('available');
						}
					});

				} else {
					$('#jrange').removeClass('has-dates');
				}

				$('#mix-container').mixItUp('filter', '.available, .always-available');

			});
		$('<a href="#close-calendar" ><i class="icon icon-small-close"></i> Close</a>')
			.appendTo($('#jrange div .ui-datepicker-buttonpane'))
			.on('click', function (e) {
				e.preventDefault();
				$('#jrange').removeClass('open');
				$('#jrange .datepicker').hide();
			});
	}

})(jQuery, window);

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
			// .on('click', '.explore-filters-toggle', function(event){
			// 	event.preventDefault();

			// 	$('.explore-filters').toggleClass('filter-menus-closed');
			// })
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
( function( $, window, undefined ) {
	'use strict';

	// MARKETO FORM BEHAVIOR

	$(document).ready(function() {
		var marketoTitle = '';

		setTimeout( checkRows, 2000 );
		
		$(document).on( 'change', '#Title', function() {
			checkRows();
		});

		if( $('#get-info-form').length )  {
			universalLead();
			ajaxFormSubmit();
		}

	});

	function checkRows() {
		var marketoTitle = document.querySelector('#Title');
		var marketoFormRow = document.querySelectorAll( '.mktoFormRow' );

		$(marketoFormRow).each(function() {
			if( $(this).children('.mktoPlaceholder').length ) {
				$(this).addClass('hidden');
				console.log('hide');
			} else {
				$(this).removeClass('hidden');
				console.log('show');
			}
		});
	}

	function universalLead() {
		/**
		 * Wire the Role, wsProduct and MoreMusic fields together
		 * - restrict wsProduct based on Role
		 * - show MoreMusic where wsProduct === 'Performing'
		 *
		 */
		(function(roleSelect,interestSelect){
			roleSelect.on('change',function(){
				console.log(jQuery(this).val());
				var role =  jQuery(this).val();
				jQuery('#get-info-wsProduct option').filter('.'+role).show();
				jQuery('#get-info-wsProduct option').not('.'+role).hide();
			});
			interestSelect.on('change',function(){
				console.log(jQuery(this).val());
				if('Performing' === (jQuery(this)).val()) {
					jQuery('li#moremusicfield').css('display','list-item');
				} else {
					jQuery('li#moremusicfield').css('display','none');
				}
			});
		})(jQuery('select#get-info-role'),jQuery('select#get-info-wsProduct'));

		/**
		 * Make the submit button unclickable after first click
		 */
		jQuery(document).ready(function() {
			jQuery('#get-info-submit').lockSubmit();
		});

		/**
		 * (Re)set the SchoolCity and SchoolName to (Choose State first.) and (Please choose your City first.) respectively
		 */
		wsData.resetSchoolCitySchoolNameFields = function() {
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			school.val('(Please choose your City first.)').attr('readonly','readonly');
			city.val('(Choose State first.)').attr('readonly','readonly');
		}
		jQuery(document).ready(function() {
			wsData.resetSchoolCitySchoolNameFields();
		});

		/**
		 * Base URL for API calls
		 */
		wsData.api_base_url = "http://apis.worldstrides.com/mdrapi/v1/";

		/**
		 * Digest and display JSON list of states
		 */
		wsData.populateStates = function (){
			var numstates = wsData.states.length;
			var statefield = jQuery('#get-info-state');
			for(var i=0; i<numstates; i++){
				statefield.append('<option value="'+wsData.states[i].abbrev+'">'+wsData.states[i].full+'</option>');
			}
		};
		jQuery(document).ready(function() {
			wsData.populateStates();
		});

		/**
		 * (Re)set the ajax listeners to be connected to the State dropdown and City input
		 */
		wsData.reattachAjaxListeners = function() {
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			state.attr("onchange", "wsData.getCityList();"); // get the cities after state is chosen
			city.attr("onchange", "wsData.getSchoolsFromCity();"); // get the schools after the city is chosen
		}
		jQuery(document).ready(function() {
			wsData.reattachAjaxListeners();
		});



		/**
		 * Async call to the MDR API to get the list of cities
		 */
		wsData.mdrApiCities = {};
		wsData.getCityList = function (){
			//Erase values of city and school, in case they switch states.
			//TODO: UNCOMMENT THIS: ws_resetSchoolCitySchoolNameFields();

			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			//If they choose other for city or state, autocomplete is turned off. If they choose a different state,
			//we want autocomplete to be back on. If they choose other, autocomplete will be disabled. We'll un-disable it. (not
			//the same as enabling it, in case you're wondering.
			if(city.attr("autocomplete") != null) {
				city.autocomplete("option", "disabled", false);
			}
			if(school.attr("autocomplete") != null){
				school.autocomplete("option", "disabled", false);
			}

			jQuery.ajax({
				url: wsData.api_base_url + 'cityList/' + state.val() + "'",
				type: 'GET',
				dataType: 'jsonp',
				jsonp:'callback',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert('Status: ' + textStatus); alert('Error: ' + errorThrown);
				},
				success:function(data){
					var output = jQuery.parseJSON(data);
					city.find('option').remove().end();
					wsData.mdrApiCities = output;
					jQuery.each(output, function(i, item){
						city.append('<option value="' + item.school_city + '">' + item.school_city + '</option>');
					});
					wsData.mdrapiSetCityAutoComplete();
					city.val('').removeAttr('readonly'); // make city editable
				}
			});
		};
		jQuery(document).ready(function() {
			// wsData.getCityList(); // Don't call on document ready -- too much data!
		});


		/**
		 * Set autocomplete for city input
		 */
		wsData.mdrapiSetCityAutoComplete = function (){

			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');


			city.autocomplete({
				minLength: 1,
				source: function(req, response) {
					var reqRegex = jQuery.ui.autocomplete.escapeRegex(req.term);
					var reqMatcher = new RegExp("^"+reqRegex,"i");
					response(
						jQuery.grep(wsData.mdrApiCities,function(item){
							return reqMatcher.test(item.label);
						})
					);
				},
				response: function (event, ui) {
					var noResult = {
						value: "Other",
						label: "Other"
					};
					ui.content.push(noResult);

				},
				select: function (event, ui) {
					if (ui.item.value === "Other") {
						// The item selected from the menu, if any. Otherwise the property is null
						//If they choose "other," it's not a ui.item, so show the hidden fields and clear the field.
						city.val("Other");
						// TODO: (MAYBE) IE FALLBACK: ws_showHiddenFields();
						city.val("");
						//If you don't shift close it, the menu stays open, the autocomplete list stays open
						city.autocomplete( "close" ).autocomplete( "option", "disabled", true );
						jQuery('#Company').val('').removeAttr('readonly');  // make school editable
						event.preventDefault(); // prevent jQuery UI from putting "Other" in the input field
					} else {
						city.attr("name", ui.item.pid);
						city.attr("value", ui.item.label);
						wsData.getSchoolsFromCity();
					}
					// TODO: CREATE ERROR CODE: jQuery("#cityError").hide();
				},
				open: function(event, ui){
					//this line adds 'other' at the end of the autocomplete list.
					//jQuery("ul.ui-autocomplete.ui-menu").append('<li class="ui-menu-item" role="presentation"><a class = "ui-corner-all" name="Other" id="ui-id-' + parseInt(jQuery("ul.ui-autocomplete.ui-menu").children().length + 2) + '" tabindex="-1">Other</a></li>');

				},
				change: function (event, ui) {


					if(!ui.item){
						//http://api.jqueryui.com/autocomplete/#event-change -
						// The item selected from the menu, if any. Otherwise the property is null
						//so clear the item for force selection
						city.val("");
						// TODO: CREATE ERROR CODE: jQuery("#cityError").show();

					}

				}
			});//end autocomplete})
		}

		/**
		 * Ajax call for populating school autocomplete
		 */
		wsData.mdrApiSchools = {};
		wsData.getSchoolsFromCity = function(){
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			jQuery.ajax({
				url: wsData.api_base_url + 'city/'+ city.val() + '/state/' + state.val() + "'",
				type: 'GET',
				dataType: 'jsonp',
				jsonp:'callback',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert('Status: ' + textStatus); alert('Error: ' + errorThrown);
				},
				success:function(data){
					var output = jQuery.parseJSON(data);
					wsData.mdrApiSchools = output;
					wsData.setSchoolAutoComplete();
					school.val('').removeAttr('readonly');  // make school editable
				}
			});
		}

		/**
		 * populate autocomplete for school based on Ajax data
		 */
		wsData.setSchoolAutoComplete = function(){
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			school.autocomplete({
				minLength: 1,
				source: function (req, response) {
					var reqRegex = jQuery.ui.autocomplete.escapeRegex(req.term);
					var reqMatcher = new RegExp("^" + reqRegex, "i");
					response(
						jQuery.grep(wsData.mdrApiSchools, function (item) {
							return reqMatcher.test(item.label);
						})
					);
				},
				response: function (event, ui) {
					var noResult = {
						value: "Other",
						label: "Other"
					};
					ui.content.push(noResult);

				},
				select: function (event, ui) {
					if (ui.item.value === "Other") {
						// The item selected from the menu, if any. Otherwise the property is null
						//If they choose "other," it's not a ui.item, so show the hidden fields and clear the field.
						// jQuery("#Company").val("Other");
						// TODO IE FALLBACK?? ws_showHiddenFields();
						school.val("");
						//If you don't close it, the autocomplete menu stays open.
						school.autocomplete("close").autocomplete("option", "disabled", true);
						event.preventDefault(); // prevent jQuery UI error
					} else {
						school.attr("name", ui.item.pid);
						school.attr("value", ui.item.label);
						wsData.findSchool();
					}
					jQuery("#schoolError").hide();
				},
				change: function (event, ui) {
					if(!ui.item){
						//http://api.jqueryui.com/autocomplete/#event-change -
						// The item selected from the menu, if any. Otherwise the property is null
						//so clear the item for force selection
						school.val("");
						jQuery("#schoolError").show();

					}}
			});//end autocomplete})

		}

		/**
		 * Take input from findSchool, fill out hidden fields with information about that school
		 */
		wsData.fillOutForm = function(school_name, school_pid, school_Phone, school_Address, school_City, school_State, school_Zip) {
			jQuery("#companyMDRPID").val(school_pid);
			jQuery('#companyPhone').val(school_Phone);
			jQuery('#companyAddress').val(school_Address);
			jQuery('#companyZipcode').val(school_Zip);
		}

		/**
		 * Parse MDRAPI data to find the specific school
		 */
		wsData.findSchool = function(){
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			var ws_schoolPid = school.attr('name');
			if(ws_schoolPid === undefined){
				jQuery("#Company").hide();
				jQuery("#wsOtherSchool").show();
				//focus wasn't working. According to stack overflow, this callback takes focus out of the current thread and puts
				//it into another one.
				setTimeout(function(){
					jQuery("#wsOtherSchool").focus();
				}, 0);
				// TODO IE FALLBACK?? ws_showHiddenFields();
			}else {
				var ws_schoolObject = wsData.mdrApiSchools.filter(function (x) {
					return x.pid == ws_schoolPid;
				})[0];
				var ws_schoolName = ws_schoolObject.school_name;
				var ws_schoolAddress = ws_schoolObject.school_address_1;
				var ws_schoolCity = ws_schoolObject.school_city;
				var ws_schoolState = ws_schoolObject.school_state;
				var ws_schoolZip = ws_schoolObject.school_zipcode;
				var ws_schoolPhone = ws_schoolObject.school_phone;

				alert('TODO: Populate info about '+ws_schoolName+' in hidden fields');

				wsData.fillOutForm(ws_schoolName, ws_schoolPid, ws_schoolPhone, ws_schoolAddress, ws_schoolCity, ws_schoolState, ws_schoolZip);
			}
		}

		/**
		 * Chain off to the Marketo Munchkin API function 'associateLead' to submit user data
		 */
		/*
		 // All of this needs to go into the processing function in php or maybe the ajax submit
		jQuery('#get-info-form').submit(function (e) {
			var form = this;
			var action = jQuery('#get-info-form').attr('action');
			e.preventDefault();
			var url = "//apis.worldstrides.com/mktohash/hash-email.php?email=" + jQuery('#get-info-email').val() + '&callback=?';
			jQuery.getJSON(url, function(jsonp){
				console.log('Marketo associate lead: hash of user email is: ' + jsonp.Email);
				jQuery('#get-info-form').attr('action',action + '&hash=success');
				mktoMunchkinFunction(
					'associateLead', {
						'Email': jQuery('#get-info-email').val(),
						'FirstName': jQuery('#get-info-first-name').val(),
						'LastName': jQuery('#get-info-last-name').val(),
						'Job Title': jQuery('#get-info-role').val(),
						'Phone Number': jQuery('#get-info-phone').val(),
						'wsProduct': jQuery('#get-info-wsProduct').val(),
						'form_comments': jQuery('#get-info-comment').val()
					},
					jsonp.Email
				);
			})
				.fail(function(){
					console.log('Marketo associate lead: API hash call failed.');
					jQuery('#get-info-form').attr('action',action + '&hash=fail');
				})
				.always(function(){
					// form.submit();
					form.options;
				});

		});
		*/

		wsData.states =
			[
				{
					"full": "Alabama",
					"abbrev": "AL"
				},
				{
					"full": "Alaska",
					"abbrev": "AK"
				},
				{
					"full": "Arizona",
					"abbrev": "AZ"
				},
				{
					"full": "Arkansas",
					"abbrev": "AR"
				},
				{
					"full": "California",
					"abbrev": "CA"
				},
				{
					"full": "Colorado",
					"abbrev": "CO"
				},
				{
					"full": "Connecticut",
					"abbrev": "CT"
				},
				{
					"full": "Delaware",
					"abbrev": "DE"
				},
				{
					"full": "District of Columbia",
					"abbrev": "DC"
				},
				{
					"full": "Florida",
					"abbrev": "FL"
				},
				{
					"full": "Georgia",
					"abbrev": "GA"
				},
				{
					"full": "Hawaii",
					"abbrev": "HI"
				},
				{
					"full": "Idaho",
					"abbrev": "ID"
				},
				{
					"full": "Illinois",
					"abbrev": "IL"
				},
				{
					"full": "Indiana",
					"abbrev": "IN"
				},
				{
					"full": "Iowa",
					"abbrev": "IA"
				},
				{
					"full": "Kansas",
					"abbrev": "KS"
				},
				{
					"full": "Kentucky",
					"abbrev": "KY"
				},
				{
					"full": "Louisiana",
					"abbrev": "LA"
				},
				{
					"full": "Maine",
					"abbrev": "ME"
				},
				{
					"full": "Maryland",
					"abbrev": "MD"
				},
				{
					"full": "Massachusetts",
					"abbrev": "MA"
				},
				{
					"full": "Michigan",
					"abbrev": "MI"
				},
				{
					"full": "Minnesota",
					"abbrev": "MN"
				},
				{
					"full": "Mississippi",
					"abbrev": "MS"
				},
				{
					"full": "Missouri",
					"abbrev": "MO"
				},
				{
					"full": "Montana",
					"abbrev": "MT"
				},
				{
					"full": "Nebraska",
					"abbrev": "NE"
				},
				{
					"full": "Nevada",
					"abbrev": "NV"
				},
				{
					"full": "New Hampshire",
					"abbrev": "NH"
				},
				{
					"full": "New Jersey",
					"abbrev": "NJ"
				},
				{
					"full": "New Mexico",
					"abbrev": "NM"
				},
				{
					"full": "New York",
					"abbrev": "NY"
				},
				{
					"full": "North Carolina",
					"abbrev": "NC"
				},
				{
					"full": "North Dakota",
					"abbrev": "ND"
				},
				{
					"full": "Ohio",
					"abbrev": "OH"
				},
				{
					"full": "Oklahoma",
					"abbrev": "OK"
				},
				{
					"full": "Oregon",
					"abbrev": "OR"
				},
				{
					"full": "Pennsylvania",
					"abbrev": "PA"
				},
				{
					"full": "Rhode Island",
					"abbrev": "RI"
				},
				{
					"full": "South Carolina",
					"abbrev": "SC"
				},
				{
					"full": "South Dakota",
					"abbrev": "SD"
				},
				{
					"full": "Tennessee",
					"abbrev": "TN"
				},
				{
					"full": "Texas",
					"abbrev": "TX"
				},
				{
					"full": "Utah",
					"abbrev": "UT"
				},
				{
					"full": "Vermont",
					"abbrev": "VT"
				},
				{
					"full": "Virginia",
					"abbrev": "VA"
				},
				{
					"full": "Virgin Islands",
					"abbrev": "VI"
				},
				{
					"full": "Washington",
					"abbrev": "WA"
				},
				{
					"full": "West Virginia",
					"abbrev": "WV"
				},
				{
					"full": "Wisconsin",
					"abbrev": "WI"
				},
				{
					"full": "Wyoming",
					"abbrev": "WY"
				},
				{
					"full": "Alberta",
					"abbrev": "AB"
				},
				{
					"full": "British Columbia",
					"abbrev": "BC"
				},
				{
					"full": "Manitoba",
					"abbrev": "MB"
				},
				{
					"full": "New Brunswick",
					"abbrev": "NB"
				},
				{
					"full": "Newfoundland",
					"abbrev": "NF"
				},
				{
					"full": "Northwest Territories",
					"abbrev": "NT"
				},
				{
					"full": "Nova Scotia",
					"abbrev": "NS"
				},
				{
					"full": "Ontario",
					"abbrev": "ON"
				},
				{
					"full": "Prince Edward Island",
					"abbrev": "PE"
				},
				{
					"full": "Quebec",
					"abbrev": "QC"
				},
				{
					"full": "Saskatchewan",
					"abbrev": "SK"
				},
				{
					"full": "Yukon",
					"abbrev": "YT"
				}
			]
	}

	 function ajaxFormSubmit() {

		 var form = $('#get-info-form');
			 // form_data = new FormData( this ),
			 // first_name = $('#get-info-form').find(),


		 // capture ajax submit
		 form.submit( function(event) {
			 // setup AJAX options
			 var options = {
				 url: worldstrides_ajax.ajaxUrl,  // this is part of the JS object you pass in from wp_localize_scripts.
				 type: 'post',        // 'get' or 'post', override for form's 'method' attribute
				 // dataType: 'json',       // 'xml', 'script', or 'json' (expected server response type) Note: json doesn't like echos in the php function
				 data: {
					 action: 'data_to_marketo',
					 // not sure if there's a more efficient way to do this
					 first_name : form.find('input[name="first_name"]').val(),
					 last_name : form.find('input[name="last_name"]').val(),
					 email : form.find('input[name="email"]').val(),
					 phone : form.find('input[name="phone"]').val(),
					 state : form.find('input[name="get-info-state"]').val(),
					 city : form.find('input[name="get-info-city"]').val(),
					 school : form.find('input[name="get-info-school"]').val(),
					 comments : form.find('#get-info-comment').val(),
					 // form_data : form.serialize()
				 },
				 success : function( responseText ) {
					 // alert( responseText );
					 form.html('Your request has been submitted successfully - ' + responseText );
				 }
			 };

			 event.preventDefault();

			 jQuery.ajax(options);
		 });

	 }
 } )( jQuery );
( function( $, window, undefined ) {
	'use strict';

	// HOME PAGE STUFF

	if ( $( 'body' ).hasClass('home') ) {

		$(document).ready(function(){

			var $intro = $('#intro'),
				offset = $('#quick-access-menu').innerHeight(),
				winHeight = window.innerHeight - offset;

			$intro.css({
				minHeight: winHeight + 'px'
			});

		});

	}
	

 } )( jQuery, window );
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
( function( $, window, undefined ) {
	'use strict';

	// Itineraries

	var map,
		layer,
		init_coords,
		marker_data,
		$slideshow, 
		$slideshow_images;

	if ( $( 'body' ).hasClass('single-itinerary') ) {

		L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';

		$(document).ready(function(){

			// Browser events
			$('body')
				.on('click', '.toggle-dates', function(e){
					if ( $( '.date-list' ).hasClass( 'all-dates' ) ) {
						$( '.date-range.hidden-dates' ).slideUp();
						$( '.date-list' ).removeClass( 'all-dates' );
					} else {
						$( '.date-range.hidden-dates' ).slideDown();
						$( '.date-list' ).addClass('all-dates');
					}
					return false;
				})
				.on('click', 'a.slide-toggle', function(e){
					var $this = $( this ),
						target = $( $this.attr('href') ),
						$target = $( target );

					if ( $this.hasClass('active') ) {
						$this.removeClass('active');
						$target.slideUp(300);
						$this.text('Details');
					} else {
						$this.addClass('active');
						$target.slideDown(300);
						$this.text('Close');
					}
					return false;
				});


			if ( $('#tour-highlights-map').length > 0 ) {

				// Assign variables
				init_coords = $('.tour-highlights').data('location'),
				marker_data = $('#tour-highlights-data').data('highlights'),
				$slideshow  = $('.cycle-slideshow'),
				$slideshow_images = $slideshow.find('img').toArray();
				
				if ( marker_data ) {

					// Slide show events
					$slideshow
						.on('cycle-initialized', cycleInit )
						.on('cycle-before', cycleBefore );
						
				}
			}

		});

	}

	function returnGeoJSON( array ) {
		var collection = {
				"type": "FeatureCollection",
				"features": []
			};

		$( array ).each( function( index ){
			var	point = {
				  "type": "Feature",
				  "geometry": {
				    "type": "Point",
				    "coordinates": [
				      parseFloat(this.itinerary_highlights_location.longitude),
				      parseFloat(this.itinerary_highlights_location.latitude)
				    ]
				  },
				  "properties": {
				  	"id": index,
				    "icon": {
			            "iconUrl": wsData.themeDir + "/assets/images/pin@2x.png",
			            "iconSize": [20, 60], // size of the icon
			            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
			            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
			            "className": "dot"
			        },
			        "iconHover": {
			            "iconUrl": wsData.themeDir + "/assets/images/pin-orange@2x.png",
			            "iconSize": [20, 60], // size of the icon
			            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
			            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
			            "className": "dot"
			        }
				  }
				};

			collection.features.push( point );
		});

		return collection;
	}

	function cycleInit( event, optionHash ){
		
		// Format marker data into geoJSON
		var collection = returnGeoJSON( marker_data );

		// Setup Map and Layer
		map = L.mapbox.map('tour-highlights-map', 'worldstrides.b898407f', {
			scrollWheelZoom: false,
			dragging: false,
			zoomControl: false,
			center: [ parseFloat(init_coords.latitude), parseFloat(init_coords.longitude) ],
			zoom: 13
		});
		layer = L.mapbox.featureLayer(collection).addTo(map);

		// Map Events
		map
			.on('ready resize', function(){
				map.invalidateSize();
				map.fitBounds( layer.getBounds(), { padding: [ 30, 30 ], maxZoom: 16 } );
			});

		// Layer Events
		layer
			.on('layeradd', function(e) {
			    var marker = e.layer,
			        feature = marker.feature;

				if ( feature.properties.id == 0 ) {
					marker.setIcon(L.icon(feature.properties.iconHover));
				} else {
					marker.setIcon(L.icon(feature.properties.icon));	
				}
			})
			.on('click', function(e){
				$slideshow.cycle( 'goto', e.layer.feature.properties.id );
			});
	}

	function cycleBefore( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ){
		
		var marker_id = $slideshow_images.indexOf(incomingSlideEl);
		
		layer.eachLayer(function (layer) {

			if ( layer.feature.properties.id == marker_id ) {
				layer.setIcon( L.icon( layer.feature.properties.iconHover ));
			} else {
				layer.setIcon( L.icon( layer.feature.properties.icon ));
			}

		});
	}

 } )( jQuery );
( function( $, window, undefined ) {
	'use strict';

	// MAPBOX MAPS

	$(document).ready(function() {

		if ( $('#office-map').length > 0 ) {

			L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';
			
			var map = L.mapbox.map('office-map', 'worldstrides.b898407f', {
					scrollWheelZoom: false,
					zoomControl: false,
					center: [38.030266, -78.48363499999999],
					zoom: 13
				}),
				data = JSON.parse( $('#offices-json').text() ),
				collection = {
					"type": "FeatureCollection",
					"features": []
				},
				layer = L.mapbox.featureLayer().addTo(map);

			if ( data ) {

				$(data).each(function(){
					var point = {
					  "type": "Feature",
					  "geometry": {
					    "type": "Point",
					    "coordinates": [
					      parseFloat(this.about_offices_locations_coordinates.longitude),
					      parseFloat(this.about_offices_locations_coordinates.latitude)
					    ]
					  },
					  "properties": {
					    "title": this.name,
					    "icon": {
				            "iconUrl": "http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin@2x.png",
				            "iconSize": [20, 60], // size of the icon
				            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
				            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
				            "className": "dot"
				        },
				        "iconHover": {
				            "iconUrl": "http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin-orange@2x.png",
				            "iconSize": [20, 60], // size of the icon
				            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
				            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
				            "className": "dot"
				        }
					  }
					};

					collection.features.push(point);
				});

				layer
					.on('layeradd', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;

					    marker.setIcon(L.icon(feature.properties.icon));
					})
					.on('mouseover', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;

					    marker.openPopup();
						marker.setIcon(L.icon(feature.properties.iconHover));
					})
					.on('mouseout', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;

						marker.closePopup();
						marker.setIcon(L.icon(feature.properties.icon));
					})
				
				map.on('ready', function(){
					layer.setGeoJSON(collection);
					map.fitBounds(layer.getBounds());
				});

			}
			
		}

	});

 } )( jQuery );
( function( $, window, undefined ) {
	'use strict';

	// MOBILE NAV

	$('body')
		.on('click', '.menu-toggle', function(event){
			event.preventDefault();

			var target = $(this).attr('href');

			$(target).toggleClass('open');
		});
	

 } )( jQuery, window );
( function( $, window, undefined ) {
	'use strict';

	// RESOURCES PAGE BEHAVIOR

	var resourceTarget = document.querySelectorAll( '.resource-target' ),
		resourceQuestion = document.querySelectorAll( '.resource-question > .entry-header > a' ),
		sectionNav = document.querySelectorAll( '.section-nav' ),
		resourceNav = document.querySelectorAll( '.resource-nav' ),
		resourceTitle = document.querySelectorAll( '.section-resource-questions h2');

	$(document).ready(function() {

		// Resource Landing Page

		$(resourceTarget).first().addClass('active');

		$(resourceQuestion).on('click', function(e) {
			e.preventDefault();
			$(this)
				.closest( '.resource-question' )
				.toggleClass( 'open' )
				.children( '.entry-content' )
				.slideToggle( 'fast' );
		});

		$(resourceTarget).on({
			focus: function() {
				$(this).closest('.resource-target').addClass('active').siblings('.resource-target').removeClass('active');
			},
			click: function(e) {
				e.preventDefault();
				$(this).closest('.resource-target').addClass('active').siblings('.resource-target').removeClass('active');
			}
		}, "> a");

		// Resource Taxonomy Pages

		$( sectionNav ).scrollToFixed();

		setTimeout(function() {
			$( '.resource-nav ul > li:first-child > a').trigger("click");
		}, 1);

		$( resourceNav ).on( 'click', 'a', function(e) {
			e.preventDefault();
			$( '.active' ).removeClass('active');
			$( this ).addClass('active');
			var filter = $( this ).attr('data-filter');
			var title = $( this ).text();

			$( resourceTitle ).text("questions about " + title);

			$( '.resource-type-' + filter + '' )
			.fadeIn('fast').siblings('.resource-question:not(.resource-type-' + filter + ')').fadeOut('fast');

		});
	});

 } )( jQuery );
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

 } )( jQuery );
/*!
* jQuery Cycle2; version: 2.1.6 build: 20141007
* http://jquery.malsup.com/cycle2/
* Copyright (c) 2014 M. Alsup; Dual licensed: MIT/GPL
*/
!function(a){"use strict";function b(a){return(a||"").toLowerCase()}var c="2.1.6";a.fn.cycle=function(c){var d;return 0!==this.length||a.isReady?this.each(function(){var d,e,f,g,h=a(this),i=a.fn.cycle.log;if(!h.data("cycle.opts")){(h.data("cycle-log")===!1||c&&c.log===!1||e&&e.log===!1)&&(i=a.noop),i("--c2 init--"),d=h.data();for(var j in d)d.hasOwnProperty(j)&&/^cycle[A-Z]+/.test(j)&&(g=d[j],f=j.match(/^cycle(.*)/)[1].replace(/^[A-Z]/,b),i(f+":",g,"("+typeof g+")"),d[f]=g);e=a.extend({},a.fn.cycle.defaults,d,c||{}),e.timeoutId=0,e.paused=e.paused||!1,e.container=h,e._maxZ=e.maxZ,e.API=a.extend({_container:h},a.fn.cycle.API),e.API.log=i,e.API.trigger=function(a,b){return e.container.trigger(a,b),e.API},h.data("cycle.opts",e),h.data("cycle.API",e.API),e.API.trigger("cycle-bootstrap",[e,e.API]),e.API.addInitialSlides(),e.API.preInitSlideshow(),e.slides.length&&e.API.initSlideshow()}}):(d={s:this.selector,c:this.context},a.fn.cycle.log("requeuing slideshow (dom not ready)"),a(function(){a(d.s,d.c).cycle(c)}),this)},a.fn.cycle.API={opts:function(){return this._container.data("cycle.opts")},addInitialSlides:function(){var b=this.opts(),c=b.slides;b.slideCount=0,b.slides=a(),c=c.jquery?c:b.container.find(c),b.random&&c.sort(function(){return Math.random()-.5}),b.API.add(c)},preInitSlideshow:function(){var b=this.opts();b.API.trigger("cycle-pre-initialize",[b]);var c=a.fn.cycle.transitions[b.fx];c&&a.isFunction(c.preInit)&&c.preInit(b),b._preInitialized=!0},postInitSlideshow:function(){var b=this.opts();b.API.trigger("cycle-post-initialize",[b]);var c=a.fn.cycle.transitions[b.fx];c&&a.isFunction(c.postInit)&&c.postInit(b)},initSlideshow:function(){var b,c=this.opts(),d=c.container;c.API.calcFirstSlide(),"static"==c.container.css("position")&&c.container.css("position","relative"),a(c.slides[c.currSlide]).css({opacity:1,display:"block",visibility:"visible"}),c.API.stackSlides(c.slides[c.currSlide],c.slides[c.nextSlide],!c.reverse),c.pauseOnHover&&(c.pauseOnHover!==!0&&(d=a(c.pauseOnHover)),d.hover(function(){c.API.pause(!0)},function(){c.API.resume(!0)})),c.timeout&&(b=c.API.getSlideOpts(c.currSlide),c.API.queueTransition(b,b.timeout+c.delay)),c._initialized=!0,c.API.updateView(!0),c.API.trigger("cycle-initialized",[c]),c.API.postInitSlideshow()},pause:function(b){var c=this.opts(),d=c.API.getSlideOpts(),e=c.hoverPaused||c.paused;b?c.hoverPaused=!0:c.paused=!0,e||(c.container.addClass("cycle-paused"),c.API.trigger("cycle-paused",[c]).log("cycle-paused"),d.timeout&&(clearTimeout(c.timeoutId),c.timeoutId=0,c._remainingTimeout-=a.now()-c._lastQueue,(c._remainingTimeout<0||isNaN(c._remainingTimeout))&&(c._remainingTimeout=void 0)))},resume:function(a){var b=this.opts(),c=!b.hoverPaused&&!b.paused;a?b.hoverPaused=!1:b.paused=!1,c||(b.container.removeClass("cycle-paused"),0===b.slides.filter(":animated").length&&b.API.queueTransition(b.API.getSlideOpts(),b._remainingTimeout),b.API.trigger("cycle-resumed",[b,b._remainingTimeout]).log("cycle-resumed"))},add:function(b,c){var d,e=this.opts(),f=e.slideCount,g=!1;"string"==a.type(b)&&(b=a.trim(b)),a(b).each(function(){var b,d=a(this);c?e.container.prepend(d):e.container.append(d),e.slideCount++,b=e.API.buildSlideOpts(d),e.slides=c?a(d).add(e.slides):e.slides.add(d),e.API.initSlide(b,d,--e._maxZ),d.data("cycle.opts",b),e.API.trigger("cycle-slide-added",[e,b,d])}),e.API.updateView(!0),g=e._preInitialized&&2>f&&e.slideCount>=1,g&&(e._initialized?e.timeout&&(d=e.slides.length,e.nextSlide=e.reverse?d-1:1,e.timeoutId||e.API.queueTransition(e)):e.API.initSlideshow())},calcFirstSlide:function(){var a,b=this.opts();a=parseInt(b.startingSlide||0,10),(a>=b.slides.length||0>a)&&(a=0),b.currSlide=a,b.reverse?(b.nextSlide=a-1,b.nextSlide<0&&(b.nextSlide=b.slides.length-1)):(b.nextSlide=a+1,b.nextSlide==b.slides.length&&(b.nextSlide=0))},calcNextSlide:function(){var a,b=this.opts();b.reverse?(a=b.nextSlide-1<0,b.nextSlide=a?b.slideCount-1:b.nextSlide-1,b.currSlide=a?0:b.nextSlide+1):(a=b.nextSlide+1==b.slides.length,b.nextSlide=a?0:b.nextSlide+1,b.currSlide=a?b.slides.length-1:b.nextSlide-1)},calcTx:function(b,c){var d,e=b;return e._tempFx?d=a.fn.cycle.transitions[e._tempFx]:c&&e.manualFx&&(d=a.fn.cycle.transitions[e.manualFx]),d||(d=a.fn.cycle.transitions[e.fx]),e._tempFx=null,this.opts()._tempFx=null,d||(d=a.fn.cycle.transitions.fade,e.API.log('Transition "'+e.fx+'" not found.  Using fade.')),d},prepareTx:function(a,b){var c,d,e,f,g,h=this.opts();return h.slideCount<2?void(h.timeoutId=0):(!a||h.busy&&!h.manualTrump||(h.API.stopTransition(),h.busy=!1,clearTimeout(h.timeoutId),h.timeoutId=0),void(h.busy||(0!==h.timeoutId||a)&&(d=h.slides[h.currSlide],e=h.slides[h.nextSlide],f=h.API.getSlideOpts(h.nextSlide),g=h.API.calcTx(f,a),h._tx=g,a&&void 0!==f.manualSpeed&&(f.speed=f.manualSpeed),h.nextSlide!=h.currSlide&&(a||!h.paused&&!h.hoverPaused&&h.timeout)?(h.API.trigger("cycle-before",[f,d,e,b]),g.before&&g.before(f,d,e,b),c=function(){h.busy=!1,h.container.data("cycle.opts")&&(g.after&&g.after(f,d,e,b),h.API.trigger("cycle-after",[f,d,e,b]),h.API.queueTransition(f),h.API.updateView(!0))},h.busy=!0,g.transition?g.transition(f,d,e,b,c):h.API.doTransition(f,d,e,b,c),h.API.calcNextSlide(),h.API.updateView()):h.API.queueTransition(f))))},doTransition:function(b,c,d,e,f){var g=b,h=a(c),i=a(d),j=function(){i.animate(g.animIn||{opacity:1},g.speed,g.easeIn||g.easing,f)};i.css(g.cssBefore||{}),h.animate(g.animOut||{},g.speed,g.easeOut||g.easing,function(){h.css(g.cssAfter||{}),g.sync||j()}),g.sync&&j()},queueTransition:function(b,c){var d=this.opts(),e=void 0!==c?c:b.timeout;return 0===d.nextSlide&&0===--d.loop?(d.API.log("terminating; loop=0"),d.timeout=0,e?setTimeout(function(){d.API.trigger("cycle-finished",[d])},e):d.API.trigger("cycle-finished",[d]),void(d.nextSlide=d.currSlide)):void 0!==d.continueAuto&&(d.continueAuto===!1||a.isFunction(d.continueAuto)&&d.continueAuto()===!1)?(d.API.log("terminating automatic transitions"),d.timeout=0,void(d.timeoutId&&clearTimeout(d.timeoutId))):void(e&&(d._lastQueue=a.now(),void 0===c&&(d._remainingTimeout=b.timeout),d.paused||d.hoverPaused||(d.timeoutId=setTimeout(function(){d.API.prepareTx(!1,!d.reverse)},e))))},stopTransition:function(){var a=this.opts();a.slides.filter(":animated").length&&(a.slides.stop(!1,!0),a.API.trigger("cycle-transition-stopped",[a])),a._tx&&a._tx.stopTransition&&a._tx.stopTransition(a)},advanceSlide:function(a){var b=this.opts();return clearTimeout(b.timeoutId),b.timeoutId=0,b.nextSlide=b.currSlide+a,b.nextSlide<0?b.nextSlide=b.slides.length-1:b.nextSlide>=b.slides.length&&(b.nextSlide=0),b.API.prepareTx(!0,a>=0),!1},buildSlideOpts:function(c){var d,e,f=this.opts(),g=c.data()||{};for(var h in g)g.hasOwnProperty(h)&&/^cycle[A-Z]+/.test(h)&&(d=g[h],e=h.match(/^cycle(.*)/)[1].replace(/^[A-Z]/,b),f.API.log("["+(f.slideCount-1)+"]",e+":",d,"("+typeof d+")"),g[e]=d);g=a.extend({},a.fn.cycle.defaults,f,g),g.slideNum=f.slideCount;try{delete g.API,delete g.slideCount,delete g.currSlide,delete g.nextSlide,delete g.slides}catch(i){}return g},getSlideOpts:function(b){var c=this.opts();void 0===b&&(b=c.currSlide);var d=c.slides[b],e=a(d).data("cycle.opts");return a.extend({},c,e)},initSlide:function(b,c,d){var e=this.opts();c.css(b.slideCss||{}),d>0&&c.css("zIndex",d),isNaN(b.speed)&&(b.speed=a.fx.speeds[b.speed]||a.fx.speeds._default),b.sync||(b.speed=b.speed/2),c.addClass(e.slideClass)},updateView:function(a,b){var c=this.opts();if(c._initialized){var d=c.API.getSlideOpts(),e=c.slides[c.currSlide];!a&&b!==!0&&(c.API.trigger("cycle-update-view-before",[c,d,e]),c.updateView<0)||(c.slideActiveClass&&c.slides.removeClass(c.slideActiveClass).eq(c.currSlide).addClass(c.slideActiveClass),a&&c.hideNonActive&&c.slides.filter(":not(."+c.slideActiveClass+")").css("visibility","hidden"),0===c.updateView&&setTimeout(function(){c.API.trigger("cycle-update-view",[c,d,e,a])},d.speed/(c.sync?2:1)),0!==c.updateView&&c.API.trigger("cycle-update-view",[c,d,e,a]),a&&c.API.trigger("cycle-update-view-after",[c,d,e]))}},getComponent:function(b){var c=this.opts(),d=c[b];return"string"==typeof d?/^\s*[\>|\+|~]/.test(d)?c.container.find(d):a(d):d.jquery?d:a(d)},stackSlides:function(b,c,d){var e=this.opts();b||(b=e.slides[e.currSlide],c=e.slides[e.nextSlide],d=!e.reverse),a(b).css("zIndex",e.maxZ);var f,g=e.maxZ-2,h=e.slideCount;if(d){for(f=e.currSlide+1;h>f;f++)a(e.slides[f]).css("zIndex",g--);for(f=0;f<e.currSlide;f++)a(e.slides[f]).css("zIndex",g--)}else{for(f=e.currSlide-1;f>=0;f--)a(e.slides[f]).css("zIndex",g--);for(f=h-1;f>e.currSlide;f--)a(e.slides[f]).css("zIndex",g--)}a(c).css("zIndex",e.maxZ-1)},getSlideIndex:function(a){return this.opts().slides.index(a)}},a.fn.cycle.log=function(){window.console&&console.log&&console.log("[cycle2] "+Array.prototype.join.call(arguments," "))},a.fn.cycle.version=function(){return"Cycle2: "+c},a.fn.cycle.transitions={custom:{},none:{before:function(a,b,c,d){a.API.stackSlides(c,b,d),a.cssBefore={opacity:1,visibility:"visible",display:"block"}}},fade:{before:function(b,c,d,e){var f=b.API.getSlideOpts(b.nextSlide).slideCss||{};b.API.stackSlides(c,d,e),b.cssBefore=a.extend(f,{opacity:0,visibility:"visible",display:"block"}),b.animIn={opacity:1},b.animOut={opacity:0}}},fadeout:{before:function(b,c,d,e){var f=b.API.getSlideOpts(b.nextSlide).slideCss||{};b.API.stackSlides(c,d,e),b.cssBefore=a.extend(f,{opacity:1,visibility:"visible",display:"block"}),b.animOut={opacity:0}}},scrollHorz:{before:function(a,b,c,d){a.API.stackSlides(b,c,d);var e=a.container.css("overflow","hidden").width();a.cssBefore={left:d?e:-e,top:0,opacity:1,visibility:"visible",display:"block"},a.cssAfter={zIndex:a._maxZ-2,left:0},a.animIn={left:0},a.animOut={left:d?-e:e}}}},a.fn.cycle.defaults={allowWrap:!0,autoSelector:".cycle-slideshow[data-cycle-auto-init!=false]",delay:0,easing:null,fx:"fade",hideNonActive:!0,loop:0,manualFx:void 0,manualSpeed:void 0,manualTrump:!0,maxZ:100,pauseOnHover:!1,reverse:!1,slideActiveClass:"cycle-slide-active",slideClass:"cycle-slide",slideCss:{position:"absolute",top:0,left:0},slides:"> img",speed:500,startingSlide:0,sync:!0,timeout:4e3,updateView:0},a(document).ready(function(){a(a.fn.cycle.defaults.autoSelector).cycle()})}(jQuery),/*! Cycle2 autoheight plugin; Copyright (c) M.Alsup, 2012; version: 20130913 */
function(a){"use strict";function b(b,d){var e,f,g,h=d.autoHeight;if("container"==h)f=a(d.slides[d.currSlide]).outerHeight(),d.container.height(f);else if(d._autoHeightRatio)d.container.height(d.container.width()/d._autoHeightRatio);else if("calc"===h||"number"==a.type(h)&&h>=0){if(g="calc"===h?c(b,d):h>=d.slides.length?0:h,g==d._sentinelIndex)return;d._sentinelIndex=g,d._sentinel&&d._sentinel.remove(),e=a(d.slides[g].cloneNode(!0)),e.removeAttr("id name rel").find("[id],[name],[rel]").removeAttr("id name rel"),e.css({position:"static",visibility:"hidden",display:"block"}).prependTo(d.container).addClass("cycle-sentinel cycle-slide").removeClass("cycle-slide-active"),e.find("*").css("visibility","hidden"),d._sentinel=e}}function c(b,c){var d=0,e=-1;return c.slides.each(function(b){var c=a(this).height();c>e&&(e=c,d=b)}),d}function d(b,c,d,e){var f=a(e).outerHeight();c.container.animate({height:f},c.autoHeightSpeed,c.autoHeightEasing)}function e(c,f){f._autoHeightOnResize&&(a(window).off("resize orientationchange",f._autoHeightOnResize),f._autoHeightOnResize=null),f.container.off("cycle-slide-added cycle-slide-removed",b),f.container.off("cycle-destroyed",e),f.container.off("cycle-before",d),f._sentinel&&(f._sentinel.remove(),f._sentinel=null)}a.extend(a.fn.cycle.defaults,{autoHeight:0,autoHeightSpeed:250,autoHeightEasing:null}),a(document).on("cycle-initialized",function(c,f){function g(){b(c,f)}var h,i=f.autoHeight,j=a.type(i),k=null;("string"===j||"number"===j)&&(f.container.on("cycle-slide-added cycle-slide-removed",b),f.container.on("cycle-destroyed",e),"container"==i?f.container.on("cycle-before",d):"string"===j&&/\d+\:\d+/.test(i)&&(h=i.match(/(\d+)\:(\d+)/),h=h[1]/h[2],f._autoHeightRatio=h),"number"!==j&&(f._autoHeightOnResize=function(){clearTimeout(k),k=setTimeout(g,50)},a(window).on("resize orientationchange",f._autoHeightOnResize)),setTimeout(g,30))})}(jQuery),/*! caption plugin for Cycle2;  version: 20130306 */
function(a){"use strict";a.extend(a.fn.cycle.defaults,{caption:"> .cycle-caption",captionTemplate:"{{slideNum}} / {{slideCount}}",overlay:"> .cycle-overlay",overlayTemplate:"<div>{{title}}</div><div>{{desc}}</div>",captionModule:"caption"}),a(document).on("cycle-update-view",function(b,c,d,e){if("caption"===c.captionModule){a.each(["caption","overlay"],function(){var a=this,b=d[a+"Template"],f=c.API.getComponent(a);f.length&&b?(f.html(c.API.tmpl(b,d,c,e)),f.show()):f.hide()})}}),a(document).on("cycle-destroyed",function(b,c){var d;a.each(["caption","overlay"],function(){var a=this,b=c[a+"Template"];c[a]&&b&&(d=c.API.getComponent("caption"),d.empty())})})}(jQuery),/*! command plugin for Cycle2;  version: 20140415 */
function(a){"use strict";var b=a.fn.cycle;a.fn.cycle=function(c){var d,e,f,g=a.makeArray(arguments);return"number"==a.type(c)?this.cycle("goto",c):"string"==a.type(c)?this.each(function(){var h;return d=c,f=a(this).data("cycle.opts"),void 0===f?void b.log('slideshow must be initialized before sending commands; "'+d+'" ignored'):(d="goto"==d?"jump":d,e=f.API[d],a.isFunction(e)?(h=a.makeArray(g),h.shift(),e.apply(f.API,h)):void b.log("unknown command: ",d))}):b.apply(this,arguments)},a.extend(a.fn.cycle,b),a.extend(b.API,{next:function(){var a=this.opts();if(!a.busy||a.manualTrump){var b=a.reverse?-1:1;a.allowWrap===!1&&a.currSlide+b>=a.slideCount||(a.API.advanceSlide(b),a.API.trigger("cycle-next",[a]).log("cycle-next"))}},prev:function(){var a=this.opts();if(!a.busy||a.manualTrump){var b=a.reverse?1:-1;a.allowWrap===!1&&a.currSlide+b<0||(a.API.advanceSlide(b),a.API.trigger("cycle-prev",[a]).log("cycle-prev"))}},destroy:function(){this.stop();var b=this.opts(),c=a.isFunction(a._data)?a._data:a.noop;clearTimeout(b.timeoutId),b.timeoutId=0,b.API.stop(),b.API.trigger("cycle-destroyed",[b]).log("cycle-destroyed"),b.container.removeData(),c(b.container[0],"parsedAttrs",!1),b.retainStylesOnDestroy||(b.container.removeAttr("style"),b.slides.removeAttr("style"),b.slides.removeClass(b.slideActiveClass)),b.slides.each(function(){var d=a(this);d.removeData(),d.removeClass(b.slideClass),c(this,"parsedAttrs",!1)})},jump:function(a,b){var c,d=this.opts();if(!d.busy||d.manualTrump){var e=parseInt(a,10);if(isNaN(e)||0>e||e>=d.slides.length)return void d.API.log("goto: invalid slide index: "+e);if(e==d.currSlide)return void d.API.log("goto: skipping, already on slide",e);d.nextSlide=e,clearTimeout(d.timeoutId),d.timeoutId=0,d.API.log("goto: ",e," (zero-index)"),c=d.currSlide<d.nextSlide,d._tempFx=b,d.API.prepareTx(!0,c)}},stop:function(){var b=this.opts(),c=b.container;clearTimeout(b.timeoutId),b.timeoutId=0,b.API.stopTransition(),b.pauseOnHover&&(b.pauseOnHover!==!0&&(c=a(b.pauseOnHover)),c.off("mouseenter mouseleave")),b.API.trigger("cycle-stopped",[b]).log("cycle-stopped")},reinit:function(){var a=this.opts();a.API.destroy(),a.container.cycle()},remove:function(b){for(var c,d,e=this.opts(),f=[],g=1,h=0;h<e.slides.length;h++)c=e.slides[h],h==b?d=c:(f.push(c),a(c).data("cycle.opts").slideNum=g,g++);d&&(e.slides=a(f),e.slideCount--,a(d).remove(),b==e.currSlide?e.API.advanceSlide(1):b<e.currSlide?e.currSlide--:e.currSlide++,e.API.trigger("cycle-slide-removed",[e,b,d]).log("cycle-slide-removed"),e.API.updateView())}}),a(document).on("click.cycle","[data-cycle-cmd]",function(b){b.preventDefault();var c=a(this),d=c.data("cycle-cmd"),e=c.data("cycle-context")||".cycle-slideshow";a(e).cycle(d,c.data("cycle-arg"))})}(jQuery),/*! hash plugin for Cycle2;  version: 20130905 */
function(a){"use strict";function b(b,c){var d;return b._hashFence?void(b._hashFence=!1):(d=window.location.hash.substring(1),void b.slides.each(function(e){if(a(this).data("cycle-hash")==d){if(c===!0)b.startingSlide=e;else{var f=b.currSlide<e;b.nextSlide=e,b.API.prepareTx(!0,f)}return!1}}))}a(document).on("cycle-pre-initialize",function(c,d){b(d,!0),d._onHashChange=function(){b(d,!1)},a(window).on("hashchange",d._onHashChange)}),a(document).on("cycle-update-view",function(a,b,c){c.hash&&"#"+c.hash!=window.location.hash&&(b._hashFence=!0,window.location.hash=c.hash)}),a(document).on("cycle-destroyed",function(b,c){c._onHashChange&&a(window).off("hashchange",c._onHashChange)})}(jQuery),/*! loader plugin for Cycle2;  version: 20131121 */
function(a){"use strict";a.extend(a.fn.cycle.defaults,{loader:!1}),a(document).on("cycle-bootstrap",function(b,c){function d(b,d){function f(b){var f;"wait"==c.loader?(h.push(b),0===j&&(h.sort(g),e.apply(c.API,[h,d]),c.container.removeClass("cycle-loading"))):(f=a(c.slides[c.currSlide]),e.apply(c.API,[b,d]),f.show(),c.container.removeClass("cycle-loading"))}function g(a,b){return a.data("index")-b.data("index")}var h=[];if("string"==a.type(b))b=a.trim(b);else if("array"===a.type(b))for(var i=0;i<b.length;i++)b[i]=a(b[i])[0];b=a(b);var j=b.length;j&&(b.css("visibility","hidden").appendTo("body").each(function(b){function g(){0===--i&&(--j,f(k))}var i=0,k=a(this),l=k.is("img")?k:k.find("img");return k.data("index",b),l=l.filter(":not(.cycle-loader-ignore)").filter(':not([src=""])'),l.length?(i=l.length,void l.each(function(){this.complete?g():a(this).load(function(){g()}).on("error",function(){0===--i&&(c.API.log("slide skipped; img not loaded:",this.src),0===--j&&"wait"==c.loader&&e.apply(c.API,[h,d]))})})):(--j,void h.push(k))}),j&&c.container.addClass("cycle-loading"))}var e;c.loader&&(e=c.API.add,c.API.add=d)})}(jQuery),/*! pager plugin for Cycle2;  version: 20140415 */
function(a){"use strict";function b(b,c,d){var e,f=b.API.getComponent("pager");f.each(function(){var f=a(this);if(c.pagerTemplate){var g=b.API.tmpl(c.pagerTemplate,c,b,d[0]);e=a(g).appendTo(f)}else e=f.children().eq(b.slideCount-1);e.on(b.pagerEvent,function(a){b.pagerEventBubble||a.preventDefault(),b.API.page(f,a.currentTarget)})})}function c(a,b){var c=this.opts();if(!c.busy||c.manualTrump){var d=a.children().index(b),e=d,f=c.currSlide<e;c.currSlide!=e&&(c.nextSlide=e,c._tempFx=c.pagerFx,c.API.prepareTx(!0,f),c.API.trigger("cycle-pager-activated",[c,a,b]))}}a.extend(a.fn.cycle.defaults,{pager:"> .cycle-pager",pagerActiveClass:"cycle-pager-active",pagerEvent:"click.cycle",pagerEventBubble:void 0,pagerTemplate:"<span>&bull;</span>"}),a(document).on("cycle-bootstrap",function(a,c,d){d.buildPagerLink=b}),a(document).on("cycle-slide-added",function(a,b,d,e){b.pager&&(b.API.buildPagerLink(b,d,e),b.API.page=c)}),a(document).on("cycle-slide-removed",function(b,c,d){if(c.pager){var e=c.API.getComponent("pager");e.each(function(){var b=a(this);a(b.children()[d]).remove()})}}),a(document).on("cycle-update-view",function(b,c){var d;c.pager&&(d=c.API.getComponent("pager"),d.each(function(){a(this).children().removeClass(c.pagerActiveClass).eq(c.currSlide).addClass(c.pagerActiveClass)}))}),a(document).on("cycle-destroyed",function(a,b){var c=b.API.getComponent("pager");c&&(c.children().off(b.pagerEvent),b.pagerTemplate&&c.empty())})}(jQuery),/*! prevnext plugin for Cycle2;  version: 20140408 */
function(a){"use strict";a.extend(a.fn.cycle.defaults,{next:"> .cycle-next",nextEvent:"click.cycle",disabledClass:"disabled",prev:"> .cycle-prev",prevEvent:"click.cycle",swipe:!1}),a(document).on("cycle-initialized",function(a,b){if(b.API.getComponent("next").on(b.nextEvent,function(a){a.preventDefault(),b.API.next()}),b.API.getComponent("prev").on(b.prevEvent,function(a){a.preventDefault(),b.API.prev()}),b.swipe){var c=b.swipeVert?"swipeUp.cycle":"swipeLeft.cycle swipeleft.cycle",d=b.swipeVert?"swipeDown.cycle":"swipeRight.cycle swiperight.cycle";b.container.on(c,function(){b._tempFx=b.swipeFx,b.API.next()}),b.container.on(d,function(){b._tempFx=b.swipeFx,b.API.prev()})}}),a(document).on("cycle-update-view",function(a,b){if(!b.allowWrap){var c=b.disabledClass,d=b.API.getComponent("next"),e=b.API.getComponent("prev"),f=b._prevBoundry||0,g=void 0!==b._nextBoundry?b._nextBoundry:b.slideCount-1;b.currSlide==g?d.addClass(c).prop("disabled",!0):d.removeClass(c).prop("disabled",!1),b.currSlide===f?e.addClass(c).prop("disabled",!0):e.removeClass(c).prop("disabled",!1)}}),a(document).on("cycle-destroyed",function(a,b){b.API.getComponent("prev").off(b.nextEvent),b.API.getComponent("next").off(b.prevEvent),b.container.off("swipeleft.cycle swiperight.cycle swipeLeft.cycle swipeRight.cycle swipeUp.cycle swipeDown.cycle")})}(jQuery),/*! progressive loader plugin for Cycle2;  version: 20130315 */
function(a){"use strict";a.extend(a.fn.cycle.defaults,{progressive:!1}),a(document).on("cycle-pre-initialize",function(b,c){if(c.progressive){var d,e,f=c.API,g=f.next,h=f.prev,i=f.prepareTx,j=a.type(c.progressive);if("array"==j)d=c.progressive;else if(a.isFunction(c.progressive))d=c.progressive(c);else if("string"==j){if(e=a(c.progressive),d=a.trim(e.html()),!d)return;if(/^(\[)/.test(d))try{d=a.parseJSON(d)}catch(k){return void f.log("error parsing progressive slides",k)}else d=d.split(new RegExp(e.data("cycle-split")||"\n")),d[d.length-1]||d.pop()}i&&(f.prepareTx=function(a,b){var e,f;return a||0===d.length?void i.apply(c.API,[a,b]):void(b&&c.currSlide==c.slideCount-1?(f=d[0],d=d.slice(1),c.container.one("cycle-slide-added",function(a,b){setTimeout(function(){b.API.advanceSlide(1)},50)}),c.API.add(f)):b||0!==c.currSlide?i.apply(c.API,[a,b]):(e=d.length-1,f=d[e],d=d.slice(0,e),c.container.one("cycle-slide-added",function(a,b){setTimeout(function(){b.currSlide=1,b.API.advanceSlide(-1)},50)}),c.API.add(f,!0)))}),g&&(f.next=function(){var a=this.opts();if(d.length&&a.currSlide==a.slideCount-1){var b=d[0];d=d.slice(1),a.container.one("cycle-slide-added",function(a,b){g.apply(b.API),b.container.removeClass("cycle-loading")}),a.container.addClass("cycle-loading"),a.API.add(b)}else g.apply(a.API)}),h&&(f.prev=function(){var a=this.opts();if(d.length&&0===a.currSlide){var b=d.length-1,c=d[b];d=d.slice(0,b),a.container.one("cycle-slide-added",function(a,b){b.currSlide=1,b.API.advanceSlide(-1),b.container.removeClass("cycle-loading")}),a.container.addClass("cycle-loading"),a.API.add(c,!0)}else h.apply(a.API)})}})}(jQuery),/*! tmpl plugin for Cycle2;  version: 20121227 */
function(a){"use strict";a.extend(a.fn.cycle.defaults,{tmplRegex:"{{((.)?.*?)}}"}),a.extend(a.fn.cycle.API,{tmpl:function(b,c){var d=new RegExp(c.tmplRegex||a.fn.cycle.defaults.tmplRegex,"g"),e=a.makeArray(arguments);return e.shift(),b.replace(d,function(b,c){var d,f,g,h,i=c.split(".");for(d=0;d<e.length;d++)if(g=e[d]){if(i.length>1)for(h=g,f=0;f<i.length;f++)g=h,h=h[i[f]]||c;else h=g[c];if(a.isFunction(h))return h.apply(g,e);if(void 0!==h&&null!==h&&h!=c)return h}return c})}})}(jQuery);

// Lock a submit button when clicked from being clicking again and change the value of the submit to a message, while preserving the submits name and value in a hidden input.
// License: http://www.gnu.org/licenses/lgpl.txt
// Homepage: http://blog.leenix.co.uk/2009/09/jquery-plugin-locksubmit-stop-submit.html
// Version 1.03

jQuery.fn.lockSubmit = function(options) {

	//Default text to change submit button too
	var settings = jQuery.extend({
		submitText: null,
		onAddCSS: null,
		onClickCSS: null
	}, options);

	//add CSS to this button
	if(settings.onAddCSS) {	this.addClass(settings.onAddCSS); }

	return this.click(function(e) {		

		//Hide current submit and insert a dummy submit which is disabled. The reason for doing this and not just disabling the normal submit, is that in some browsers the disabled submit will stop the form being submited at all.

		targetselect = jQuery(this);

		targetselect.hide();
		
		//new buttons value
		if(settings.submitText) { var newValue = settings.submitText; } else { var newValue = jQuery(this).val(); }

		//insert hidden field with name and value of submit
		targetselect.after("<input id='dummySubmit' disabled='disabled' type='submit' name='"+jQuery(this).attr("name")+"DUMMY' value='"+newValue+"'>");

		//add onClick CSS
		if(settings.onClickCSS) {
			jQuery("#dummySubmit").addClass(settings.onClickCSS);
		}

		return true;
	});

};

jQuery.fn.lockSubmitReset = function() {
	this.show();
	jQuery("#dummySubmit").remove();
};


!function(a,b){a.MixItUp=function(){var b=this;b._execAction("_constructor",0),a.extend(b,{selectors:{target:".mix",filter:".filter",sort:".sort"},animation:{enable:!0,effects:"fade scale",duration:600,easing:"ease",perspectiveDistance:"3000",perspectiveOrigin:"50% 50%",queue:!0,queueLimit:1,animateChangeLayout:!1,animateResizeContainer:!0,animateResizeTargets:!1,staggerSequence:!1,reverseOut:!1},callbacks:{onMixLoad:!1,onMixStart:!1,onMixBusy:!1,onMixEnd:!1,onMixFail:!1,_user:!1},controls:{enable:!0,live:!1,toggleFilterButtons:!1,toggleLogic:"or",activeClass:"active"},layout:{display:"inline-block",containerClass:"",containerClassFail:"fail"},load:{filter:"all",sort:!1},_$body:null,_$container:null,_$targets:null,_$parent:null,_$sortButtons:null,_$filterButtons:null,_suckMode:!1,_mixing:!1,_sorting:!1,_clicking:!1,_loading:!0,_changingLayout:!1,_changingClass:!1,_changingDisplay:!1,_origOrder:[],_startOrder:[],_newOrder:[],_activeFilter:null,_toggleArray:[],_toggleString:"",_activeSort:"default:asc",_newSort:null,_startHeight:null,_newHeight:null,_incPadding:!0,_newDisplay:null,_newClass:null,_targetsBound:0,_targetsDone:0,_queue:[],_$show:a(),_$hide:a()}),b._execAction("_constructor",1)},a.MixItUp.prototype={constructor:a.MixItUp,_instances:{},_handled:{_filter:{},_sort:{}},_bound:{_filter:{},_sort:{}},_actions:{},_filters:{},extend:function(b){for(var c in b)a.MixItUp.prototype[c]=b[c]},addAction:function(b,c,d,e){a.MixItUp.prototype._addHook("_actions",b,c,d,e)},addFilter:function(b,c,d,e){a.MixItUp.prototype._addHook("_filters",b,c,d,e)},_addHook:function(b,c,d,e,f){var g=a.MixItUp.prototype[b],h={};f=1===f||"post"===f?"post":"pre",h[c]={},h[c][f]={},h[c][f][d]=e,a.extend(!0,g,h)},_init:function(b,c){var d=this;if(d._execAction("_init",0,arguments),c&&a.extend(!0,d,c),d._$body=a("body"),d._domNode=b,d._$container=a(b),d._$container.addClass(d.layout.containerClass),d._id=b.id,d._platformDetect(),d._brake=d._getPrefixedCSS("transition","none"),d._refresh(!0),d._$parent=d._$targets.parent().length?d._$targets.parent():d._$container,d.load.sort&&(d._newSort=d._parseSort(d.load.sort),d._newSortString=d.load.sort,d._activeSort=d.load.sort,d._sort(),d._printSort()),d._activeFilter="all"===d.load.filter?d.selectors.target:"none"===d.load.filter?"":d.load.filter,d.controls.enable&&d._bindHandlers(),d.controls.toggleFilterButtons){d._buildToggleArray();for(var e=0;e<d._toggleArray.length;e++)d._updateControls({filter:d._toggleArray[e],sort:d._activeSort},!0)}else d.controls.enable&&d._updateControls({filter:d._activeFilter,sort:d._activeSort});d._filter(),d._init=!0,d._$container.data("mixItUp",d),d._execAction("_init",1,arguments),d._buildState(),d._$targets.css(d._brake),d._goMix(d.animation.enable)},_platformDetect:function(){var a=this,c=["Webkit","Moz","O","ms"],d=["webkit","moz"],e=window.navigator.appVersion.match(/Chrome\/(\d+)\./)||!1,f="undefined"!=typeof InstallTrigger,g=function(a){for(var b=0;b<c.length;b++)if(c[b]+"Transition"in a.style)return{prefix:"-"+c[b].toLowerCase()+"-",vendor:c[b]};return"transition"in a.style?"":!1},h=g(a._domNode);a._execAction("_platformDetect",0),a._chrome=e?parseInt(e[1],10):!1,a._ff=f?parseInt(window.navigator.userAgent.match(/rv:([^)]+)\)/)[1]):!1,a._prefix=h.prefix,a._vendor=h.vendor,a._suckMode=window.atob&&a._prefix?!1:!0,a._suckMode&&(a.animation.enable=!1),a._ff&&a._ff<=4&&(a.animation.enable=!1);for(var i=0;i<d.length&&!window.requestAnimationFrame;i++)window.requestAnimationFrame=window[d[i]+"RequestAnimationFrame"];"function"!=typeof Object.getPrototypeOf&&("object"==typeof"test".__proto__?Object.getPrototypeOf=function(a){return a.__proto__}:Object.getPrototypeOf=function(a){return a.constructor.prototype}),a._domNode.nextElementSibling===b&&Object.defineProperty(Element.prototype,"nextElementSibling",{get:function(){for(var a=this.nextSibling;a;){if(1===a.nodeType)return a;a=a.nextSibling}return null}}),a._execAction("_platformDetect",1)},_refresh:function(a,c){var d=this;d._execAction("_refresh",0,arguments),d._$targets=d._$container.find(d.selectors.target);for(var e=0;e<d._$targets.length;e++){var f=d._$targets[e];if(f.dataset===b||c){f.dataset={};for(var g=0;g<f.attributes.length;g++){var h=f.attributes[g],i=h.name,j=h.value;if(i.indexOf("data-")>-1){var k=d._helpers._camelCase(i.substring(5,i.length));f.dataset[k]=j}}}f.mixParent===b&&(f.mixParent=d._id)}if(d._$targets.length&&a||!d._origOrder.length&&d._$targets.length){d._origOrder=[];for(var e=0;e<d._$targets.length;e++){var f=d._$targets[e];d._origOrder.push(f)}}d._execAction("_refresh",1,arguments)},_bindHandlers:function(){var c=this,d=a.MixItUp.prototype._bound._filter,e=a.MixItUp.prototype._bound._sort;c._execAction("_bindHandlers",0),c.controls.live?c._$body.on("click.mixItUp."+c._id,c.selectors.sort,function(){c._processClick(a(this),"sort")}).on("click.mixItUp."+c._id,c.selectors.filter,function(){c._processClick(a(this),"filter")}):(c._$sortButtons=a(c.selectors.sort),c._$filterButtons=a(c.selectors.filter),c._$sortButtons.on("click.mixItUp."+c._id,function(){c._processClick(a(this),"sort")}),c._$filterButtons.on("click.mixItUp."+c._id,function(){c._processClick(a(this),"filter")})),d[c.selectors.filter]=d[c.selectors.filter]===b?1:d[c.selectors.filter]+1,e[c.selectors.sort]=e[c.selectors.sort]===b?1:e[c.selectors.sort]+1,c._execAction("_bindHandlers",1)},_processClick:function(c,d){var e=this,f=function(c,d,f){var g=a.MixItUp.prototype;g._handled["_"+d][e.selectors[d]]=g._handled["_"+d][e.selectors[d]]===b?1:g._handled["_"+d][e.selectors[d]]+1,g._handled["_"+d][e.selectors[d]]===g._bound["_"+d][e.selectors[d]]&&(c[(f?"remove":"add")+"Class"](e.controls.activeClass),delete g._handled["_"+d][e.selectors[d]])};if(e._execAction("_processClick",0,arguments),!e._mixing||e.animation.queue&&e._queue.length<e.animation.queueLimit){if(e._clicking=!0,"sort"===d){var g=c.attr("data-sort");(!c.hasClass(e.controls.activeClass)||g.indexOf("random")>-1)&&(a(e.selectors.sort).removeClass(e.controls.activeClass),f(c,d),e.sort(g))}if("filter"===d){var h,i=c.attr("data-filter"),j="or"===e.controls.toggleLogic?",":"";e.controls.toggleFilterButtons?(e._buildToggleArray(),c.hasClass(e.controls.activeClass)?(f(c,d,!0),h=e._toggleArray.indexOf(i),e._toggleArray.splice(h,1)):(f(c,d),e._toggleArray.push(i)),e._toggleArray=a.grep(e._toggleArray,function(a){return a}),e._toggleString=e._toggleArray.join(j),e.filter(e._toggleString)):c.hasClass(e.controls.activeClass)||(a(e.selectors.filter).removeClass(e.controls.activeClass),f(c,d),e.filter(i))}e._execAction("_processClick",1,arguments)}else"function"==typeof e.callbacks.onMixBusy&&e.callbacks.onMixBusy.call(e._domNode,e._state,e),e._execAction("_processClickBusy",1,arguments)},_buildToggleArray:function(){var a=this,b=a._activeFilter.replace(/\s/g,"");if(a._execAction("_buildToggleArray",0,arguments),"or"===a.controls.toggleLogic)a._toggleArray=b.split(",");else{a._toggleArray=b.split("."),!a._toggleArray[0]&&a._toggleArray.shift();for(var c,d=0;c=a._toggleArray[d];d++)a._toggleArray[d]="."+c}a._execAction("_buildToggleArray",1,arguments)},_updateControls:function(c,d){var e=this,f={filter:c.filter,sort:c.sort},g=function(a,b){try{d&&"filter"===h&&"none"!==f.filter&&""!==f.filter?a.filter(b).addClass(e.controls.activeClass):a.removeClass(e.controls.activeClass).filter(b).addClass(e.controls.activeClass)}catch(c){}},h="filter",i=null;e._execAction("_updateControls",0,arguments),c.filter===b&&(f.filter=e._activeFilter),c.sort===b&&(f.sort=e._activeSort),f.filter===e.selectors.target&&(f.filter="all");for(var j=0;2>j;j++)i=e.controls.live?a(e.selectors[h]):e["_$"+h+"Buttons"],i&&g(i,"[data-"+h+'="'+f[h]+'"]'),h="sort";e._execAction("_updateControls",1,arguments)},_filter:function(){var b=this;b._execAction("_filter",0);for(var c=0;c<b._$targets.length;c++){var d=a(b._$targets[c]);d.is(b._activeFilter)?b._$show=b._$show.add(d):b._$hide=b._$hide.add(d)}b._execAction("_filter",1)},_sort:function(){var a=this,b=function(a){for(var b=a.slice(),c=b.length,d=c;d--;){var e=parseInt(Math.random()*c),f=b[d];b[d]=b[e],b[e]=f}return b};a._execAction("_sort",0),a._startOrder=[];for(var c=0;c<a._$targets.length;c++){var d=a._$targets[c];a._startOrder.push(d)}switch(a._newSort[0].sortBy){case"default":a._newOrder=a._origOrder;break;case"random":a._newOrder=b(a._startOrder);break;case"custom":a._newOrder=a._newSort[0].order;break;default:a._newOrder=a._startOrder.concat().sort(function(b,c){return a._compare(b,c)})}a._execAction("_sort",1)},_compare:function(a,b,c){c=c?c:0;var d=this,e=d._newSort[c].order,f=function(a){return a.dataset[d._newSort[c].sortBy]||0},g=isNaN(1*f(a))?f(a).toLowerCase():1*f(a),h=isNaN(1*f(b))?f(b).toLowerCase():1*f(b);return h>g?"asc"===e?-1:1:g>h?"asc"===e?1:-1:g===h&&d._newSort.length>c+1?d._compare(a,b,c+1):0},_printSort:function(a){var b=this,c=a?b._startOrder:b._newOrder,d=b._$parent[0].querySelectorAll(b.selectors.target),e=d.length?d[d.length-1].nextElementSibling:null,f=document.createDocumentFragment();b._execAction("_printSort",0,arguments);for(var g=0;g<d.length;g++){var h=d[g],i=h.nextSibling;"absolute"!==h.style.position&&(i&&"#text"===i.nodeName&&b._$parent[0].removeChild(i),b._$parent[0].removeChild(h))}for(var g=0;g<c.length;g++){var j=c[g];if("default"!==b._newSort[0].sortBy||"desc"!==b._newSort[0].order||a)f.appendChild(j),f.appendChild(document.createTextNode(" "));else{var k=f.firstChild;f.insertBefore(j,k),f.insertBefore(document.createTextNode(" "),j)}}e?b._$parent[0].insertBefore(f,e):b._$parent[0].appendChild(f),b._execAction("_printSort",1,arguments)},_parseSort:function(a){for(var b=this,c="string"==typeof a?a.split(" "):[a],d=[],e=0;e<c.length;e++){var f="string"==typeof a?c[e].split(":"):["custom",c[e]],g={sortBy:b._helpers._camelCase(f[0]),order:f[1]||"asc"};if(d.push(g),"default"===g.sortBy||"random"===g.sortBy)break}return b._execFilter("_parseSort",d,arguments)},_parseEffects:function(){var a=this,b={opacity:"",transformIn:"",transformOut:"",filter:""},c=function(b,c,d){if(a.animation.effects.indexOf(b)>-1){if(c){var e=a.animation.effects.indexOf(b+"(");if(e>-1){var f=a.animation.effects.substring(e),g=/\(([^)]+)\)/.exec(f),h=g[1];return{val:h}}}return!0}return!1},d=function(a,b){return b?"-"===a.charAt(0)?a.substr(1,a.length):"-"+a:a},e=function(a,e){for(var f=[["scale",".01"],["translateX","20px"],["translateY","20px"],["translateZ","20px"],["rotateX","90deg"],["rotateY","90deg"],["rotateZ","180deg"]],g=0;g<f.length;g++){var h=f[g][0],i=f[g][1],j=e&&"scale"!==h;b[a]+=c(h)?h+"("+d(c(h,!0).val||i,j)+") ":""}};return b.opacity=c("fade")?c("fade",!0).val||"0":"1",e("transformIn"),a.animation.reverseOut?e("transformOut",!0):b.transformOut=b.transformIn,b.transition={},b.transition=a._getPrefixedCSS("transition","all "+a.animation.duration+"ms "+a.animation.easing+", opacity "+a.animation.duration+"ms linear"),a.animation.stagger=c("stagger")?!0:!1,a.animation.staggerDuration=parseInt(c("stagger")&&c("stagger",!0).val?c("stagger",!0).val:100),a._execFilter("_parseEffects",b)},_buildState:function(a){var b=this,c={};return b._execAction("_buildState",0),c={activeFilter:""===b._activeFilter?"none":b._activeFilter,activeSort:a&&b._newSortString?b._newSortString:b._activeSort,fail:!b._$show.length&&""!==b._activeFilter,$targets:b._$targets,$show:b._$show,$hide:b._$hide,totalTargets:b._$targets.length,totalShow:b._$show.length,totalHide:b._$hide.length,display:a&&b._newDisplay?b._newDisplay:b.layout.display},a?b._execFilter("_buildState",c):(b._state=c,void b._execAction("_buildState",1))},_goMix:function(a){var b=this,c=function(){b._chrome&&31===b._chrome&&f(b._$parent[0]),b._setInter(),d()},d=function(){var a=window.pageYOffset,c=window.pageXOffset;document.documentElement.scrollHeight;b._getInterMixData(),b._setFinal(),b._getFinalMixData(),window.pageYOffset!==a&&window.scrollTo(c,a),b._prepTargets(),window.requestAnimationFrame?requestAnimationFrame(e):setTimeout(function(){e()},20)},e=function(){b._animateTargets(),0===b._targetsBound&&b._cleanUp()},f=function(a){var b=a.parentElement,c=document.createElement("div"),d=document.createDocumentFragment();b.insertBefore(c,a),d.appendChild(a),b.replaceChild(a,c)},g=b._buildState(!0);b._execAction("_goMix",0,arguments),!b.animation.duration&&(a=!1),b._mixing=!0,b._$container.removeClass(b.layout.containerClassFail),"function"==typeof b.callbacks.onMixStart&&b.callbacks.onMixStart.call(b._domNode,b._state,g,b),b._$container.trigger("mixStart",[b._state,g,b]),b._getOrigMixData(),a&&!b._suckMode?window.requestAnimationFrame?requestAnimationFrame(c):c():b._cleanUp(),b._execAction("_goMix",1,arguments)},_getTargetData:function(a,b){var c,d=this;a.dataset[b+"PosX"]=a.offsetLeft,a.dataset[b+"PosY"]=a.offsetTop,d.animation.animateResizeTargets&&(c=d._suckMode?{marginBottom:"",marginRight:""}:window.getComputedStyle(a),a.dataset[b+"MarginBottom"]=parseInt(c.marginBottom),a.dataset[b+"MarginRight"]=parseInt(c.marginRight),a.dataset[b+"Width"]=a.offsetWidth,a.dataset[b+"Height"]=a.offsetHeight)},_getOrigMixData:function(){var a=this,b=a._suckMode?{boxSizing:""}:window.getComputedStyle(a._$parent[0]),c=b.boxSizing||b[a._vendor+"BoxSizing"];a._incPadding="border-box"===c,a._execAction("_getOrigMixData",0),!a._suckMode&&(a.effects=a._parseEffects()),a._$toHide=a._$hide.filter(":visible"),a._$toShow=a._$show.filter(":hidden"),a._$pre=a._$targets.filter(":visible"),a._startHeight=a._incPadding?a._$parent.outerHeight():a._$parent.height();for(var d=0;d<a._$pre.length;d++){var e=a._$pre[d];a._getTargetData(e,"orig")}a._execAction("_getOrigMixData",1)},_setInter:function(){var a=this;a._execAction("_setInter",0),a._changingLayout&&a.animation.animateChangeLayout?(a._$toShow.css("display",a._newDisplay),a._changingClass&&a._$container.removeClass(a.layout.containerClass).addClass(a._newClass)):a._$toShow.css("display",a.layout.display),a._execAction("_setInter",1)},_getInterMixData:function(){var a=this;a._execAction("_getInterMixData",0);for(var b=0;b<a._$toShow.length;b++){var c=a._$toShow[b];a._getTargetData(c,"inter")}for(var b=0;b<a._$pre.length;b++){var c=a._$pre[b];a._getTargetData(c,"inter")}a._execAction("_getInterMixData",1)},_setFinal:function(){var a=this;a._execAction("_setFinal",0),a._sorting&&a._printSort(),a._$toHide.removeStyle("display"),a._changingLayout&&a.animation.animateChangeLayout&&a._$pre.css("display",a._newDisplay),a._execAction("_setFinal",1)},_getFinalMixData:function(){var a=this;a._execAction("_getFinalMixData",0);for(var b=0;b<a._$toShow.length;b++){var c=a._$toShow[b];a._getTargetData(c,"final")}for(var b=0;b<a._$pre.length;b++){var c=a._$pre[b];a._getTargetData(c,"final")}a._newHeight=a._incPadding?a._$parent.outerHeight():a._$parent.height(),a._sorting&&a._printSort(!0),a._$toShow.removeStyle("display"),a._$pre.css("display",a.layout.display),a._changingClass&&a.animation.animateChangeLayout&&a._$container.removeClass(a._newClass).addClass(a.layout.containerClass),a._execAction("_getFinalMixData",1)},_prepTargets:function(){var b=this,c={_in:b._getPrefixedCSS("transform",b.effects.transformIn),_out:b._getPrefixedCSS("transform",b.effects.transformOut)};b._execAction("_prepTargets",0),b.animation.animateResizeContainer&&b._$parent.css("height",b._startHeight+"px");for(var d=0;d<b._$toShow.length;d++){var e=b._$toShow[d],f=a(e);e.style.opacity=b.effects.opacity,e.style.display=b._changingLayout&&b.animation.animateChangeLayout?b._newDisplay:b.layout.display,f.css(c._in),b.animation.animateResizeTargets&&(e.style.width=e.dataset.finalWidth+"px",e.style.height=e.dataset.finalHeight+"px",e.style.marginRight=-(e.dataset.finalWidth-e.dataset.interWidth)+1*e.dataset.finalMarginRight+"px",e.style.marginBottom=-(e.dataset.finalHeight-e.dataset.interHeight)+1*e.dataset.finalMarginBottom+"px")}for(var d=0;d<b._$pre.length;d++){var e=b._$pre[d],f=a(e),g={x:e.dataset.origPosX-e.dataset.interPosX,y:e.dataset.origPosY-e.dataset.interPosY},c=b._getPrefixedCSS("transform","translate("+g.x+"px,"+g.y+"px)");f.css(c),b.animation.animateResizeTargets&&(e.style.width=e.dataset.origWidth+"px",e.style.height=e.dataset.origHeight+"px",e.dataset.origWidth-e.dataset.finalWidth&&(e.style.marginRight=-(e.dataset.origWidth-e.dataset.interWidth)+1*e.dataset.origMarginRight+"px"),e.dataset.origHeight-e.dataset.finalHeight&&(e.style.marginBottom=-(e.dataset.origHeight-e.dataset.interHeight)+1*e.dataset.origMarginBottom+"px"))}b._execAction("_prepTargets",1)},_animateTargets:function(){var b=this;b._execAction("_animateTargets",0),b._targetsDone=0,b._targetsBound=0,b._$parent.css(b._getPrefixedCSS("perspective",b.animation.perspectiveDistance+"px")).css(b._getPrefixedCSS("perspective-origin",b.animation.perspectiveOrigin)),b.animation.animateResizeContainer&&b._$parent.css(b._getPrefixedCSS("transition","height "+b.animation.duration+"ms ease")).css("height",b._newHeight+"px");for(var c=0;c<b._$toShow.length;c++){var d=b._$toShow[c],e=a(d),f={x:d.dataset.finalPosX-d.dataset.interPosX,y:d.dataset.finalPosY-d.dataset.interPosY},g=b._getDelay(c),h={};d.style.opacity="";for(var i=0;2>i;i++){var j=0===i?j=b._prefix:"";b._ff&&b._ff<=20&&(h[j+"transition-property"]="all",h[j+"transition-timing-function"]=b.animation.easing+"ms",h[j+"transition-duration"]=b.animation.duration+"ms"),h[j+"transition-delay"]=g+"ms",h[j+"transform"]="translate("+f.x+"px,"+f.y+"px)"}(b.effects.transform||b.effects.opacity)&&b._bindTargetDone(e),b._ff&&b._ff<=20?e.css(h):e.css(b.effects.transition).css(h)}for(var c=0;c<b._$pre.length;c++){var d=b._$pre[c],e=a(d),f={x:d.dataset.finalPosX-d.dataset.interPosX,y:d.dataset.finalPosY-d.dataset.interPosY},g=b._getDelay(c);(d.dataset.finalPosX!==d.dataset.origPosX||d.dataset.finalPosY!==d.dataset.origPosY)&&b._bindTargetDone(e),e.css(b._getPrefixedCSS("transition","all "+b.animation.duration+"ms "+b.animation.easing+" "+g+"ms")),e.css(b._getPrefixedCSS("transform","translate("+f.x+"px,"+f.y+"px)")),b.animation.animateResizeTargets&&(d.dataset.origWidth-d.dataset.finalWidth&&1*d.dataset.finalWidth&&(d.style.width=d.dataset.finalWidth+"px",d.style.marginRight=-(d.dataset.finalWidth-d.dataset.interWidth)+1*d.dataset.finalMarginRight+"px"),d.dataset.origHeight-d.dataset.finalHeight&&1*d.dataset.finalHeight&&(d.style.height=d.dataset.finalHeight+"px",d.style.marginBottom=-(d.dataset.finalHeight-d.dataset.interHeight)+1*d.dataset.finalMarginBottom+"px"))}b._changingClass&&b._$container.removeClass(b.layout.containerClass).addClass(b._newClass);for(var c=0;c<b._$toHide.length;c++){for(var d=b._$toHide[c],e=a(d),g=b._getDelay(c),k={},i=0;2>i;i++){var j=0===i?j=b._prefix:"";k[j+"transition-delay"]=g+"ms",k[j+"transform"]=b.effects.transformOut,k.opacity=b.effects.opacity}e.css(b.effects.transition).css(k),(b.effects.transform||b.effects.opacity)&&b._bindTargetDone(e)}b._execAction("_animateTargets",1)},_bindTargetDone:function(b){var c=this,d=b[0];c._execAction("_bindTargetDone",0,arguments),d.dataset.bound||(d.dataset.bound=!0,c._targetsBound++,b.on("webkitTransitionEnd.mixItUp transitionend.mixItUp",function(e){(e.originalEvent.propertyName.indexOf("transform")>-1||e.originalEvent.propertyName.indexOf("opacity")>-1)&&a(e.originalEvent.target).is(c.selectors.target)&&(b.off(".mixItUp"),delete d.dataset.bound,c._targetDone())})),c._execAction("_bindTargetDone",1,arguments)},_targetDone:function(){var a=this;a._execAction("_targetDone",0),a._targetsDone++,a._targetsDone===a._targetsBound&&a._cleanUp(),a._execAction("_targetDone",1)},_cleanUp:function(){var b=this,c=b.animation.animateResizeTargets?"transform opacity width height margin-bottom margin-right":"transform opacity";unBrake=function(){b._$targets.removeStyle("transition",b._prefix)},b._execAction("_cleanUp",0),b._changingLayout?b._$show.css("display",b._newDisplay):b._$show.css("display",b.layout.display),b._$targets.css(b._brake),b._$targets.removeStyle(c,b._prefix).removeAttr("data-inter-pos-x data-inter-pos-y data-final-pos-x data-final-pos-y data-orig-pos-x data-orig-pos-y data-orig-height data-orig-width data-final-height data-final-width data-inter-width data-inter-height data-orig-margin-right data-orig-margin-bottom data-inter-margin-right data-inter-margin-bottom data-final-margin-right data-final-margin-bottom"),b._$hide.removeStyle("display"),b._$parent.removeStyle("height transition perspective-distance perspective perspective-origin-x perspective-origin-y perspective-origin perspectiveOrigin",b._prefix),b._sorting&&(b._printSort(),b._activeSort=b._newSortString,b._sorting=!1),b._changingLayout&&(b._changingDisplay&&(b.layout.display=b._newDisplay,b._changingDisplay=!1),b._changingClass&&(b._$parent.removeClass(b.layout.containerClass).addClass(b._newClass),b.layout.containerClass=b._newClass,b._changingClass=!1),b._changingLayout=!1),b._refresh(),b._buildState(),b._state.fail&&b._$container.addClass(b.layout.containerClassFail),b._$show=a(),b._$hide=a(),window.requestAnimationFrame&&requestAnimationFrame(unBrake),b._mixing=!1,"function"==typeof b.callbacks._user&&b.callbacks._user.call(b._domNode,b._state,b),"function"==typeof b.callbacks.onMixEnd&&b.callbacks.onMixEnd.call(b._domNode,b._state,b),b._$container.trigger("mixEnd",[b._state,b]),b._state.fail&&("function"==typeof b.callbacks.onMixFail&&b.callbacks.onMixFail.call(b._domNode,b._state,b),b._$container.trigger("mixFail",[b._state,b])),b._loading&&("function"==typeof b.callbacks.onMixLoad&&b.callbacks.onMixLoad.call(b._domNode,b._state,b),b._$container.trigger("mixLoad",[b._state,b])),b._queue.length&&(b._execAction("_queue",0),b.multiMix(b._queue[0][0],b._queue[0][1],b._queue[0][2]),b._queue.splice(0,1)),b._execAction("_cleanUp",1),b._loading=!1},_getPrefixedCSS:function(a,b,c){var d=this,e={},f="",g=-1;for(g=0;2>g;g++)f=0===g?d._prefix:"",c?e[f+a]=f+b:e[f+a]=b;return d._execFilter("_getPrefixedCSS",e,arguments)},_getDelay:function(a){var b=this,c="function"==typeof b.animation.staggerSequence?b.animation.staggerSequence.call(b._domNode,a,b._state):a,d=b.animation.stagger?c*b.animation.staggerDuration:0;return b._execFilter("_getDelay",d,arguments)},_parseMultiMixArgs:function(a){for(var b=this,c={command:null,animate:b.animation.enable,callback:null},d=0;d<a.length;d++){var e=a[d];null!==e&&("object"==typeof e||"string"==typeof e?c.command=e:"boolean"==typeof e?c.animate=e:"function"==typeof e&&(c.callback=e))}return b._execFilter("_parseMultiMixArgs",c,arguments)},_parseInsertArgs:function(b){for(var c=this,d={index:0,$object:a(),multiMix:{filter:c._state.activeFilter},callback:null},e=0;e<b.length;e++){var f=b[e];"number"==typeof f?d.index=f:"object"==typeof f&&f instanceof a?d.$object=f:"object"==typeof f&&c._helpers._isElement(f)?d.$object=a(f):"object"==typeof f&&null!==f?d.multiMix=f:"boolean"!=typeof f||f?"function"==typeof f&&(d.callback=f):d.multiMix=!1}return c._execFilter("_parseInsertArgs",d,arguments)},_execAction:function(a,b,c){var d=this,e=b?"post":"pre";if(!d._actions.isEmptyObject&&d._actions.hasOwnProperty(a))for(var f in d._actions[a][e])d._actions[a][e][f].call(d,c)},_execFilter:function(a,b,c){var d=this;if(d._filters.isEmptyObject||!d._filters.hasOwnProperty(a))return b;for(var e in d._filters[a])return d._filters[a][e].call(d,c)},_helpers:{_camelCase:function(a){return a.replace(/-([a-z])/g,function(a){return a[1].toUpperCase()})},_isElement:function(a){return window.HTMLElement?a instanceof HTMLElement:null!==a&&1===a.nodeType&&"string"===a.nodeName}},isMixing:function(){var a=this;return a._execFilter("isMixing",a._mixing)},filter:function(){var a=this,b=a._parseMultiMixArgs(arguments);a._clicking&&(a._toggleString=""),a.multiMix({filter:b.command},b.animate,b.callback)},sort:function(){var a=this,b=a._parseMultiMixArgs(arguments);a.multiMix({sort:b.command},b.animate,b.callback)},changeLayout:function(){var a=this,b=a._parseMultiMixArgs(arguments);a.multiMix({changeLayout:b.command},b.animate,b.callback)},multiMix:function(){var a=this,c=a._parseMultiMixArgs(arguments);if(a._execAction("multiMix",0,arguments),a._mixing)a.animation.queue&&a._queue.length<a.animation.queueLimit?(a._queue.push(arguments),a.controls.enable&&!a._clicking&&a._updateControls(c.command),a._execAction("multiMixQueue",1,arguments)):("function"==typeof a.callbacks.onMixBusy&&a.callbacks.onMixBusy.call(a._domNode,a._state,a),a._$container.trigger("mixBusy",[a._state,a]),a._execAction("multiMixBusy",1,arguments));else{a.controls.enable&&!a._clicking&&(a.controls.toggleFilterButtons&&a._buildToggleArray(),a._updateControls(c.command,a.controls.toggleFilterButtons)),a._queue.length<2&&(a._clicking=!1),delete a.callbacks._user,c.callback&&(a.callbacks._user=c.callback);var d=c.command.sort,e=c.command.filter,f=c.command.changeLayout;a._refresh(),d&&(a._newSort=a._parseSort(d),a._newSortString=d,a._sorting=!0,a._sort()),e!==b&&(e="all"===e?a.selectors.target:e,a._activeFilter=e),a._filter(),f&&(a._newDisplay="string"==typeof f?f:f.display||a.layout.display,a._newClass=f.containerClass||"",(a._newDisplay!==a.layout.display||a._newClass!==a.layout.containerClass)&&(a._changingLayout=!0,a._changingClass=a._newClass!==a.layout.containerClass,a._changingDisplay=a._newDisplay!==a.layout.display)),a._$targets.css(a._brake),a._goMix(c.animate^a.animation.enable?c.animate:a.animation.enable),a._execAction("multiMix",1,arguments)}},insert:function(){var a=this,b=a._parseInsertArgs(arguments),c="function"==typeof b.callback?b.callback:null,d=document.createDocumentFragment(),e=function(){return a._refresh(),a._$targets.length?b.index<a._$targets.length||!a._$targets.length?a._$targets[b.index]:a._$targets[a._$targets.length-1].nextElementSibling:a._$parent[0].children[0]}();if(a._execAction("insert",0,arguments),b.$object){for(var f=0;f<b.$object.length;f++){var g=b.$object[f];d.appendChild(g),d.appendChild(document.createTextNode(" "))}a._$parent[0].insertBefore(d,e)}a._execAction("insert",1,arguments),"object"==typeof b.multiMix&&a.multiMix(b.multiMix,c)},prepend:function(){var a=this,b=a._parseInsertArgs(arguments);a.insert(0,b.$object,b.multiMix,b.callback)},append:function(){var a=this,b=a._parseInsertArgs(arguments);a.insert(a._state.totalTargets,b.$object,b.multiMix,b.callback)},getOption:function(a){var c=this,d=function(a,c){for(var d=c.split("."),e=d.pop(),f=d.length,g=1,h=d[0]||c;(a=a[h])&&f>g;)h=d[g],g++;return a!==b?a[e]!==b?a[e]:a:void 0};return a?c._execFilter("getOption",d(c,a),arguments):c},setOptions:function(b){var c=this;c._execAction("setOptions",0,arguments),"object"==typeof b&&a.extend(!0,c,b),c._execAction("setOptions",1,arguments)},getState:function(){var a=this;return a._execFilter("getState",a._state,a)},forceRefresh:function(){var a=this;a._refresh(!1,!0)},destroy:function(b){var c=this,d=a.MixItUp.prototype._bound._filter,e=a.MixItUp.prototype._bound._sort;c._execAction("destroy",0,arguments),c._$body.add(a(c.selectors.sort)).add(a(c.selectors.filter)).off(".mixItUp");for(var f=0;f<c._$targets.length;f++){var g=c._$targets[f];b&&(g.style.display=""),delete g.mixParent}c._execAction("destroy",1,arguments),d[c.selectors.filter]&&d[c.selectors.filter]>1?d[c.selectors.filter]--:1===d[c.selectors.filter]&&delete d[c.selectors.filter],e[c.selectors.sort]&&e[c.selectors.sort]>1?e[c.selectors.sort]--:1===e[c.selectors.sort]&&delete e[c.selectors.sort],delete a.MixItUp.prototype._instances[c._id]}},a.fn.mixItUp=function(){var c,d=arguments,e=[],f=function(b,c){var d=new a.MixItUp,e=function(){return("00000"+(16777216*Math.random()<<0).toString(16)).substr(-6).toUpperCase()};d._execAction("_instantiate",0,arguments),b.id=b.id?b.id:"MixItUp"+e(),d._instances[b.id]||(d._instances[b.id]=d,d._init(b,c)),d._execAction("_instantiate",1,arguments)};return c=this.each(function(){if(d&&"string"==typeof d[0]){var c=a.MixItUp.prototype._instances[this.id];if("isLoaded"===d[0])e.push(c?!0:!1);else{var g=c[d[0]](d[1],d[2],d[3]);g!==b&&e.push(g)}}else f(this,d[0])}),e.length?e.length>1?e:e[0]:c},a.fn.removeStyle=function(c,d){return d=d?d:"",this.each(function(){for(var e=this,f=c.split(" "),g=0;g<f.length;g++)for(var h=0;4>h;h++){switch(h){case 0:var i=f[g];break;case 1:var i=a.MixItUp.prototype._helpers._camelCase(i);break;case 2:var i=d+f[g];break;case 3:var i=a.MixItUp.prototype._helpers._camelCase(d+f[g])}if(e.style[i]!==b&&"unknown"!=typeof e.style[i]&&e.style[i].length>0&&(e.style[i]=""),!d&&1===h)break}e.attributes&&e.attributes.style&&e.attributes.style!==b&&""===e.attributes.style.value&&e.attributes.removeNamedItem("style")})}}(jQuery);
/*! modernizr 3.0.0-alpha.3 (Custom Build) | MIT *
 * http://v3.modernizr.com/download/#-audio-backgroundsize-bgsizecover-borderimage-borderradius-boxshadow-canvas-cssanimations-csscolumns-cssgradients-cssreflections-csstransforms-csstransforms3d-csstransitions-cssvhunit-cssvmaxunit-cssvminunit-cssvwunit-flexbox-flexboxlegacy-fontface-generatedcontent-hashchange-history-hsla-multiplebgs-opacity-rgba-smil-srcset-svg-svgasimg-textshadow-touchevents-video-domprefixes-hasevent-load-prefixes-shiv-testallprops-testprop-teststyles !*/
!function(e,t,n){function r(e,t){return typeof e===t}function o(){var e,t,n,o,a,i,s;for(var c in T){if(e=[],t=T[c],t.name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(n=0;n<t.options.aliases.length;n++)e.push(t.options.aliases[n].toLowerCase());for(o=r(t.fn,"function")?t.fn():t.fn,a=0;a<e.length;a++)i=e[a],s=i.split("."),1===s.length?Modernizr[s[0]]=o:(!Modernizr[s[0]]||Modernizr[s[0]]instanceof Boolean||(Modernizr[s[0]]=new Boolean(Modernizr[s[0]])),Modernizr[s[0]][s[1]]=o),b.push((o?"":"no-")+s.join("-"))}}function a(e){var t=E.className,n=Modernizr._config.classPrefix||"";if(Modernizr._config.enableJSClass){var r=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");t=t.replace(r,"$1"+n+"js$2")}Modernizr._config.enableClasses&&(t+=" "+n+e.join(" "+n),E.className=t)}function i(e,t){return!!~(""+e).indexOf(t)}function s(e,t){return e-1===t||e===t||e+1===t}function c(e){return e.replace(/([a-z])-([a-z])/g,function(e,t,n){return t+n.toUpperCase()}).replace(/^-/,"")}function l(){var e=t.body;return e||(e=_("body"),e.fake=!0),e}function d(e,t,n,r){var o,a,i,s,c="modernizr",d=_("div"),u=l();if(parseInt(n,10))for(;n--;)i=_("div"),i.id=r?r[n]:c+(n+1),d.appendChild(i);return o=["&#173;",'<style id="s',c,'">',e,"</style>"].join(""),d.id=c,(u.fake?u:d).innerHTML+=o,u.appendChild(d),u.fake&&(u.style.background="",u.style.overflow="hidden",s=E.style.overflow,E.style.overflow="hidden",E.appendChild(u)),a=t(d,e),u.fake?(u.parentNode.removeChild(u),E.style.overflow=s,E.offsetHeight):d.parentNode.removeChild(d),!!a}function u(e,t){if("object"==typeof e)for(var n in e)R(e,n)&&u(n,e[n]);else{e=e.toLowerCase();var r=e.split("."),o=Modernizr[r[0]];if(2==r.length&&(o=o[r[1]]),"undefined"!=typeof o)return Modernizr;t="function"==typeof t?t():t,1==r.length?Modernizr[r[0]]=t:(!Modernizr[r[0]]||Modernizr[r[0]]instanceof Boolean||(Modernizr[r[0]]=new Boolean(Modernizr[r[0]])),Modernizr[r[0]][r[1]]=t),a([(t&&0!=t?"":"no-")+r.join("-")]),Modernizr._trigger(e,t)}return Modernizr}function f(e){return e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-")}function p(t,r){var o=t.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(f(t[o]),r))return!0;return!1}if("CSSSupportsRule"in e){for(var a=[];o--;)a.push("("+f(t[o])+":"+r+")");return a=a.join(" or "),d("@supports ("+a+") { #modernizr { position: absolute; } }",function(e){return"absolute"==getComputedStyle(e,null).position})}return n}function m(e,t,o,a){function s(){d&&(delete O.style,delete O.modElem)}if(a=r(a,"undefined")?!1:a,!r(o,"undefined")){var l=p(e,o);if(!r(l,"undefined"))return l}var d,u,f,m,h;for(O.style||(d=!0,O.modElem=_("modernizr"),O.style=O.modElem.style),f=e.length,u=0;f>u;u++)if(m=e[u],h=O.style[m],i(m,"-")&&(m=c(m)),O.style[m]!==n){if(a||r(o,"undefined"))return s(),"pfx"==t?m:!0;try{O.style[m]=o}catch(g){}if(O.style[m]!=h)return s(),"pfx"==t?m:!0}return s(),!1}function h(e,t){return function(){return e.apply(t,arguments)}}function g(e,t,n){var o;for(var a in e)if(e[a]in t)return n===!1?e[a]:(o=t[e[a]],r(o,"function")?h(o,n||t):o);return!1}function v(e,t,n,o,a){var i=e.charAt(0).toUpperCase()+e.slice(1),s=(e+" "+N.join(i+" ")+i).split(" ");return r(t,"string")||r(t,"undefined")?m(s,t,o,a):(s=(e+" "+k.join(i+" ")+i).split(" "),g(s,t,n))}function y(e,t,r){return v(e,n,n,t,r)}var b=[];!function(e,t){function n(e,t){var n=e.createElement("p"),r=e.getElementsByTagName("head")[0]||e.documentElement;return n.innerHTML="x<style>"+t+"</style>",r.insertBefore(n.lastChild,r.firstChild)}function r(){var e=b.elements;return"string"==typeof e?e.split(" "):e}function o(e,t){var n=b.elements;"string"!=typeof n&&(n=n.join(" ")),"string"!=typeof e&&(e=e.join(" ")),b.elements=n+" "+e,l(t)}function a(e){var t=y[e[g]];return t||(t={},v++,e[g]=v,y[v]=t),t}function i(e,n,r){if(n||(n=t),u)return n.createElement(e);r||(r=a(n));var o;return o=r.cache[e]?r.cache[e].cloneNode():h.test(e)?(r.cache[e]=r.createElem(e)).cloneNode():r.createElem(e),!o.canHaveChildren||m.test(e)||o.tagUrn?o:r.frag.appendChild(o)}function s(e,n){if(e||(e=t),u)return e.createDocumentFragment();n=n||a(e);for(var o=n.frag.cloneNode(),i=0,s=r(),c=s.length;c>i;i++)o.createElement(s[i]);return o}function c(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(n){return b.shivMethods?i(n,e,t):t.createElem(n)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+r().join().replace(/[\w\-:]+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(b,t.frag)}function l(e){e||(e=t);var r=a(e);return!b.shivCSS||d||r.hasCSS||(r.hasCSS=!!n(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),u||c(e,r),e}var d,u,f="3.7.2",p=e.html5||{},m=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,h=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g="_html5shiv",v=0,y={};!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",d="hidden"in e,u=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(n){d=!0,u=!0}}();var b={elements:p.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:f,shivCSS:p.shivCSS!==!1,supportsUnknownElements:u,shivMethods:p.shivMethods!==!1,type:"default",shivDocument:l,createElement:i,createDocumentFragment:s,addElements:o};e.html5=b,l(t)}(this,t);var T=[],w={_version:"3.0.0-alpha.3",_config:{classPrefix:"ws-",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var n=this;setTimeout(function(){t(n[e])},0)},addTest:function(e,t,n){T.push({name:e,fn:t,options:n})},addAsyncTest:function(e){T.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=w,Modernizr=new Modernizr,Modernizr.addTest("history",function(){var t=navigator.userAgent;return-1===t.indexOf("Android 2.")&&-1===t.indexOf("Android 4.0")||-1===t.indexOf("Mobile Safari")||-1!==t.indexOf("Chrome")||-1!==t.indexOf("Windows Phone")?e.history&&"pushState"in e.history:!1}),Modernizr.addTest("svg",!!t.createElementNS&&!!t.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect);var x=function(){},S=function(){};e.console&&(x=function(){var t=console.error?"error":"log";e.console[t].apply(e.console,Array.prototype.slice.call(arguments))},S=function(){var t=console.warn?"warn":"log";e.console[t].apply(e.console,Array.prototype.slice.call(arguments))}),w.load=function(){"yepnope"in e?(S("yepnope.js (aka Modernizr.load) is no longer included as part of Modernizr. yepnope appears to be available on the page, so we’ll use it to handle this call to Modernizr.load, but please update your code to use yepnope directly.\n See http://github.com/Modernizr/Modernizr/issues/1182 for more information."),e.yepnope.apply(e,[].slice.call(arguments,0))):x("yepnope.js (aka Modernizr.load) is no longer included as part of Modernizr. Get it from http://yepnopejs.com. See http://github.com/Modernizr/Modernizr/issues/1182 for more information.")};var C=w._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):[];w._prefixes=C;var E=t.documentElement,z="Moz O ms Webkit",k=w._config.usePrefixes?z.toLowerCase().split(" "):[];w._domPrefixes=k;var _=function(){return"function"!=typeof t.createElement?t.createElement(arguments[0]):t.createElement.apply(t,arguments)};Modernizr.addTest("canvas",function(){var e=_("canvas");return!(!e.getContext||!e.getContext("2d"))}),Modernizr.addTest("cssgradients",function(){var e="background-image:",t="gradient(linear,left top,right bottom,from(#9f9),to(white));",n="linear-gradient(left top,#9f9, white);",r=e+C.join(n+e).slice(0,-e.length);Modernizr._config.usePrefixes&&(r+=e+"-webkit-"+t);var o=_("div"),a=o.style;return a.cssText=r,(""+a.backgroundImage).indexOf("gradient")>-1}),Modernizr.addTest("multiplebgs",function(){var e=_("div"),t=e.style;return t.cssText="background:url(https://),url(https://),red url(https://)",/(url\s*\(.*?){3}/.test(t.background)}),Modernizr.addTest("opacity",function(){var e=_("div"),t=e.style;return t.cssText=C.join("opacity:.55;"),/^0.55$/.test(t.opacity)}),Modernizr.addTest("rgba",function(){var e=_("div"),t=e.style;return t.cssText="background-color:rgba(150,255,150,.5)",(""+t.backgroundColor).indexOf("rgba")>-1}),Modernizr.addTest("audio",function(){var e=_("audio"),t=!1;try{(t=!!e.canPlayType)&&(t=new Boolean(t),t.ogg=e.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,""),t.mp3=e.canPlayType("audio/mpeg;").replace(/^no$/,""),t.opus=e.canPlayType('audio/ogg; codecs="opus"').replace(/^no$/,""),t.wav=e.canPlayType('audio/wav; codecs="1"').replace(/^no$/,""),t.m4a=(e.canPlayType("audio/x-m4a;")||e.canPlayType("audio/aac;")).replace(/^no$/,""))}catch(n){}return t}),Modernizr.addTest("video",function(){var e=_("video"),t=!1;try{(t=!!e.canPlayType)&&(t=new Boolean(t),t.ogg=e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),t.h264=e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),t.webm=e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,""),t.vp9=e.canPlayType('video/webm; codecs="vp9"').replace(/^no$/,""),t.hls=e.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/,""))}catch(n){}return t}),Modernizr.addTest("srcset","srcset"in _("img"));var P=function(e){function n(t,n){var o;return t?(n&&"string"!=typeof n||(n=_(n||"div")),t="on"+t,o=t in n,!o&&r&&(n.setAttribute||(n=_("div")),n.setAttribute(t,""),o="function"==typeof n[t],n[t]!==e&&(n[t]=e),n.removeAttribute(t)),o):!1}var r=!("onblur"in t.documentElement);return n}(),M=w.hasEvent=P;Modernizr.addTest("hashchange",function(){return M("hashchange",e)===!1?!1:t.documentMode===n||t.documentMode>7}),Modernizr.addTest("hsla",function(){var e=_("div"),t=e.style;return t.cssText="background-color:hsla(120,40%,100%,.5)",i(t.backgroundColor,"rgba")||i(t.backgroundColor,"hsla")});var j="CSS"in e&&"supports"in e.CSS,I="supportsCSS"in e;Modernizr.addTest("supports",j||I);var A={}.toString;Modernizr.addTest("smil",function(){return!!t.createElementNS&&/SVGAnimate/.test(A.call(t.createElementNS("http://www.w3.org/2000/svg","animate")))});var B=w.testStyles=d,$=function(){var e=navigator.userAgent,t=e.match(/applewebkit\/([0-9]+)/gi)&&parseFloat(RegExp.$1),n=e.match(/w(eb)?osbrowser/gi),r=e.match(/windows phone/gi)&&e.match(/iemobile\/([0-9])+/gi)&&parseFloat(RegExp.$1)>=9,o=533>t&&e.match(/android/gi);return n||o||r}();$?Modernizr.addTest("fontface",!1):B('@font-face {font-family:"font";src:url("https://")}',function(e,n){var r=t.getElementById("smodernizr"),o=r.sheet||r.styleSheet,a=o?o.cssRules&&o.cssRules[0]?o.cssRules[0].cssText:o.cssText||"":"",i=/src/i.test(a)&&0===a.indexOf(n.split(" ")[0]);Modernizr.addTest("fontface",i)}),B('#modernizr{font:0/0 a}#modernizr:after{content:":)";visibility:hidden;font:7px/1 a}',function(e){Modernizr.addTest("generatedcontent",e.offsetHeight>=7)}),B("#modernizr { height: 50vh; }",function(t){var n=parseInt(e.innerHeight/2,10),r=parseInt((e.getComputedStyle?getComputedStyle(t,null):t.currentStyle).height,10);Modernizr.addTest("cssvhunit",r==n)}),B("#modernizr1{width: 50vmax}#modernizr2{width:50px;height:50px;overflow:scroll}",function(){var n=t.getElementById("modernizr1"),r=t.getElementById("modernizr2"),o=parseInt((r.offsetWidth-r.clientWidth)/2,10),a=E.clientWidth/100,i=E.clientHeight/100,c=parseInt(50*Math.max(a,i),10),l=parseInt((e.getComputedStyle?getComputedStyle(n,null):n.currentStyle).width,10);Modernizr.addTest("cssvmaxunit",s(c,l)||s(c,l-o))},2),B("#modernizr1{width: 50vm;width:50vmin}#modernizr2{width:50px;height:50px;overflow:scroll}",function(){var n=t.getElementById("modernizr1"),r=t.getElementById("modernizr2"),o=parseInt((r.offsetWidth-r.clientWidth)/2,10),a=E.clientWidth/100,i=E.clientHeight/100,c=parseInt(50*Math.min(a,i),10),l=parseInt((e.getComputedStyle?getComputedStyle(n,null):n.currentStyle).width,10);Modernizr.addTest("cssvminunit",s(c,l)||s(c,l-o))},2),B("#modernizr { width: 50vw; }",function(t){var n=parseInt(e.innerWidth/2,10),r=parseInt((e.getComputedStyle?getComputedStyle(t,null):t.currentStyle).width,10);Modernizr.addTest("cssvwunit",r==n)}),Modernizr.addTest("touchevents",function(){var n;if("ontouchstart"in e||e.DocumentTouch&&t instanceof DocumentTouch)n=!0;else{var r=["@media (",C.join("touch-enabled),("),"heartz",")","{#modernizr{top:9px;position:absolute}}"].join("");B(r,function(e){n=9===e.offsetTop})}return n});var N=w._config.usePrefixes?z.split(" "):[];w._cssomPrefixes=N;var R;!function(){var e={}.hasOwnProperty;R=r(e,"undefined")||r(e.call,"undefined")?function(e,t){return t in e&&r(e.constructor.prototype[t],"undefined")}:function(t,n){return e.call(t,n)}}(),w._l={},w.on=function(e,t){this._l[e]||(this._l[e]=[]),this._l[e].push(t),Modernizr.hasOwnProperty(e)&&setTimeout(function(){Modernizr._trigger(e,Modernizr[e])},0)},w._trigger=function(e,t){if(this._l[e]){var n=this._l[e];setTimeout(function(){var e,r;for(e=0;e<n.length;e++)(r=n[e])(t)},0),delete this._l[e]}},Modernizr._q.push(function(){w.addTest=u}),Modernizr.addTest("svgasimg",t.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1"));var F={elem:_("modernizr")};Modernizr._q.push(function(){delete F.elem});var O={style:F.elem.style};Modernizr._q.unshift(function(){delete O.style});var L=w.testProp=function(e,t,r){return m([e],n,t,r)};Modernizr.addTest("textshadow",L("textShadow","1px 1px")),w.testAllProps=v,w.testAllProps=y,Modernizr.addTest("backgroundsize",y("backgroundSize","100%",!0)),Modernizr.addTest("bgsizecover",y("backgroundSize","cover")),Modernizr.addTest("borderimage",y("borderImage","url() 1",!0)),Modernizr.addTest("borderradius",y("borderRadius","0px",!0)),Modernizr.addTest("boxshadow",y("boxShadow","1px 1px",!0)),Modernizr.addTest("cssanimations",y("animationName","a",!0)),function(){Modernizr.addTest("csscolumns",function(){var e=!1,t=y("columnCount");try{(e=!!t)&&(e=new Boolean(e))}catch(n){}return e});for(var e,t,n=["Width","Span","Fill","Gap","Rule","RuleColor","RuleStyle","RuleWidth","BreakBefore","BreakAfter","BreakInside"],r=0;r<n.length;r++)e=n[r].toLowerCase(),t=y("column"+n[r]),("breakbefore"===e||"breakafter"===e||"breakinside"==e)&&(t=t||y(n[r])),Modernizr.addTest("csscolumns."+e,t)}(),Modernizr.addTest("cssreflections",y("boxReflect","above",!0)),Modernizr.addTest("csstransforms",function(){return-1===navigator.userAgent.indexOf("Android 2.")&&y("transform","scale(1)",!0)}),Modernizr.addTest("csstransforms3d",function(){var e=!!y("perspective","1px",!0),t=Modernizr._config.usePrefixes;if(e&&(!t||"webkitPerspective"in E.style)){var n;Modernizr.supports?n="@supports (perspective: 1px)":(n="@media (transform-3d)",t&&(n+=",(-webkit-transform-3d)")),n+="{#modernizr{left:9px;position:absolute;height:5px;margin:0;padding:0;border:0}}",B(n,function(t){e=9===t.offsetLeft&&5===t.offsetHeight})}return e}),Modernizr.addTest("csstransitions",y("transition","all",!0)),Modernizr.addTest("flexbox",y("flexBasis","1px",!0)),Modernizr.addTest("flexboxlegacy",y("boxDirection","reverse",!0)),o(),a(b),delete w.addTest,delete w.addAsyncTest;for(var W=0;W<Modernizr._q.length;W++)Modernizr._q[W]();e.Modernizr=Modernizr}(window,document);
(function defineMustache(global,factory){if(typeof exports==="object"&&exports&&typeof exports.nodeName!=="string"){factory(exports)}else if(typeof define==="function"&&define.amd){define(["exports"],factory)}else{global.Mustache={};factory(Mustache)}})(this,function mustacheFactory(mustache){var objectToString=Object.prototype.toString;var isArray=Array.isArray||function isArrayPolyfill(object){return objectToString.call(object)==="[object Array]"};function isFunction(object){return typeof object==="function"}function typeStr(obj){return isArray(obj)?"array":typeof obj}function escapeRegExp(string){return string.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g,"\\$&")}function hasProperty(obj,propName){return obj!=null&&typeof obj==="object"&&propName in obj}var regExpTest=RegExp.prototype.test;function testRegExp(re,string){return regExpTest.call(re,string)}var nonSpaceRe=/\S/;function isWhitespace(string){return!testRegExp(nonSpaceRe,string)}var entityMap={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#x2F;"};function escapeHtml(string){return String(string).replace(/[&<>"'\/]/g,function fromEntityMap(s){return entityMap[s]})}var whiteRe=/\s*/;var spaceRe=/\s+/;var equalsRe=/\s*=/;var curlyRe=/\s*\}/;var tagRe=/#|\^|\/|>|\{|&|=|!/;function parseTemplate(template,tags){if(!template)return[];var sections=[];var tokens=[];var spaces=[];var hasTag=false;var nonSpace=false;function stripSpace(){if(hasTag&&!nonSpace){while(spaces.length)delete tokens[spaces.pop()]}else{spaces=[]}hasTag=false;nonSpace=false}var openingTagRe,closingTagRe,closingCurlyRe;function compileTags(tagsToCompile){if(typeof tagsToCompile==="string")tagsToCompile=tagsToCompile.split(spaceRe,2);if(!isArray(tagsToCompile)||tagsToCompile.length!==2)throw new Error("Invalid tags: "+tagsToCompile);openingTagRe=new RegExp(escapeRegExp(tagsToCompile[0])+"\\s*");closingTagRe=new RegExp("\\s*"+escapeRegExp(tagsToCompile[1]));closingCurlyRe=new RegExp("\\s*"+escapeRegExp("}"+tagsToCompile[1]))}compileTags(tags||mustache.tags);var scanner=new Scanner(template);var start,type,value,chr,token,openSection;while(!scanner.eos()){start=scanner.pos;value=scanner.scanUntil(openingTagRe);if(value){for(var i=0,valueLength=value.length;i<valueLength;++i){chr=value.charAt(i);if(isWhitespace(chr)){spaces.push(tokens.length)}else{nonSpace=true}tokens.push(["text",chr,start,start+1]);start+=1;if(chr==="\n")stripSpace()}}if(!scanner.scan(openingTagRe))break;hasTag=true;type=scanner.scan(tagRe)||"name";scanner.scan(whiteRe);if(type==="="){value=scanner.scanUntil(equalsRe);scanner.scan(equalsRe);scanner.scanUntil(closingTagRe)}else if(type==="{"){value=scanner.scanUntil(closingCurlyRe);scanner.scan(curlyRe);scanner.scanUntil(closingTagRe);type="&"}else{value=scanner.scanUntil(closingTagRe)}if(!scanner.scan(closingTagRe))throw new Error("Unclosed tag at "+scanner.pos);token=[type,value,start,scanner.pos];tokens.push(token);if(type==="#"||type==="^"){sections.push(token)}else if(type==="/"){openSection=sections.pop();if(!openSection)throw new Error('Unopened section "'+value+'" at '+start);if(openSection[1]!==value)throw new Error('Unclosed section "'+openSection[1]+'" at '+start)}else if(type==="name"||type==="{"||type==="&"){nonSpace=true}else if(type==="="){compileTags(value)}}openSection=sections.pop();if(openSection)throw new Error('Unclosed section "'+openSection[1]+'" at '+scanner.pos);return nestTokens(squashTokens(tokens))}function squashTokens(tokens){var squashedTokens=[];var token,lastToken;for(var i=0,numTokens=tokens.length;i<numTokens;++i){token=tokens[i];if(token){if(token[0]==="text"&&lastToken&&lastToken[0]==="text"){lastToken[1]+=token[1];lastToken[3]=token[3]}else{squashedTokens.push(token);lastToken=token}}}return squashedTokens}function nestTokens(tokens){var nestedTokens=[];var collector=nestedTokens;var sections=[];var token,section;for(var i=0,numTokens=tokens.length;i<numTokens;++i){token=tokens[i];switch(token[0]){case"#":case"^":collector.push(token);sections.push(token);collector=token[4]=[];break;case"/":section=sections.pop();section[5]=token[2];collector=sections.length>0?sections[sections.length-1][4]:nestedTokens;break;default:collector.push(token)}}return nestedTokens}function Scanner(string){this.string=string;this.tail=string;this.pos=0}Scanner.prototype.eos=function eos(){return this.tail===""};Scanner.prototype.scan=function scan(re){var match=this.tail.match(re);if(!match||match.index!==0)return"";var string=match[0];this.tail=this.tail.substring(string.length);this.pos+=string.length;return string};Scanner.prototype.scanUntil=function scanUntil(re){var index=this.tail.search(re),match;switch(index){case-1:match=this.tail;this.tail="";break;case 0:match="";break;default:match=this.tail.substring(0,index);this.tail=this.tail.substring(index)}this.pos+=match.length;return match};function Context(view,parentContext){this.view=view;this.cache={".":this.view};this.parent=parentContext}Context.prototype.push=function push(view){return new Context(view,this)};Context.prototype.lookup=function lookup(name){var cache=this.cache;var value;if(cache.hasOwnProperty(name)){value=cache[name]}else{var context=this,names,index,lookupHit=false;while(context){if(name.indexOf(".")>0){value=context.view;names=name.split(".");index=0;while(value!=null&&index<names.length){if(index===names.length-1)lookupHit=hasProperty(value,names[index]);value=value[names[index++]]}}else{value=context.view[name];lookupHit=hasProperty(context.view,name)}if(lookupHit)break;context=context.parent}cache[name]=value}if(isFunction(value))value=value.call(this.view);return value};function Writer(){this.cache={}}Writer.prototype.clearCache=function clearCache(){this.cache={}};Writer.prototype.parse=function parse(template,tags){var cache=this.cache;var tokens=cache[template];if(tokens==null)tokens=cache[template]=parseTemplate(template,tags);return tokens};Writer.prototype.render=function render(template,view,partials){var tokens=this.parse(template);var context=view instanceof Context?view:new Context(view);return this.renderTokens(tokens,context,partials,template)};Writer.prototype.renderTokens=function renderTokens(tokens,context,partials,originalTemplate){var buffer="";var token,symbol,value;for(var i=0,numTokens=tokens.length;i<numTokens;++i){value=undefined;token=tokens[i];symbol=token[0];if(symbol==="#")value=this.renderSection(token,context,partials,originalTemplate);else if(symbol==="^")value=this.renderInverted(token,context,partials,originalTemplate);else if(symbol===">")value=this.renderPartial(token,context,partials,originalTemplate);else if(symbol==="&")value=this.unescapedValue(token,context);else if(symbol==="name")value=this.escapedValue(token,context);else if(symbol==="text")value=this.rawValue(token);if(value!==undefined)buffer+=value}return buffer};Writer.prototype.renderSection=function renderSection(token,context,partials,originalTemplate){var self=this;var buffer="";var value=context.lookup(token[1]);function subRender(template){return self.render(template,context,partials)}if(!value)return;if(isArray(value)){for(var j=0,valueLength=value.length;j<valueLength;++j){buffer+=this.renderTokens(token[4],context.push(value[j]),partials,originalTemplate)}}else if(typeof value==="object"||typeof value==="string"||typeof value==="number"){buffer+=this.renderTokens(token[4],context.push(value),partials,originalTemplate)}else if(isFunction(value)){if(typeof originalTemplate!=="string")throw new Error("Cannot use higher-order sections without the original template");value=value.call(context.view,originalTemplate.slice(token[3],token[5]),subRender);if(value!=null)buffer+=value}else{buffer+=this.renderTokens(token[4],context,partials,originalTemplate)}return buffer};Writer.prototype.renderInverted=function renderInverted(token,context,partials,originalTemplate){var value=context.lookup(token[1]);if(!value||isArray(value)&&value.length===0)return this.renderTokens(token[4],context,partials,originalTemplate)};Writer.prototype.renderPartial=function renderPartial(token,context,partials){if(!partials)return;var value=isFunction(partials)?partials(token[1]):partials[token[1]];if(value!=null)return this.renderTokens(this.parse(value),context,partials,value)};Writer.prototype.unescapedValue=function unescapedValue(token,context){var value=context.lookup(token[1]);if(value!=null)return value};Writer.prototype.escapedValue=function escapedValue(token,context){var value=context.lookup(token[1]);if(value!=null)return mustache.escape(value)};Writer.prototype.rawValue=function rawValue(token){return token[1]};mustache.name="mustache.js";mustache.version="2.1.3";mustache.tags=["{{","}}"];var defaultWriter=new Writer;mustache.clearCache=function clearCache(){return defaultWriter.clearCache()};mustache.parse=function parse(template,tags){return defaultWriter.parse(template,tags)};mustache.render=function render(template,view,partials){if(typeof template!=="string"){throw new TypeError('Invalid template! Template should be a "string" '+'but "'+typeStr(template)+'" was given as the first '+"argument for mustache#render(template, view, partials)")}return defaultWriter.render(template,view,partials)};mustache.to_html=function to_html(template,view,partials,send){var result=mustache.render(template,view,partials);if(isFunction(send)){send(result)}else{return result}};mustache.escape=escapeHtml;mustache.Scanner=Scanner;mustache.Context=Context;mustache.Writer=Writer});

(function(a){a.isScrollToFixed=function(b){return !!a(b).data("ScrollToFixed")};a.ScrollToFixed=function(d,i){var m=this;m.$el=a(d);m.el=d;m.$el.data("ScrollToFixed",m);var c=false;var H=m.$el;var I;var F;var k;var e;var z;var E=0;var r=0;var j=-1;var f=-1;var u=null;var A;var g;function v(){H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed");f=-1;E=H.offset().top;r=H.offset().left;if(m.options.offsets){r+=(H.offset().left-H.position().left)}if(j==-1){j=r}I=H.css("position");c=true;if(m.options.bottom!=-1){H.trigger("preFixed.ScrollToFixed");x();H.trigger("fixed.ScrollToFixed")}}function o(){var J=m.options.limit;if(!J){return 0}if(typeof(J)==="function"){return J.apply(H)}return J}function q(){return I==="fixed"}function y(){return I==="absolute"}function h(){return !(q()||y())}function x(){if(!q()){var J=H[0].getBoundingClientRect();u.css({display:H.css("display"),width:J.width,height:J.height,"float":H.css("float")});cssOptions={"z-index":m.options.zIndex,position:"fixed",top:m.options.bottom==-1?t():"",bottom:m.options.bottom==-1?"":m.options.bottom,"margin-left":"0px"};if(!m.options.dontSetWidth){cssOptions.width=H.css("width")}H.css(cssOptions);H.addClass(m.options.baseClassName);if(m.options.className){H.addClass(m.options.className)}I="fixed"}}function b(){var K=o();var J=r;if(m.options.removeOffsets){J="";K=K-E}cssOptions={position:"absolute",top:K,left:J,"margin-left":"0px",bottom:""};if(!m.options.dontSetWidth){cssOptions.width=H.css("width")}H.css(cssOptions);I="absolute"}function l(){if(!h()){f=-1;u.css("display","none");H.css({"z-index":z,width:"",position:F,left:"",top:e,"margin-left":""});H.removeClass("scroll-to-fixed-fixed");if(m.options.className){H.removeClass(m.options.className)}I=null}}function w(J){if(J!=f){H.css("left",r-J);f=J}}function t(){var J=m.options.marginTop;if(!J){return 0}if(typeof(J)==="function"){return J.apply(H)}return J}function B(){if(!a.isScrollToFixed(H)||H.is(":hidden")){return}var M=c;var L=h();if(!c){v()}else{if(h()){E=H.offset().top;r=H.offset().left}}var J=a(window).scrollLeft();var N=a(window).scrollTop();var K=o();if(m.options.minWidth&&a(window).width()<m.options.minWidth){if(!h()||!M){p();H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed")}}else{if(m.options.maxWidth&&a(window).width()>m.options.maxWidth){if(!h()||!M){p();H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed")}}else{if(m.options.bottom==-1){if(K>0&&N>=K-t()){if(!L&&(!y()||!M)){p();H.trigger("preAbsolute.ScrollToFixed");b();H.trigger("unfixed.ScrollToFixed")}}else{if(N>=E-t()){if(!q()||!M){p();H.trigger("preFixed.ScrollToFixed");x();f=-1;H.trigger("fixed.ScrollToFixed")}w(J)}else{if(!h()||!M){p();H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed")}}}}else{if(K>0){if(N+a(window).height()-H.outerHeight(true)>=K-(t()||-n())){if(q()){p();H.trigger("preUnfixed.ScrollToFixed");if(F==="absolute"){b()}else{l()}H.trigger("unfixed.ScrollToFixed")}}else{if(!q()){p();H.trigger("preFixed.ScrollToFixed");x()}w(J);H.trigger("fixed.ScrollToFixed")}}else{w(J)}}}}}function n(){if(!m.options.bottom){return 0}return m.options.bottom}function p(){var J=H.css("position");if(J=="absolute"){H.trigger("postAbsolute.ScrollToFixed")}else{if(J=="fixed"){H.trigger("postFixed.ScrollToFixed")}else{H.trigger("postUnfixed.ScrollToFixed")}}}var D=function(J){if(H.is(":visible")){c=false;B()}};var G=function(J){(!!window.requestAnimationFrame)?requestAnimationFrame(B):B()};var C=function(){var K=document.body;if(document.createElement&&K&&K.appendChild&&K.removeChild){var M=document.createElement("div");if(!M.getBoundingClientRect){return null}M.innerHTML="x";M.style.cssText="position:fixed;top:100px;";K.appendChild(M);var N=K.style.height,O=K.scrollTop;K.style.height="3000px";K.scrollTop=500;var J=M.getBoundingClientRect().top;K.style.height=N;var L=(J===100);K.removeChild(M);K.scrollTop=O;return L}return null};var s=function(J){J=J||window.event;if(J.preventDefault){J.preventDefault()}J.returnValue=false};m.init=function(){m.options=a.extend({},a.ScrollToFixed.defaultOptions,i);z=H.css("z-index");m.$el.css("z-index",m.options.zIndex);u=a("<div />");I=H.css("position");F=H.css("position");k=H.css("float");e=H.css("top");if(h()){m.$el.after(u)}a(window).bind("resize.ScrollToFixed",D);a(window).bind("scroll.ScrollToFixed",G);if("ontouchmove" in window){a(window).bind("touchmove.ScrollToFixed",B)}if(m.options.preFixed){H.bind("preFixed.ScrollToFixed",m.options.preFixed)}if(m.options.postFixed){H.bind("postFixed.ScrollToFixed",m.options.postFixed)}if(m.options.preUnfixed){H.bind("preUnfixed.ScrollToFixed",m.options.preUnfixed)}if(m.options.postUnfixed){H.bind("postUnfixed.ScrollToFixed",m.options.postUnfixed)}if(m.options.preAbsolute){H.bind("preAbsolute.ScrollToFixed",m.options.preAbsolute)}if(m.options.postAbsolute){H.bind("postAbsolute.ScrollToFixed",m.options.postAbsolute)}if(m.options.fixed){H.bind("fixed.ScrollToFixed",m.options.fixed)}if(m.options.unfixed){H.bind("unfixed.ScrollToFixed",m.options.unfixed)}if(m.options.spacerClass){u.addClass(m.options.spacerClass)}H.bind("resize.ScrollToFixed",function(){u.height(H.height())});H.bind("scroll.ScrollToFixed",function(){H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed");B()});H.bind("detach.ScrollToFixed",function(J){s(J);H.trigger("preUnfixed.ScrollToFixed");l();H.trigger("unfixed.ScrollToFixed");a(window).unbind("resize.ScrollToFixed",D);a(window).unbind("scroll.ScrollToFixed",G);H.unbind(".ScrollToFixed");u.remove();m.$el.removeData("ScrollToFixed")});D()};m.init()};a.ScrollToFixed.defaultOptions={marginTop:0,limit:0,bottom:-1,zIndex:1000,baseClassName:"scroll-to-fixed-fixed"};a.fn.scrollToFixed=function(b){return this.each(function(){(new a.ScrollToFixed(this,b))})}})(jQuery);