<?php
/**
 * Template Name: Contact
 *
 * This is the general template for the contact page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="primary-section">
			<header class="section-header pattern-3">
				<div class="section-header-content">
					<h1><?php the_title(); ?></h1>
				</div>
			</header>
		</section>

		<?php the_post(); ?>
		<div class="contact-wrap">

			<section class="do-you-have-a-question">
				<div class="content">
					<?php the_content(); ?>
				</div>
			</section>
		
			<?php 
			$contact_sections = get_post_meta( $post->ID, 'contact_fields_sections', true );
			foreach ( $contact_sections as $section ) : ?>

				<?php
					if ( array_key_exists( 'contact_fields_section_title', $section ) ) {
						$title_clean = str_replace( array('?','!','$','*','&','(',')','%','#','@','\'','"',':', '.'), '', $section['contact_fields_section_title']);
						$section_slug = strtolower( str_replace( array(' '), '-', $title_clean) );
					} else {
						$section_slug = 'other';
					}
				?>

				<section class="<?php echo esc_attr( $section_slug ); ?> contact-section">
					<?php if ( array_key_exists( 'contact_fields_section_title', $section ) ) { ?>
						<h2 class="ws-container pattern-1"><?php echo $section['contact_fields_section_title']; ?></h2>
					<?php } ?>
					<div class="section-content ws-container">
						<?php echo apply_filters( 'the_content', $section['contact_fields_section_content'] ); ?>
					</div>
				</section>

			<?php endforeach; ?>
		
		</div>

		<?php get_template_part( 'partials/module', 'discover-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
