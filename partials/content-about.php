<?php
/**
 * Content display for about pages
 */
?>

<section id="post-<?php the_ID(); ?>" <?php post_class('about section-content'); ?>>
	<?php if ( ! is_page( 'about') ) : ?>
	<header class="entry-header">
		<h2 class="entry-title">
			<?php the_title(); ?>
		</h2>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</section>