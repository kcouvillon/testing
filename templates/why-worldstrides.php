<?php
/**
 * Template Name: Why WorldStrides
 *
 * Template for the Why WorldStrides page
 *
 * @todo figure out where the various content pieces are being stored
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php the_post(); ?>
		<?php get_template_part( 'partials/content', 'why' ) ?>


	</main>
</div>

<?php get_footer(); ?>
