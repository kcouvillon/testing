<?php
/**
 * The template for the home page (/) of the site
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section id="intro" class="home-section primary-section" style="background-image:linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(<?php echo wp_get_attachment_url(217); ?>)">
		
			<div class="intro-content">
				<h1>Travel with the World’s Leading Educational Tour Provider</h1>
				<h4>Only WorldStrides creates immersive educational programs that uniquely meet the needs and interests of students at every stage of their development.</h4>
				<a href="#" class="btn">Why Worldstrides?</a>
			</div>

		</section>

		<section class="home-section programs">
			<div class="ws-container">
				<h3>Our Educational Travel Opportunities</h3>
				<ul class="programs-list list-unstyled clearfix">
					<?php 
					$count = 0;
					while ( $count < 5 ) : ?>

					<?php $url = ( $count % 2 == 0 ) ? 'http://placehold.it/600x337' : 'http://placehold.it/600x337/999999/BBBBBB'; ?>
					<li class="program tile tile-third" style="background-image:url(<?php echo $url; ?>);">
						<a href="#">
							<div class="tile-content">
								<div class="tags">Discoveries Programs</div>
								<h4>Middle School</h4>
							</div>
						</a>
					</li>
					
					<?php $count++; endwhile; ?>
				</ul>
				
			</div>
		</section>

		<section class="home-section itineraries">
			<div class="ws-container">
				<h3>A Selection of our Tours and Programs</h3>
			</div>
			<ul class="itineraries-list list-unstyled clearfix">
				
				<?php $count = 0; ?>
				<?php while( $count < 8 ) : ?>
				<?php $url = ( $count % 2 == 0 ) ? 'http://placehold.it/600x337' : 'http://placehold.it/600x337/999999/BBBBBB'; ?>
				<?php $tileSize = ( $count == 3 || $count == 4 ) ? 'tile-half' : 'tile-third'; ?>
				<li class="itinerary tile <?php echo $tileSize; ?>" style="background-image:url(<?php echo $url; ?>);">
					<a href="#">
						<div class="tile-content">
							<div class="tags">High School&nbsp;&nbsp;Individual</div>
							<h4>Oxbridge Academic Programs</h4>
						</div>
					</a>
				</li>
				<?php $count++; endwhile; ?>

			</ul>
		</section>

		<section class="home-section resources">
			<div class="ws-container">
				<h3>Have Questions? We Have Answers.</h3>
				<ul class="resources-list list-unstyled clearfix">
					
					<?php $count = 0; ?>
					<?php while( $count < 3 ) : ?>
					<?php $url = ( $count % 2 == 0 ) ? 'http://placehold.it/600x337' : 'http://placehold.it/600x337/999999/BBBBBB'; ?>
					<li class="resource tile tile-third" style="background-image:url(<?php echo $url; ?>);">
						<a href="#">
							<div class="tile-content">
								<div class="tags">Parents</div>
								<h4>Scholarship Opportunities</h4>
							</div>
						</a>
					</li>
					<?php $count++; endwhile; ?>

				</ul>
			</div>
		</section>

		<section class="home-section learn-more">
			<h3>Ready to Learn More About Traveling with WorldStrides?</h3>
			[form]
		</section>

		<section class="home-section blog">
			<h3>Latest Stories from the WorldStrides Blog</h3>
		</section>

	</main>
</div>

<?php get_footer(); ?>
