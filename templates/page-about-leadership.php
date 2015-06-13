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
				<p>Not leadership bios found.</p>
			<?php endif; ?>

			<?php foreach ( $associated_bios as $bio ) : ?>

				<?php $post = get_post( $bio ); ?>

				<div class="bio">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="headshot">
							<?php // @todo replace this with specific image size when ready ?>
							<?php the_post_thumbnail( 'medium' ); ?>
						</div>
					<?php endif; ?>

					<header>
						<h2><?php the_title(); ?></h2>

						<h3>Position will go here</h3>
					</header>

					<?php the_content(); ?>
				</div>

			<?php endforeach; ?>
		</div>

	</main>
</div>

<?php get_footer(); ?>
