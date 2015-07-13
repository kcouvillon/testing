<?php
/**
 * Terminal layout for Collections
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main collection" role="main">

		<?php the_post(); ?>

		<?php
		$anchor = 0;

		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $featured[0] . ')';
		} ?>
		<section class="primary-section">
			<header class="section-header pattern-<?php echo rand( 1, 9 ); ?>" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">
					<nav class="breadcrumbs">
						<a href="<?php echo esc_url( home_url( '/explore' ) ); ?>">Explore</a>>
						<a href="<?php echo esc_url( home_url( '/collections' ) ); ?>">Collections</a>>
						<span><?php the_title(); ?></span>
					</nav>
					<h1><?php the_title(); ?></h1>

					<?php the_content(); ?>
				</div>
			</header>

			<nav class="section-nav">
				<ul class="section-menu">
					<li>[TBD]</li>
					<li><a href="#tour-highlights">Tour Highlights</a></li>
					<li><a href="#education">Education</a></li>
					<li><a href="#itinerary">Itinerary</a></li>
					<li><a href="#resources">Resources</a></li>
				</ul>
			</nav>

		</section>

		<h2 class="section-content">Title</h2>
		<a name="#anchor-<?php $anchor++; echo $anchor; ?>"></a>

		<section class="section-content why-content">

			<?php $associated_why_ws = get_post_meta( $post->ID, 'attached_why_ws', true) ; ?>

			<?php if ( 0 == count( $associated_why_ws ) ) : ?>
				<p>Nothing found.</p>
			<?php endif; ?>

			<?php foreach ( $associated_why_ws as $why_ws ) : ?>

				<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

			<?php endforeach; ?>

		</section>

		<?php get_template_part( 'partials/module', 'discover-why' ); ?>

		<section class="section-content resources">
				<h2 class="section-title">Have Questions? We Have Answers.</h2>
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
		</section>

		<section class="section-content programs">
			<h2 class="section-title">Our Educational Travel Opportunities</h2>
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

			<a class="program-all-link" href="">See All</a>

		</section>

		<section class="section-content programs">
			<h2 class="section-title">Events</h2>
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

			<a class="program-all-link" href="">See All</a>
				
		</section>

		<section class="home-section blog">
			<div class="ws-container">
				<h2 class="section-title">Latest Stories from the WorldStrides Blog</h2>
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

		<div class="blog-single-cta">
			<span class="h2">Request Information about a WorldStrides {PROGRAM TYPE} Program</span>
			<span>I am a</span>
			<select name="" id="">
				<option value="">Parent</option>
				<option value="">Traveler</option>
				<option value="">Teacher</option>
			</select>
			<button class="btn btn-primary">Get the Info</button>
		</div>

		<section class="info-cta">
			
			<div class="additional-info">
				<h3>Additional Information</h3>
				<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet.</p>
				<button class="btn btn-primary">Request Catalogue</button>
			</div>

			<div class="email-updates">
				<h3>Email Updates About These Tours</h3>
				<p>Interested in learning more? Enter your email address and we’ll share further information, promotions, and other opportunities.</p>
				<form action="">
					<input type="email" placeholder="Email Address">
					<input type="submit" class="btn btn-primary" value="Sign Up">
				</form>
			</div>
		</section>

<?php get_footer(); ?>
