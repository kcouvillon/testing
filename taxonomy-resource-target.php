<?php
/**
 * Template for the blog categories
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1>Resource target</h1>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content' ) ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
