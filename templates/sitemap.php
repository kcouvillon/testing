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

						<?php
							$posts = new WP_Query( array(
								'post_type' => 'itinerary',
								'tax_query'              => array(
									array(
										'taxonomy' => 'product-line',
										'field'    => 'slug',
										'terms'    => 'discoveries'
									)
								),
								'posts_per_page'         => -1,
								'no_found_rows'          => true,
								'update_post_term_cache' => false,
								'update_post_meta_cache' => false,
								'order'                  => 'ASC',
								'orderby'                => 'title'
							));

							while ( $posts->have_posts() ) : $posts->the_post();
						?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>

					<ul>
						<h3>High School</h3>

						<?php
						$posts = new WP_Query( array(
							'post_type' => 'itinerary',
							'tax_query'              => array(
								array(
									'taxonomy' => 'product-line',
									'field'    => 'slug',
									'terms'    => 'perspectives'
								)
							),
							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'order'                  => 'ASC',
							'orderby'                => 'title'
						));

						while ( $posts->have_posts() ) : $posts->the_post();
							?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>

					<ul>
						<h3>University</h3>

						<?php
						$posts = new WP_Query( array(
							'post_type' => 'itinerary',
							'tax_query'              => array(
								array(
									'taxonomy' => 'product-line',
									'field'    => 'slug',
									'terms'    => 'capstone'
								)
							),
							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'order'                  => 'ASC',
							'orderby'                => 'title'
						));

						while ( $posts->have_posts() ) : $posts->the_post();
							?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>

					<ul>
						<h3>Performing Arts</h3>
						<?php
						$posts = new WP_Query( array(
							'post_type' => 'itinerary',
							'tax_query'              => array(
								array(
									'taxonomy' => 'product-line',
									'field'    => 'slug',
									'terms'    => 'on-stage'
								)
							),
							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false,
							'order'                  => 'ASC',
							'orderby'                => 'title'
						));

						while ( $posts->have_posts() ) : $posts->the_post();
							?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>
				</section>

				<section>
					<h2><a href="/why-worldstrides/">Why WorldStrides</a></h2>
				</section>

				<section>
					<h2><a href="">Stories</a></h2>
					<ul>
						<?php
						$posts = new WP_Query( array(

							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false
						));

						while ( $posts->have_posts() ) : $posts->the_post();
							?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>
				</section>

				<section>
					<h2>Resource Center</h2>
					<ul>
						<?php
						$posts = new WP_Query( array(
							'post_type'              => 'resource',
							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false
						));

						while ( $posts->have_posts() ) : $posts->the_post();
							?>

							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php endwhile; ?>
					</ul>
				</section>

				<section>
					<h2>About</h2>
					<ul>
						<li>Pages + bios under leadership + press</li>
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