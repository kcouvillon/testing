<?php
/**
 * Template for the bio profiles, to make it look like About
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>


		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<section <?php post_class( 'section-content bio' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="headshot-hero">
							<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
						</div>
					<?php endif; ?>

					<div class="entry-content">

						<h3 class="entry-title">
							<?php the_title(); ?>
						</h3>

						<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>
						<?php if ( $position ) : ?>
							<span class="entry-position"><?php echo esc_html( $position ); ?></span>
						<?php endif; ?>

						<?php the_content(); ?>

						<footer class="entry-footer">
							<a href="<?php echo esc_url( home_url( '/about/leadership/' ) ); ?>">Back to Leadership</a>
						</footer>
						
					</div>

				</section>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		<?php get_template_part( 'partials/module', 'discovery-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
