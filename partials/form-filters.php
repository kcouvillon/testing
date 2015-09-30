<?php

 /**
  * Populates hidden multi-select lists for form submission to Marketo.
  * Provides filter information (interests, etc) as extra hidden data.
  * Borrows code from explore-filters.php.
  */

 $post_id = get_the_ID();

 $product_lines = get_the_terms( $post_id, 'product-line' );
 $filters = get_the_terms( $post_id, 'filter' );
 $collections = get_the_terms( $post_id, '_collection' );

 $interestsArgs = array( 
	'parent' => 11, // Interest
	'orderby' => 'term_order', 
	'hide_empty' => false,
	'exclude' => 384 // Faith Based & Service
	);

 $interests  = get_terms( 'filter', $interestsArgs ); 

 /**
  * The Interests will just be hidden fields
  */
 $hide_if_context_classes ='hidden hide-if-context';
 if(false===$filters) {
  	$hide_if_context_classes = 'hide-if-context'; // show these elements if there's no context
 } else {

 }

/*OUT OF PHP - FOLLOWING IS DEBUGGING JS:*/?>

		<script type="text/javascript">
			console.log('Term Data about current post / itinerary: ');
			console.log(<?php echo "'Product Lines: " . json_encode($product_lines) . "'" ?>);
			console.log(<?php echo "'Filters: " . json_encode($filters) . "'" ?>);
			console.log(<?php echo "'Collections: " . json_encode($collections) . "'" ?>);
		</script>

<?php /*BACK IN PHP*/

 /**
  * If there is Product-Line context on this page, it will pass through as hidden
  *
  * ORDER, IN CASE OF TIES: Discoveries > Perspectives > Capstone > OnStage > Excel Sports
  */
$product_line_maximizer = '';


if(false !== $product_lines) :	// IF PRODUCT LINES ARE KNOWN -----------------------------


	// See LEAD ROUTING LOGIC DIAGRAM: http://worldstridesdev.org/blog/lead-routing-logic-for-marketo-to-maximizer/

	foreach ( $product_lines as $division ) {
		if ( 'discoveries' == $division->slug ) {
			$product_line_maximizer = 'Middle School - History'; // default to History
			break;
		} elseif ( 'perspectives' == $division->slug ) {
			$product_line_maximizer = 'High School - International';
			break;
		} elseif ( 'capstone' == $division->slug ) {
			$product_line_maximizer = 'Capstone'; // does not exist in Maximizer yet
			break;
		} elseif ( 'on-stage' == $division->slug ) {
			$product_line_maximizer = 'Performing';
			break;
		} elseif ( 'excel-sports' == $division->slug ) {
			$product_line_maximizer = 'Sports'; // does not exist in Maximizer yet
			break;
		} else {
			$product_line_maximizer = 'Unknown';
		}
	}

	if('Middle School - History' == $product_line_maximizer) {
		foreach ( $collections as $collection) {
			if ( 'science-discoveries' == $collection->slug )
				$product_line_maximizer = 'Middle School - Science'; // Science if it's in that collection
		}
	}

endif;	          // ENDIF PRODUCT LINES ARE KNOWN -----------------------------  ?>

<li class="field hidden">
	<input id="get-info-maxproductline" type="hidden" name="mkto_wsMaxProductLine" title="Product Line" value="<?php echo $product_line_maximizer; ?>">
</li>

<li id="interest" class="field">
	<label class="hidden" for="get-info-interest">I am interested in </label>
	<select type="hidden" id="get-info-interest" class="hidden" name="mkto_wsInterest" title="General Interest">
		<option value="">Select...</option>

<?php foreach ( $interests as $interest ) : /*START LOOP FOR MAIN SELECT LIST*/ ?>

		<option value="<?php echo $interest->slug; ?>"
				class = "stu par ele mse hse une"
				data-interest-id="<?php echo $interest->term_id; ?>">
			<?php echo $interest->name; ?>
		</option>

