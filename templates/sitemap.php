<?php
/**
 * Template Name: Sitemap
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="primary-section">
				<header class="section-header pattern-6">
					<div class="section-header-content">
						<h1><?php the_title(); ?></h1>
						<p class="description"><?php the_content(); ?></p>
					</div>
				</header>
				<nav class="section-nav">
					<ul class="section-menu hide-print">
						<li><a href="#sitemap-explore">Explore</a></li>
						<li><a href="#sitemap-stories">Stories</a></li>
						<li><a href="#sitemap-resource-center">Resource Center</a></li>
						<li><a href="#sitemap-about">About</a></li>
					</ul>
					<a href="<?php echo esc_url( home_url( '/why-worldstrides/' ) ); ?>" class="btn btn-info subnav-cta hide-print">Why Worldstrides »</a>
				</nav>
			</section>

			<section class="section-content">
				<?php the_post(); ?>

				<section class="sitemap-section sitemap-explore" id="sitemap-explore">
					<header>
						<h2>Explore</h2>
						<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>" class="btn btn-primary hide-print">Explore Our Trips »</a>
					</header>

					<h4>Middle School</h4>

					<ul class="list-unstyled">
						<?php
							$count = 0;
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
							$post_count = count( $posts->posts );
							$posts_per_col = intval( $post_count / 3 );
						?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>
					</ul>

					<h4>High School</h4>

					<ul class="list-unstyled">

						<?php
						$count = 0;
						$posts = new WP_Query( array(
							'post_type' => 'itinerary',
							'tax_query' => array(
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
						$post_count = count( $posts->posts );
						$posts_per_col = intval( $post_count / 3 ); ?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>
					</ul>

					<h4>University</h4>

					<ul class="list-unstyled">

						<?php
						$count = 0;
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
						$post_count = count( $posts->posts );
						$posts_per_col = intval( $post_count / 3 ); ?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>

					</ul>

					<h4>Performing Arts</h4>

					<ul class="list-unstyled">
						<?php
						$count = 0;
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
						$post_count = count( $posts->posts );
						$posts_per_col = intval( $post_count / 3 ); ?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>
					</ul>
				</section>

				<section class="sitemap-section sitemap-stories" id="sitemap-stories">
					<header>
						<h2>Stories</h2>
						<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn btn-primary hide-print">Read Our Stories »</a>
					</header>
					<ul class="list-unstyled">
						<?php
						$count = 0;
						$posts = new WP_Query( array(

							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false
						));
						$post_count = count( $posts->posts );
						$posts_per_col = intval( $post_count / 3 ); ?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>
					</ul>
				</section>

				<section class="sitemap-section sitemap-resource-center" id="sitemap-resource-center">
					<header>
						<h2>Resource Center</h2>
						<a href="<?php echo esc_url( home_url( '/resource-center/' ) ); ?>" class="btn btn-primary hide-print">Get the answers you're looking for »</a>
					</header>
					<ul class="list-unstyled">
						<?php
						$count = 0;
						$posts = new WP_Query( array(
							'post_type'              => 'resource',
							'posts_per_page'         => -1,
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false
						));
						$post_count = count( $posts->posts );
						$posts_per_col = intval( $post_count / 3 ); ?>

						<div class="column">
						<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<?php if ( $count == $posts_per_col ) {
								echo '</div><div class="column">';
								$count = 0;
								} ?>
							<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>

						<?php $count++; endwhile; ?>
						</div>
					</ul>
				</section>

				<section class="sitemap-section sitemap-about" id="sitemap-about">
					<header>
						<h2>About</h2>
						<a href="<?php echo esc_url( home_url( '/about/history' ) ); ?>" class="btn btn-primary hide-print">Discover who we are »</a>
					</header>
					<ul class="list-unstyled">
						<div class="column">
							<li><a href="<?php echo esc_url( home_url( '/about/history/' ) ); ?>">History</a></li>
							<li><a href="<?php echo esc_url( home_url( '/about/partnerships/' ) ); ?>">Partnerships</a></li>
							<li><a href="<?php echo esc_url( home_url( '/about/careers/' ) ); ?>">Careers</a></li>
							<li><a href="<?php echo esc_url( home_url( '/about/offices/' ) ); ?>">Offices</a></li>
						</div>
						<div class="column">
							<li>
								<a href="<?php echo esc_url( home_url( '/about/leadership/' ) ); ?>">Leadership</a>
								<ul class="list-unstyled">
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

									while ( $leadership_bios->have_posts() ) : $leadership_bios->the_post(); ?>
										<li><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
								</ul>
							</li>
						</div>
						<div class="column">
							
							<li>
								<a href="<?php echo esc_url( home_url( '/about/press/' ) ); ?>">Press Center</a>
								<ul class="list-unstyled">
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
						</div>
					</ul>
				</section>

				<section class="sitemap-section sitemap-utility">

					<header>
						<h2>More...</h2>
					</header>

					<ul class="list-unstyled">
						<div class="column">
							<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
							<li><a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Register</a></li>
							<li><a href="<?php echo esc_url( home_url( '/make-a-payment/' ) ); ?>">Make a payment</a></li>
							<li><a href="http://mytrip.worldstrides.org/login.xml">MyTrip login</a></li>
						</div><div class="column">
							<li><a href="<?php echo esc_url( home_url( '/legal-policy/' ) ); ?>">Legal Policy</a></li>
							<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
							<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms and Conditions</a></li>
						</div>
					</ul>

				</section>

			</section>

		</main>
	</div>

<?php get_footer();