<?php
/**
 * Content display for about pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_archive( 'press' ) && has_post_thumbnail() ) {
		the_post_thumbnail( 'thumbnail' );
	} ?>

	<?php if ( ! is_page( 'about') && ! is_archive() ) : ?>
		<header class="entry-header">
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
		</header>
	<?php endif; ?>

	<?php if ( is_archive( 'press' ) ) : ?>
		<header class="entry-header">
			<div class="entry-meta">
				<time datetime=""><?php the_time( 'F j, Y' ); ?></time>
				<span class="entry-categories"><?php echo get_the_category_list( ', ' ); ?></span>
			</div>
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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

	<?php if ( is_page( 'partnerships' ) ) : ?>
		<?php get_template_part( 'partials/content', 'partnerships' ); ?>
	<?php endif; ?>

	<?php if ( is_page( 'careers' ) ) : ?>
		<?php get_template_part( 'partials/content', 'careers' ); ?>
	<?php endif; ?>

	<footer class="entry-footer">

	</footer>
</article>