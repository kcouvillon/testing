<?php
/**
 * The template for the home page (/) of the site
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section id="intro" class="home-section primary-section" style="background-image:linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(<?php echo wp_get_attachment_url(219); ?>)">
		
			<div class="intro-content">
				<h1 class="page-title">Travel with the World’s Leading Educational Tour Provider</h1>
				<h4 class="page-subtitle">Only WorldStrides creates immersive educational programs that uniquely meet the needs and interests of students at every stage of their development.</h4>
				<a href="#" class="btn btn-primary">Why Worldstrides?</a>
			</div>

		</section>

		<section class="home-section programs">
			<div class="ws-container">
				<h2 class="section-title">Our Educational Travel Opportunities</h2 class="section-title">
				<ul class="programs-list list-unstyled clearfix">
					<?php 
					$count = 0;
					$data = array(
						array(
							"title" => "Middle School",
							"meta" => array("Discoveries Programs")
						),
						array(
							"title" => "High School",
							"meta" => array("Passages Programs")
						),
						array(
							"title" => "University",
							"meta" => array("Capstone Programs")
						),
						array(
							"title" => "Performing Arts",
							"meta" => array("On Stage Programs")
						),
					);
					foreach ( $data as $item ) : ?>

					<?php $pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif'; ?>
					<li class="program tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
						<div class="tile-content">
							<ul class="meta list-unstyled">
								<?php foreach ( $item['meta'] as $meta ) : ?>
								<li><a href="#"><?php echo $meta; ?></a></li>
								<?php endforeach; ?>
							</ul>
							<h2 class="tile-title"><a href="#"><?php echo $item['title']; ?></a></h2>
						</div>
					</li>
					
					<?php $count++; endforeach; ?>
				</ul>
				
			</div>
		</section>

		<section class="home-section itineraries">
			<div class="ws-container">
				<h2 class="section-title">A Selection of our Tours and Programs</h2 class="section-title">
			</div>
			<ul class="itineraries-list list-unstyled clearfix">
				
				<?php 	
					$count = 0;
					$data = array(
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Collection Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Collection Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						),
						array(
							"title" => "Itinerary Title",
							"meta" => array("Traveler", "Destination")
						)
					);

					foreach ( $data as $item ) :

					$pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern5.gif' : 'ws_w_pattern8.gif';
					if ( $item['title'] == 'Collection Title' ) {
						$tileSize = 'tile-half';
						$pattern = 'ws_w_pattern4.gif';
					} else {
						$tileSize = 'tile-third';
					}
				?>

				<li class="itinerary tile <?php echo $tileSize; ?>" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
					<div class="tile-content">
						<ul class="meta list-unstyled">
							<?php foreach ( $item['meta'] as $meta ) : ?>
							<li><a href="#"><?php echo $meta; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<h2 class="tile-title"><a href="#"><?php echo $item['title']; ?></a></h2>
					</div>
				</li>

				<?php 
					$count++; 
					endforeach; 
				?>

			</ul>
		</section>

		<section class="home-section resources">
			<div class="ws-container">
				<h2 class="section-title">Have Questions? We Have Answers.</h2 class="section-title">
				<ul class="resources-list list-unstyled clearfix">
					
					<?php 
						$count = 0;
						$data = array(
							array(
								"title" => "Resource Title",
								"meta" => array("Parents")
							),
							array(
								"title" => "Resource Title",
								"meta" => array("Educators")
							),
							array(
								"title" => "Resource Title",
								"meta" => array("Students")
							)
						);

						foreach ( $data as $item ) :
						$pattern = ( $count % 2 == 0 ) ? 'ws_w_pattern1.gif' : 'ws_w_pattern2.gif'; 
					?>

					<li class="resource tile tile-third" style="background-image:url(<?php echo esc_url( get_template_directory_uri().'/assets/images/src/patterns/'.$pattern ); ?>);">
						<div class="tile-content">
							<ul class="meta list-unstyled">
								<?php foreach ( $item['meta'] as $meta ) : ?>
								<li><a href="#"><?php echo $meta; ?></a></li>
								<?php endforeach; ?>
							</ul>
							<h2 class="tile-title"><a href="#"><?php echo $item['title']; ?></a></h2>
						</div>
					</li>
					
					<?php 
						$count++; 
						endforeach; 
					?>

				</ul>
			</div>
		</section>

		<section class="home-section learn-more clearfix">
			<div class="ws-container">
				<form action="#" class="ws-form">
					<div class="left">
						<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
						<ul class="form-fields list-unstyled">
							<li class="field">
								I am an
								<select name="name">
									<option value="">Educator</option>
									<option value="">Parent</option>
									<option value="">Student</option>
								</select>
							</li>
							<li class="field">
								Interested in
								<select name="name">
									<option value="">Middle School Travel</option>
									<option value="">High School Travel</option>
									<option value="">University Travel</option>
								</select>
							</li>
							<li class="field">
								Do you have a tour scheduled?
								&nbsp;&nbsp;
								<input type="radio" name="tour" id="tour-yes" value="yes" />
								<label for="tour-yes">Yes</label>
								&nbsp;
								<input type="radio" name="tour" id="tour-no" value="no" />
								<label for="tour-no">No</label>
							</li>
						</ul>
					</div>
					<div class="right">
						<ul class="form-fields list-unstyled">
							<li class="field field-complex">
								<div class="field-left">
									<input type="text" name="first_name" value="" placeholder="First Name" />
								</div>
								<div class="field-right">
									<input type="text" name="last_name" value="" placeholder="Last Name" />
								</div>
							</li>
							<li class="field">
								<input type="email" name="email" value="" placeholder="Email Address" />
							</li>
							<li class="field">
								<input type="tel" name="phone" value="" placeholder="Phone Number" />
							</li>
							<li class="field">
								<input type="text" name="group_name" value="" placeholder="School or Group Name" />
							</li>
						</ul>
						<input type="submit" name="" value="Get Info" class="btn btn-primary" />
					</div>
				</form>
			</div>
		</section>

		<section class="home-section blog">
			<div class="ws-container">
				<h2 class="section-title">Latest Stories from the WorldStrides Blog</h2 class="section-title">
			</div>

			<div class="blog-wrap">

				<section>

				<?php $args = array( 'post_type' => 'post', 'posts_per_page' => 1 );
				$blogPosts = new WP_Query($args); ?>
				<?php if ( $blogPosts->have_posts() ) : ?>

					<?php while ( $blogPosts->have_posts() ) : $blogPosts->the_post(); ?>

						<?php get_template_part( 'partials/content', 'blog' ) ?>

					<?php endwhile; ?>

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

				</section>

				<aside class="sidebar">
					
					<?php $args = array( 'post_type' => 'post', 'posts_per_page' => 2, 'offset' => 1 );
					$blogPosts = new WP_Query($args); ?>
					<?php if ( $blogPosts->have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while ( $blogPosts->have_posts() ) : $blogPosts->the_post(); ?>

							<?php get_template_part( 'partials/content', 'blog-sidebar' ) ?>

						<?php endwhile; ?>

					<?php else : ?>

						<p>Nothing found</p>

					<?php endif; ?>

				</aside>

			</div>

		</section>

	</main>
</div>

<?php get_footer(); ?>
