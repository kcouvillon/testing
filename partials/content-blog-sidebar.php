<?php
/**
 * Content display blog posts on list pages (home, category, archive)
 */

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_page( 'about' ) ) : ?>

			<?php
			$background = '';
			if ( has_post_thumbnail() ) {
				$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				$background = 'url(' . $featured[0] . ')';
				$class = ' has-blog-image';
			} else {
				$class = ' ' . WS_Helpers::get_random_pattern();
			} ?>

		<header class="section-header entry-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
			<?php echo get_the_category_list(); ?>
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<a href="<?php the_permalink(); ?>" title="Read <?php the_title(); ?> »"><span class="hide">Read more</span></a>
		</header>
	<?php endif; ?>

	<div class="entry-body">

		<div class="entry-content">
			<a href="<?php the_permalink(); ?>" class="entry-link">Keep Reading</a>
		</div>

	</div>

</article>