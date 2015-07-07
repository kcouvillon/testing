<?php
/**
 * Template Name: Payment
 *
 * This is the general template for the Make a Payment page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/payment', 'header' ); ?>

		<?php the_post(); ?>

		<section class="register section-content">

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
		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
