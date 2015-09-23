<?php

 /**
  * Borrows code from explore-filters.php
  */

 $interestsArgs = array( 
	'parent' => 11, // Interest
	'orderby' => 'term_order', 
	'hide_empty' => false,
	'exclude' => 384 // Faith Based & Service
	);

 $interests  = get_terms( 'filter', $interestsArgs ); 
/*OUT OF PHP*/?>


<li class="field">
	<label for="get-info-wsProduct">I am interested in</label>
	<select id="get-info-wsProduct" name="mkto_wsProduct" title="General Interest">
		<option value="">Select...</option>


<?php /*BACK IN*/
	foreach ( $interests as $interest ) :
/*OUT OF PHP*/?>
		<option value="<?php echo $interest->slug; ?>"
				data-interest-id="<?php echo $interest->term_id; ?>">
			<?php echo $interest->name; ?>
		</option>



<?php endforeach; /*END LOOP FOR MAIN SELECT LIST*/ ?>

		<option value="faith-and-service"
				data-interest-id="384">
			Faith-based
		</option>

		<option value="faith-and-service"
				data-interest-id="384">
			Service
		</option>

	</select>
</li>

<?php foreach ( $interests as $interest ) : /*START LOOP FOR SUB-SELECT LISTS*/?>

<li id="get-info-wsProductDetail-<?php echo $interest->slug; ?>" data-interest-parent-id="<?php echo $interest->term_id; ?>" class="field" class="invisible">
	<label for="get-info-moredetail-<?php echo $interest->slug; ?>">I want to learn more about</label>
	<select id="get-info-moredetail-<?php echo $interest->slug; ?>" name="mkto_wsProductDetail" title="-<?php echo 'Specific Interest within ' . $interest->name; ?>">
		<option value="">Select...</option>


		<?php 
		$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id ) ); 
		foreach ( $child_interests as $child_interest ) : ?>

		<option value="#<?php echo $child_interest->slug; ?>" 
				data-filter-list=".interests-filters">
			<?php echo $child_interest->name; ?>
		</option>
		
		<?php endforeach; ?>

		<?php /*
		<option value="Music Festivals">Music Festivals </option>
		<option value="International Concert Tours">International Concert Tours</option>
		<option value="American Performing Tours">American Performing Tours</option>
		<option value="Marching Band Opportunities">Marching Band Opportunities</option>
		<option value="Dance &amp; Cheer Opportunities">Dance &amp; Cheer Opportunities</option>
		<option value="Domestic Theatre Opportunities">Domestic Theatre Opportunities</option>
		<option value="International Theatre Opportunities">International Theatre Opportunities</option>
		*/ ?>

		<option value="Im not sure yet">I'm not sure yet</option>
	</select>
</li>

<?php endforeach; /*END LOOP FOR SUB-SELECT LISTS*/?>















<?php

/*
<option value='Middle School - History' class='stu par ele mse hse'>U.S. History Themed Tours</option>
<option value='Middle School - Science' class='stu par ele mse hse'>Science Themed Tours</option>
<option value='High School - International' class='stu par mse hse'>Tours to International Destinations</option>
<option value='Performing' class='stu par ele mse hse une'>Performing Arts Travel</option>
<option value='Undergraduate' class='stu par une'>Undergraduate Tours</option>
<option value='Graduate' class='stu par une'>Graduate-Level Tours</option>
<option value="Unknown" class='stu par ele mse hse une'>I'm not sure</option>
*/

?>