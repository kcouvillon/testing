<?php
/**
 * Content display blog posts on list pages (home, category, archive)
 */

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-body">

			<div class="entry-content">
				<nav class="breadcrumbs"><time datetime="<?php echo get_the_time('Y-m-d'); ?>"><?php the_time('F j, Y'); ?></time> <?php echo get_the_category_list('&nbsp'); ?></nav>
				<h1 itemprop="headline"><?php the_title(); ?></h1>
				<div itemprop="articleBody"><?php the_content(); ?></div>
			</div>

	</div>

</article>