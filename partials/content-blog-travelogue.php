<?php
/**
 * Content display blog posts on list pages (home, category, archive)
 */

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_single() ) : ?>

			<?php
			$background = '';
			if ( has_post_thumbnail() ) {
				$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
				$background = 'linear-gradient( rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28) ), url(' . $featured[0] . ')';
			} ?>

		<header class="section-header entry-header pattern-<?php echo rand(1, 9); ?>" style="background-image: <?php echo $background; ?>;">

			<?php echo get_the_category_list(); ?>

			<h2 class="entry-title"><?php the_title(); ?></h2>

		</header>
	<?php endif; ?>

	<div class="entry-body">

		<?php if( ! is_single() ) :
			get_template_part( 'partials/content', 'blog-author' );
		?>

			<div class="entry-content">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="entry-link">Keep Reading</a>
			</div>

		<?php else : ?>

			<div class="entry-content">

				<?php the_content(); ?>

				<div class="related-postcard">
					<img src="http://placehold.it/400x300" alt="">
					<h3>Related Postcard</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia architecto aut quo nemo debitis vel, rem officia necessitatibus esse, numquam magni illo eligendi. Officiis, soluta dicta temporibus repellendus! A, architecto.</p>
				</div>

			</div>

		<?php endif; ?>

	</div>

</article>