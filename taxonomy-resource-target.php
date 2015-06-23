<?php
/**
 * Template for the blog categories
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'tax-header' ); ?>

		<section class="section-resource-questions">

		<?php if ( have_posts() ) : ?>

			<h2>{Static} Questions about Benefits</h2>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/resources', 'questions' ) ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
