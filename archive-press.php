<?php
/**
 * Template for the About - Press page
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<H3>This is the press archive/home page</H3>

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php // @todo probably want press content module ?>
				<?php get_template_part( 'partials/content', 'about' ) ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
