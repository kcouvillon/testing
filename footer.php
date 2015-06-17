<?php
/**
 * The template for displaying the footer.
 *
 * @package WorldStrides
 * @since 0.1.0
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<nav id="footer-navigation" class="footer-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
		</nav>

		<ul class="contact-us">
			<li>Contact Us</li>
			<ul class="sub-menu">
				<li><a href="">Phone Number</a></li>
				<li><a href="">Email Address</a></li>
				<li><a href="">Chat Link</a></li>
				<li><a href="">Catalogue Request Link</a></li>
			</ul>
		</ul>

		<div class="site-info">
			<ul class="social-icons">
				<li class="youtube"><a href="#">YouTube</a></li>
				<li class="facebook"><a href="#">Facebook</a></li>
				<li class="twitter"><a href="#">Twitter</a></li>
				<li class="instagram"><a href="#">Instagram</a></li>
				<li class="pinterest"><a href="#">Pinterest</a></li>
			</ul>

			<ul class="departing-from">
				<li>Departing From</li>
				<select>
					<option selected>USA</option>
					<option>United Kingdom</option>
					<option>Australia</option>
					<option>China</option>
				</select>
			</ul>

			<ul class="site-info-menu">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>privacy-policy">Privacy Policy</a></li>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>terms-conditions/">Terms and Conditions</a></li>
				<li>&copy; <?php echo date('Y'); ?> WorldStrides, Inc.</li>
			</ul>

		</div>

		<div class="site-info">

		</div>

		<div class="tagline">
			<?php // @todo should this come out of the WP description field? ?>
			<h2>Explore. Discover. Become.</h2>
		</div>

	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) : ?>
<div class="media-size"></div>
<?php endif; ?>

</body>
</html>