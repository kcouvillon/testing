<?php
/**
 * Template Name: About - Offices
 *
 * This is the template for the Offices page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>

		<div class="about-wrap">

			<section class="about section-content">
				<?php get_template_part( 'partials/content', 'about' ) ?>

				<?php $offices = get_post_meta( $post->ID, 'about_offices_list', true ); ?>

				<?php foreach ( $offices as $office ) : ?>

				<section class="office">
					<h3 class="office-title">
						<?php echo $office['location']; ?>
						<?php if ( array_key_exists( 'location_extra', $office ) ) : ?><span><?php echo $office['location_extra']; ?></span><?php endif; ?>
					</h3>

					<?php
					if ( array_key_exists( 'image', $office ) ) {
						$image_url = $office['image'];
					} else {
						$image_url = 'http://placehold.it/375x271';
					}
					?>
					<img class="office-img" src="<?php echo esc_url( $image_url ); ?>" alt="">

					<p class="office-content"><?php echo wptexturize( $office['description'] ); ?>.</p>
					<div class="office-address">
						<p><strong>Office Address</strong></p>
						<?php echo apply_filters( 'the_content', $office['address'] ); ?>
						<small>For trackable correspondence, such as UPS and FedEx, only</small>
					</div>
					<div class="office-address mailing-address">
						<p><strong>Express Mail Address</strong></p>
						<?php echo apply_filters( 'the_content', $office['mail_address'] ); ?>
						<small>For all correspondence, such as US Postal Service<br><span>Please note: P.O. boxes cannot accept expedited or overnight shipments via UPS or FedEx.</span></small>
					</div>
				</section>

				<?php endforeach; ?>

				<section class="international-programs">
					<h3>International Programs</h3>

					<?php $programs = get_post_meta( $post->ID, 'about_offices_program_list', true ); ?>

					<?php foreach ( $programs as $program ) : ?>
					<div class="program">
						<p><strong><?php echo apply_filters( 'the_title', $program['title'] ); ?></strong></p>
						<?php echo apply_filters( 'the_content', $program['phone'] ); ?>
						<?php echo apply_filters( 'the_content', $program['address'] ); ?>
					</div>
					<?php endforeach; ?>
				</section>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>
		<!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
