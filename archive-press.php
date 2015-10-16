<?php
/**
 * Template for the About - Press page
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<div class="about-wrap">
			<section class="about section-content">

				<h1 class="h2">Press Center</h1>

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'partials/content', 'about' ) ?>

					<?php endwhile; ?>

					<?php echo paginate_links(); ?>

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>

	</main>
</div>

<?php get_footer(); ?>
