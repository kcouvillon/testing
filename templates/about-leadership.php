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
		
		<section class="section-content leadership-content">
			<?php get_template_part( 'partials/content', 'about' ) ?>
		</section>

		<section class="section-content leadership">
			<?php $associated_bios = get_post_meta( $post->ID, 'ws_attached_leadership_bios', true ); ?>

			<?php if ( 0 == count( $associated_bios ) ) : ?>
				<p>No leadership bios found.</p>
			<?php endif; ?>

			<?php foreach ( $associated_bios as $bio_id ) : ?>

				<?php $bio = get_post( $bio_id ); ?>
				<?php $position = get_post_meta( $bio_id, 'ws_bio_position', true ); ?>

				<article <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail( $bio_id ) ) : ?>
							<div class="headshot">
								<?php // @todo replace this with specific image size when ready (differentiate between single/page) ?>
								<?php echo get_the_post_thumbnail( $bio_id, 'medium' ); ?>
							</div>
						<?php else : ?>
							<div class="headshot-pattern pattern-<?php echo rand(1, 9); ?>">

							</div>
						<?php endif; ?>

						<h3 class="entry-title">
							<a href="<?php echo esc_url( get_permalink( $bio_id ) ); ?>" rel="bookmark">
								<?php echo apply_filters( 'title', $bio->post_title ); ?>
							</a>
						</h3>

						<?php if ( $position ) : ?>
							<span class="entry-position"><?php echo esc_html( $position ); ?></span>
						<?php endif; ?>
					</header>

					<div class="entry-content">
						<?php
						$content = $bio->post_excerpt;
						if ( ! $content ) {
							$content = $bio->post_content;
						}
						?>
						<?php echo apply_filters( 'content', $content ); ?>
					</div>

					<footer class="entry-footer">
						<a href="<?php echo esc_url( get_the_permalink( $bio_id ) ); ?>">Read More</a>
					</footer>
				</article>

			<?php endforeach; ?>
		</section>

	</main>
</div>

<?php get_footer(); ?>
