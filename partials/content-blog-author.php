<?php

if ( class_exists( 'coauthors_plus' ) ) :
	// Get the Co-Authors for the post
	$co_authors = get_coauthors($post->ID);

	// For each Co-Author, echo a wrapper div, their name, and their bio if they have one
	foreach ( $co_authors as $key => $co_author ) : ?>
		<div class="entry-author">
			<?php if ( has_post_thumbnail( $co_author->ID) ) {
				echo get_the_post_thumbnail( $co_author->ID, 'thumbnail', array( 'class' => 'avatar' ) );
			}; ?>

			<span>
				<?php if ( $co_author->author_type ) : ?>
					<?php echo $co_author->author_type; ?><br>
				<?php endif; ?>
				<strong>
					<a href="<?php echo esc_url( home_url( '/author/' . $co_author->user_nicename . '/' ) ); ?>" rel="author">
						<?php echo $co_author->display_name; ?>
					</a>
				</strong>
			</span>
		</div>

	<?php endforeach; ?>
<?php endif; ?>