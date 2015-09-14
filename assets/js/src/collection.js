/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
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
