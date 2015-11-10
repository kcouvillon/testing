<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<section class="primary-section">
	<?php
	$background = '';
	if ( has_post_thumbnail() ) {
		$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
		$background = 'url(' . $featured[0] . ')';
		$class = '';
	} else {
		$class = ' ' . WS_Helpers::get_random_pattern() . ' ';
	} ?>
	<header class="section-header resources-header <?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
		<div class="ws-container">
			<div class="section-header-content">
				<nav class="breadcrumbs">
					<?php
					$resource_page = get_page_by_path('resource-center');
					?>
					<a href="<?php echo home_url( '/') . get_page_uri($resource_page->ID); ?>">Resource Center</a>
					>
					<span><?php the_title(); ?></span>
				</nav>
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</header>
</section>
