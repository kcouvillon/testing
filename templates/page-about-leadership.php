<?php
/**
 * Template Name: About - Leadership
 *
 * The template for the Leadership page
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>

		<?php get_template_part( 'partials/content', 'about' ) ?>

		<?php
			// @todo limit this to just leadership
			$leadership_bios = new WP_Query( array(
				'post_type' => 'bio',
				'tax_query' => array(
					array(
						'taxonomy' => 'role',
						'field'    => 'slug',
						'terms'    => 'leadership',
					),
				),
			));
		?>

		<div class="leadership">
			<?php if ( $leadership_bios->have_posts() ) : ?>

				<?php while ( $leadership_bios->have_posts() ) : $leadership_bios->the_post(); ?>

					<div class="bio">
						<?php // @todo get featured image ?>
						<header>
							<h2><?php the_title(); ?></h2>
							<h3>Position</h3>
						</header>

						<?php the_content(); ?>
					</div>

				<?php endwhile; ?>

			<?php else : ?>

				<p>No leadership bios found</p>

			<?php endif; ?>
		</div>

	</main>
</div>

<?php get_footer(); ?>
