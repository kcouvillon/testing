<?php
/*
Template Name: Form Page
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main blog" role="main">

		<section class="section-content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; endif; ?>

		</section>

	</main>
</div>

<?php get_footer(); ?>
