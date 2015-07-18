<?php

if ( class_exists( 'coauthors_plus' ) ) :
	// Get the Co-Authors for the post
	$co_authors = get_coauthors();

	// For each Co-Author, echo a wrapper div, their name, and their bio if they have one
	foreach ( $co_authors as $key => $co_author ) : ?>
		<div class="entry-author">
			<?php // echo get_avatar( get_the_author_meta( 'ID' ) ); ?>

			<span>
				<?php if ( $co_author->author_type ) : ?>
					<?php echo $co_author->author_type; ?><br>
				<?php endif; ?>

				<strong><?php echo $co_author->display_name; ?></strong>
			</span>
		</div>

	<?php endforeach; ?>
<?php endif; ?>