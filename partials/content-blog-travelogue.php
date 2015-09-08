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
				$background = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.45) ), url(' . $featured[0] . ')';
				$class = ' has-blog-image';
			} else {
				$class = ' pattern-' . rand(1, 9);
			}?>

		<header class="section-header entry-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">

			<?php echo get_the_category_list(); ?>

			<h2 class="entry-title"><?php the_title(); ?></h2>

		</header>
	<?php endif; ?>

	<div class="entry-body">

		<?php if( ! is_single() ) :
			get_template_part( 'partials/content', 'blog-author' );
		?>

			<div class="entry-content" itemprop="articleBody">
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="entry-link">Keep Reading</a>
			</div>

		<?php else : ?>

			<div class="entry-content" itemprop="articleBody">

				<?php the_content(); ?>

				<?php
				$related_content = array_map( 'intval', explode( ',', get_post_meta( $post->ID, 'ws_blog_related_content', true ) ) );

				$related_content_posts = new WP_Query( array(
					'post__in'               => $related_content,
					'no_found_rows'          => true,
					'update_post_term_cache' => false,
					'update_post_meta_cache' => false,
					'post_type'              => array( 'itinerary', 'collection', 'post' )
				) );
				?>

				<?php while ( $related_content_posts->have_posts() ) : ?>
					<?php
					$related_content_posts->the_post();

					$background = '';
					$featured = '';

					if ( has_post_thumbnail() ) {
						$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
						$background = 'linear-gradient( rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45) ), url(' . $featured[0] . ')';
					}
					?>
					<div class="related-postcard">
						<?php if ( $featured ) :?>
							<img src="<?php echo $featured[0]; ?>" alt="">
						<?php endif; ?>
						<h3><?php the_title(); ?></h3>
						<p><?php the_excerpt(); ?></p>
					</div>
				<?php endwhile; ?>

			</div>

		<?php endif; ?>

	</div>

</article>