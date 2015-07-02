<?php
/**
 * Content display blog posts on list pages (home, category, archive)
 */

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-body">

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

	</div>

</article>