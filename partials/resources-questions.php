<?php
/**
 * Default content display
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'resource-question' ); ?>>
	<header class="entry-header">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>