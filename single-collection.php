<?php
/**
 * Terminal layout for Collections
 */

$section_link = 1;
$section_num = 1;

$associated_why_ws = get_post_meta( $post->ID, 'attached_why_ws', true);
$associated_resources = get_post_meta( $post->ID, 'attached_resources', true);
$before_block_sections = get_post_meta( $post->ID, 'collection_blocks_before_list', true );
$after_block_sections = get_post_meta( $post->ID, 'collection_blocks_after_list', true );

$collection_type = get_post_meta( $post->ID, 'collection_type', true );

$display_title = get_post_meta( $post->ID, 'general_display_title', true );

// Different title for Capstone itineraries
$itinerary_title = get_post_meta( $post->ID, 'itineraries_title', true );
if ( $itinerary_title ) {
	$itinerary_title = apply_filters( 'the_title', $itinerary_title );
} else {
	$itinerary_title = 'Select an Itinerary';
}

if ( ! $display_title ) {
	$display_title = get_the_title();
}

$associated_itineraries_override = get_post_meta( $post->ID, 'associated_itineraries', true );

if ( $associated_itineraries_override ) {
	$associated_itineraries = new WP_Query( array(
		'post_type'              => 'itinerary',
		'posts_per_page'         => 75,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'post__in'               => $associated_itineraries_override,
		'orderby'                => 'post__in'
	) );
} else {
	$post_obj = $wp_query->get_queried_object();

	$associated_itineraries = new WP_Query( array(
		'post_type' => 'itinerary',
		'tax_query' => array(
			array(
				'taxonomy' => '_collection',
				'field'    => 'slug',
				'terms'    => $post_obj->post_name
			)
		),
		'posts_per_page' => 75,
		'no_found_rows' => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'order' => 'ASC',
		'orderby' => 'title'
	) );
}

