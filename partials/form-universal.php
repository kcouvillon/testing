<form id="get-info-form" method="post" action="<?php echo site_url() . '/wp-admin/admin-post.php?'; ?>" class="ws-form">
	<input type="hidden" name="action" value="data_to_marketo">
	<div class="left">
		<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
		<ul class="form-fields list-unstyled">
			<li class="field">
				My role is
				<select id="get-info-role" name="Title">
					<option value="">Select...</option>
					<option value="stu">Student</option>
					<option value="par">Parent</option>
					<option value="ele">Elementary School Educator</option>
					<option value="mse">Middle School Educator</option>
					<option value="hse">High School Educator</option>
					<option value="une">College / University Educator</option>
				</select>
			</li>
			<li class="field">
				I am interested in
				<select id="get-info-wsProduct" name="wsProduct">
					<option value="Unknown">Select...</option>
					<option value='Middle School - History' class='par ele mse hse'>U.S. History Themed Tours</option>
					<option value='Middle School - Science' class='par ele mse hse'>Science Themed Tours</option>
					<option value='High School - International' class='par mse hse'>Tours to International Destinations</option>
					<option value='Performing' class='par ele mse hse une'>Performing Arts Travel</option>
					<option value='Undergraduate' class='par une'>Undergraduate Tours</option>
					<option value='Graduate' class='par une'>Graduate-Level Tours</option>
					<option value="Unknown" class="par ele mse hse une">I'm not sure</option>
				</select>
			</li>
			<li id="moremusicfield" class="field" style="display:none;">
				I want to learn more about
				<select id="moremusic" name="moremusic">
					<option value="">Select...</option>
					<option value="Music Festivals">Music Festivals </option>
					<option value="International Concert Tours">International Concert Tours</option>
					<option value="American Performing Tours">American Performing Tours</option>
					<option value="Marching Band Opportunities">Marching Band Opportunities</option>
					<option value="Dance & Cheer Opportunities">Dance & Cheer Opportunities</option>
					<option value="Domestic Theatre Opportunities">Domestic Theatre Opportunities</option>
					<option value="International Theatre Opportunities">International Theatre Opportunities</option>
					<option value="Im not sure yet">I'm not sure yet</option>
				</select>
			</li>
			<script type="text/javascript">
				
			
				/**
				 * Wire the Role, wsProduct and MoreMusic fields together
				 * - restrict wsProduct based on Role
				 * - show MoreMusic where wsProduct === 'Performing'
				 * 
				 */
				(function(roleSelect,interestSelect){
					roleSelect.on('change',function(){
						console.log(jQuery(this).val());
						role =  jQuery(this).val();
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
				 * Async call to the MDR API to get the State list
				 */
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
						url: wsData.api_base_url + 'cityList/' + jQuery('#companyState').val() + "'",
						type: 'GET',
						dataType: 'jsonp',
						jsonp:'callback',
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							alert('Status: ' + textStatus); alert('Error: ' + errorThrown);
						},
						success:function(data){
							var output = jQuery.parseJSON(data);
							city.find('option').remove().end();
							wsMdrApiCities = output;
							jQuery.each(output, function(i, item){
								city.append('<option value="' + item.school_city + '">' + item.school_city + '</option>');
							});
							//TODO: UNCOMMENT THIS: ws_mdrapiSetCityAutoComplete();
							city.val('').removeAttr('readonly'); // make city editable
						}
					});					
				};
				wsData.getCityList();
				
				
				/**
				 * Chain off to the Marketo Munchkin API function 'associateLead' to submit user data
				 */
				
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
						form.submit();
					});
					
				});
				
				
				
			</script>
			<li class="field">
				I have a tour scheduled:
				&nbsp;&nbsp;
				<input type="radio" name="tour" id="tour-yes" value="yes">
				<label for="tour-yes">Yes</label>
				&nbsp;
				<input type="radio" name="tour" id="tour-no" value="no">
				<label for="tour-no">No</label>
			</li>
		</ul>
	</div>
	<div class="right">
		<ul class="form-fields list-unstyled">
			<li class="field field-complex">
				<div class="field-left">
					<input id="get-info-first-name" type="text" name="first_name" value="" placeholder="First Name">
				</div>
				<div class="field-right">
					<input id="get-info-last-name" type="text" name="last_name" value="" placeholder="Last Name">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<input id="get-info-email" type="email" name="email" value="" placeholder="Email Address">
				</div>
				<div class="field-right">
					<input id="get-info-phone" type="tel" name="phone" value="" placeholder="Phone Number">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<select id="get-info-state" name="get-info-state">
						<option value="">Select State...</option>
					</select>
				</div>
				<div class="field-right">
					<input id="get-info-city" type="text" name="get-info-city" value="" placeholder="City">
				</div>
			</li>
			<li class="field">
				<input id="get-info-school" type="text" name="get-info-school" value="" placeholder="School Name">
			</li>
			<li class="field">
				<textarea id="get-info-comment" name="get-info-comment" rows="3" cols="30" style="max-height: none;" placeholder="Comments or Questions?" ></textarea>
			</li>
		</ul>
		<input id="get-info-submit" type="submit" name="" value="Get Info" class="btn btn-primary">
	</div>
</form>

<script type="text/javascript">
// TODO: Move this to js/
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
</script>