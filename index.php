<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

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

					<?php get_template_part( 'partials/content', 'blog' ) ?>

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

				<?php // we need to find out where these posts should come from ?>
				
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'partials/content', 'blog-sidebar' ) ?>

					<?php endwhile; ?>

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

			</aside>

		</div>

	</main>
</div>

<?php get_footer(); ?>
