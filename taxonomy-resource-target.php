<?php
/**
 * Template for the blog categories
 */

 get_header();

 $title = get_queried_object()->name;
 ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'tax-header' ); ?>

		<section class="section-resource-questions">


		<?php if ( have_posts() ) : ?>

			<?php
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			
			if( $term->parent > 0 ) : ?>

				<h2>Questions for <?php echo $title; ?></h2>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'partials/resources', 'questions' ); ?>

				<?php endwhile; ?>

			<?php else : ?>
				
				<?php get_template_part( 'partials/resources', 'child-terms-list' ); ?>

			<?php endif; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
