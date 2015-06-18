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

		<section class="section-content leadership">
			<?php $associated_bios = get_post_meta( $post->ID, 'ws_attached_leadership_bios', true ); ?>

			<?php if ( 0 == count( $associated_bios ) ) : ?>
				<p>No leadership bios found.</p>
			<?php endif; ?>

			<?php foreach ( $associated_bios as $bio ) : ?>

				<?php $post = get_post( $bio ); print_r($bio);?>

				<article <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="headshot">
								<?php // @todo replace this with specific image size when ready (differentiate between single/page) ?>
								<?php the_post_thumbnail( 'large' ); ?>
							</div>
						<?php endif; ?>

						<h3 class="entry-title">
							<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h3>

						<?php if ( $position ) : ?>
							<span class="entry-position"><?php echo esc_html( $position ); ?></span>
						<?php endif; ?>
					</header>

					<div class="entry-content">
						<?php if ( is_page('about') ) : ?>
							<?php the_content($bio->post_id); ?>
						<?php else : ?>
							<?php the_excerpt($bio->post_id); ?>
						<?php endif; ?>
					</div>

					<footer class="entry-footer">
						<?php if ( is_page('about') ) : ?>
							<?php // @todo should 'back to leadership/category' link go here? ?>
						<?php else : ?>
							<a href="<?php the_permalink(); ?>">Read More</a>
						<?php endif; ?>
					</footer>
				</article>

			<?php endforeach; ?>
		</section>

	</main>
</div>

<?php get_footer(); ?>
