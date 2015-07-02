<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

			<?php
			$blog_type = WS_Helpers::blog_type( $post->ID );
			$background = '';
			if ( has_post_thumbnail() ) {
				$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $featured[0] . ')';
			} ?>

		<?php if ( $blog_type === 'postcard' ) : ?>
			<section class="primary-section">
				<iframe width="100%" height="700" src="https://www.youtube.com/embed/_SzwjiuNWyo" frameborder="0" allowfullscreen></iframe>
			</section>
		<?php
		else :
		?>
			<section class="section-header primary-section pattern-3" style="background-image: <?php echo $background; ?>">
				<div class="section-header-content">

					<nav class="breadcrumbs">
						<?php the_time('F, j Y'); ?>
						<?php echo get_the_category_list('&nbsp;'); ?>
					</nav>
					<h1><?php echo get_the_title(); ?></h1>
					<?php echo wp_trim_words(get_post($post->ID)->post_content, 55); ?>
				</div>
			</section>
		<?php endif; ?>

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

				<div class="blog-pager">
					<div class="blog-pager-prev">
						<span>Previous {CATEGORY} Story</span>
						<?php previous_post_link('%link', '%title', true); ?>
					</div>
					<div class="blog-pager-next">
						<span>Next {CATEGORY} Story</span>
						<?php next_post_link('%link', '%title', true); ?>
					</div>
				</div>

				FACEBOOK COMMENTS HERE

			<?php else : ?>

				<p>Nothing found</p>

			<?php endif; ?>

			</div><!-- blog-single-content -->

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

		</div><!-- blog-single-wrap -->

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
