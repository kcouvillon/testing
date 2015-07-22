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

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main filter-endpoint" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'linear-gradient( rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28) ), url(' . $featured[0] . ')';
		} ?>
		<section class="primary-section">
			<header class="section-header pattern-<?php echo rand( 1, 9 ); ?>" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">
					<nav class="breadcrumbs">
						<a href="<?php echo esc_url( home_url( '/explore' ) ); ?>">Explore</a>>
						<span>Interests</span>>
						<span><?php the_title(); ?></span>
					</nav>
					<h1><?php the_title(); ?></h1>

					<?php the_content(); ?>
				</div>

				<?php get_template_part( 'partials/content', 'tooltips' ); ?>

			</header>

			<nav class="section-nav">
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

					<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Itineraries</a></li>

					<?php if ( ! empty( $after_block_sections ) ) : ?>
						<?php foreach ( $after_block_sections as $section ) : ?>
							<?php if ( ! empty ( $section['title'] ) ) : ?>
								<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['title']; ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>

				</ul>
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
						<?php $resource = get_post( $resource_id ); ?>
						<?php $pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif'; ?>

						<li class="resource tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
							<div class="tile-content">
								<ul class="meta list-unstyled">
									<?php $targets = wp_get_object_terms( $resource_id, 'resource-target' ); ?>
									<?php $target_parents = array(); ?>

									<?php foreach ( $targets as $target ) : ?>
										<?php if ( 'Featured' != $target->name ) : ?>

											<?php $parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' ); ?>

											<?php if ( ! in_array( $parent->term_id, $target_parents ) ) : ?>
												<?php $target_parents[] = $parent->term_id; ?>

												<li><?php echo $parent->name; ?></li>

											<?php endif; ?>

										<?php endif; ?>
									<?php endforeach; ?>

								</ul>
								<h2 class="tile-title"><a href="#"><?php echo apply_filters( 'the_title', $resource->post_title ); ?></a></h2>
							</div>
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

		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content programs">
			<h2 class="section-title">Related Collections</h2>
			<ul class="programs-list list-unstyled clearfix">
				<?php 
				$count = 0;
				$data = array(
					array(
						"title" => "Middle School",
						"meta" => array("Discoveries Programs")
					),
					array(
						"title" => "High School",
						"meta" => array("Passages Programs")
					),
					array(
						"title" => "University",
						"meta" => array("Capstone Programs")
					),
					array(
						"title" => "Performing Arts",
						"meta" => array("On Stage Programs")
					),
				);
				foreach ( $data as $item ) : ?>

				<?php $pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif'; ?>
				<li class="program tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
					<div class="tile-content">
						<ul class="meta list-unstyled">
							<?php foreach ( $item['meta'] as $meta ) : ?>
							<li><a href="#"><?php echo $meta; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<h2 class="tile-title"><a href="#"><?php echo $item['title']; ?></a></h2>
					</div>
				</li>
				
				<?php $count++; endforeach; ?>
			</ul>

		</section>

		<section class="section-content programs">
			<h2 class="section-title">Related Programs</h2>
			<ul class="programs-list list-unstyled clearfix">
				<?php 
				$count = 0;
				$data = array(
					array(
						"title" => "Middle School",
						"meta" => array("Discoveries Programs")
					),
					array(
						"title" => "High School",
						"meta" => array("Passages Programs")
					),
					array(
						"title" => "University",
						"meta" => array("Capstone Programs")
					),
					array(
						"title" => "Performing Arts",
						"meta" => array("On Stage Programs")
					),
				);
				foreach ( $data as $item ) : ?>

				<?php $pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif'; ?>
				<li class="program tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
					<div class="tile-content">
						<ul class="meta list-unstyled">
							<?php foreach ( $item['meta'] as $meta ) : ?>
							<li><a href="#"><?php echo $meta; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<h2 class="tile-title"><a href="#"><?php echo $item['title']; ?></a></h2>
					</div>
				</li>
				
				<?php $count++; endforeach; ?>
			</ul>
				
		</section>

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

		<section class="home-section blog">
			<div class="ws-container">
				<h2 class="section-title">Latest Stories from the WorldStrides Blog</h2>
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

		<div class="blog-single-cta">
			<span class="h2">Request Information about a WorldStrides {PROGRAM TYPE} Program</span>
			<span>I am a</span>
			<select name="" id="">
				<option value="">Parent</option>
				<option value="">Traveler</option>
				<option value="">Teacher</option>
			</select>
			<button class="btn btn-primary">Get the Info</button>
		</div>

<?php get_footer(); ?>
