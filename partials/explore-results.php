<?php
global $post; 
$filters = array_map( 'intval', get_terms( 'filter', array( 'fields' => 'ids' ) ) );
$collection_args = array(
	'post_type' => 'collection', 
	'posts_per_page' => 200,
	// 'posts_per_page' => 20,
	'tax_query' => array(
        array(
            'taxonomy' => 'filter',
            'field'	   => 'term_id',
			'terms'    => $filters,
        )
    ),
	'no_found_rows'          => true
);
$itinerary_args = array(
	'post_type' => 'itinerary', 
	'posts_per_page' => 300,
	// 'posts_per_page' => 30,
	'tax_query' => array(
        array(
            'taxonomy' => 'filter',
            'field'	   => 'term_id',
			'terms'    => $filters,
        )
    ),
	'no_found_rows'          => true
);
$itineraries = new WP_Query( $itinerary_args );
$collections = new WP_Query( $collection_args );
?>

<section class="explore-results section-content">

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
					$scrim = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.45) ),';
				} else {
					$image = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '5' : '8') . '.gif';
					$scrim = '';
				}
				?>
				<article <?php post_class( $post_class ); ?>
						 style="background-image:<?php echo $scrim . ' url(' . $image . ')'; ?>;" >

					<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm collection-image" />

					<div class="tile-content collection-content">
						<ul class="meta collection-meta list-unstyled">
							<?php foreach ( $terms as $term ) : if ( in_array( $term->term_id, get_term_children( 222, 'filter' )) ) { ?>

								<li><?php echo $term->name; ?></li>
							
							<?php } endforeach; ?>
						</ul>
						<h2 class="tile-title collection-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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
				$count++;	
				$post_class = ( $count <= 9 ) ? 'tile tile-third' : 'tile tile-third';
				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
					$scrim = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.7) ),';
				} else {
					$image = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '1' : '4') . '.gif';
					$scrim = '';
				}
				?>
				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo $scrim . ' url(' . $image . ')'; ?>;" >

					<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />

					<div class="tile-content itinerary-content">
						<h2 class="tile-title itinerary-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</div>

				</article>

			<?php endwhile; ?>
		
		</div>
		<a href="#toggle-results" class="toggle-results">See All</a>
	</div>

</section>