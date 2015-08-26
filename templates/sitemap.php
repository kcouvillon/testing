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
						<li><a href="<?php echo esc_url( home_url( '/about/history/' ) ); ?>">History</a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/partnerships/' ) ); ?>">Partnerships</a></li>
						<li>
							<a href="<?php echo esc_url( home_url( '/about/leadership/' ) ); ?>">Leadership</a>
							<ul>
								<?php
								$leadership_bios = new WP_Query( array(
									'post_type' => 'bio',
									'tax_query' => array(
										array(
											'taxonomy' => 'role',
											'field'    => 'slug',
											'terms'    => 'leadership',
										),
									),
									'posts_per_page'         => -1,
									'order'                  => 'ASC',
									'orderby'                => 'title',
									'no_found_rows'          => true,
									'update_post_term_cache' => false,
									'update_post_meta_cache' => false
								));

								while ( $leadership_bios->have_posts() ) : $leadership_bios->the_post();
								?>
									<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
							</ul>
						</li>
						<li><a href="<?php echo esc_url( home_url( '/about/careers/' ) ); ?>">Careers</a></li>
						<li>
							<a href="<?php echo esc_url( home_url( '/about/press/' ) ); ?>">Press Center</a>
							<ul>
								<?php
								$press = new WP_Query( array(
									'post_type' => 'press',
									'posts_per_page'         => -1,
									'order'                  => 'ASC',
									'orderby'                => 'title',
									'no_found_rows'          => true,
									'update_post_term_cache' => false,
									'update_post_meta_cache' => false
								));

								while ( $press->have_posts() ) : $press->the_post();
								?>
								<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php endwhile; ?>
							</ul>
						</li>
						<li><a href="<?php echo esc_url( home_url( '/about/offices/' ) ); ?>">Offices</a></li>
					</ul>
				</section>

				<ul>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
					<li><a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Register</a></li>
					<li><a href="<?php echo esc_url( home_url( '/make-a-payment/' ) ); ?>">Make a payment</a></li>
					<li><a href="http://mytrip.worldstrides.org/login.xml">MyTrip login</a></li>
				</ul>

				<ul>
					<li><a href="<?php echo esc_url( home_url( '/legal-policy/' ) ); ?>">Legal Policy</a></li>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms and Conditions</a></li>
				</ul>

			</section>

		</main>
	</div>

<?php get_footer();