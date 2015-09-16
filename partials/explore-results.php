<?php
global $post; 
$filters = array_map( 'intval', get_terms( 'filter', array( 'fields' => 'ids' ) ) );
$collection_args = array(
	'post_type' => 'collection', 
	'posts_per_page' => 500,
	// 'posts_per_page' => 20,
	'tax_query' => array(
        array(
            'taxonomy' => 'filter',
            'field'	   => 'term_id',
			'terms'    => $filters,
        )
    ),
	'no_found_rows'          => true,
	'orderby' => 'title',
	'order' => 'ASC'
);
$itinerary_args = array(
	'post_type' => 'itinerary', 
	'posts_per_page' => 500,
	// 'posts_per_page' => 30,
	'tax_query' => array(
        array(
            'taxonomy' => 'filter',
            'field'	   => 'term_id',
			'terms'    => $filters,
        )
    ),
	'no_found_rows'          => true,
	'orderby' => 'title',
	'order' => 'ASC'
);
$itineraries = new WP_Query( $itinerary_args );
$collections = new WP_Query( $collection_args );
?>

<section id="explore-results" class="explore-results section-content">

	<div class="collections show-previews">
		<header class="results-header">
			<h2>Collections</h2>
		</header>
		<div class="results clearfix">


			<?php 
			$count = 0;
			while( $collections->have_posts() ) : $collections->the_post(); ?>

				<?php
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$count++;
				$post_class = ( $count <= 3 ) ? 'tile tile-third' : 'tile tile-third';
				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$image = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '5' : '8') . '.gif';
				}
				?>
				<article <?php post_class( $post_class ); ?>
						 style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm collection-image" />

					<div class="tile-content collection-content">
						<ul class="meta collection-meta list-unstyled">
							<?php foreach ( $terms as $term ) : if ( in_array( $term->term_id, get_term_children( 222, 'filter' )) ) { ?>
								<li><?php echo $term->name; ?></li>
							<?php } endforeach; ?>
						</ul>
						<?php if ( '844' == $post->ID ) : ?>
							<img class="smithsonian-image" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small.png' ); ?>" />
							<img class="smithsonian-image-mobile" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small-gray.png' ); ?>" />
						<?php endif; ?>
						<h3 class="h2 tile-title collection-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</div>

				</article>

			<?php endwhile; ?>

		</div>
		<a href="#toggle-results" class="toggle-results">See All</a>
	</div>

	<div class="itineraries show-previews">
		<header class="results-header">
			<h2>Itineraries</h2>
		</header>
		<div class="results clearfix">
			
			<?php 
			$count = 0;
			while ( $itineraries->have_posts() ) : $itineraries->the_post(); ?>

				<?php 
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$count++;	
				$post_class = ( $count <= 9 ) ? 'tile tile-third' : 'tile tile-third';
				$itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );
				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$image = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '1' : '4') . '.gif';
				}
				?>
				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />

					<div class="tile-content itinerary-content">
						<ul class="meta itinerary-meta list-unstyled">
							<?php foreach ( $terms as $term ) : if ( in_array( $term->term_id, get_term_children( 222, 'filter' )) ) { ?>
								<li><?php echo $term->name; ?></li>
							<?php } endforeach; ?>
						</ul>
						<?php if ( 'smithsonian' == $itinerary_type ) : ?>
							<img class="smithsonian-image" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small.png' ); ?>" />
							<img class="smithsonian-image-mobile" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small-gray.png' ); ?>" />
						<?php endif; ?>
						<h3 class="h2 tile-title itinerary-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</div>

				</article>

			<?php endwhile; ?>
		
		</div>
		<a href="#toggle-results" class="toggle-results">See All</a>
	</div>

</section>