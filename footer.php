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

		<ul class="social-icons">
			<li class="youtube"><a href="#">YouTube</a></li>
			<li class="facebook"><a href="#">Facebook</a></li>
			<li class="twitter"><a href="#">Twitter</a></li>
			<li class="instagram"><a href="#">Instagram</a></li>
			<li class="pinterest"><a href="#">Pinterest</a></li>
		</ul>

		<div class="departing-from">
			<h3>Departing From</h3>
			<select>
				<option selected>USA</option>
				<option>United Kingdom</option>
				<option>Australia</option>
				<option>China</option>
			</select>
		</div>

		<div class="tagline">
			<?php // @todo should this come out of the WP description field? ?>
			<h2>Explore. Discover. Become.</h2>
		</div>

		<div class="site-info">
			<ul class="site-info-menu">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>privacy-policy">Privacy Policy</a></li>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>terms-conditions/">Terms and Conditions</a></li>
				<li>&copy; <?php echo date('Y'); ?> WorldStrides, Inc.</li>
			</ul>

		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>