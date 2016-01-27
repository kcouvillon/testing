<div class="search-widget">

	<?php if( ! is_search() ) : ?>

		<form role="search" method="get" action="<?php echo site_url(); ?>">
            <label for="input-search-blog" class="block no-placeholder">Search Blog</label>
            <input type="search" placeholder="Search Blog" name="s">
            <input type='hidden' name='post_type' value='post' />			
			<!-- <input type="submit" class="btn-primary search-submit" value="S" style="float:right"> -->
		</form>
	<?php endif; ?>

	<h3>Explore by Tag</h3>

	<?php $tags = get_terms( 'post_tag', array( 'hide_empty' => true ) ); ?>

	<?php foreach ( $tags as $tag ) : ?>
		<a class="btn btn-success" href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>
	<?php endforeach; ?>

	<h3>Explore by Category</h3>

	
    <?php $cats = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC',
        'parent'  => 0
    )); ?>

	<?php foreach ( $cats as $cat ) : ?>
		<a class="btn btn-primary" href="<?php echo get_category_link( $cat->term_id ); ?>"><?php echo $cat->cat_name; ?></a>
	<?php endforeach; ?>

</div>