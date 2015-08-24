<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

get_header();

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main <?php echo $blog_type; ?>" role="main">

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			// if it's a postcard, don't add the overlay
			if ( $blog_type === 'postcard' ) :
				$background = 'url(' . $featured[0] . ')';
			// if not, include the overlay
			else :
				 $background = 'url(' . $featured[0] . ')';
			endif;
			$class = '';
		} else {
			$class = ' pattern-3';
		} ?>

		<section class="section-header primary-section<?php echo $class; ?>" style="background-image: <?php echo $background; ?>">

			<?php if ( $blog_type === 'general' || $blog_type === 'travelogue' ) : ?>
				<div class="section-header-content">

					<nav class="breadcrumbs">
						<time><?php the_time( 'F, j Y' ); ?></time>>
						<?php echo get_the_category_list( '>' ); ?>>
						<span><?php echo get_the_title(); ?></span>
					</nav>
					<h1><?php echo get_the_title(); ?></h1>
					<?php echo get_the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</section>

		<div class="blog-single-wrap">

			<div class="blog-single-meta">
				<?php get_template_part( 'partials/content', 'blog-author' ); ?>
				<?php get_template_part( 'partials/content', 'blog-sharing' ); ?>
				<?php get_template_part( 'partials/content', 'blog-tags' ); ?>
			</div>

			<div class="blog-single-content">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php /* Make sure it's a blog 'post' and then check type*/ ?>
						<?php if ( $post->post_type == 'post' ) : ?>

							<?php

							if ( $blog_type == 'travelogue' ) {
								get_template_part( 'partials/content', 'blog-travelogue' );
							} elseif ( $blog_type == 'postcard' ) {
								get_template_part( 'partials/content', 'blog-postcard' );
							} else {
								get_template_part( 'partials/content', 'blog' );
							}
							?>

						<?php else : ?>

							<?php get_template_part( 'partials/content' ) ?>

						<?php endif; ?>

					<?php endwhile; ?>

					<?php
					$categories = get_the_category();
					$category   = $categories[0];
					?>

					<div class="blog-pager">
						<div class="blog-pager-prev">
							<?php if ( get_previous_post() ) { ?>
								<span>Previous <?php echo $category->name; ?> Story</span>
								<?php previous_post_link( '%link', '%title', true ); ?>
							<?php } else { ?>
								<span>No Older Stories</span>
								<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">See all Stories</a>
							<?php } ?>
						</div>
						<div class="blog-pager-next">
							<?php if ( get_next_post() ) { ?>
								<span>Next <?php echo $category->name; ?> Story</span>
								<?php next_post_link( '%link', '%title', true ); ?>
							<?php } else { ?>
								<span>No Newer Stories</span>
								<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Go Back to All Stories</a>
							<?php } ?>
						</div>
					</div>

					<?php $comments = get_post_meta( $post->ID, 'facebook_comments'. false ); ?>

					<?php if ( $comments ) : ?>
					<a name="comments"></a>
					<h4>Comments</h4>
					<div class="fb-comments" data-href="<?php the_permalink(); ?>"></div>
					<?php endif; ?>

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

			</div>
			<!-- blog-single-content -->

			<?php if ( $blog_type === 'general' ) : ?>

				<?php
				// Related content is a comma separated string, needs to be an integer array for post__in
				$related_content = array_map( 'intval', explode( ',', get_post_meta( $post->ID, 'ws_blog_related_content', true ) ) );

				$related_content_posts = new WP_Query( array(
					'post__in'               => $related_content,
					'no_found_rows'          => true,
					'update_post_term_cache' => false,
					'update_post_meta_cache' => false,
					'post_type'              => array( 'itinerary', 'collection', 'post' )
				) );
				?>

				<?php if ( $related_content_posts->have_posts() ) : ?>

					<aside class="sidebar">

						<?php while ( $related_content_posts->have_posts() ) : ?>
							<?php
							$related_content_posts->the_post();

							$background = '';

							if ( has_post_thumbnail() ) {
								$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
								$background = 'url(' . $featured[0] . ')';
							}
							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="section-header entry-header pattern-8" style="background-image: <?php echo $background ?>;">
									<?php $subtitle = WS_Helpers::get_subtitle( $post->ID, 'destination' ); ?>
									<?php if ( $subtitle ) : ?>
									<ul class="post-categories">
										<li>
											<?php echo $subtitle; ?>
										</li>
									</ul>
									<?php endif; ?>

									<h2 class="entry-title"><?php the_title(); ?></h2>
								</header>

								<div class="entry-body">
									<div class="entry-content">
										<p><?php the_excerpt(); ?></p>
										<a href="<?php the_permalink(); ?>"><button class="btn btn-primary">Learn More</button></a>
									</div>
								</div>

							</article>

						<?php endwhile; ?>

					</aside>

				<?php endif; ?>

			<?php endif; ?>

		</div>
		<!-- blog-single-wrap -->

		<?php get_template_part( 'partials/module', 'request-info' ); ?>

	</main>
</div>

<?php get_footer(); ?>
