<?php
/**
 * Reusable breadcrumb code for division landing pages
 */

$division_slug = $post->post_name;

if ( 'discoveries' == $division_slug ) {
	$division_breadcrumbname = 'Middle School';
} elseif ( 'perspectives' == $division_slug ) {
	$division_breadcrumbname = 'High School';
} elseif ( 'capstone' == $division_slug ) {
	$division_breadcrumbname = 'Capstone';
} elseif ( 'on-stage' == $division_slug ) {
	$division_breadcrumbname = 'Performing Arts';
} elseif ( 'sports' == $division_slug ) {
	$division_breadcrumbname = 'Sports';
} else {
	$division_breadcrumbname = get_the_title();
}

?>

	<nav class="breadcrumbs hide-print">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>>
		<span><?php echo apply_filters( 'the_title', $division_breadcrumbname ); ?></span>
	</nav>
