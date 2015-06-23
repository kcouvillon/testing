<?php
/**
 * Template Name: Resources
 *
 * Template for the main resources page
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'header' ); ?>

		<?php
			$featured_questions = new WP_Query( array(
				'post_type' => 'resource',
				'tax_query' => array(
					array(
						'taxonomy' => 'resource-target',
						'field'    => 'slug',
						'terms'    => 'featured',
					),
				),
			));
		?>

		<section class="section-resource-questions">

		<?php if ( is_page( 'resource-center' ) ) : ?>

			<h2>Common Questions</h2>

		<?php endif; ?>

		<?php if ( $featured_questions->have_posts() ) : ?>

			<?php while ( $featured_questions->have_posts() ) : $featured_questions->the_post(); ?>

				<?php get_template_part( 'partials/resources', 'questions' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>No featured resources found</p>

		<?php endif; ?>

		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>
	</main>
</div>

<?php get_footer(); ?>
