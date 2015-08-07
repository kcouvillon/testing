<?php
/**
 * The template for displaying 404 pages (not found).
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="primary-section">
				<header class="section-header error-header pattern-6">
					<div class="section-header-content">
						<h1 class="page-title"><?php _e( 'Oops! We don’t know where that page is.', 'obsub' ); ?></h1>
						<h4 class="description">But we know where the Louvre is!</h4>
						<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>" class="btn btn-primary">Explore our trips »</a>
					</div>
				</header>
			</section>

			<section class="error-map" style="background-image:url(https://api.tiles.mapbox.com/v4/worldstrides.b898407f/url-http%3A%2F%2Fwsbeta.co%2Fwp-content%2Fthemes%2Fworldstrides%2Fassets%2Fimages%2Fpin-orange.png\(2.3358607292175293,48.86101631231847\)/2.3358607292175293,48.86009631231847,15/1280x450.png?access_token=pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg);"></section><!-- .about-wrap -->

		</main>
	</div>

<?php get_footer(); ?>