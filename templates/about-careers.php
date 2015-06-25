<?php
/**
 * Template Name: About - Careers
 *
 * This is the template for the Careers page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>

		<div class="about-wrap">

			<section class="about section-content">
				<?php get_template_part( 'partials/content', 'about' ) ?>
			</section>

			<section class="about section-content">

				<button class="btn btn-primary">View our Current Openings</button>

				<section class="benefits">
					<h3>Benefits of Working at WorldStrides</h3>
					<p>In addition to our fun and inspiring environment, WorldStrides offers a number of benefits for our full-time, year-round staff:</p>

					<div class="benefits-wrap">
						<div class="benefit">
							<img class="benefit-img" src="http://placehold.it/80x80" alt="">
							<span class="benefit-desc">Employee and family discounts on WorldStrides travel programs</span>
						</div>
					</div>
				</section>

				<section class="career-examples">
					<h3>Learn what you can do at WorldStrides</h3>
					<p>WorldStrides offers a variety of careers in Marketing, Sales, Account Management, Customer Service, Finance, and Human Resources. Meet some of our team members and learn what their roles entail.</p>

					<div class="example-wrap">
						<article class="example">
							<div class="headshot">
								<img src="http://placehold.it/385x250" alt="">
							</div>
							<header class="entry-title">
								<h3 class="entry-name">Person Name</h3>
								<span class="entry-desc">Person Job Description</span>
							</header>
							<div class="entry-content">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quibusdam error iure eos. Cum, libero doloribus id temporibus ex dicta suscipit voluptatum sed quasi ratione consequuntur et, quis repellendus ipsa!</p>
							</div>
						</article>
					</div>
				</section>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>
		<!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
