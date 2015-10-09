/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( jQuery, window, undefined ) {
	'use strict';

	// MARKETO FORM BEHAVIOR

	jQuery(document).ready(function() {

		if( jQuery('#get-info-form').length )  {
			wsData.populateStates();
			universalLead();
			wsData.validateAndSubmitForm();
		}

	});

	/**
	 * Base URL for API calls
	 */
	wsData.mdrapi_base_url = "http://apis.worldstrides.com/mdrapi/v1/";

	/**
	 * Parameters for the spinner: http://fgnass.github.io/spin.js/
	 */
	wsData.spinnerParams = {
		  lines: 9 // The number of lines to draw
		, length: 8 // The length of each line
		, width: 2 // The line thickness
		, radius: 4 // The radius of the inner circle
		, scale: 1 // Scales overall size of the spinner
		, corners: 1 // Corner roundness (0..1)
		, color: '#000' // #rgb or #rrggbb or array of colors
		, opacity: 0.25 // Opacity of the lines
		, rotate: 0 // The rotation offset
		, direction: 1 // 1: clockwise, -1: counterclockwise
		, speed: 1 // Rounds per second
		, trail: 60 // Afterglow percentage
		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		, className: 'spinner' // The CSS class to assign to the spinner
		, top: '1.25em' // Top position relative to parent
		, left: '50%' // Left position relative to parent
		, shadow: false // Whether to render a shadow
		, hwaccel: false // Whether to use hardware acceleration
		, position: 'relative' // Element positioning
	}

	/**
	 * Digest and display JSON list of states
	 */
	wsData.populateStates = function (){


			jQuery.ajax({
				url: wsData.mdrapi_base_url + 'allStates/',
				type: 'GET',
				dataType: 'jsonp',
				jsonp:'callback',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Status: ' + textStatus); alert('Error: ' + errorThrown);
				},
				success:function(data){
					var output = jQuery.parseJSON(data);
					var numstates = output.length;
					var statefield = jQuery('#get-info-state');
					for(var i=0; i<numstates; i++){
						statefield.append('<option value="'+output[i][1]+'">'+output[i][0]+'</option>');
					}



				}
			});

	};

	function universalLead() {
		/**
		 * Wire the Role (Title), wsProduct fields together
		 * toggle wsProduct based on Role: stu (student) par (parent) ...
		 * Hide most of the form if it's a student
		 */
		(function(roleSelect){
			wsData.toggleViewForStudent(this);
			roleSelect.on('change',function(){
				wsData.toggleViewForStudent(this);
			});
		})(jQuery('select#get-info-Title'));

		wsData.toggleViewForStudent = function(titleEl) {
			var role =  jQuery(titleEl).children('option:selected').attr('data-value');
			jQuery('#get-info-Product option').filter('.'+role).show();
			jQuery('#get-info-Product option').not('.'+role).hide();

			if('stu' === role ) {
				jQuery('.hide-if-student').addClass('hidden').addClass('hidden-for-student');
				jQuery('.show-if-student').removeClass('hidden');
			} else {
				jQuery('.hidden-for-student').removeClass('hidden').removeClass( 'hidden-for-student' );
				jQuery('.show-if-student').addClass('hidden');					
			}
		}

		jQuery('#current-context-name').on('click',function(){
			jQuery('.hide-if-context').removeClass('hidden');
			jQuery(this).hide();
		});

		/**
		 * Toggle the visibility of the wsProductDetail dropdowns
		 */
		(function(productSelect){
			productSelect.on('change', function(){
				var interestID = parseFloat(jQuery(this).children('option:selected').attr('data-interest-id'));
				jQuery('li[id^="get-info-wsProductDetail"]')
					.addClass('hidden')
					.filter(function(){
						return parseFloat(jQuery(this).attr('data-interest-parent-id'))===interestID;
					})
					.removeClass('hidden'); 
			});
		})(jQuery('select#get-info-wsProduct'));


		/**
		 * Make the submit button unclickable after first click
		 */
		jQuery(document).ready(function() {
				jQuery('#get-info-submit').lockSubmit().on('click',function(){
					// TODO: react to click
				});
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

			// var citySpinner = new Spinner(wsData.spinnerParams).spin(jQuery('#citySpinnerSpan')[0]);
			var citySpinner = new Spinner(wsData.spinnerParams);
			jQuery('#citySpinnerSpan').after(citySpinner.spin().el);

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
				url: wsData.mdrapi_base_url + 'cityList/' + state.val() + "'",
				type: 'GET',
				dataType: 'jsonp',
				jsonp:'callback',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Status: ' + textStatus); alert('Error: ' + errorThrown);
				},
				success:function(data){
					var output = jQuery.parseJSON(data);
					city.find('option').remove().end();
					wsData.mdrApiCities = output;
					jQuery.each(output, function(i, item){
						city.append('<option value="' + item.school_city + '">' + item.school_city + '</option>');
					});
					wsData.setCityAutoComplete();
					city.val('').removeAttr('readonly'); // make city editable
				}
			}).always(function(){
				citySpinner.stop();
			});
		};
		jQuery(document).ready(function() {
			// wsData.getCityList(); // Don't call on document ready -- too much data!
		});


		/**
		 * Set autocomplete for city input
		 */
		wsData.setCityAutoComplete = function (){

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
						// TODO: (MAYBE) IE FALLBACK: ws_showHiddenFields();
						// city.val("");  <- DELETE ME?
						console.log('OTHER selected - disabling autocomplte on City.');

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
						// city.val("");
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

			var schoolSpinner = new Spinner(wsData.spinnerParams);
			jQuery('#schoolSpinnerSpan').after(schoolSpinner.spin().el);

			jQuery.ajax({
				url: wsData.mdrapi_base_url + 'city/'+ city.val() + '/state/' + state.val() + "'",
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
			}).always(function(){
				schoolSpinner.stop();
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
						// school.val(""); <- DELETE ME?
						console.log('OTHER selected - disabling autocomplte on School.');

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
						// school.val("");
						jQuery("#schoolError").show();

					}}
			});//end autocomplete})

		}

		/**
		 * Take input from findSchool, fill out hidden fields with information about that school
		 */
		wsData.fillOutForm = function(school_name, school_pid, school_Phone, school_Address, school_City, school_State, school_Zip) {
			jQuery("#get-info-companyMDRPID").val(school_pid);
			jQuery('#get-info-companyPhone').val(school_Phone);
			jQuery('#get-info-companyAddress').val(school_Address);
			jQuery('#get-info-companyZipcode').val(school_Zip);
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

				wsData.fillOutForm(ws_schoolName, ws_schoolPid, ws_schoolPhone, ws_schoolAddress, ws_schoolCity, ws_schoolState, ws_schoolZip);
				school.attr('name','mkto_Company'); // reset the name for transfer to Marketo
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

	}

	wsData.validateAndSubmitForm = function() {
		jQuery('#get-info-form').validate({
			submitHandler: function(form) {
				wsData.ajaxFormSubmit(jQuery(form));
				if(event.preventDefault) { event.preventDefault(); }
				event.returnValue = false; // IE9
				return false;
			},
			rules: {
				mkto_Title: "required",
				mkto_leadFormProduct: "required",
				mkto_FirstName: "required",
				mkto_USorAbroadDestination: "required",
				mkto_LastName: "required",
				mkto_Email: "required",
				mkto_Phone: "required",
				mkto_companyState: "required",
				mkto_companyCity: "required",
				mkto_Company: "required",
			},
			messages: {
				mkto_Title: "&nbsp; (important!)",
				mkto_leadFormProduct: "&nbsp; Please tell us what kind of travel interests you.",
				mkto_USorAbroadDestination: "&nbsp; Please tell us: U.S. or outside the U.S.?",
				mkto_FirstName: "Please provide your First Name.",
				mkto_LastName: "Please provide your Last Name.",
				mkto_Email: { 
					required: "Please provide your Email Address.",
					email: "Please give a valid Email Address."
				},
				mkto_Phone: "Please provide a Number where we can reach you.",
				mkto_companyState: "What state is your school in?",
				mkto_companyCity: "What city is your school in?",
				mkto_Company: "What is the name of your school?",
			},
			invalidHandler: function(event, validator) {
				jQuery('#invalid-message').show();
				jQuery('#get-info-submit').lockSubmitReset();
			}
		});
	}

	wsData.ajaxFormSubmit = function(form) {
		 // setup AJAX options
		 var formData = {};
		 var elements = form.find('[id^="get-info-"]');
		 var numEls = elements.length;
		 var varVal = {};
		 for(var i=0; i<numEls; i++){
		 	var el = elements.eq(i);
		 	if(!el.attr('name') || el.attr('name').slice(0,5) !== 'mkto_') { 
		 		continue; // skip if it's not labeled as mkto_
		 	}
		 	var varName = el.attr('name').slice(5); // name is now Marketo-friendly name, after 'mkto_', (FWIW, title is web-accessible title)
		 	if(el.prop('tagName').toUpperCase() === "LI") { // radio button groups in "LI"
		 		var inputs = el.children().filter('input'); // Usually, Yes or No - maybe others
		 		varVal = {};
		 		for(var j=0; j<inputs.length; j++){
			 		if(inputs.eq(j).is(':checked')) {
			 			varVal = inputs.eq(j).val();
			 		}
			 	}
		 	} else {
		 		varVal = el.val();
		 	}
		 	formData[varName]=varVal;
		 	console.log(varName+' => '+varVal);
		 }
		 var options = {
			 url: worldstrides_ajax.ajaxUrl,  // this is part of the JS object you pass in from wp_localize_scripts.
			 type: 'post',        // 'get' or 'post', override for form's 'method' attribute
			 data: formData, 
			 success : function( responseText ) {
				 form.html('Your request has been submitted successfully - ' + responseText );
			 }
		 };

		 jQuery.ajax(options);
	 }
 } )( jQuery );