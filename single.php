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
				$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $featured[0] . ')';
			endif;
		} ?>

		<section class="section-header primary-section pattern-3" style="background-image: <?php echo $background; ?>">

			<?php if ( $blog_type === 'general' || $blog_type === 'travelogue' ) : ?>
				<div class="section-header-content">

					<nav class="breadcrumbs">
						<?php the_time( 'F, j Y' ); ?>
						<?php echo get_the_category_list( '&nbsp;' ); ?>
					</nav>
					<h1><?php echo get_the_title(); ?></h1>
					<?php echo get_the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</section>

		<div class="blog-single-wrap">

			<div class="blog-single-meta">
				<?php get_template_part( 'partials/content', 'blog-author' ); ?>
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
								<a href="<?php esc_url( home_url( '/blog' ) ); ?>">See all Stories</a>
							<?php } ?>
						</div>
						<div class="blog-pager-next">
							<?php if ( get_next_post() ) { ?>
								<span>Next <?php echo $category->name; ?> Story</span>
								<?php next_post_link( '%link', '%title', true ); ?>
							<?php } else { ?>
								<span>No Newer Stories</span>
								<a href="<?php esc_url( home_url( '/blog' ) ); ?>">Go Back to All Stories</a>
							<?php } ?>
						</div>
					</div>

					FACEBOOK COMMENTS HERE

				<?php else : ?>

					<p>Nothing found</p>

				<?php endif; ?>

			</div>
			<!-- blog-single-content -->

			<?php if ( $blog_type === 'general' ) : ?>

				<aside class="sidebar">
					<article class="post-1 post type-post status-publish format-standard hentry category-new" id="post-1">
						<header class="section-header entry-header pattern-8" style="background-image: ;">
							<ul class="post-categories">
								<li>
									<a href="http://worldstrides.dev/category/new/" rel="category tag">New</a>
								</li>
							</ul>

							<h2 class="entry-title">STATIC MARKUP</h2>
						</header>

						<div class="entry-body">
							<div class="entry-content">
								<p>Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!</p>
								<button class="btn btn-primary">STATiC BUTTON</button>
							</div>
						</div>

					</article>
				</aside>

			<?php endif; ?>

		</div>
		<!-- blog-single-wrap -->

		<div class="blog-single-cta">
			<span class="h2">Request Information about a WorldStrides {PROGRAM TYPE} Program</span>
			<span>I am a</span>
			<select name="" id="">
				<option value="">Parent</option>
				<option value="">Traveler</option>
				<option value="">Teacher</option>
			</select>
			<button class="btn btn-primary">Get the Info</button>
		</div>

	</main>
</div>

<?php get_footer(); ?>
