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
		<?php if ( is_singular() ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
	</div>

	<footer class="entry-footer">
		<?php if ( is_singular() ) : ?>
			<?php // @todo should 'back to leadership/category' link go here? ?>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>">Read More</a>
		<?php endif; ?>
	</footer>
</article>