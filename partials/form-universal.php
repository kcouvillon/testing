 <?php
 $post_id = get_the_ID();
 $title = get_the_title( $post_id );

 if(false === get_the_terms( $post_id, 'product-line' )) { // different greeting based on context
 	$title = __("Ready to Learn More About Traveling with WorldStrides?", "worldstrides");
 } else {
 	$title = sprintf(__("Thank you for your interest in our WorldStrides %s Tour! Please tell us a little more about yourself so we can get you sent to the right place."),$title);
 }


  /**
  * The Interests will just be hidden fields
  */
 $hide_if_context_classes ='hidden hide-if-context';
 if(false===get_the_terms( $post_id, 'filter' )) {
  	$hide_if_context_classes = 'hide-if-context'; // show these elements if there's no context
 } 

?>

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
				<select id="get-info-Title" name="mkto_Title" title="Role">
					<option data-value="non" value="">Select...</option>
					<option data-value="stu" value="Student">Student</option>
					<option data-value="par" value="Parent">Parent</option>
					<option data-value="ele" value="Teacher">Elementary School Educator</option>
					<option data-value="mse" value="Teacher">Middle School Educator</option>
					<option data-value="hse" value="Teacher">High School Educator</option>
					<option data-value="une" value="Teacher">College / University Educator</option>
				</select>
			</li>

			<li id="student-thanks" name="student-thanks" class="show-if-student hidden" title="Students, thanks for your interest.">
				<p id="student-thanks-p1"> 
					<?php _e("Thanks for visiting!  Please let us know how we can help you.  ", 'worldstrides'); ?>
					<?php _e("You can get the answers to most questions by accessing our <a href=\"/resource-center/\">Resource Center</a>.  ", 'worldstrides'); ?>
				</p>
				<p id="student-thanks-p2"> <?php _e("You can also visit all our social media sites and see what the excitement is all about.", 'worldstrides'); ?>
					<?php _e(" Tell your friends about all these amazing places to visit!", 'worldstrides'); ?>
				</p>
				<?php get_template_part('partials/sociallinks'); ?>

			</li>

			<li id="get-info-tour-scheduled" name="mkto_areyouCurrentlyScheduledforaWorldStridestrip" 
											 class="field hide-if-student" 
											 title="I have a Tour Scheduled">
				<label>I have a tour scheduled:</label>
				 &nbsp;<wbr>
				<input type="radio" name="mkto_TourScheduled" id="tour-yes" value="yes" title="Yes">
				<label for="tour-yes">Yes</label>
				&nbsp;
				<input type="radio" name="mkto_TourScheduled" id="tour-no" value="no" title="No">
				<label for="tour-no">No</label>
			</li>

			<?php get_template_part('partials/form','filters'); ?>


			<li id="product" class="field hide-if-student <?php echo $hide_if_context_classes; ?>">
				<label for="get-info-Product">I want to learn more about</label>
				<select id="get-info-Product" name="mkto_leadFormProduct">
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
					<option value="Im not sure yet" class='non stu par ele mse hse une'>I'm not sure yet</option>
				</select>
			</li>


			<li id="get-info-domestic-or-international" name="mkto_domesticOrInternational" class="field hide-if-student <?php echo $hide_if_context_classes; ?>" title="Destination U.S. or Elsewhere?">
				<label>I would travel:</label>
				&nbsp;<wbr>
				<input type="radio" name="mkto_USorAbroadDestination" id="destination-us" value="us" title="Within the U.S.">
				<label for="destination-us">within the U.S.</label>
				<br class="visible-xs">
				<input type="radio" name="mkto_USorAbroadDestination" id="destination-abroad" value="abroad" title="Outside of the U.S." style="white-space: nowrap;">
				<label for="destination-abroad">outside of the U.S.</label>
				<label for="mkto_USorAbroadDestination" class="error" style="display:none;"></label>
			</li>			

			<li class="field field-complex hide-if-student">
				<div class="field-left">
					<label for="get-info-first-name" class="block no-placeholder">First Name</label>
					<input id="get-info-first-name" type="text" name="mkto_FirstName" value="" placeholder="First Name" title="First Name">
				</div>
				<div class="field-right">
					<label for="get-info-last-name" class="block no-placeholder">Last Name</label>
					<input id="get-info-last-name" type="text" name="mkto_LastName" value="" placeholder="Last Name" title="Last Name">
				</div>
			</li>
		</ul>
	</div>
	<div class="right">
		<ul class="form-fields list-unstyled">
			<li class="field field-complex">
				<div class="field-left">
					<label for="get-info-email" class="block no-placeholder">Email Address</label>	
					<input id="get-info-email" type="email" name="mkto_Email" value="" placeholder="Email Address" title="Email Address">
				</div>
				<div class="field-right hide-if-student">
					<label for="get-info-phone" class="block no-placeholder">Phone Number</label>
					<input id="get-info-phone" type="tel" name="mkto_Phone" value="" placeholder="Phone Number" title="Preferred Phone Number">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left hide-if-student">
					<label for="get-info-state" class="block no-placeholder">Select State...</label>
					<select id="get-info-state" name="mkto_companyState" title="School State">
						<option value="">Select State...</option>
					</select>
				</div>

				<div class="field-left show-if-student show-if-parent">
					<label for="get-info-question" class="block no-placeholder">Question for WorldStrides...?</label>
					<select id="get-info-question" name="mkto_iwanttoMarketingActivity" title="Question for WorldStrides...?">
						<option value="">Question for WorldStrides...?</option>
						<option value="I have a question about an upcoming trip.">I have a question about an upcoming trip.</option>
						<option value="I have questions about how your trips work.">I have questions about how your trips work.</option>
						<option value="I need to register for a trip.">I need to register for a trip.</option>
						<option value="I need to make a payment.">I need to make a payment.</option>
						<option value="I want to refer a teacher to lead a trip.">I want to refer a teacher to lead a trip.</option>
						<option value="I am interested in leading a trip.">I am interested in leading a trip.</option>
					</select>
				</div>

				<div class="field-right hide-if-student">
					<span id="citySpinnerSpan">   </span>
					<label for="get-info-city" class="block no-placeholder">School City</label>
					<input id="get-info-city" type="text" name="mkto_companyCity" value="" placeholder="School City" title="School City">
				</div>
			</li>
			<li class="field hide-if-student">
				<span id="schoolSpinnerSpan">   </span>
				<label for="get-info-school" class="block no-placeholder">School Name</label>
				<input id="get-info-school" type="text" name="mkto_Company" value="" placeholder="School Name" title="School Name">
			</li>
			<li class="field hide-if-student">
				<label for="get-info-comment" class="block no-placeholder">Comments or Questions?</label>
				<textarea id="get-info-comment" name="mkto_formcomments" rows="3" cols="30" style="max-height: none;" placeholder="Comments or Questions?" title="Comments or Questions"></textarea>
			</li>
		</ul>

		<input id="get-info-companyMDRPID" type="hidden" name="mkto_companyMDRPID" value="" >
		<input id="get-info-companyPhone" type="hidden" name="mkto_companyPhone" value="" >
 		<input id="get-info-companyAddress" type="hidden" name="mkto_companyAddress" value="" >
		<input id="get-info-companyZipcode" type="hidden" name="mkto_companyZipcode" value="" >
		<input id="get-info-wsurl" type="hidden" name="mkto_wsurl" value="<?php echo WS_Form::current_page_url(); ?>" >

		<input id="get-info-submit" type="submit" name="ButtonAction" value="I&apos;m Done" class="btn btn-primary" title="Get Information"> <div id="invalid-message" style="display:none;">Please correct the errors in this form</div>
	</div>
</form>