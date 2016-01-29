<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

$recent_highlights = WS_Helpers::get_blog_sidebar_posts();

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-header primary-section pattern-3">
			<div class="ws-container">
				<div class="section-header-content">
					<?php $category = get_category_by_slug( get_query_var('category_name') ); ?>
					<h1><?php echo $category->name; ?> Stories</h1>
				</div>
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

				<?php get_template_part( 'partials/content-blog-sidebar-search-tags' ); ?>



			</aside>

		</div>

	</main>
</div>

<?php get_footer(); ?>
