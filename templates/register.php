<?php
/**
 * Template Name: Register
 *
 * This is the general template for the Make a Payment page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area register-and-payment register">
	<main id="main" class="site-main" role="main">

		<section class="primary-section">
			<header class="section-header pattern-3">
				<div class="ws-container">
					<div class="section-header-content">
						<h1 class="section-title"><?php the_title(); ?></h1>
					</div>
				</div>
			</header>
		</section>

		<?php the_post(); ?>

		<section class="register-payment-section ws-container">
			<div class="section-content">

				<?php the_content(); ?>

				<form 
				id="register-form"
				action="https://olr.worldstrides.net/scripts/cgiip.exe/registeronline/default.htm"
				data-have-id-action="https://olr.worldstrides.net/scripts/cgiip.exe/registeronline/default.htm"
				data-no-id-action="http://www.educationaltravel.com/Login/tabid/78/type/enroll/Default?returnurl=/default.aspx"
				method="post" 
				class="ws-form">
					
					<ul class="fields list-unstyled">
<!-- 						<li>
							<label for="payment-first-name">First Name</label>
							<input type="name" class="payment-field first-name" name="first_name" id="payment-first-name">
						</li>
						<li>
							<label for="payment-last-name">Last Name</label>
							<input type="name" class="payment-field last-name" name="last_name" id="payment-last-name">
						</li>
 -->
 						<li id="payment-trip-id-li">
							<input type="text" class="payment-field trip-id" name="tripnumber" title="Trip ID" placeholder="Trip ID" id="payment-trip-id">
							<!-- <span class="help-text">Still can&apos;t find your Trip ID? <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" target="_blank">Call customer service</a></span> -->
						</li>
						<li>
							<div>
								<div style="float:left; margin-right: 15px; height: 30px;"><input type="checkbox" id="have-username"></div>
								<div id="have-username-label"><span><?php _e('My registration materials included a username and password instead of a Trip ID.', 'worldstrides'); ?></label></div>
							</div>
						</li>
					</ul>
					<input id="hidden-eqh" type="hidden" name="eqh" value="yes" >
					<footer>
						<input type="submit" value="Get Started" class="btn btn-primary">
					</footer>

				</form>

			</div>
			<?php get_template_part( 'partials/module', 'contact' ) ?>
		</section>

	</main>
</div>

<?php get_footer(); ?>
