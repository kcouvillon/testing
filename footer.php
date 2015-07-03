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

		<nav id="footer-navigation" class="footer-navigation clearfix" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container_class' => 'footer-menu footer-1', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer2', 'container_class' => 'footer-menu footer-2', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer3', 'container_class' => 'footer-menu footer-3', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer4', 'container_class' => 'footer-menu footer-4', 'menu_id' => '' ) ); ?>
		</nav>

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

		<!-- <div class="site-info">

		</div> -->

		<div class="tagline">
			<h2 class="footer-logo">
				<a href="<?php echo esc_url( home_url() ); ?>">
					<span class="hide"><?php echo bloginfo('description'); ?></span>
				</a>
			</h2>
		</div>

	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) : ?>
<div class="media-size"></div>
<?php endif; ?>

</body>
</html>