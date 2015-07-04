<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>

		<?php endwhile; endif; ?>

		</section>

	</main>
</div>

<?php get_footer(); ?>
