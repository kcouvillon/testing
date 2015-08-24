<?php
/**
 * Default content display
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( is_singular( 'press' ) ) {
		$background = '';
		if ( has_post_thumbnail() ) {
			$has_post_thumbnail = true;
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			$background = 'url(' . $featured[0] . ')';
		}
	} ?>

	<header class="entry-header<?php if ( $has_post_thumbnail ) echo ' press-thumbnail'; ?>" <?php if ( $has_post_thumbnail ) echo 'style="background: '. $background .'"'; ?>>

		<time><?php the_time( 'F, j Y' ); ?></time>

		<h1 class="entry-title">
				<?php the_title(); ?>
		</h1>


		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">

			</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>