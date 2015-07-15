<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

$recent_highlights = array();

$recent_travelogue = new WP_Query( array(
	'posts_per_page' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'blog-type',
			'field'    => 'slug',
			'terms'    => 'travelogue',
		),
	),
	'no_found_rows'          => true,
	'update_post_term_cache' => false,
	'update_post_meta_cache' => false,
) );

$recent_postcard = new WP_Query( array(
	'posts_per_page' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'blog-type',
			'field'    => 'slug',
			'terms'    => 'postcard',
		),
	),
	'no_found_rows'          => true,
	'update_post_term_cache' => false,
	'update_post_meta_cache' => false,
) );

if ( $recent_travelogue->have_posts() ) {
	$recent_travelogue->the_post();
	$recent_highlights[] = $post->ID;
}

if ( $recent_postcard->have_posts() ) {
	$recent_postcard->the_post();
	$recent_highlights[] = $post->ID;
}

$recent_postcard->rewind_posts();
$recent_travelogue->rewind_posts();

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-header primary-section pattern-3">
			<div class="section-header-content">
				<h1>Stories</h1>

				<?php
				$page = get_page_by_title( 'Blog' );
				$excerpt = $page->post_excerpt;
				?>
				<?php echo apply_filters( 'the_content', $excerpt ); ?>
			</div>
		</section>

		<div class="blog-wrap">

			<section>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( ! in_array( $post->ID, $recent_highlights ) ) : ?>

						<?php get_template_part( 'partials/content', 'blog' ) ?>

					<?php endif; ?>

				<?php endwhile; ?>

				<?php echo paginate_links(); ?>

			<?php else : ?>

				<p>Nothing found</p>

			<?php endif; ?>

			</section>

			<aside class="sidebar">

				<div class="search-widget">
					
					<input type="search" placeholder="Search Blog">

					<h3>Explore by Traveler</h3>

					<button class="btn btn-success">middle school</button>
					<button class="btn btn-success">high school</button>
					<button class="btn btn-success">university</button>
					<button class="btn btn-success">performing arts</button>
					<button class="btn btn-success">sports</button>

					<h3>Explore by Destination</h3>

					<button class="btn btn-success">middle school</button>
					<button class="btn btn-success">high school</button>
					<button class="btn btn-success">university</button>
					<button class="btn btn-success">performing arts</button>
					<button class="btn btn-success">sports</button>

					<h3>Explore by Program</h3>

					<button class="btn btn-success">middle school</button>
					<button class="btn btn-success">high school</button>
					<button class="btn btn-success">university</button>
					<button class="btn btn-success">performing arts</button>
					<button class="btn btn-success">sports</button>

				</div>
				
				<?php if ( $recent_postcard->have_posts() ) : ?>

					<?php while ( $recent_postcard->have_posts() ) : $recent_postcard->the_post(); ?>

						<?php get_template_part( 'partials/content', 'blog-sidebar' ); echo '!!'; ?>

					<?php endwhile; ?>

				<?php endif; ?>

				<?php if ( $recent_travelogue->have_posts() ) : ?>

					<?php while ( $recent_travelogue->have_posts() ) : $recent_travelogue->the_post(); ?>

						<?php get_template_part( 'partials/content', 'blog-sidebar' ) ?>

					<?php endwhile; ?>

				<?php endif; ?>

			</aside>

		</div>

		<section class="clearfix ws-container learn-more">
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

	</main>
</div>

<?php get_footer(); ?>
