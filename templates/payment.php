<?php
/**
 * Template Name: Payment
 *
 * This is the general template for the Make a Payment page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area register-and-payment make-a-payment">
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
							<span class="help-text">Don’t know your trip ID? <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" target="_blank">Call customer service</a></span>
						</li>
					</ul>

					<footer>
						<input type="submit" value="Make a Payment" class="btn btn-primary">
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-info">Contact Worldstrides</a>
					</footer>

				</form>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>

	</main>
</div>

<?php get_footer(); ?>
