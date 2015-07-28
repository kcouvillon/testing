<div class="search-widget">

	<?php if( ! is_search() ) : ?>
		<input type="search" placeholder="Search Blog">
	<?php endif; ?>

	<h3>Explore by Tag</h3>

	<?php $tags = get_terms( 'post_tag', array( 'hide_empty' => true ) ); ?>

	<?php foreach ( $tags as $tag ) : ?>
		<a class="btn btn-success" href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>
	<?php endforeach; ?>

</div>