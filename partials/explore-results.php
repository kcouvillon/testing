<section class="explore-results section-content">

	<div class="collections">
		<header class="results-header">
			<h2>Collections</h2>
			<a href="#" class="see-more">See more</a>
		</header>
		<div class="results clearfix">

			<?php
			global $post; 
			$count = 0;
			$collections = get_posts( array('post_type' => 'collection', 'posts_per_page' => 200) );
			foreach ( $collections as $post ) : setup_postdata($post); ?>

			<?php
			$count++;
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
				$background = $thumb_url_array[0];
				$scrim = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.45) ),';
			} else {
				$background = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '5' : '8') . '.gif';
				$scrim = '';
			}
			?>
			<article <?php post_class('tile tile-third'); ?>
					 style="background-image:<?php echo $scrim . ' url(' . $background . ')'; ?>;" >

				<div class="tile-content collection-content">
					<ul class="meta collection-meta list-unstyled">
						<?php 
						$terms = get_the_terms( get_the_ID(), 'filter' );
						foreach ( $terms as $term ) : if ( in_array( $term->term_id, get_term_children( 222, 'filter' )) ) { ?>

							<li><?php echo $term->name; ?></li>
						
						<?php } endforeach; ?>
					</ul>
					<h2 class="tile-title collection-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>

			</article>

			<?php endforeach; wp_reset_postdata(); ?>

		</div>
	</div>

	<div class="itineraries">
		<header class="results-header">
			<h2>Itineraries</h2>
		</header>
		<div class="results clearfix">
			
			<?php
			global $post; 
			$count = 0;
			$collections = get_posts( array('post_type' => 'itinerary', 'posts_per_page' => 200) );
			foreach ( $collections as $post ) : setup_postdata($post); ?>

			<?php
			$count++;
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
				$background = $thumb_url_array[0];
				$scrim = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.7) ),';
			} else {
				$background = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '1' : '4') . '.gif';
				$scrim = '';
			}
			?>
			<article <?php post_class('tile tile-third'); ?>
					 style="background-image:<?php echo $scrim . ' url(' . $background . ')'; ?>;" >

				<div class="tile-content itinerary-content">
					<ul class="meta itinerary-meta list-unstyled">
						<?php 
						// $terms = get_the_terms( get_the_ID(), 'filter' );
						// $top_level_terms = array();

						// foreach ( $terms as $term ) {
						// 	$ancestors = get_ancestors( $term->term_id, 'filter' );
						// 	if ( in_array( 11, $ancestors) && ! in_array( $ancestors[0], $top_level_terms ) ) {
						// 		array_push( $top_level_terms, $ancestors[0] );
						// 	}
						// }

						// foreach ( $top_level_terms as $term_id ) {
						// 	$top_term = get_term( $term_id, 'filter' );
						// 	echo '<li>' . $top_term->name . '</li>';
						// }

						?>
					</ul>
					<h2 class="tile-title itinerary-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>

			</article>

			<?php endforeach; wp_reset_postdata(); ?>

		</div>
	</div>

</section>