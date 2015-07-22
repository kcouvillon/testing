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

		<nav id="footer-navigation" class="footer-navigation clearfix  hide-print" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container_class' => 'footer-menu footer-1', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer2', 'container_class' => 'footer-menu footer-2', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer3', 'container_class' => 'footer-menu footer-3', 'menu_id' => '' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer4', 'container_class' => 'footer-menu footer-4', 'menu_id' => '' ) ); ?>
		</nav>

		<div class="site-info">
			<ul class="social-icons hide-print">
				<li class="youtube"><a href="https://www.youtube.com/user/WorldStrides" target="_blank" class="icon-youtube"><span class="hide">YouTube</span></a></li>
				<li class="facebook"><a href="https://www.facebook.com/WorldStrides" target="_blank" class="icon-facebook"><span class="hide">Facebook</span></a></li>
				<li class="twitter"><a href="https://twitter.com/worldstrides" target="_blank" class="icon-twitter"><span class="hide">Twitter</span></a></li>
				<li class="pinterest"><a href="https://www.pinterest.com/worldstrides/" target="_blank" class="icon-pinterest"><span class="hide">Pinterest</span></a></li>
				<li class="instagram"><a href="https://instagram.com/worldstrides" target="_blank" class="icon-instagram"><span class="hide">Instagram</span></a></li>
			</ul>

			<ul class="departing-from hide-print">
				<li>Departing From</li>
				<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<option value="" selected>USA</option>
					<option value="http://worldstrides.co.uk/">United Kingdom</option>
					<option value="http://trekset.com.au/">Australia</option>
					<option value="http://worldstrides.cn/">China</option>
				</select>
			</ul>

			<ul class="site-info-menu">
				<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
				<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms and Conditions</a></li>
				<li>&copy; <?php echo date('Y'); ?> WorldStrides, Inc.</li>
			</ul>

		</div>

		<div class="clearfix"></div>

		<div class="tagline">
			<h2 class="footer-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
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