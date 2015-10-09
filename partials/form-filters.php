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
			$product_line_maximizer = 'University'; // does not exist in Maximizer yet
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
	<input id="get-info-websiteInterestFilters" type="hidden" name="mkto_websiteInterestFilters" value="<?php echo WS_Form::slugs_from_terms($filters); ?>" >
	<input id="get-info-websiteProductLines" type="hidden" name="mkto_websiteProductLines" value="<?php echo WS_Form::slugs_from_terms($product_lines); ?>" >
	<input id="get-info-websiteCollections" type="hidden" name="mkto_websiteCollections" value="<?php echo WS_Form::slugs_from_terms($collections); ?>" >
</li>


<?php 
/* LOOP FOR MAIN INTEREST FILTERS

<li id="interest" class="field">
	<label class="hidden" for="get-info-interest">I am interested in </label>
	<select type="hidden" id="get-info-interest" class="hidden" name="mkto_wsInterest" title="General Interest">
		<option value="">Select...</option>

<?php foreach ( $interests as $interest ) : ?>

		<option value="<?php echo $interest->slug; ?>"
				class = "non stu par ele mse hse une"
				data-interest-id="<?php echo $interest->term_id; ?>">
			<?php echo $interest->name; ?>
		</option>

<?php endforeach; ?>

		<option value="faith-and-service"
				class = "non stu par ele mse hse une"
				data-interest-id="384">
			Faith-based
		</option>

		<option value="faith-and-service"
				class = "non stu par ele mse hse une"
			Service
		</option>

		<option value="Unknown"
				class = "non stu par ele mse hse une">
			I don't know yet
		</option>
	</select>
</li>

*/
/* LOOP FOR SUB-SELECT LISTS

 foreach ( $interests as $interest ) :  
	$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id ) ); 
	if(!empty($child_interests)) :

	<li id="interest-detail-<?php echo $interest->slug; ?>" data-interest-parent-id="<?php echo $interest->term_id; ?>" class="field hidden">
		<label for="get-info-moredetail-<?php echo $interest->slug; ?>">Visitors to this page are generally interested in:</label>
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

    endif; ?>

<?php endforeach; // END LOOP FOR SUB-SELECT LISTS
?>

*/

