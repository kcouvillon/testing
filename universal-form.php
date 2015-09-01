<form action="http://wsbeta.co/#" class="ws-form">
	<div class="left">
		<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
		<ul class="form-fields list-unstyled">
			<li class="field">
				My role is
				<select id="role" name="role">
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
				<select id="interestedin" name="interestedin">
					<option value="">Select...</option>
					<option value='History Themed Programs' class='par ele mse hse'>History Themed
						Programs</option>
					<option value='Science Themed Programs' class='par ele mse hse'>Science Themed
						Programs</option>
					<option value='Tours to International Destinations' class='par mse hse'>Tours to
						International Destinations</option>
					<option value='Performing Arts Travel' class='par ele mse hse une'>Performing Arts Travel</option>
					<option value='Undergraduate Tours' class='par une'>Undergraduate Tours</option>
					<option value='Graduate-Level Tours' class='par une'>Graduate-Level Tours</option>
					<option value="I'm not sure" class="par ele mse hse une">I'm not sure</option>
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
				(function(roleSelect,interestSelect){
					roleSelect.on('change',function(){
						console.log(jQuery(this).val());
						role =  jQuery(this).val();
						jQuery('#interestedin option').filter('.'+role).show();
						jQuery('#interestedin option').not('.'+role).hide();
					});
					interestSelect.on('change',function(){
						console.log(jQuery(this).val());
						if('Performing Arts Travel' === (jQuery(this)).val()) {
							jQuery('li#moremusicfield').css('display','list-item');
						} else {
							jQuery('li#moremusicfield').css('display','none');
						}
					});
				})(jQuery('select#role'),jQuery('select#interestedin'));
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
					<input type="text" name="first_name" value="" placeholder="First Name">
				</div>
				<div class="field-right">
					<input type="text" name="last_name" value="" placeholder="Last Name">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<input type="email" name="email" value="" placeholder="Email Address">
				</div>
				<div class="field-right">
					<input type="tel" name="phone" value="" placeholder="Phone Number">
				</div>
			</li>
			<li class="field field-complex">
				<div class="field-left">
					<select name="state">
						<option value="">State</option>
					</select>
				</div>
				<div class="field-right">
					<input type="text" name="city" value="City" placeholder="City">
				</div>
			</li>
			<li class="field">
				<input type="text" name="group_name" value="" placeholder="School Name">
			</li>
			<li class="field">
				<textarea name="message" rows="3" cols="30" style="max-height: none;">
					Comments or Questions?
				</textarea>
			</li>
		</ul>
		<input type="submit" name="" value="Get Info" class="btn btn-primary">
	</div>
</form>
