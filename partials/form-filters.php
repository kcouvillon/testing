<?php
 /**
  * Populates hidden input fields for form submission to Marketo.
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

/*OUT OF PHP - FOLLOWING IS DEBUGGING JS:*/?>
		<script type="text/javascript">
			console.log('Term Data about current post / itinerary: ');
			console.log(<?php echo "'Product Lines: " . json_encode($product_lines) . "'" ?>);
			console.log(<?php echo "'Filters: " . json_encode($filters) . "'" ?>);
			console.log(<?php echo "'Collections: " . json_encode($collections) . "'" ?>);
		</script>

<?php $product_line_maximizer = WS_Form::presubmit_max_product_from_context($product_lines); ?>

<li class="field hidden">
	<input id="get-info-maxproductline" type="hidden" name="mkto_wsMaxProductLine" title="Product Line" value="<?php echo $product_line_maximizer; ?>">
	<input id="get-info-websiteInterestFilters" type="hidden" name="mkto_websiteInterestFilters" value="<?php echo WS_Form::slugs_from_terms($filters); ?>" >
	<input id="get-info-websiteProductLines" type="hidden" name="mkto_websiteProductLines" value="<?php echo WS_Form::slugs_from_terms($product_lines); ?>" >
	<input id="get-info-websiteCollections" type="hidden" name="mkto_websiteCollections" value="<?php echo WS_Form::slugs_from_terms($collections); ?>" >
</li>

<?php