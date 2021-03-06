<?php
/**
 * Used to display "tiles" around the site
 */

global $post;

$itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );

if ( ( $post->ID == '844' || 'smithsonian' == $itinerary_type ) && ! isset( $resource ) ) {
	$show_smithsonian = true;
} else {
	$show_smithsonian = false;
}

if ( is_single( '1147' ) ) {
	// On heritage collection (id: 1147), open itinerary in new tab
	// to preserve results from date selection. 
	$target = "_blank";
} else {
	$target = "_self";
}
?>

<?php if ( $show_smithsonian ) : ?>
	<img class="smithsonian-image" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian-small.png' ); ?>" />
<?php endif; ?>

<div class="tile-content">
	
	<?php if ( !empty( $meta_list ) ) : ?>
	<ul class="meta list-unstyled">

		<?php foreach( $meta_list as $meta ) : ?>
			<?php if ( array_key_exists('url', $meta) ) : ?>

			<li><a href="<?php echo esc_url( $meta['url'] ); ?>"><?php echo $meta['name']; ?></a></li>
			
			<?php else : ?>

			<li class="list-tag-no-link"><?php echo $meta['name']; ?></li>	
			
			<?php endif; ?>
		<?php endforeach; ?>

	</ul>
	<?php endif; ?>
	
	<h3 class="h2 tile-title"><?php echo $title; ?></h3>

	<?php $tile_synopsis = get_post_meta( $post->ID, 'itinerary_tile_synopsis_content', true ); 
	if ( $tile_synopsis && !empty( $tile_synopsis ) && !isset( $is_itinerary ) ) : ?>
		<p class="tile-synopsis"><?php echo $tile_synopsis; ?></p>
	<?php endif; ?>

</div>

<a class="tile-link" href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>"><span class="hide">Go to <?php echo $title; ?></span></a>
