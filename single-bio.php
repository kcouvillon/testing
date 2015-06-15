<?php
/**
 * Template for the bio profiles, to make it look like About
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content', 'bio' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		<?php get_template_part( 'partials/module', 'discovery-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
