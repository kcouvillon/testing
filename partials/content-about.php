<?php
/**
 * Content display for about pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_archive( 'press' ) && has_post_thumbnail() ) {
		the_post_thumbnail( 'thumbnail' );
	} ?>

	<?php if ( ! is_page( 'about' ) && ! is_archive() ) : ?>
		<header class="entry-header">
			<h2 class="entry-title"><strong>
				<?php the_title(); ?>
			</strong></h2>
		</header>
	<?php endif; ?>

	<?php if ( is_archive( 'press' ) ) : ?>
		<header class="entry-header">
			<div class="entry-meta">
				<time datetime=""><?php the_time( 'F j, Y' ); ?></time>
			</div>
			<h3 class="entry-title"><?php the_title(); ?></h3>
		</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_archive( 'press' ) ) {
			the_excerpt();
			echo '<a href="'. get_the_permalink() .'">Keep Reading</a>';
		} else {
			the_content();
		}
		?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>