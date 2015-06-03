<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php /* Make sure it's a blog 'post' and then check type*/ ?>
				<?php if ( $post->post_type == 'post' ) : ?>

					<?php
						$terms = get_the_terms( $post->ID, 'blog-type' );
						$term_slug = $terms[0]->slug;

						if ( $term_slug == 'travelogue' ) {
							get_template_part( 'partials/content', 'blog-travelogue' );
						} elseif( $term_slug == 'postcard' ) {
							get_template_part( 'partials/content', 'blog-postcard' );
						} else {
							get_template_part( 'partials/content', 'blog' );
						}
					?>

				<?php else : ?>

					<?php get_template_part( 'partials/content' ) ?>

				<?php endif; ?>

			<?php endwhile; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
