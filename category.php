<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

$recent_highlights = WS_Helpers::get_blog_sidebar_posts();

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-header primary-section pattern-3">
			<div class="section-header-content">
				<?php $category = get_category_by_slug( get_query_var('category_name') ); ?>
				<h1><?php echo $category->name; ?> Stories</h1>
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

				<?php if ( ! empty( $recent_highlights ) ) : ?>

					<?php foreach( $recent_highlights as $recent_highlight ) : ?>

						<?php $post = get_post( $recent_highlight ); ?>

						<?php get_template_part( 'partials/content', 'blog-sidebar' ); ?>

					<?php endforeach; ?>

					<?php wp_reset_postdata(); ?>

				<?php endif; ?>

			</aside>

		</div>

	</main>
</div>

<?php get_footer(); ?>
