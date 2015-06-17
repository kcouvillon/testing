<?php
/**
 * The template for displaying the header.
 *
 * @package WorldStrides
 * @since 0.1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri() . '/images/favicon.ico'; ?>" />
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/images/favicon.png'; ?>" />
	<link rel="icon" type="image/gif" href="<?php echo get_template_directory_uri() . '/images/favicon.gif'; ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<nav id="quick-access" class="quick-access" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'quick-access-menu' ) ); ?>
	</nav>

	<header id="masthead" class="site-header" role="banner">
		<a class="logo-lg" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="http://placehold.it/216x46" alt=""></a>
		<a class="logo-sm" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="http://placehold.it/40x50" alt=""></a>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<a href="#">Explore Our Trips >></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav>
	</header>

	<div id="content" class="site-content">