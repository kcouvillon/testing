<?php
/**
 * Header used across the about page templates
 */

$about_page = get_page_by_path( 'about' );
?>


<section class="about primary-section">
	<header class="section-header pattern-3">
		<div class="section-header-content">
			<h1 class="section-title"><?php echo apply_filters( 'the_title', $about_page->post_title ) ?></h1>

			<div class="description">
				<?php echo apply_filters( 'the_content', $about_page->post_excerpt ) ?>
			</div>
		</div>
	</header>

	<nav class="section-nav">
		<?php wp_nav_menu( array( 'theme_location' => 'about', 'menu_class' => 'section-menu' ) ); ?>
	</nav>

</section>