<?php
/**
 * Template Name: Why WorldStrides
 *
 * Template for the Why WorldStrides page
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'linear-gradient( 90deg, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0) ), url(' . $featured[0] . ')';
		}
		?>

		<?php $sections = get_post_meta( $post->ID, 'why_worldstrides_section_group', true ); ?>

		<section class="primary-section">
			<header class="section-header" style="background-image: <?php echo $background; ?>;">
				<div class="mobile-hero">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
				<div class="ws-container">
					<div class="section-header-content">
						<h1 class="page-title section-title">Why Travel With WorldStrides?</h1>
						<?php the_content(); ?>
					</div>
				</div>
			</header>

			<nav id="section-nav" class="section-nav">
				<div class="ws-container">
					<ul class="section-menu">
						<?php foreach ( $sections as $section ) : ?>
							<li>
								<a href="#<?php echo sanitize_title( $section['title'] ); ?>"><?php echo apply_filters( 'title', $section['title'] ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</nav>

			<?php if ( has_post_thumbnail() ) : ?>
			<a href="#section-nav" class="content-cta">
				<span class="hide">Skip to Content</span>
				<i class="icon-arrow-down"></i>
			</a>
			<?php endif; ?>
				
		</section>

		<?php foreach ( $sections as $section ) : ?>
			<section>
				<a name="<?php echo sanitize_title( $section['title'] ); ?>"></a>
				<?php
				$featured = wp_get_attachment_image_src( $section['image_id'], 'itinerary' );
				$background = 'linear-gradient( 90deg, rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0) ), url(' . $featured[0] . ')';
				?>
				<header class="section-header<?php echo ( !empty( $featured ) ) ? ' has-section-image' : ''; ?>" style="background-image: <?php echo $background; ?>;">
					<div class="ws-container">
						<div class="section-header-content">
							<h2 class="h1 page-title section-title"><?php echo apply_filters( 'title', $section['title'] ); ?></h2>

							<p><?php echo esc_textarea( $section['description'] ); ?></p>
						</div>
					<div class="ws-container">
				</header>

				<div class="section-content why-content">

					<?php $associated_why_ws = $section['attached_why_ws']; ?>

					<?php if ( 0 == count( $associated_why_ws ) ) : ?>
						<p>Nothing found.</p>
					<?php endif; ?>

					<?php foreach ( $associated_why_ws as $why_ws ) : ?>

						<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

	</main>
</div>

<?php get_footer(); ?>
