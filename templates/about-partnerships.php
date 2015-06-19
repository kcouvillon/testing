<?php
/**
 * Template Name: About - Partnerships
 *
 * This is the general template for the about page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>
		<div class="about-wrap">

			<section class="about section-content">
				<?php get_template_part( 'partials/content', 'about' ) ?>
			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div><!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
