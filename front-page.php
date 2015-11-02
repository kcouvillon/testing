<?php
/**
 * The template for the home page (/) of the site
 */

get_header(); the_post();

$associated_why_ws = get_post_meta( $post->ID, 'attached_why_ws', true);
$associated_resources = get_post_meta( $post->ID, 'attached_resources', true);
$associated_programs = get_post_meta( $post->ID, 'attached_programs', true);
$block_sections = get_post_meta( $post->ID, 'home_blocks_list', true );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		$background = '';
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
		}
		?>

		<section id="intro" class="home-section primary-section">
			
			<header class="section-header" style="background-image: <?php echo $background; ?>;">
				<div class="mobile-hero">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
				<div class="ws-container">
					<div class="section-header-content">
						<?php the_content(); ?>
					</div>
				</div>
			</header>

			<?php get_template_part('partials/content', 'tooltips'); ?>

		</section>

		<?php if ( ! empty( $associated_why_ws ) ) : ?>
			<section class="section-content why-content">

				<?php foreach ( $associated_why_ws as $why_ws ) : ?>

					<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

				<?php endforeach; ?>

			</section>
		<?php endif; ?>

		<?php

		$data = array(
			array(
				'slug' => 'discoveries',
				'meta' => array( array( 'name'=>'Elementary &amp; Middle' ) )
			),
			array(
				'slug' => 'perspectives',
				'meta' => array( array( 'name'=>'High School' ) )
			),
			array(
				'slug' => 'capstone',
				'meta' => array( array( 'name'=>'Undergrad &amp; Postgrad' ) )
			),
			array(
				'slug' => 'on-stage',
				'meta' => array( array( 'name'=>'Performing Arts' ) )
			),
			array(
				'slug' => 'sports',
				'meta' => array( array( 'name'=>'Sports' ) )
			),
			array(
				'slug' => 'individual-travel-programs',
				'meta' => array( array( 'name'=>'Individual' ) )
			),
		);

		$divisions_title = get_post_meta( $post->ID, 'home_options_divisions_title', true );

		?>
		<section class="home-section programs">
			<div class="ws-container">
				<?php if ( $divisions_title ) : ?>
					<h2 class="section-title"><?php echo apply_filters( 'the_content', $divisions_title ); ?></h2>
				<?php endif; ?>

				<ul class="programs-list list-unstyled clearfix">
					<?php $count = 0; ?>

					<?php foreach ( $data as $item ) : ?>

						<?php 
						$division_page = get_page_by_path( $item['slug'] );

						if ( $division_page ) :
							$meta_list = $item['meta'];
							$url = get_the_permalink( $division_page->ID );
							$title = apply_filters( 'the_title', $division_page->post_title );

							if ( has_post_thumbnail( $division_page->ID ) ) {
								$thumb_id = get_post_thumbnail_id( $division_page->ID );
								$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'medium', true );
								$background = $thumb_url_array[0];
								$class = ' has-tile-image';
							} else {
								$background = get_template_directory_uri() . '/assets/images/src/patterns/ws_w_pattern' . ( ($count % 2 == 0 ) ? '5' : '8') . '.gif';
								$class = ' no-tile-image';
							}
							?>

							<li class="program tile tile-third<?php echo $class; ?>" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
								<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
							</li>

							<?php $count++; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>

			</div>
		</section>

		<?php if ( $associated_resources ) : ?>
			<section class="section-content resources">
				<h2 class="section-title">Have Questions? We Have Answers.</h2>

				<ul class="resources-list list-unstyled clearfix">

					<?php foreach ( $associated_resources as $resource_id ) : ?>
						
						<?php 
						$resource = get_post( $resource_id );
						$background = '';
						$targets = wp_get_object_terms( $resource_id, 'resource-target' );
						$target_parents = array();
						$url = get_the_permalink( $resource_id );
						$title = apply_filters( 'the_title', $resource->post_title );
						$meta_list = array();
						
						foreach ( $targets as $target ) {
							if ( 'Featured' != $target->name ) {
								$parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' );
								if ( ! in_array( $parent->term_id, $target_parents ) ) {
									$target_parents[] = $parent->term_id;
									$target_url = home_url( '/resources/' . $parent->slug . '/' );
									$target_name = $parent->name;
									array_push( $meta_list , array( 'url' => $target_url, 'name' => $target_name ) );
								}

							}
						}

						if( has_post_thumbnail( $resource_id ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $resource_id ), 'medium' );
							$background = 'url(' . $featured[0] . ')';
							$class = '';
						} else {
							$class = ' ' . WS_Helpers::get_random_pattern();
						} ?>

						<li class="resource tile tile-third <?php echo $class; ?>" style="background-image: <?php echo $background; ?>">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>

					<?php endforeach; ?>
					<?php $resource = null; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( $associated_programs ) : ?>

		<section class="home-section itineraries">
			<div class="ws-container">
				<h2 class="section-title">A Selection of our Tours and Programs</h2>
				<ul class="itineraries-list list-unstyled clearfix">
					
					<?php $count = 0; ?>

					<?php foreach ( $associated_programs as $program_id ) : ?>

						<?php
						$program = get_post( $program_id );
						$pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern5.gif' : 'ws_w_pattern8.gif';
						$title = apply_filters( 'the_title', $program->post_title );
						$url = get_the_permalink( $program->ID );
						$meta_list = array( array( 'name' => WS_Helpers::get_subtitle( $program->ID ) ) );

						if ( $count == 3 || $count == 4 ) {
							$tile_size = 'tile-half';
							$pattern = 'ws_w_pattern4.gif';
						} else {
							$tile_size = 'tile-third';
						}

						if ( has_post_thumbnail( $program_id ) ) {
							$thumb_id = get_post_thumbnail_id( $program_id );

							if ( 'tile-half' == $tile_size ) {
								$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'large', true );

							} else {
								// had this at medium, but was pretty bad looking
								$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'large', true );
							}

							$background = $thumb_url_array[0];
							$class = ' has-tile-image';
						} else {
							$background = get_template_directory_uri() . '/assets/images/src/patterns/ws_w_pattern' . ( ($count % 2 == 0 ) ? '5' : '8') . '.gif';
							$class = ' no-tile-image';
						}

						?>

						<li class="program tile <?php echo $tile_size; echo $class; ?>" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>

						<?php $count++; ?>
					<?php endforeach; ?>

				</ul>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( ! empty( $block_sections ) ) : ?>
		<section class="ws-container ws-blocks tour-blocks-before print-page-break">

			<?php foreach ( $block_sections as $section ) : ?>
				<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
				<?php if ( ! empty( $section['collection_blocks_before_title'] ) ) : ?>
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

		<section class="home-section learn-more clearfix ws-container">
			<?php get_template_part('partials/form','universal'); ?>
		</section>

		<section class="home-section blog">
			<div class="ws-container">
				<h2 class="section-title"><a class="text-color-link" href="<?php echo home_url('/blog/'); ?>">Latest Stories from the WorldStrides Blog<a></h2>
			</div>

			<div class="blog-wrap">

				<section>

				<?php $args = array( 'post_type' => 'post', 'posts_per_page' => 1 );
				$blogPosts = new WP_Query($args); ?>
				<?php if ( $blogPosts->have_posts() ) : ?>

					<?php while ( $blogPosts->have_posts() ) : $blogPosts->the_post(); ?>

						<?php get_template_part( 'partials/content', 'blog' ) ?>

					<?php endwhile; ?>

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

				</section>

				<aside class="sidebar">
					
					<?php $args = array( 'post_type' => 'post', 'posts_per_page' => 2, 'offset' => 1 );
					$blogPosts = new WP_Query($args); ?>
					<?php if ( $blogPosts->have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while ( $blogPosts->have_posts() ) : $blogPosts->the_post(); ?>

							<?php get_template_part( 'partials/content', 'blog-sidebar' ) ?>

						<?php endwhile; ?>

					<?php else : ?>

						<p>Nothing found</p>

					<?php endif; ?>

				</aside>

			</div>

		</section>

	</main>
</div>

<?php get_footer(); ?>
