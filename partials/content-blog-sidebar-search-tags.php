<div class="search-widget">

	<input type="search" placeholder="Search Blog">

	<h3>Explore by Tag</h3>

	<?php $tags = get_terms( 'post_tag', array( 'hide_empty' => true ) ); ?>

	<?php foreach ( $tags as $tag ) : ?>
		<button class="btn btn-success"><a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a></button>
	<?php endforeach; ?>

</div>