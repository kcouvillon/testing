<?php
/**
 * Template Name: Contact
 *
 * This is the general template for the contact page. Make sure this page is selected from the template drop down
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

		<?php the_post(); ?>
		<div class="contact-wrap">

			<section class="do-you-have-a-question">
				<div class="content">
					<h3>Do you have a question?</h3>
					<p>Many common questions are listed in our <a href="http://ws.local/resource-center/">Resource Center&nbsp;»</a></p>
				</div>
			</section>
		
			<section class="customer-support contact-section">
				<h2 class="ws-container pattern-1">Customer Support</h2>
				<div class="section-content ws-container">
					<p>For assistance for registration, payments, scholarships, and more.&nbsp;Please note it may take up to 2 business days to respond to your inquiry.</p>
					<div class="columns clearfix">
						<div class="column">
							<h5>Middle &amp; High School Programs</h5>
							<p><a href="#" class="btn btn-primary">Register</a></p>
							<p>
								<a href="tel:800-468-5899">800-468-5899</a><br>
								<a href="mailto:Customerservice@worldstrides.org">Customerservice@worldstrides.org</a>
							</p>
							<p style="max-width: 330px;"><small>
								<strong>To register by fax</strong>, send your completed form to 434-982-8748. <strong>To register by mail</strong>, send your completed registration form to P.O. Box 9033, Charlottesville, VA 22911.
							</small></p>
						</div>
						<div class="column">
							<h5>University Programs</h5>
							<p><a href="" class="btn btn-primary">Register</a></p>
							<p>
								<a href="tel:800-422-2368">800-422-2368</a><br>
								<a href="mailto:capstone@worldstrides.org">capstone@worldstrides.org</a>
							</p>
						</div>
						<div class="column">
							<h5>Performing Programs</h5>
							<p><a href="" class="btn btn-primary">Register</a></p>
							<p><a href="tel:800-651-0468">800-651-0468</a></p>
						</div>
					</div>
				</div>
			</section>

			<section class="emergency contact-section">
				<h2 class="ws-container pattern-2">Emergency?</h2>
				<div class="section-content ws-container">
					<p>Our Tour Central offices can be reached 24 hours a day. Please call this number only in regard to an emergency on a program currently traveling.</p>
					<div class="columns clearfix">
						<div class="column">
							<h5>D.C. Tour Central headquarters</h5>
							<p><a href="tel:800-999-4542">800-999-4542</a></p>
						</div>
						<div class="column">
							<h5>If calling internationally</h5>
							<p><a href="tel:703-933-6143">703-933-6143</a></p>
						</div>
						<div class="column">
							<h5>New York City Tour Central office</h5>
							<p><a href="tel:800-727-8692">800-727-8692</a></p>
						</div>
					</div>
				</div>
			</section>

			<section class="lead-a-program contact-section">
				<h2 class="ws-container pattern-8">Interested in Leading a Travel Program?</h2>
				<div class="section-content ws-container">
					<h5>Submit your information, and a representative will reach out directly.</h5>
					<p><a href="" class="btn btn-primary">Lead a Travel Program</a></p>
				</div>
			</section>

			<section class="other contact-section">
				<div class="section-content ws-container">
					<h3>Press Inquiries?</h3>
					<p><a href="http://ws.local/about/press/" class="btn btn-info">Press Center</a></p>
					<h3>Interested in a Career with WorldStrides?</h3>
					<p><a href="http://ws.local/about/careers/" class="btn btn-info">Career Opportunities</a></p>
				</div>
			</section>
					
		
		</div>

		<?php get_template_part( 'partials/module', 'discover-why' ); ?>

	</main>
</div>

<?php get_footer(); ?>
