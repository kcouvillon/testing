<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

$recent_highlights = WS_Helpers::get_blog_sidebar_posts();

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="search-header">
			
			<form role="search" method="get" class="search-results-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<i class="icon icon-search"></i>
				<input type="search" class="search-field" placeholder="<?php the_search_query(); ?>" value="" name="s" title="Search for:">
				<div class="search-options">
					<span>All of WorldStrides</span>
					<input type="radio" name="search-option" class="search-radio" value="all">
					<span>Stories</span>
					<input type="radio" name="search-option" class="search-radio" value="stories" checked="checked">
				</div>
			</form>
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

				<span class="h3">Sorry, we couldn't find anything. Try another search term or use the Explore links.</span>

			<?php endif; ?>

			</section>

			<?php get_sidebar( 'search' ); ?>

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
