/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
( function( $, window, undefined ) {

	if ( $('body').hasClass('single-collection postid-1147') ) { // only for Heritage Festivals Collection

		'use strict';

		// Collections
		// http://www.benknowscode.com/2012/11/selecting-ranges-jquery-ui-datepicker.html

		$.datepicker._defaults.onAfterUpdate = null;

		var datepicker__updateDatepicker = $.datepicker._updateDatepicker;

		$.datepicker._updateDatepicker = function( inst ) {
			datepicker__updateDatepicker.call( this, inst );

			var onAfterUpdate = this._get(inst, 'onAfterUpdate');
			if (onAfterUpdate) {
				onAfterUpdate.apply((inst.input ? inst.input[0] : null), [(inst.input ? inst.input.val() : ''), inst]);
			}
		}

		var cur, prv;

		// global variables to track the date range
		cur = -1;
		prv = -1;
		 
		// Create the picker and align it to the bottom of the input field 
		$('#jrange div')
			.datepicker({
				numberOfMonths: 2,
				dateFormat: "yymmdd",
	            // changeMonth: true,
	            // changeYear: true,
	            showButtonPanel: true,
	            beforeShowDay: function ( date ) {
					return [true, ( (date.getTime() >= Math.min(prv, cur) && date.getTime() <= Math.max(prv, cur)) ? 'date-range-selected' : '')];
				},
				onSelect: function ( dateText, inst ) {
					var d1, d2;

					prv = +cur;
					cur = (new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)).getTime();

					if ( prv == -1 || prv == cur ) {
						prv = cur;
						$('#jrange input').val( dateText );
					} else {
						d1 = $.datepicker.formatDate( 'yymmdd', new Date(Math.min(prv,cur)), {} );
						d2 = $.datepicker.formatDate( 'yymmdd', new Date(Math.max(prv,cur)), {} );
						$('#jrange input').val( d1+'-'+d2 );	
					}

				},
				onAfterUpdate: function ( inst ) {
					$('<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">Apply</button>')
						.appendTo($('#jrange div .ui-datepicker-buttonpane'))
						.on('click', function () { 
							$('#jrange div').hide(); 
						});
				}
			})
			.hide(); // Hide it for later
		 
		// Listen for focus on the input field and show the picker
		$('#jrange input').on('focus', function (e) {
				$('#jrange div').show();
			 });

	}



})(jQuery, window);
