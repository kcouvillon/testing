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

				<?php the_content(); ?>

				<section class="partners accreditation">
					<?php
					$accreditation_partners = get_post_meta( $post->ID, 'about_partnerships_accreditation_partners', true );
					$accreditation_notes    = get_post_meta( $post->ID, 'about_partnerships_accreditation_notes', true );
					?>

					<h3>Accreditation</h3>

					<div class="partner-wrap">
						<?php foreach ( $accreditation_partners as $partner ) : ?>
							<?php
							if ( array_key_exists( 'image', $partner ) ) {
								$partner_image = $partner['image'];
							} else {
								$partner_image = 'http://placehold.it/82x82';
							}
							?>
							<div class="partner">
								<img class="partner-img" src="<?php echo esc_url( $partner_image ); ?>" alt="">
								<span class="partner-title"><?php echo apply_filters( 'the_title', $partner['title'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
					<?php if ( $accreditation_notes ) : ?>
						<p class="footnote"><?php echo esc_html( $accreditation_notes ); ?></p>
					<?php endif; ?>
				</section>

				<section class="partners education">
					<?php
					$education_partners = get_post_meta( $post->ID, 'about_partnerships_educational-organizations_partners', true );
					$education_notes    = get_post_meta( $post->ID, 'about_partnerships_educational-organizations_notes', true );
					?>

					<h3>Educational Organizations</h3>

					<div class="partner-wrap">
						<?php foreach ( $education_partners as $partner ) : ?>
							<?php
							if ( array_key_exists( 'image', $partner ) ) {
								$partner_image = $partner['image'];
							} else {
								$partner_image = 'http://placehold.it/82x82';
							}
							?>
							<div class="partner">
								<img class="partner-img" src="<?php echo esc_url( $partner_image ); ?>" alt="">
								<span class="partner-title"><?php echo apply_filters( 'the_title', $partner['title'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
					<?php if ( $education_notes ) : ?>
						<p class="footnote"><?php echo esc_html( $education_notes ); ?></p>
					<?php endif; ?>
				</section>

				<section class="partners travel">
					<?php
					$travel_partners = get_post_meta( $post->ID, 'about_partnerships_travel-associations_partners', true );
					$travel_notes    = get_post_meta( $post->ID, 'about_partnerships_travel-associations_notes', true );
					?>

					<h3>Travel Associations</h3>

					<div class="partner-wrap travel">
						<?php foreach ( $travel_partners as $partner ) : ?>
							<?php
							if ( array_key_exists( 'image', $partner ) ) {
								$partner_image = $partner['image'];
							} else {
								$partner_image = 'http://placehold.it/82x82';
							}
							?>
							<div class="partner">
								<img class="partner-img" src="<?php echo esc_url( $partner_image ); ?>" alt="">
								<span class="partner-title"><?php echo apply_filters( 'the_title', $partner['title'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
					<?php if ( $travel_notes ) : ?>
						<p class="footnote"><?php echo esc_html( $travel_notes ); ?></p>
					<?php endif; ?>
				</section>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>
		<!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
