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

		<div class="leadership">
			<?php $associated_bios = get_post_meta( $post->ID, 'ws_attached_leadership_bios', true ); ?>

			<?php if ( 0 == count( $associated_bios ) ) : ?>
				<p>No leadership bios found.</p>
			<?php endif; ?>

			<?php foreach ( $associated_bios as $bio ) : ?>

				<?php $post = get_post( $bio ); ?>

				<?php get_template_part( 'partials/content', 'bio' ); ?>

			<?php endforeach; ?>
		</div>

	</main>
</div>

<?php get_footer(); ?>
