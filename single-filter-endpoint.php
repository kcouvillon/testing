<?php
/**
 * Terminal layout for Filter Endpoints
 */

$post_type = get_post_type();

$section_link = 1;
$section_num = 1;

$associated_why_ws = get_post_meta( $post->ID, 'attached_why_ws', true);
$associated_resources = get_post_meta( $post->ID, 'attached_resources', true);
$before_block_sections = get_post_meta( $post->ID, 'collection_blocks_before_list', true );
$after_block_sections = get_post_meta( $post->ID, 'collection_blocks_after_list', true );

$display_title = get_post_meta( $post->ID, 'general_display_title', true );

$associated_filter_id = WS_Associated_Filter::get_associated_filter_id( $post->ID );

if ( ! $display_title ) {
	$display_title = get_the_title();
}

get_header(); ?>

<?php
	$associated_collections = new WP_Query( array(
		'post_type' => 'collection',
		'post_per_page' => 150,
		'tax_query' => array(
			array(
				'taxonomy' => 'filter',
				'field'    => 'term_id',
				'terms'    => $associated_filter_id
			)
		),
		'no_found_rows' => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
	));
?>

<?php
$associated_itineraries = new WP_Query( array(
	'post_type' => 'itinerary',
	'post_per_page' => 150,
	'tax_query' => array(
		array(
			'taxonomy' => 'filter',
			'field'    => 'term_id',
			'terms'    => $associated_filter_id
		)
	),
	'no_found_rows' => true,
	'update_post_term_cache' => false,
	'update_post_meta_cache' => false,
));
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main filter-endpoint" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
			$class = '';
		} else {
			$class = ' pattern-' . rand( 1, 9 );
		} ?>
		<section class="primary-section">
			<header class="section-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
				<div class="ws-container">
					<div class="section-header-content">
						<nav class="breadcrumbs">
							<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore</a>>
							<span>Interests</span>>
							<span><?php the_title(); ?></span>
						</nav>
						<h1><?php echo apply_filters( 'the_title', $display_title ); ?></h1>

						<?php the_content(); ?>
					</div>
				</div>

				<?php get_template_part( 'partials/content', 'tooltips' ); ?>

			</header>

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
								<?php if ( ! empty ( $section['title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( $associated_collections->have_posts() ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Collections</a></li>
						<?php endif; ?>

						<?php if ( $associated_itineraries->have_posts() ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Programs</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $after_block_sections ) ) : ?>
							<?php foreach ( $after_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</ul>
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

		<?php if ( $associated_resources ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content resources">
				<h2 class="section-title">Have Questions? We Have Answers.</h2>

				<ul class="resources-list list-unstyled clearfix">
					
					<?php $count = 0; ?>
					<?php foreach ( $associated_resources as $resource_id ) : ?>
						
						<?php 
						$resource = get_post( $resource_id );
						$pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif';
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
									array_push( $meta_list, array( "name" => $parent->name ) );
								}
							}
						} ?>

						<li class="resource tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>
					
						<?php $count++; ?>
					<?php endforeach; ?>

				</ul>
		</section>
		<?php endif; ?>

		<?php if ( ! empty( $before_block_sections ) ) : ?>
			<section class="ws-container ws-blocks tour-blocks-before print-page-break">

				<?php foreach ( $before_block_sections as $section ) : ?>
					<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

					<?php if ( ! empty( $section['title'] ) ) : ?>
						<h2 class="section-content"><?php echo apply_filters( 'the_title', $section['title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>

				<?php endforeach; ?>

			</section>

		<?php endif; ?>

		<?php if ( $associated_collections->have_posts() ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="section-content programs">
				<h2 class="section-title">Related Collections</h2>
				<ul class="programs-list list-unstyled clearfix meta">
					<?php $count = 0; ?>

					<?php while ( $associated_collections->have_posts() ) : ?>
						<?php $associated_collections->the_post(); ?>
						<?php
						if ( has_post_thumbnail() ) {
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
							$background = $thumb_url_array[0];
						} else {
							$background = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '5' : '8') . '.gif';
						}
						?>

						<li class="program tile tile-third" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
							<div class="tile-content">
								<?php if( 'interest' === $post_type || 'destination' === $post_type ) : ?>
								<ul class="meta list-unstyled list-tags">
									<?php if( 'interest' === $post_type ) : ?>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'destination' ); ?></li>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'traveler' ); ?></li>
									<?php elseif( 'destination' === $post_type ) : ?>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'interest' ); ?></li>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'traveler' ); ?></li>
									<?php endif; ?>
								</ul>
								<?php endif; ?>
								<h2 class="tile-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</div>
						</li>


						<?php $count++; ?>
					<?php endwhile; ?>
				</ul>

			</section>
		<?php endif; ?>

		<?php if ( $associated_itineraries->have_posts() ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="section-content programs">
				<h2 class="section-title">Related Programs</h2>
				<ul class="programs-list list-unstyled clearfix">
					<?php $count = 0; ?>

					<?php while ( $associated_itineraries->have_posts() ) : ?>
						<?php $associated_itineraries->the_post(); ?>
						<?php
						if ( has_post_thumbnail() ) {
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
							$background = $thumb_url_array[0];
						} else {
							$background = get_template_directory_uri().'/assets/images/src/patterns/ws_w_pattern' . (($count % 2 == 0) ? '5' : '8') . '.gif';
						}
						?>

						<li class="program tile tile-third" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
							<div class="tile-content">
								<ul class="meta list-unstyled list-tags">
									<?php if( 'interest' === $post_type ) : ?>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'destination' ); ?></li>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'traveler' ); ?></li>
									<?php elseif( 'destination' === $post_type ) : ?>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'interest' ); ?></li>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'traveler' ); ?></li>
									<?php elseif( 'traveler' === $post_type ) : ?>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'destination' ); ?></li>
										<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $post->ID, 'interest' ); ?></li>
									<?php endif; ?>
								</ul>
								<h2 class="tile-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

								<?php $itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true ); ?>

								<?php if ( 'smithsonian' == $itinerary_type ) : ?>
									<div class="smithsonian"></div>
								<?php endif; ?>
							</div>
						</li>

						<?php $count++; ?>
					<?php endwhile; ?>
				</ul>

			</section>
		<?php endif; ?>

		<?php if ( ! empty( $after_block_sections ) ) : ?>
			<?php foreach ( $after_block_sections as $section ) : ?>
				<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
				<section class="ws-container ws-blocks tour-blocks-after">
					<?php if ( ! empty( $section['title'] ) ) : ?>
						<h2><?php echo apply_filters( 'the_title', $section['title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>
				</section>

			<?php endforeach; ?>
		<?php endif; ?>

		<?php $related_blog_post_ids = get_post_meta( $post->ID, 'related_blog_posts', true); ?>

		<?php
		if ( $related_blog_post_ids ) {
			// string of comma separated numbers needs to be converted to array of integers
			$related_blog_post_ids = explode( ',', $related_blog_post_ids );
			array_walk( $related_blog_post_ids, 'intval' );

			$blog_posts = new WP_Query( array(
				'post_type'              => 'post',
				'posts_per_page'         => 3,
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'post__in'               => $related_blog_post_ids
			) );
		} else {
			$blog_posts = '';
		}
		?>

		<?php if ( is_object( $blog_posts ) && $blog_posts->have_posts() ) : ?>
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

		<?php get_template_part( 'partials/module', 'request-info' ); ?>

		<?php get_footer(); ?>
