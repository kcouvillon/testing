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