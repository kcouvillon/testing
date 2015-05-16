<?php
/**
 * The main template file
 *
 * @package WorldStrides
 * @since 0.1.0
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<h2><?php the_title(); ?></h2>

				<?php the_content(); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

 <?php get_footer(); ?>
