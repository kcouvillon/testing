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

		<section id="intro" class="home-section primary-section" style="background-image: <?php echo $background; ?>;">
		
			<div class="intro-content">
				<?php the_content(); ?>
			</div>

			<?php get_template_part('partials/content', 'tooltips'); ?>

		</section>

		<?php if ( ! empty( $associated_why_ws ) ) : ?>
			<section class="section-content why-content">

				<?php foreach ( $associated_why_ws as $why_ws ) : ?>

					<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

				<?php endforeach; ?>

			</section>
		<?php endif; ?>

		<?php get_template_part( 'partials/divisions'); ?>

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
							<div class="tile-content">
								<ul class="meta list-unstyled">
									<li class="list-tag-no-link"><?php echo WS_Helpers::get_subtitle( $program->ID ); ?></li>
								</ul>
								<h2 class="tile-title"><a href="<?php echo get_the_permalink( $program->ID ); ?>"><?php echo apply_filters( 'the_title', $program->post_title ); ?></a></h2>
							</div>
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

		<?php if ( $associated_resources ) : ?>
			<section class="section-content resources">
				<h2 class="section-title">Have Questions? We Have Answers.</h2>

				<ul class="resources-list list-unstyled clearfix">

					<?php foreach ( $associated_resources as $resource_id ) : ?>
						<?php $resource = get_post( $resource_id ); ?>
						<?php
						$background = '';
						if( has_post_thumbnail( $resource_id ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
							$background = 'url(' . $featured[0] . ')';
							$class = '';
						} else {
							$class = ' pattern-' . rand(1, 9);
						} ?>

						<li class="resource tile tile-third <?php echo $class; ?>" style="background-image: <?php echo $background; ?>">
							<div class="tile-content">
								<ul class="meta list-unstyled">
									<?php $targets = wp_get_object_terms( $resource_id, 'resource-target' ); ?>
									<?php $target_parents = array(); ?>

									<?php foreach ( $targets as $target ) : ?>
										<?php if ( 'Featured' != $target->name ) : ?>

											<?php $parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' ); ?>

											<?php if ( ! in_array( $parent->term_id, $target_parents ) ) : ?>
												<?php $target_parents[] = $parent->term_id; ?>

												<li><a href="<?php echo esc_url( home_url( '/resources/' . $parent->slug . '/' ) ) ; ?>"><?php echo $parent->name; ?></a></li>

											<?php endif; ?>

										<?php endif; ?>
									<?php endforeach; ?>

								</ul>
								<h2 class="tile-title"><a href="<?php echo get_the_permalink( $resource_id ); ?>"><?php echo apply_filters( 'the_title', $resource->post_title ); ?></a></h2>
							</div>
						</li>
					<?php endforeach; ?>

				</ul>
			</section>
		<?php endif; ?>

		<section class="home-section learn-more clearfix ws-container">
				<form action="#" class="ws-form">
					<div class="left">
						<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
						<ul class="form-fields list-unstyled">
							<li class="field">
								I am an
								<select name="name">
									<option value="">Educator</option>
									<option value="">Parent</option>
									<option value="">Student</option>
								</select>
							</li>
							<li class="field">
								Interested in
								<select name="name">
									<option value="">Middle School Travel</option>
									<option value="">High School Travel</option>
									<option value="">University Travel</option>
								</select>
							</li>
							<li class="field">
								Do you have a tour scheduled?
								&nbsp;&nbsp;
								<input type="radio" name="tour" id="tour-yes" value="yes" />
								<label for="tour-yes">Yes</label>
								&nbsp;
								<input type="radio" name="tour" id="tour-no" value="no" />
								<label for="tour-no">No</label>
							</li>
						</ul>
					</div>
					<div class="right">
						<ul class="form-fields list-unstyled">
							<li class="field field-complex">
								<div class="field-left">
									<input type="text" name="first_name" value="" placeholder="First Name" />
								</div>
								<div class="field-right">
									<input type="text" name="last_name" value="" placeholder="Last Name" />
								</div>
							</li>
							<li class="field">
								<input type="email" name="email" value="" placeholder="Email Address" />
							</li>
							<li class="field">
								<input type="tel" name="phone" value="" placeholder="Phone Number" />
							</li>
							<li class="field">
								<input type="text" name="group_name" value="" placeholder="School or Group Name" />
							</li>
						</ul>
						<input type="submit" name="" value="Get Info" class="btn btn-primary" />
					</div>
				</form>
		</section>

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

	</main>
</div>

<?php get_footer(); ?>
