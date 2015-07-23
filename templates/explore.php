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
			$background = 'linear-gradient( rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28) ), url(' . $featured[0] . ')';
		}
		?>

		<section class="explore primary-section">
			<header class="section-header pattern-1" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">

					<h1 class="section-title"><?php the_title(); ?></h1>
					<p class="description"><?php the_content(); ?></p>

				</div>
			</header>
		</section>

		<section class="explore-tool" ng-view></section>

	</main>
</div>

<?php get_footer(); ?>
