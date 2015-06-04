<?php
/**
 * Content display for blog travelogue posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_page( 'about') ) : ?>
	<header class="entry-header">
		<h1 class="entry-title">
			Travelogue: <?php the_title(); ?>
		</h1>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>