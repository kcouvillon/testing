 <?php
  /**
   * Core HTML for the Lead Form
   */
 $post_id = get_the_ID();
 $title = get_the_title( $post_id );

   /**
  * The Interests will not render if there is sufficient context
  */
 $tour_context_exists = ( false !== get_the_terms( $post_id, 'product-line' ) && '/blog/' !== $_SERVER["REQUEST_URI"] );


 if( !$tour_context_exists ) { // different greeting based on context
 	$title = __("Please fill out the form below and we will get in touch.", "worldstrides");
 } else {
 	$title = sprintf(__("Thank you for your interest in our WorldStrides %s Tour! Please tell us a little more about yourself so we can get you sent to the right place."),$title);
 }


?>
<div id="getinfoform-logo-div" style="position: absolute; left: 50%;"></div>
<span id="getinfoform-spinner-span"> </span>
<form id="get-info-form" action="" class="ws-form" title="Get More Information About WorldStrides">
	<input id="get-info-action" type="hidden" name="mkto_action" value="data_to_marketo">
	<h2 class="form-title"><?php echo $title; ?></h2>
	<div class="left">
		<?php $phone = get_post_meta( $post->ID, 'itinerary_phone', true ); 
			if (!empty($phone)) : ?>
				<p>Rather call us on the phone? Reach us at: <?php echo $phone; ?></p>
			<?php endif; ?>
		<ul class="form-fields list-unstyled">
			<li class="field">
				<label for="get-info-Title">My role is</label>
				<select id="get-info-Title" name="mkto_Title" title="Role" class="non stu par ele mse hse une">
					<option data-value="non" value="">Select...</option>
					<option data-value="stu" value="Student">Student</option>
					<option data-value="par" value="Parent">Parent</option>
					<option data-value="ele" value="A Teacher">Elementary School Educator</option>
					<option data-value="mse" value="A Teacher">Middle School Educator</option>
					<option data-value="hse" value="A Teacher">High School Educator</option>
					<option data-value="une" value="A Teacher">Undergraduate Educator</option>
					<option data-value="une" value="A Teacher">Graduate Educator</option>
					<option data-value="non" value="A Teacher">Other</option>
				</select>
			</li>

			<li id="get-info-student-thanks-li" name="student-thanks" class="hidden stu" title="Students, thanks for your interest.">
				<p id="student-thanks-p1"> 
					<?php _e("Thanks for visiting!  Please let us know how we can help you.  ", 'worldstrides'); ?>
					<?php _e("You can get the answers to most questions by accessing our <a href=\"/resource-center/\">Resource Center</a>.  ", 'worldstrides'); ?>
				</p>
				<p id="student-thanks-p2"> <?php _e("You can also visit all our social media sites and see what the excitement is all about.", 'worldstrides'); ?>
					<?php _e(" Tell your friends about all these amazing places to visit!", 'worldstrides'); ?>
				</p>
				<?php get_template_part('partials/sociallinks'); ?>
			</li>

			<li id="get-info-parent-hello-li" name="parent-hello" class="hidden par" title="Parents, we are here to help.">
				<p id="parent-hello-p1">
					<?php _e("Questions?  We&apos;re here to help.  Just tell us a little about yourself and what you have questions about ", 'worldstrides'); ?>
					<?php _e("and we&apos;ll be right with you.", 'worldstrides'); ?>
				</p>

				<?php 
				$primary_phone_mssg = '';
				if (!empty($phone)) : 
					$primary_phone_mssg = sprintf(__("%s, or at our main toll-free number: "),$phone);
				endif; ?>

				<p id="parent-hello-p2">
					<?php _e("You can also call us at ", 'worldstrides'); ?>
					<?php echo $primary_phone_mssg; ?>
					<?php _e("1-800-999-7676", 'worldstrides'); ?>
				</p>
			</li>

			<li id="get-info-tour-scheduled" name="mkto_areyouCurrentlyScheduledforaWorldStridestrip" 
											 class="field non stu par ele mse hse une" 
											 title="I have a Tour Scheduled">
				<label>I have a tour scheduled:</label>
				 &nbsp;<wbr>
				<input type="radio" name="mkto_TourScheduled" id="tour-yes" value="true" title="Yes">
				<label for="tour-yes">Yes</label>
				&nbsp;
				<input type="radio" name="mkto_TourScheduled" id="tour-no" value="false" title="No">
				<label for="tour-no">No</label>
				<label for="mkto_TourScheduled" class="error" style="display:none;"></label>
			</li>

			<?php get_template_part('partials/form','filters'); // Add hidden information

			// Render the "I want to learn about" and "domestic/international" questions if there is no context on the page
			if(!$tour_context_exists) : ?>

				<li id="get-info-product-li" class="field non ele mse hse une">
					<label for="get-info-Product">I want to learn more about</label>
					<select id="get-info-Product" name="mkto_leadFormProduct" title="Learn More About" class="non ele mse hse une">
						<option value="" class='non stu par ele mse hse une'>Select...</option>
						<!-- option value='referring a teacher to WorldStrides' class='non stu par ele mse hse'>referring a teacher to WorldStrides</option -->
						<option value='History-Culture Themed Programs (K-12)' class='non stu par ele mse hse'>History &amp; Culture Themed Programs (K-12)</option>
						<option value='Science Themed Programs (K-12)' class='non stu par ele mse hse'>Science Themed Programs (K-12)</option>
						<option value='Sports Tours' class='non stu par ele mse hse une'>Sports Tours</option>
						<option value='Undergraduate Tours' class='non stu par une'>Undergraduate Tours</option>
						<option value='Graduate-Level Tours' class='non stu par une'>Graduate-Level Tours</option>
						<option value="Music Festivals" class='non stu par ele mse hse une'>Music Festivals </option>
						<option value="Concert and Performing Tours" class='non stu par ele mse hse une'>Concert and Performing Tours</option>
						<option value="Marching Band Opportunities" class='non stu par ele mse hse une'>Marching Band Opportunities</option>
						<option value="Dance-Cheer Opportunities" class='non stu par ele mse hse une'>Dance &amp; Cheer Opportunities</option>
						<option value="Theatre Opportunities" class='non stu par ele mse hse une'>Theatre Opportunities</option>
						<option value="Individual Travel Opportunities" class='non stu par ele mse hse une'>Individual Travel Opportunities</option>
						<option value="Im not sure yet" class='non stu par ele mse hse une'>I'm not sure yet</option>
					</select>
				</li>


				<li id="get-info-domestic-or-international" name="mkto_domesticOrInternational" class="field non ele mse hse une" title="Destination U.S. or Elsewhere?">
					<label>I would travel:</label>
					&nbsp;<wbr>
					<input type="radio" name="mkto_USorAbroadDestination" id="destination-us" value="us" title="Within the U.S.">
					<label for="destination-us">within the U.S.</label>
					<br class="visible-xs">
					<input type="radio" name="mkto_USorAbroadDestination" id="destination-abroad" value="abroad" title="Outside of the U.S." style="white-space: nowrap;">
					<label for="destination-abroad">outside of the U.S.</label>
					<label for="mkto_USorAbroadDestination" class="error" style="display:none;"></label>
				</li>	

			<?php endif; ?>		

			<li id="get-info-name-li" class="field field-complex non stu par ele mse hse une">
				<div class="field-left">
					<label for="get-info-first-name" class="block no-placeholder">First Name</label>
					<input id="get-info-first-name" type="text" name="mkto_FirstName" value="" placeholder="First Name" class="non stu par ele mse hse une" title="First Name">
				</div>
				<div class="field-right">
					<label for="get-info-last-name" class="block no-placeholder">Last Name</label>
					<input id="get-info-last-name" type="text" name="mkto_LastName" value="" placeholder="Last Name" class="non stu par ele mse hse une" title="Last Name">
				</div>
			</li>
		</ul>
	</div>
	<div class="right">
		<ul class="form-fields list-unstyled">
			<li class="field">
				<div id="get-info-question-div" class="field-left hidden stu par">
					<label for="get-info-question" class="block no-placeholder">Question for WorldStrides...?</label>
					<select id="get-info-question" name="mkto_iwanttoMarketingActivity" class="stu par" title="Question for WorldStrides...?">
						<option value="" class="stu par">Question for WorldStrides...?</option>
						<option value="I have a question about an upcoming trip." class="stu par">I have a question about an upcoming trip.</option>
						<option value="I am interested in taking a trip with WorldStrides." class="stu par">I am interested in taking a trip with WorldStrides.</option>
						<option value="I need to register for a trip." class="stu par">I need to register for a trip.</option>
						<option value="I need to make a payment." class="stu par">I need to make a payment.</option>
						<!-- option value="I want to refer a teacher to lead a trip." class="stu par">I want to refer a teacher to lead a trip.</option -->
						<!-- option value="I am interested in leading a trip." class="par">I am interested in leading a trip.</option -->
						<option value="I want to raise funds for a trip." class="stu par">I want to raise funds for a trip.</option>
					</select>
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<label for="get-info-email" class="block no-placeholder">Email Address</label>	
					<input id="get-info-email" type="email" name="mkto_Email" value="" placeholder="Email Address" class="non stu par ele mse hse une" title="Email Address">
				</div>
				<div class="field-right hide-if-student">
					<label for="get-info-phone" class="block no-placeholder">Phone Number</label>
					<input id="get-info-phone" type="tel" name="mkto_Phone" value="" placeholder="Phone Number"  class="non par ele mse hse une" title="Preferred Phone Number">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left non par ele mse hse une">
					<label for="get-info-state" class="block no-placeholder">Select State...</label>
					<select id="get-info-state" name="mkto_companyState" class="non stu par ele mse hse une" title="School State">
						<option value="">Select State...</option>
					</select>
				</div>

				<div id="get-info-city-div" class="field-right non stu par ele mse hse une">
					<span id="citySpinnerSpan">   </span>
					<label for="get-info-city" class="block no-placeholder">School City</label>
					<input id="get-info-city" type="text" name="mkto_companyCity" value="" placeholder="School City" class="non stu par ele mse hse une" title="School City">
				</div>
			</li>
			<li id="get-info-school-li" class="field non stu par ele mse hse une">
				<span id="schoolSpinnerSpan">   </span>
				<label for="get-info-school" class="block no-placeholder">School Name</label>
				<input id="get-info-school" type="text" name="mkto_Company" value="" placeholder="School Name" class="non stu par ele mse hse une" title="School Name">
			</li>
			<li id="get-info-comments-li" class="field non stu par ele mse hse une">
				<label for="get-info-comment" class="block no-placeholder">Comments or Questions?</label>
				<textarea id="get-info-comment" name="mkto_formcomments" rows="3" cols="30" style="max-height: none;" placeholder="Comments or Questions?" class="non stu par ele mse hse une" title="Comments or Questions"></textarea>
			</li>
		</ul>

		<input id="get-info-gradeLevel" type="hidden" name="mkto_Grades__c" value="" >

		<input id="get-info-companyMDRPID" type="hidden" name="mkto_companyMDRPID" value="" >
		<input id="get-info-companyPhone" type="hidden" name="mkto_companyPhone" value="" >
 		<input id="get-info-companyAddress" type="hidden" name="mkto_companyAddress" value="" >
		<input id="get-info-companyZipcode" type="hidden" name="mkto_companyZipcode" value="" >

		<input id="get-info-wsmedium" type="hidden" name="mkto_wsmedium" value="<?php // echo WS_Form::presubmit_get_wsparams('wsmedium','WEB'); // servercaching fail ?>" >
		<input id="get-info-wsdesc" type="hidden" name="mkto_wsdesc" value="<?php // echo WS_Form::presubmit_get_wsparams('wsdesc'); // servercaching fail ?>" >

		<?php 
			$current_page_url = WS_Form::current_page_url();
			global $post;
			if( false !== strpos($current_page_url,'request-info') && !empty($_POST["wsurl"]) ) {
				$current_page_url = $_POST["wsurl"] . '#via/request-info/';
			}

			if( false !== strpos($current_page_url,'request-info') && !empty($_POST["role"]) ) {
				$current_post_role = $_POST["role"];
			}
		 ?>
		<script>
		  'use strict';
		  wsData.passedInRole = '<?php echo isset($current_post_role) ? $current_post_role : 'undefined'; ?>';
		</script>
		<input id="get-info-wsurl" type="hidden" name="mkto_wsurl" value="<?php echo $current_page_url; ?>" >

		<input id="get-info-submit" type="submit" name="ButtonAction" value="Send Info" class="btn btn-primary non stu par ele mse hse une" title="Get Information"> <div id="invalid-message" style="display:none;">Please correct the errors in this form</div>
	</div>
</form>