$calendar = get_post_meta($post->ID, 'itineraries_calendar', true);

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main collection" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
			$class = '';
		} else {
			$class = ' pattern-' . rand( 3, 9 );
		} ?>
		<section class="primary-section">
			<header class="section-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
				
				<div class="mobile-hero">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>

				<div class="ws-container">
					<div class="section-header-content">
						<nav class="breadcrumbs hide-print">
							<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore</a>>
							<span>Collections</span>>
							<span><?php the_title(); ?></span>
						</nav>
						<h1><?php echo apply_filters( 'the_title', $display_title ); ?></h1>

						<?php $subtitle = get_post_meta( $post->ID, 'collection_options_subtitle', true ); ?>

						<?php if ( $subtitle ) : ?>
							<p class="header-subtitle"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
						<?php endif; ?>

						<?php the_content(); ?>
					</div>
				</div>

				<?php get_template_part( 'partials/content', 'tooltips' ); ?>
				
			</header>

			<?php if ( 'outlier' != $collection_type ) : ?>

			<nav class="section-nav">
				<div class="ws-container">
					<ul class="section-menu hide-print">

						<?php if ( ! empty( $associated_why_ws ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Why WorldStrides?</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $associated_resources ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Resources</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $before_block_sections ) ) : ?>
							<?php foreach ( $before_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['collection_blocks_before_title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['collection_blocks_before_title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( $associated_itineraries->have_posts() ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $itinerary_title; ?></a></li>
						<?php endif; ?>

						<?php if ( ! empty( $after_block_sections ) ) : ?>
							<?php foreach ( $after_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['collection_blocks_after_title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['collection_blocks_after_title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</ul>

					<a href="<?php echo esc_url( home_url( '/request-info/' ) ); ?>" class="btn btn-primary subnav-cta">Request Info</a>
				</div>
			</nav>

		</section>

		<?php if ( ! empty( $associated_why_ws ) ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content why-content">

			<?php foreach ( $associated_why_ws as $why_ws ) : ?>

				<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

			<?php endforeach; ?>

		</section>

		<?php endif; ?>

		<?php $display_discover_why = get_post_meta( $post->ID, 'discover_why', true); ?>
		<?php if ( 'on' == $display_discover_why ) : ?>
			<?php get_template_part( 'partials/module', 'discover-why' ); ?>
		<?php endif; ?>

		<?php if ( $associated_resources ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content resources">
				<h2 class="section-title">Have Questions? We Have Answers.</h2>

				<ul class="resources-list list-unstyled clearfix">

					<?php foreach ( $associated_resources as $resource_id ) : ?>
						
						<?php 
						$resource = get_post( $resource_id );
						$background = '';
						$targets = wp_get_object_terms( $resource_id, 'resource-target' );
						$target_parents = array();
						$title = apply_filters( 'the_title', $resource->post_title );
						$url = get_the_permalink( $resource_id );
						$meta_list = array();

						foreach ( $targets as $target ) {
							if ( 'Featured' != $target->name ) {
								$parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' );
								if ( ! in_array( $parent->term_id, $target_parents ) ) {
									$target_parents[] = $parent->term_id;
									array_push( $meta_list, array( "name" => $parent->name, "url" => home_url( '/resources/' . $parent->slug . '/' ) ) );
								}
							}
						}

						if( has_post_thumbnail( $resource_id ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $resource_id ), 'medium' );
							$background = 'url(' . $featured[0] . ')';
							$class = '';
						} else {
							$class = ' ' . WS_Helpers::get_random_pattern('dark');
						} ?>

						<li class="resource tile tile-third <?php echo $class; ?>" style="background-image: <?php echo $background; ?>">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>

					<?php endforeach; ?>
					<?php $resource = null; ?>
				</ul>

		</section>
		<?php endif; ?>

		<?php if ( ! empty( $before_block_sections ) ) : ?>

			<section class="ws-container ws-blocks tour-blocks-before print-page-break">

				<?php foreach ( $before_block_sections as $section ) : ?>

					<?php if ( ! empty( $section['collection_blocks_before_title'] ) ) : ?>
						<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

						<h2 class="section-content"><?php echo apply_filters( 'the_title', $section['collection_blocks_before_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>

				<?php endforeach; ?>

			</section>

		<?php endif; ?>

		<?php if ( $associated_itineraries->have_posts() ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

			<section class="section-content programs">
				<header class="programs-header ws-container">
					<h2 class="section-title"><?php echo $itinerary_title; ?></h2>
					<?php if ( "on" === $calendar ) : ?>
						<div id="jrange" class="dates">
							<div class="mask">
								<a href="#open-calendar">
									<i class="icon icon-calendar"></i>
									<span class="mask-text">Choose By Date</span>
								</a>
								<a href="#clear-calendar">
									<i class="icon icon-small-close"></i>
								</a>
							</div>
							<div class="datepicker"></div>
						</div>
					<?php endif; ?>
				</header>
				<ul <?php echo ( "on" === $calendar ) ? 'id="mix-container"' : ''; ?> class="programs-list list-unstyled clearfix">

					<?php while ( $associated_itineraries->have_posts() ) : $associated_itineraries->the_post(); ?>
						
						<?php
						$background = '';
						$class = '';
						$dates = get_post_meta( $post->ID, 'itinerary_details_date_list', true );
						$json_dates = '';
						$title = get_the_title();
						$url = get_the_permalink();
						$meta_list = array( array( "name" => WS_Helpers::get_subtitle( $post->ID ) ) );

						if ( has_post_thumbnail( $post->ID ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
							$background = 'url(' . $featured[0] . ')';
							$class = ' has-tile-image';
						} else {
							$class = ' ' . WS_Helpers::get_random_pattern('dark');
						}

						// Calculate dates for filtering
						if ( $dates && is_array( $dates ) ) {
							$i = 0;
							while ( $i < count( $dates ) ) {
								$start 	= strtotime( $dates[$i]["itinerary_details_date_start"] ) * 1000;
								$end 	= strtotime( $dates[$i]["itinerary_details_date_end"] ) * 1000;
								$dates[$i] = array( $start, $end );
								$i++;
							}
							$json_dates = json_encode($dates);
						} ?>

						<li class="program tile tile-third available<?php echo $class; ?>" data-dates="<?php echo $json_dates; ?>" style="background-image: <?php echo $background; ?>;">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>

					<?php endwhile; ?>
				</ul>

				<!-- <a class="program-all-link" href="">See All</a> -->

			</section>
		<?php endif; ?>

		<?php if ( ! empty( $after_block_sections ) ) : ?>
			<?php foreach ( $after_block_sections as $section ) : ?>
				<section class="ws-container ws-blocks tour-blocks-after">
					<?php if ( ! empty( $section['collection_blocks_after_title'] ) ) : ?>
						<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

						<h2><?php echo apply_filters( 'the_title', $section['collection_blocks_after_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>
				</section>

			<?php endforeach; ?>
		<?php endif; ?>

		<?php $display_blog = get_post_meta( $post->ID, 'collection_options_blog', true); ?>
		<?php if ( 'on' == $display_blog ) : ?>
			<?php
			$blog_posts = new WP_Query( array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'no_found_rows' => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			));
			?>

			<?php if ( $blog_posts->have_posts() ) : ?>
				<section class="home-section blog">
					<div class="ws-container">
						<h2 class="section-title"><a class="text-color-link" href="<?php echo home_url('/blog/'); ?>">Latest Stories from the WorldStrides Blog</a></h2>
					</div>

					<?php $sidebar_open = false; ?>

					<div class="blog-wrap">
						<?php $count = 0; ?>
						<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>

							<?php if ( 0 == $count ) : ?>
								<section class="section-one">
									<?php get_template_part( 'partials/content', 'blog' ); ?>
								</section>
							<?php endif; ?>

							<?php if ( 1 == $count ) : ?>
								<aside class="sidebar">
									<?php $sidebar_open = true; ?>
									<?php get_template_part( 'partials/content', 'blog-sidebar' ); ?>
							<?php endif; ?>

							<?php if ( 2 == $count ) : ?>
								<?php get_template_part( 'partials/content', 'blog-sidebar' ); ?>
							<?php endif; ?>

							<?php $count++; ?>
						<?php endwhile; ?>

							<?php if ( $sidebar_open ) : ?>
								</aside>
							<?php endif; ?>

					</div>

				</section>
			<?php endif; ?>
		<?php endif; ?>


		<?php
		$additional_info_request_box = get_post_meta( $post->ID, 'additional_info_request_box', true );
		$additional_info_text = get_post_meta( $post->ID, 'additional_info_text', true );
		$additional_info_email_title = get_post_meta( $post->ID, 'additional_info_email_title', true );
		$additional_info_email_text = get_post_meta( $post->ID, 'additional_info_email_text', true );
		?>

		<?php if ( 'on' == $additional_info_request_box ) : ?>
			<?php get_template_part( 'partials/module', 'request-info' ); ?>
		<?php endif; ?>

		<?php if ( $additional_info_text && $additional_info_email_title && $additional_info_email_text ) : ?>
			<section class="info-cta">

				<div class="additional-info">
					<h3>Additional Information</h3>
					<?php echo apply_filters( 'the_content', $additional_info_text ); ?>
				</div>

				<div class="email-updates">
					<h3><?php echo apply_filters( 'the_title', $additional_info_email_title ); ?></h3>
					<p><?php echo apply_filters( 'the_content', $additional_info_email_text ); ?></p>

					<form action="">
						<input type="email" placeholder="Email Address">
						<input type="submit" class="btn btn-primary" value="Sign Up">
					</form>
				</div>
			</section>
		<?php endif; ?>

		<?php else : ?>
			</section>
		<?php endif; ?>

	</main>
</div>

<?php get_footer();