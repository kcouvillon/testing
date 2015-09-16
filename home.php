<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-header primary-section pattern-3">
			<div class="ws-container">
				<div class="section-header-content">
					<h1>Stories</h1>

					<?php
					$page = get_page_by_title( 'Blog' );
					$excerpt = $page->post_excerpt;
					?>
					<?php echo apply_filters( 'the_content', $excerpt ); ?>
				</div>
			</div>
		</section>

		<div class="blog-wrap">

			<section>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'partials/content', 'blog' ) ?>

				<?php endwhile; ?>

				<?php echo paginate_links(); ?>

			<?php else : ?>

				<p>Nothing found</p>

			<?php endif; ?>

			</section>

			<aside class="sidebar">

				<?php get_template_part( 'partials/content-blog-sidebar-search-tags' ); ?>

			</aside>

		</div>

		<section class="clearfix ws-container learn-more">
			<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>

			<?php WS_Marketo::get_marketo_form( $post->ID ); ?>
		</section>

	</main>
</div>

<?php get_footer(); ?>
