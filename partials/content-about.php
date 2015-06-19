<?php
/**
 * Content display for about pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_archive( 'press' ) && has_post_thumbnail() ) {
		the_post_thumbnail( 'thumbnail' );
	} ?>

	<?php if ( ! is_page( 'about') ) : ?>
	<header class="entry-header">
		<h2 class="entry-title">
			<?php the_title(); ?>
		</h2>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php if( is_archive( 'press' ) ) {
			the_excerpt();
		} else {
			the_content();
		}
		?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>