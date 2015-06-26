<?php

?>

<section class="section-content">
	<?php
		$term_id = get_queried_object()->term_id;
		$taxonomy = 'resource-target';
		$terms = get_term_children( $term_id, $taxonomy );

		if ( !empty( $terms ) ) { ?>

		<div class="resource-content related-terms-list">

			<h6>Which Describes you best?</h6>
			<ul>

			<?php foreach ( $terms as $term ) { ?>

				<?php $obj = get_term_by( 'id', $term, $taxonomy ); ?>

				<li><a href="<?php echo get_term_link( $term, $taxonomy); ?>"><?php echo $obj->name; ?></a></li>

				<?php
				}
			?>
			</ul>

		</div>
		<?php	
		}
	?>
</section>
