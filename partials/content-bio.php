<?php
/**
 * Content display for bio pages
 */

$position = get_post_meta( $post->ID, 'ws_bio_position', true )
?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="headshot">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<h3 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h3>

		<?php if ( $position ) : ?>
			<span class="entry-position"><?php echo esc_html( $position ); ?></span>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php if ( is_page('about') ) : ?>
			<?php the_content(); ?>
		<?php else : ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
	</div>

	<footer class="entry-footer">
		<?php if ( is_page('about') ) : ?>
			<?php // about page gets redirected to history anyway ?>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>">Read More</a>
		<?php endif; ?>
	</footer>
</article>