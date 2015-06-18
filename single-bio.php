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

				<article <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="headshot">
								<?php // @todo replace this with specific image size when ready (differentiate between single/page) ?>
								<?php the_post_thumbnail( 'large' ); ?>
							</div>
						<?php endif; ?>

						<h3 class="entry-title">
							<?php the_title(); ?>
						</h3>

						<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>
						<?php if ( $position ) : ?>
							<span class="entry-position"><?php echo esc_html( $position ); ?></span>
						<?php endif; ?>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<footer class="entry-footer">
						<?php // @todo should 'back to leadership/category' link go here? ?>
					</footer>
				</article>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		<?php get_template_part( 'partials/module', 'discovery-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
