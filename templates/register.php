<?php
/**
 * Template Name: Payment
 *
 * This is the general template for the Make a Payment page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area register-and-payment register">
	<main id="main" class="site-main" role="main">

		<section class="primary-section">
			<header class="section-header pattern-3">
				<div class="section-header-content">
					<h1 class="section-title"><?php the_title(); ?></h1>

					<div class="description">
						<?php the_content(); ?>
					</div>
				</div>
			</header>
		</section>

		<?php the_post(); ?>

		<div class="ws-container">

			<section class="section-content">

				<form class="ws-form">
					
					<ul class="fields list-unstyled">
						<li>
							<label for="payment-first-name">First Name</label>
							<input type="name" class="payment-field first-name" name="first_name" id="payment-first-name">
						</li>
						<li>
							<label for="payment-last-name">Last Name</label>
							<input type="name" class="payment-field last-name" name="last_name" id="payment-last-name">
						</li>
						<li>
							<label for="payment-trip-id">Trip ID</label>
							<input type="text" class="payment-field trip-id" name="trip_id" id="payment-trip-id">
							<span class="help-text">Don’t know your trip ID? Call customer service <a href="tel://555-555-5555">555-555-5555</a></span>
						</li>
					</ul>

					<footer>
						<input type="submit" value="Submit" class="btn btn-primary">
					</footer>

				</form>

				<div style="display: none;">
					<h2>Choose from one of the options below</h2>
					<ul class="programs-list list-unstyled">
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

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>

	</main>
</div>

<?php get_footer(); ?>
