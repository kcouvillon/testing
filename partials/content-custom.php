<?php
/**
 * Custom query content display for about pages
 */
$postid = $row->post_id;
?>

<article id="post-<?php echo $postid ?>" <?php echo post_class(); ?>>

        <?php  echo get_the_post_thumbnail( $postid, 'post-thumbnail' ); ?>
        
		<header class="entry-header">
			<div class="entry-meta">
                <time datetime=""><?php echo get_the_date( 'F j, Y', $postid ); ?></time>
					<?php echo get_the_category_list($postid); ?>
			</div>
			<h3 class="entry-title"><a href="<?php echo get_the_permalink($postid) ?>"><?php echo get_the_title($postid) ?></a></h3>
		</header>

	<div class="entry-content">
		<?php
            the_excerpt($postid);
			echo '<a href="'. get_the_permalink($postid) .'">Keep Reading</a>';
		?>
	</div>

	<footer class="entry-footer">

	</footer>
</article>