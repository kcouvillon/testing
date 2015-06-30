<?php
/**
 * Template Name: Why WorldStrides
 *
 * Template for the Why WorldStrides page
 *
 * @todo figure out where the various content pieces are being stored
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $featured[0] . ')';
		}
		?>

		<?php $sections = get_post_meta( $post->ID, 'why_worldstrides_section_group', true ); ?>

		<section class="primary-section">
			<header class="section-header" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">
					<h1 class="page-title section-title">Why Travel With WorldStrides?</h1>
					<?php the_content(); ?>
				</div>
			</header>

			<nav class="section-nav">
				<ul class="section-menu">
					<?php foreach ( $sections as $section ) : ?>
						<li>
							<a href="#<?php echo sanitize_title( $section['title'] ); ?>"><?php echo apply_filters( 'title', $section['title'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</section>

		<?php foreach ( $sections as $section ) : ?>
			<section>
				<a name="<?php echo sanitize_title( $section['title'] ); ?>"></a>
				<?php
				$image = esc_url( $section['image'] );
				$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $image . ')';
				?>
				<header class="section-header<?php echo ( !empty( $image ) ) ? ' has-section-image' : ''; ?>" style="background-image: <?php echo $background; ?>;">
					<div class="section-header-content">
						<h1 class="page-title section-title"><?php echo apply_filters( 'title', $section['title'] ); ?></h1>

						<p><?php echo esc_textarea( $section['description'] ); ?></p>
					</div>
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
