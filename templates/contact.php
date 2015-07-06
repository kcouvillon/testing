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
			<header class="section-header resources-header">
				<div class="section-header-content">
					<h1><?php the_title(); ?></h1>
				</div>
			</header>
		</section>

		<?php the_post(); ?>
		<div class="contact-wrap">

			<section class="contact section-content">
				<?php the_content(); ?>
			</section>

		</div><!-- .about-wrap -->

		<footer class="about-footer">
			<div class="about-footer-cta">
				<span class="h2">Discover why 2 million travelers choose to travel with WorldStrides each year</span>
				<button class="btn btn-primary">Discover Why</button>
			</div>
			<div class="about-footer-img">

			</div>
		</footer>

	</main>
</div>

<?php get_footer(); ?>
