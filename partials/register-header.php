<?php
/**
 * Header used across the about page templates
 */

$register_page = get_page_by_path( 'register' );
?>


<section class="register primary-section">
	
	<header class="section-header pattern-3">
		<div class="section-header-content">
			<h1 class="section-title"><?php echo apply_filters( 'the_title', $register_page->post_title ) ?></h1>

			<p class="description">
				<?php echo apply_filters( 'the_content', $register_page->post_excerpt ) ?>
			</p>
		</div>
	</header>

</section>