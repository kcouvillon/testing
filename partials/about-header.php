<?php
/**
 * Header used across the about page templates
 */

$about_page = get_page_by_path( 'about' );
?>

<header class="about">
	<h1><?php echo apply_filters( 'the_title', $about_page->post_title ) ?></h1>

	<p class="description">
		<?php echo apply_filters( 'the_content', $about_page->post_excerpt ) ?>
	</p>
</header>

<nav class="about-menu">
	<?php wp_nav_menu( array( 'theme_location' => 'about', 'menu_id' => 'about-menu' ) ); ?>
</nav>