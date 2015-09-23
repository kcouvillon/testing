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

<?php foreach ( $interests as $interest ) : /*START LOOP FOR MAIN SELECT LIST*/ ?>

		<option value="<?php echo $interest->slug; ?>"
				class = "stu par ele mse hse une" <?php // @todo dynamically tie interests to these stu (student) par (parent) ... roles ?>
				data-interest-id="<?php echo $interest->term_id; ?>">
			<?php echo $interest->name; ?>
		</option>

<?php endforeach; /*END LOOP FOR MAIN SELECT LIST*/ ?>

		<option value="faith-and-service"
				class = "stu par ele mse hse une" <?php // @todo dynamically tie interests to these stu (student) par (parent) ... roles ?>
				data-interest-id="384">
			Faith-based
		</option>

		<option value="faith-and-service"
				class = "stu par ele mse hse une" <?php // @todo dynamically tie interests to these stu (student) par (parent) ... roles ?>
				data-interest-id="384">
			Service
		</option>

		<option value="Unknown"
				class = "stu par ele mse hse une" <?php // @todo dynamically tie interests to these stu (student) par (parent) ... roles ?>>
			I don't know yet
		</option>


	</select>
</li>

<?php foreach ( $interests as $interest ) : /*START LOOP FOR SUB-SELECT LISTS*/ 
	$child_interests = get_terms( 'filter', array( 'parent' => $interest->term_id ) ); 
	if(!empty($child_interests)) : ?>

<li id="get-info-wsProductDetail-<?php echo $interest->slug; ?>" data-interest-parent-id="<?php echo $interest->term_id; ?>" class="field hidden">
	<label for="get-info-moredetail-<?php echo $interest->slug; ?>">I want to learn more about</label>
	<select id="get-info-moredetail-<?php echo $interest->slug; ?>" name="mkto_wsProductDetail" title="-<?php echo 'Specific Interest within ' . $interest->name; ?>">
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
<?php endforeach; /*END LOOP FOR SUB-SELECT LISTS*/