<?php endforeach; /*END LOOP FOR MAIN SELECT LIST*/ ?>

		<option value="faith-and-service"
				class = "stu par ele mse hse une"
				data-interest-id="384">
			Faith-based
		</option>

		<option value="faith-and-service"
				class = "stu par ele mse hse une"
			Service
		</option>

		<option value="Unknown"
				class = "stu par ele mse hse une">
			I don't know yet
		</option>


	</select>
</li>

<?php foreach ( $interests as $interest ) : /*START LOOP FOR SUB-SELECT LISTS*/ 
	$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id ) ); 
	if(!empty($child_interests)) : ?>

<li id="interest-detail-<?php echo $interest->slug; ?>" data-interest-parent-id="<?php echo $interest->term_id; ?>" class="field hidden">
	<label for="get-info-moredetail-<?php echo $interest->slug; ?>">I want to learn more about</label>
	<select id="get-info-moredetail-<?php echo $interest->slug; ?>" name="mkto_wsInterestDetail" title="-<?php echo 'Specific Interest within ' . $interest->name; ?>">
		<option value="">Select...</option>

		<?php 
		foreach ( $child_interests as $child_interest ) : ?>

		<option value="#<?php echo $child_interest->slug; ?>" 
				data-filter-list=".interests-filters">
			<?php echo $child_interest->name; ?>
		</option>
		
		<?php endforeach; ?>

		<option value="Im not sure yet">I'm not sure yet</option>
	</select>
</li>

<?php endif; ?>
<?php endforeach; /*END LOOP FOR SUB-SELECT LISTS*/?>

<li id="product" class="field <?php echo $hide_if_context_classes; ?>">
	<label for="get-info-Product">I want to learn more about</label>
	<select id="get-info-Product" name="mkto_leadFormProduct">
		<option value="" class='stu par ele mse hse une'>Select...</option>
		<option value='History-Culture Themed Programs (K-12)' class='stu par ele mse hse'>History &amp; Culture Themed Programs (K-12)</option>
		<option value='Science Themed Programs (K-12)' class='stu par ele mse hse'>Science Themed Programs (K-12)</option>
		<option value='Sports Tours' class='stu par ele mse hse une'>Sports Tours</option>
		<option value='Undergraduate Tours' class='stu par une'>Undergraduate Tours</option>
		<option value='Graduate-Level Tours' class='stu par une'>Graduate-Level Tours</option>
		<option value="Music Festivals" class='stu par ele mse hse une'>Music Festivals </option>
		<option value="Concert and Performing Tours" class='stu par ele mse hse une'>Concert and Performing Tours</option>
		<option value="Marching Band Opportunities" class='stu par ele mse hse une'>Marching Band Opportunities</option>
		<option value="Dance-Cheer Opportunities" class='stu par ele mse hse une'>Dance &amp; Cheer Opportunities</option>
		<option value="Theatre Opportunities" class='stu par ele mse hse une'>Theatre Opportunities</option>
		<option value="Im not sure yet" class='stu par ele mse hse une'>I'm not sure yet</option>
	</select>
</li>


<li id="get-info-domestic-or-international" name="mkto_domesticOrInternational" class="field <?php echo $hide_if_context_classes; ?>" title="Destination U.S. or Elsewhere?">
	<label>I would travel:</label>
	&nbsp;<wbr>
	<input type="radio" name="mkto_USorAbroadDestination" id="destination-us" value="us" title="Within the U.S.">
	<label for="destination-us">within the U.S.</label>
	<br class="visible-xs">
	<input type="radio" name="mkto_USorAbroadDestination" id="destination-abroad" value="abroad" title="Outside of the U.S." style="white-space: nowrap;">
	<label for="destination-abroad">outside of the U.S.</label>
	<label for="mkto_USorAbroadDestination" class="error" style="display:none;"></label>
</li>
