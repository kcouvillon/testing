<?php 
/*
 *	Template Name: Explore
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area" ng-app="exploreApp">
	<main id="main" class="site-main" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
			$class = '';
		} else {
			$class = ' pattern-1';
		}
		?>

		<section class="explore primary-section">
			<header class="section-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">

					<h1 class="section-title"><?php the_title(); ?></h1>
					<p class="description"><?php the_content(); ?></p>

				</div>
			</header>
		</section>

		<section class="explore-tool">

			<div class="explore-utility ws-container">
				<span class="search-by"><i class="icon-arrow-down"></i> Use the filters below to narrow your search</span>
				<a href="#clear-filters" class="clear-all"><i class="icon icon-small-close"></i> Clear filters</a>
			</div>

			<?php get_template_part('partials/explore', 'filters'); ?>		

			<?php get_template_part('partials/explore', 'results') ?>

		</section>

	</main> 
</div>

<?php get_footer(); ?>
