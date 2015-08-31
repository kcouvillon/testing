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

	<!-- Some really intense (but necessary) Favicon code -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-57x57.png'; ?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-60x60.png'; ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-72x72.png'; ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-76x76.png'; ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-114x114.png'; ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-120x120.png'; ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-144x144.png'; ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-152x152.png'; ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/apple-touch-icon-180x180.png'; ?>">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/favicon-32x32.png'; ?>" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/android-chrome-192x192.png'; ?>" sizes="192x192">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/favicon-96x96.png'; ?>" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/favicon-16x16.png'; ?>" sizes="16x16">
	<link rel="manifest" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/manifest.json'; ?>">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/assets/images/favicons/favicon.ico'; ?>">
	<meta name="msapplication-TileColor" content="#323c53">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri() . '/assets/images/favicons/mstile-144x144.png'; ?>">
	<meta name="msapplication-config" content="<?php echo get_template_directory_uri() . '/assets/images/favicons/browserconfig.xml'; ?>">
	<meta name="theme-color" content="#ffffff">

	<script>
		var wsData = {
			themeDir: '<?php echo get_template_directory_uri(); ?>',
			siteUrl: '<?php echo site_url(); ?>'
		};
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
if ( is_singular( 'post' ) ) {
	echo WS_Comments::facebook_sdk();
}
?>

<?php echo WS_Helpers::ws_google_tag_manager(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<nav id="quick-access" class="quick-access hide-print" role="navigation">
		<?php get_search_form(); ?>
		<div class="menu-quick-access-container">
			<ul id="quick-access-menu" class="menu">
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
				<li class="menu-item"><a href="#search"><i class="icon-search"></i><span class="hide">Search</span></a></li>
			</ul>
		</div>
	</nav>

	<header id="masthead" class="site-header" role="banner">
		<h1 class="logo hide-print"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="hide">Worldstrides</span></a></h1>
		<h2 class="print-logo print-only"><span class="icon icon-shield"></span> Worldstrides</h2>
		<a href="#mobile-nav" class="menu-toggle"><i class="icon icon-menu"></i></a>

		<nav id="site-navigation" class="main-navigation hide-print" role="navigation">
			<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore Our Trips »</a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav>
	</header>

	<nav id="mobile-nav" class="mobile-nav hide-print" role="navigation">
		<a href="#mobile-nav" class="menu-toggle"><i class="icon icon-close"></i></a>
		<ul class="primary-nav menu list-unstyled">
			<li class="menu-item menu-item-explore">
				<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore Our Trips »</a>
			</li>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
		</ul>
		<form role="search" method="get" class="ws-form search-form" action="<?php echo site_url(); ?>">
			<label>
				<span class="screen-reader-text">Search for:</span>
				<i class="icon icon-search"></i>
				<input type="search" class="search-field" placeholder="Search …" value="" name="s" title="Search for:">
			</label>
			<input type="submit" class="search-submit" value="Search">
		</form>
		<ul class="secondary-nav menu list-unstyled">
			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
		</ul>
	</nav>

	<div id="content" class="site-content">