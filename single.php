<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section-header primary-section pattern-3">
			<div class="section-header-content">

				<nav class="breadcrumbs">
					<?php the_time('F, j Y'); ?>
					<?php echo get_the_category_list('&nbsp;'); ?>
				</nav>
				<h1><?php echo get_the_title(); ?></h1>

				<?php
				$page = get_page_by_title( 'Blog' );
				$excerpt = $page->post_excerpt;
				?>
				<?php echo apply_filters( 'the_content', $excerpt ); ?>
			</div>
		</section>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php /* Make sure it's a blog 'post' and then check type*/ ?>
				<?php if ( $post->post_type == 'post' ) : ?>

					<?php
						$blog_type = WS_Helpers::blog_type( $post->ID );

						if ( $blog_type == 'travelogue' ) {
							get_template_part( 'partials/content', 'blog-travelogue' );
						} elseif( $blog_type == 'postcard' ) {
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
