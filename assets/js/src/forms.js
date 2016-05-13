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
			wsData.populateLandingPageAPIValues( [ 'wsmedium', 'wsdesc' ] );
			universalLead();
			wsData.validateAndSubmitForm();
		}

		// LISTENER FOR COMMENT PRE-FILL
		jQuery('a[id^="comment-btn-"]').click( function() {
			jQuery('#get-info-comment').val(jQuery(this).attr('data-form-comment'));
		});

	});

	jQuery(document).ready(function() {
		//Assign cookie value client side to hidden field in form
		jQuery('#get-info-wsfirst').val(Cookies.get('ws_first_url'));
	});

	 //Browser Detection for IE blur
	 //Got from: http://stackoverflow.com/questions/2400935/browser-detection-in-javascript
	 navigator.Browser = (function(){
		 var ua= navigator.userAgent, tem,
				 M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
		 if(/trident/i.test(M[1])){
			 tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
			 return 'IE '+(tem[1] || '');
		 }
		 if(M[1]=== 'Chrome'){
			 tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
			 if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
		 }
		 M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
		 if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
		 return M.join(' ');
	 })();

	/**
	 * Base URL for API calls
	 */
	wsData.mdrapi_base_url = "https://apis.worldstrides.com/mdrapi/v1/";

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
	wsData.populateStates = function (event){
		jQuery.ajax({
			url: wsData.mdrapi_base_url + 'allStates/',
			type: 'GET',
			dataType: 'jsonp',
			jsonp:'callback',
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log('Status: ' + textStatus); 
				console.log('Error: ' + errorThrown);
			},
			success:function(data){
				var output = jQuery.parseJSON(data);
				var numstates = output.length;
				var statefield = jQuery('#get-info-state');
				//var statefield = jQuery('[name=mkto_companyState]');
				for(var i=0; i<numstates; i++){
					statefield.append('<option value="'+output[i][1]+'">'+output[i][0]+'</option>');
				}
			}
		});
	};

	/**
	 * Populate WorldStrides Landing Page API values:
	 * https://worldstridesdev.org/blog/worldstrides-landing-page-referral-api/
	 */
	wsData.populateLandingPageAPIValues = function ( queryparams ) {
		var qkey, qregx, qregxx, qval;
		for (var i = queryparams.length - 1; i >= 0; i--) {
			qval = '';
			qkey = queryparams[i];
			qregx = new RegExp( '\\??&?\\??' + qkey + '=' + '([A-Za-z0-9_]+)', 'i' );
			qregxx = qregx.exec( location.href );
			if( null !== qregxx && qregxx[1] ) {
				qval = qregxx[1];
				console.log( 'Looking for parameter: ' + qkey + '. Found: ' + qval );
				// populate the corresponding hidden input:
				jQuery('#get-info-' + qkey).val(qval);
			}
		};
	}

	function universalLead() {
		/**
		 * Wire the Role (Title), wsProduct fields together
		 * toggle wsProduct based on Role: stu (student) par (parent) ...
		 * Hide most of the form if it's a student
		 * Also toggle the visibility of .show-if-parent fields
		 */
		wsData.toggleViewForRole = function(selector) {
			var role =  jQuery('select#get-info-Title').children('option:selected').attr('data-value');
			var getInfoChildren = jQuery(selector);
			getInfoChildren.filter('.'+role).show().removeClass('hidden');
			getInfoChildren.not('.'+role).hide();
		}

		wsData.toggleFieldViewForRole = function() {
			wsData.toggleViewForRole('form#get-info-form [id^="get-info-"]'); // Selector for form fields that start #get-info
		}

		wsData.toggleProductViewForRole = function() {
			wsData.toggleViewForRole('select#get-info-Product option');  // Selector for the Product (I want to learn..,) dropdown
		}

		wsData.toggleQuestionViewForRole = function() {
			wsData.toggleViewForRole('select#get-info-question option');  // Selector for the Question (for students, parents)
		}

		wsData.populateHiddenGradeLevelField = function() {
			var role =  jQuery('select#get-info-Title').children('option:selected').attr('data-value');
			if( 'non'=== role || 'stu' === role || 'par' === role ) {
				jQuery('#get-info-gradeLevel').val( 'NA' ); // Parents, Students, Unselected, no grade
				return;
			} else {
				var chosenlevel = jQuery('select#get-info-Title').children('option:selected').text();
				var firstspace = chosenlevel.indexOf(' ');
				if( -1 !== firstspace ) {
					chosenlevel = chosenlevel.slice( 0, firstspace );
				}
				jQuery('#get-info-gradeLevel').val( chosenlevel );
			}

		}

		wsData.toggleAll = function() {
			wsData.toggleFieldViewForRole(); 
			wsData.toggleProductViewForRole();
			wsData.toggleQuestionViewForRole();
			wsData.populateHiddenGradeLevelField();			
		}

		wsData.toggleFieldViewForRole();
		jQuery('select#get-info-Title').on( 'change', wsData.toggleAll );

		/**
		 * Preload the role based on a post variable, if available
		 */
		if( undefined !== wsData.passedInRole && 'undefined' !== wsData.passedInRole ){
			if( jQuery('select#get-info-Title option:contains("' + wsData.passedInRole + '")').length > 0 ){
				console.log('DEBBUGGING: wsData.passedInRole = ' + wsData.passedInRole);
				wsData.passedInRole = wsData.passedInRole.replace(/\s/g,'&nbsp;');
				jQuery('select#get-info-Title option').filter(function () { return jQuery(this).html().indexOf(wsData.passedInRole) !== -1; }).prop('selected',true)
				wsData.toggleAll();
			}
		}

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

			school.val('School (Please choose your City first.)').attr('readonly','readonly');
			city.val('City (Choose State first.)').attr('readonly','readonly');
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
		wsData.getCityList = function (event){
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
					console.log('Status: ' + textStatus); 
					console.log('Error: ' + errorThrown);
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
		wsData.getSchoolsFromCity = function(event){
			// find and alias members:
			var school = jQuery('#get-info-school');
			var city = jQuery('#get-info-city');
			var state = jQuery('#get-info-state');

			var schoolSpinner = new Spinner(wsData.spinnerParams);
			jQuery('#schoolSpinnerSpan').after(schoolSpinner.spin().el);

			jQuery.ajax({
				url: wsData.mdrapi_base_url + 'city/'+ city.val() + '/state/' + state.val() + "'",
				cache: false,
				type: 'GET',
				dataType: 'jsonp',
				jsonp:'callback',
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Status: ' + textStatus); 
					console.log('Error: ' + errorThrown);
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
			}) //end autocomplete})
			.blur(function() {
				//If IE return
				if (navigator.Browser.indexOf('IE') > -1) {
					return;
				}
				else {
					if (wsData.completingSchoolInfo && wsData.completingSchoolInfo === 'now') {
						return;
					}
					wsData.completingSchoolInfo = 'now';
					if (jQuery('#get-info-school').val() != '') {
						jQuery('.ui-menu-item').filter(':contains("' + jQuery('#get-info-school').val() + '")').trigger('click');
					}
					jQuery('#get-info-comment').focus();
					wsData.completingSchoolInfo = 'done';
				}
			});
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

	wsData.validateAndSubmitForm = function(event) {
		jQuery('#get-info-form').validate({
			submitHandler: function(form,event) {
				wsData.formSpinner = new Spinner(wsData.spinnerParams);
				wsData.formSpinner.opts.lines = 30;
				wsData.formSpinner.opts.radius = 150;
				wsData.formSpinner.opts.length = 60;
				wsData.formSpinner.opts.width = 10;
				wsData.formSpinner.opts.top = '14em';
				jQuery('#getinfoform-spinner-span').after(wsData.formSpinner.spin().el);
				jQuery('#invalid-message').hide();
				wsData.ajaxFormSubmit(jQuery(form));
				if(event.preventDefault) { event.preventDefault(); }
				event.returnValue = false; // IE9
				return false;
			},
			rules: {
				mkto_Title: "required",
				mkto_leadFormProduct: "required",
				mkto_TourScheduled: "required",
				mkto_FirstName: "required",
				mkto_USorAbroadDestination: "required",
				mkto_LastName: "required",
				mkto_Email: "required",
				mkto_Phone: "required",
				mkto_companyState: "required",
				mkto_companyCity: "required",
				mkto_Company: "required",
				mkto_iwanttoMarketingActivity: "required"
			},
			messages: {
				mkto_Title: "&nbsp; (important!)",
				mkto_leadFormProduct: "&nbsp; Please tell us what kind of travel interests you.",
				mkto_TourScheduled: "&nbsp; Please tell us if you are already traveling with WorldStrides.",
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
				mkto_iwanttoMarketingActivity: "Please tell us how we can help you."
			},
			invalidHandler: function(event, validator) {
				jQuery('#invalid-message').show();
				jQuery('#get-info-submit').lockSubmitReset();
			}
		});
	}

	wsData.ajaxFormSubmit = function(form) {
		 // send data to Google Analytics
		 dataLayer.push({'event' : 'formSubmitted', 'formName' : 'main_lead'});
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
				 // form.html('Your request has been submitted successfully - ' + responseText );
				 form.html('<h2>Thanks for your interest in traveling with WorldStrides! One of our representatives will reach out to you very shortly. In the meantime, please feel free to continue <a href="/explore/">exploring</a> all the destinations on our site.</h2>');
				 console.log(responseText);
				 wsData.formSpinner.stop();
				 // wsData.waitLogo.remove();
			 }
		 };

		 jQuery.ajax(options);
	 }

 } )( jQuery );