<?php
/**
 * Template Name: About - Partnerships
 *
 * This is the general template for the about page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>
		<div class="about-wrap">

			<section class="about partnerships section-content">

				<?php get_template_part( 'partials/content', 'about' ); ?>

				<?php for ( $i = 1; $i < 8; $i++ ) : ?>
					<?php
					$section_title = get_post_meta( $post->ID, 'about_partnerships_section_'. $i .'_title', true );
					$section_partners = get_post_meta( $post->ID, 'about_partnerships_section_'. $i .'_partners', true );
					$section_notes    = get_post_meta( $post->ID, 'about_partnerships_section_'. $i .'_notes', true );
					?>
					<?php if ( $section_title ) : ?>
						<section class="partners accreditation">

							<h3><?php echo apply_filters( 'the_title', $section_title ); ?></h3>

							<div class="partner-wrap">
								<?php foreach ( $section_partners as $partner ) : ?>
									<?php
									if ( array_key_exists( 'image', $partner ) ) {
										$partner_image = $partner['image'];
									} else {
										$partner_image = '';
									}
									?>
									<div class="partner">
										<?php if ( $partner_image ) : ?>
											<a href="<?php echo $partner['url']; ?>" target="_blank"><img class="partner-img" src="<?php echo esc_url( $partner_image ); ?>" alt=""></a>
										<?php endif; ?>
										<a href="<?php echo $partner['url']; ?>" class="partner-title" target="_blank"><?php echo apply_filters( 'the_title', $partner['title'] ); ?></a>
									</div>
								<?php endforeach; ?>
							</div>
							<?php if ( $section_notes ) : ?>
								<p class="footnote"><?php echo esc_html( $section_notes ); ?></p>
							<?php endif; ?>
						</section>
					<?php endif; ?>
				<?php endfor; ?>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>
		<!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
