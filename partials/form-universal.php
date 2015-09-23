<form id="get-info-form" action="" class="ws-form" title="Get More Information About WorldStrides">
	<input id="get-info-action" type="hidden" name="mkto_action" value="data_to_marketo">
	<div class="left">
		<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
		<ul class="form-fields list-unstyled">
			<li class="field">
				<label for="get-info-Title">My role is</label>
				<select id="get-info-Title" name="mkto_Title" title="Role">
					<option value="">Select...</option>
					<option data-value="stu" value="Student">Student</option>
					<option data-value="par" value="Parent">Parent</option>
					<option data-value="ele" value="Teacher">Elementary School Educator</option>
					<option data-value="mse" value="Teacher">Middle School Educator</option>
					<option data-value="hse" value="Teacher">High School Educator</option>
					<option data-value="une" value="Teacher">College / University Educator</option>
				</select>
			</li>

			<li id="get-info-tour-scheduled" name="mkto_areyouCurrentlyScheduledforaWorldStridestrip" class="field" title="I have a Tour Scheduled">
				<label>I have a tour scheduled:</label>
				&nbsp;<wbr>
				<input type="radio" name="tour" id="tour-yes" value="yes" title="Yes">
				<label for="tour-yes">Yes</label>
				&nbsp;
				<input type="radio" name="tour" id="tour-no" value="no" title="No">
				<label for="tour-no">No</label>
			</li>

			<?php get_template_part('partials/form','filters'); ?>

			<li id="get-info-domestic-or-international" name="mkto_domesticOrInternational" class="field" title="Destination U.S. or Elsewhere?">
				<label>I would travel:</label>
				&nbsp;<wbr>
				<input type="radio" name="destination" id="destination-us" value="us" title="Within the U.S.">
				<label for="destination-us">within the U.S.</label>
				<br class="visible-xs">
				<input type="radio" name="destination" id="destination-abroad" value="abroad" title="Outside of the U.S." style="white-space: nowrap;">
				<label for="destination-abroad">outside of the U.S.</label>
			</li>


		</ul>
	</div>
	<div class="right">
		<ul class="form-fields list-unstyled">
			<li class="field field-complex">
				<div class="field-left">
					<label for="get-info-first-name" class="block no-placeholder">First Name</label>
					<input id="get-info-first-name" type="text" name="mkto_FirstName" value="" placeholder="First Name" title="First Name">
				</div>
				<div class="field-right">
					<label for="get-info-last-name" class="block no-placeholder">Last Name</label>
					<input id="get-info-last-name" type="text" name="mkto_LastName" value="" placeholder="Last Name" title="Last Name">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<label for="get-info-email" class="block no-placeholder">Email Address</label>	
					<input id="get-info-email" type="email" name="mkto_Email" value="" placeholder="Email Address" title="Email Address">
				</div>
				<div class="field-right">
					<label for="get-info-phone" class="block no-placeholder">Phone Number</label>
					<input id="get-info-phone" type="tel" name="mkto_Phone" value="" placeholder="Phone Number" title="Preferred Phone Number">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<label for="get-info-state" class="block no-placeholder">Select State...</label>
					<select id="get-info-state" name="mkto_companyState" title="School State">
						<option value="">Select State...</option>
					</select>
				</div>
				<div class="field-right">
					<label for="get-info-city" class="block no-placeholder">School City</label>
					<input id="get-info-city" type="text" name="mkto_companyCity" value="" placeholder="School City" title="School City">
				</div>
			</li>
			<li class="field">
				<label for="get-info-school" class="block no-placeholder">School Name</label>
				<input id="get-info-school" type="text" name="mkto_Company" value="" placeholder="School Name" title="School Name">
			</li>
			<li class="field">
				<label for="get-info-comment" class="block no-placeholder">Comments or Questions?</label>
				<textarea id="get-info-comment" name="mkto_formcomments" rows="3" cols="30" style="max-height: none;" placeholder="Comments or Questions?" title="Comments or Questions"></textarea>
			</li>
		</ul>

		<input id="get-info-companyMDRPID" type="hidden" name="mkto_companyMDRPID" value="" >
		<input id="get-info-companyPhone" type="hidden" name="mkto_companyPhone" value="" >
 		<input id="get-info-companyAddress" type="hidden" name="mkto_companyAddress" value="" >
		<input id="get-info-companyZipcode" type="hidden" name="mkto_companyZipcode" value="" >

		<input id="get-info-submit" type="submit" name="ButtonAction" value="Get Info" class="btn btn-primary" title="Get Information"> <div id="invalid-message" style="display:none;">Please correct the errors in this form</div>
	</div>
</form>