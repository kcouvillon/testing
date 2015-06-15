<?php
/**
 * Content display for bio pages
 */
?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="headshot">
				<?php // @todo replace this with specific image size when ready (differentiate between single/page) ?>
				<?php the_post_thumbnail( 'medium' ); ?>
			</div>
		<?php endif; ?>

		<h1 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h1>

		<h2>Position will go here</h2>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>