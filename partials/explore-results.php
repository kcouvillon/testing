<?php
global $post;

$filters = array_map( 'intval', get_terms( 'filter', array( 'fields' => 'ids' ) ) );

$select_itineraries_ids = get_post_meta( $post->ID, 'explore_attached_itineraries', true );
$select_collections_ids = get_post_meta( $post->ID, 'explore_attached_collections', true );


// See if we've got featured itineraries
if ( ! empty ( $select_itineraries_ids ) ) {
	$select_itinerary_args = array(
		'post_type' => 'itinerary',
		'posts_per_page' => 50,
		'no_found_rows'          => true,
		'post__in' => $select_itineraries_ids,
		'orderby' => 'post__in'
	);

	$select_itineraries = new WP_Query( $select_itinerary_args );
} else {
	$select_itineraries = '';
}

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
	'order' => 'ASC',
	'post__not_in' => $select_itineraries_ids
);

$itineraries = new WP_Query( $itinerary_args );


// See if we've got any featured collections
if ( ! empty ( $select_collections_ids ) ) {
	$select_collections_args = array(
		'post_type' => 'collection',
		'posts_per_page' => 50,
		'no_found_rows'          => true,
		'post__in' => $select_collections_ids,
		'orderby' => 'post__in'
	);

	$select_collections = new WP_Query( $select_collections_args );
} else {
	$select_collections = '';
}

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
	'order' => 'ASC',
	'post__not_in' => $select_collections_ids
);

$collections = new WP_Query( $collection_args );
?>

<section id="explore-results" class="explore-results section-content">

	<div class="collections show-previews">
		<header class="results-header">
			<h2>Collections</h2>
		</header>
		<div class="results clearfix">

			<?php if ( ! empty ( $select_collections_ids ) ) : ?>
			<?php while( $select_collections->have_posts() ) : $select_collections->the_post(); ?>

				<?php
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$post_class = 'tile tile-third ';
				$show_smithsonian = ( '844' == $post->ID ) ? true : false;
				$title = get_the_title();
				$url = get_the_permalink();
				$meta_list = array();

				foreach ( $terms as $term ) {
					if ( in_array( $term->term_id, get_term_children( 222, 'filter' ) ) ) {
						array_push( $meta_list, array( 'name' => $term->name ) );
					}
				}

				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$post_class .= WS_Helpers::get_random_pattern('dark') . ' ';
				}
				?>
				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<?php if ( $image ) { ?>
						<a href="<?php echo esc_url($url); ?>">
							<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />
						</a>
					<?php } ?>

					<?php include( locate_template( 'partials/tile-content.php' ) ); ?>

				</article>

			<?php endwhile; ?>
			<?php endif; ?>

			<?php while( $collections->have_posts() ) : $collections->the_post(); ?>

				<?php
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$post_class = 'tile tile-third ';
				$show_smithsonian = ( '844' == $post->ID ) ? true : false;
				$title = get_the_title();
				$url = get_the_permalink();
				$meta_list = array();

				foreach ( $terms as $term ) {
					if ( in_array( $term->term_id, get_term_children( 222, 'filter' ) ) ) {
						array_push( $meta_list, array( 'name' => $term->name ) );
					}
				}

				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$post_class .= WS_Helpers::get_random_pattern('dark') . ' ';
				}
				?>
				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<?php if ( $image ) { ?>
						<a href="<?php echo esc_url($url); ?>">
							<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />
						</a>
					<?php } ?>

					<?php include( locate_template( 'partials/tile-content.php' ) ); ?>

				</article>

			<?php endwhile; ?>

		</div>
		<a href="#toggle-results" class="toggle-results">See All Collections</a>
	</div>

	<div class="itineraries show-previews">
		<header class="results-header">
			<h2>Itineraries</h2>
		</header>
		<div class="results clearfix">
			<?php // display the featured itineries, this could probably be merged with the below somehow  ?>
			<?php if ( ! empty ( $select_itineraries_ids ) ) : ?>
			<?php while ( $select_itineraries->have_posts() ) : $select_itineraries->the_post(); ?>

				<?php
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$post_class = 'tile tile-third ';
				$title = get_the_title();
				$url = get_the_permalink();
				$meta_list = array();

				foreach ( $terms as $term ) {
					if ( in_array( $term->term_id, get_term_children( 222, 'filter' ) ) ) {
						array_push( $meta_list, array( 'name' => $term->name ) );
					}
				}

				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$post_class .= WS_Helpers::get_random_pattern('dark') . ' ';
				}
				?>

				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<?php if ( $image ) { ?>
						<a href="<?php echo esc_url($url); ?>">
							<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />
						</a>
					<?php } ?>

					<?php include( locate_template( 'partials/tile-content.php' ) ); ?>

				</article>

			<?php endwhile; ?>
			<?php endif; ?>

			<?php while ( $itineraries->have_posts() ) : $itineraries->the_post(); ?>

				<?php 
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$post_class = 'tile tile-third ';
				$title = get_the_title();
				$url = get_the_permalink();
				$meta_list = array();

				foreach ( $terms as $term ) {
					if ( in_array( $term->term_id, get_term_children( 222, 'filter' ) ) ) {
						array_push( $meta_list, array( 'name' => $term->name ) );
					}
				}

				if ( has_post_thumbnail() ) {
					$thumb_id = get_post_thumbnail_id();
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
					$image = $thumb_url_array[0];
				} else {
					$post_class .= WS_Helpers::get_random_pattern('dark') . ' ';
				}
				?>

				<article <?php post_class( $post_class ); ?> style="background-image:<?php echo ' url(' . $image . ')'; ?>;" >

					<?php if ( $image ) { ?>
						<a href="<?php echo esc_url($url); ?>">
							<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="hide-sm itinerary-image" />
						</a>
					<?php } ?>

					<?php include( locate_template( 'partials/tile-content.php' ) ); ?>

				</article>

			<?php endwhile; ?>
		
		</div>
		<a href="#toggle-results" class="toggle-results">See All Itineraries</a>
	</div>

</section>