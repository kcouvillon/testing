<?php
/**
 * Reusable breadcrumb code, for collections, itineraries, ...
 */

	$product_lines = get_the_terms( $post->ID, 'product-line' );
	if( !$product_lines || is_wp_error( $product_lines ) || empty( $product_lines )  ) {
		$product_line = new stdClass();
		$product_line->slug = 'explore';
		$product_line->name = 'Explore';
	} else {
		$product_line = $product_lines[0];
	}

?>

	<nav class="breadcrumbs hide-print">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>>
		<a href="<?php echo esc_url( home_url( '/' . $product_line->slug . '/' ) ); ?>"><?php echo $product_line->name; ?> Educational Travel</a>>
		<span><?php the_title(); ?></span>
	</nav>
