<?php
/**
 * Template Name: Sitemap
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

			<section class="section-content">
				<?php the_post(); ?>

				<?php the_content(); ?>

				<section>
					<h2><a href="">Explore</a></h2>

					<ul>
						<h3>Middle School</h3>
						<li>All the collections</li>
					</ul>

					<ul>
						<h3>High School</h3>
						<li>All the collections</li>
					</ul>

					<ul>
						<h3>University</h3>
						<li>All the collections</li>
					</ul>

					<ul>
						<h3>Performing Arts</h3>
						<li>All the collections</li>
					</ul>
				</section>

				<section>
					<h2><a href="">Why WorldStrides</a></h2>
				</section>

				<section>
					<h2><a href="">Stories</a></h2>
					<ul>
						<li>All the stories?</li>
					</ul>
				</section>

				<section>
					<h2>Resource Center</h2>
					<ul>
						<li>All the targets</li>
					</ul>
				</section>

				<section>
					<h2>About</h2>
					<ul>
						<li>Pages + bios under leadership</li>
					</ul>
				</section>

				<ul>
					<li>Contact Us</li>
					<li>Register</li>
					<li>Make a payment</li>
					<li>MyTrip login</li>
				</ul>

				<ul>
					<li>Legal Policy</li>
					<li>Privacy Policy</li>
					<li>Terms and Conditions</li>
				</ul>

			</section>

		</main>
	</div>

<?php get_footer();