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
		
			<section class="contact section-content-left">
				<?php the_content(); ?>
			</section>
			
			<section class="contact section-content-right">
				<?php echo apply_filters( 'the_content', get_post_meta( $post->ID, 'contact_column_2', true) ); ?>	
			</section>
		
		</div>

		<?php get_template_part( 'partials/module', 'discover-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
