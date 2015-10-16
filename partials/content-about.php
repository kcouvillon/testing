<?php
/**
 * Content display for about pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_archive( 'press' ) || is_search() || is_tag() && has_post_thumbnail() ) {
		the_post_thumbnail( 'thumbnail' );
	} ?>

	<?php if ( ! is_page( 'about' ) && ! is_archive() && ! is_search() ) : ?>
		<header class="entry-header">
			<h1 class="h2 entry-title"><strong>
				<?php the_title(); ?>
			</strong></h1>
		</header>
	<?php endif; ?>

	<?php if ( is_archive( 'press' ) || is_search() || is_tag() ) : ?>
		<header class="entry-header">
			<div class="entry-meta">
				<time datetime=""><?php the_time( 'F j, Y' ); ?></time>
				<?php if( is_search() ) : ?>
					<?php echo get_the_category_list(); ?>
				<?php endif; ?>
			</div>
			<h3 class="entry-title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
		</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if ( is_archive( 'press' ) || is_search() || is_tag() ) {
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