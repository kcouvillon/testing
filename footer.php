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
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container_class' => 'footer-menu footer-1', 'menu_id' => '', 'link_after' => ' <i class="icon icon-arrow-down"></i>' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer2', 'container_class' => 'footer-menu footer-2', 'menu_id' => '', 'link_after' => ' <i class="icon icon-arrow-down"></i>' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer3', 'container_class' => 'footer-menu footer-3', 'menu_id' => '', 'link_after' => ' <i class="icon icon-arrow-down"></i>' ) ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'footer4', 'container_class' => 'footer-menu footer-4', 'menu_id' => '', 'link_after' => ' <i class="icon icon-arrow-down"></i>' ) ); ?>
		</nav>

		<div class="site-info">
			<?php get_template_part('partials/sociallinks'); ?>
			<ul class="departing-from hide-print">
				<li><label for="select-ws-region">Departing From</label></li>
				<select id="select-ws-region" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<option value="" selected>USA</option>
					<option value="http://worldstrides.co.uk/">United Kingdom</option>
					<option value="http://trekset.com.au/">Australia</option>
					<option value="http://worldstrides.cn/">China</option>
				</select>
			</ul>

			<ul class="site-info-menu hide-print">
				<li><a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>">Sitemap</a></li>
				<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
				<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms and Conditions</a></li>
				<li><a href="<?php echo esc_url( home_url( '/legal-policy/' ) ); ?>">Legal Policy</a></li>
				<li>CST # 2041618-20</li>
				<li>&copy; <?php echo date('Y'); ?> WorldStrides, Inc.</li>
			</ul>

		</div>

		<div class="clearfix"></div>

		<div class="tagline">
			<div class="footer-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="hide"><?php echo bloginfo('description'); ?></span>
				</a>
			</div>
		</div>

	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<?php if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) : ?>
<div class="media-size"></div>
<?php endif; ?>

</body>
</html>