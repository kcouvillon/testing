<?php
/**
 * Header used for the resource center landing page template
 */

$resources_page = get_page_by_path( 'resource-center' );
?>

<section class="primary-section">
	<header class="section-header resources-header pattern-8">
		<div class="ws-container">
			<div class="section-header-content">
				<h1><?php echo apply_filters( 'the_title', $resources_page->post_title ) ?></h1>
				<?php if ( $resources_page->post_excerpt ) : ?>
					<div class="description">
						<?php echo apply_filters( 'the_content', $resources_page->post_excerpt ) ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header>
</section>

<section class="section-content">

	<p class="h2">Answers just right for &hellip;</p>

	<div class="resource-target-group">
		<?php
		$top_level_terms = get_terms( 'resource-target', array(
			'parent' => 0
		) );
		?>

		<?php foreach ( $top_level_terms as $top_level_term ) : ?>
			<?php
			if ( 'featured' != strtolower( $top_level_term->name ) ) :

			$child_terms = get_terms( 'resource-target', array(
				'parent' => $top_level_term->term_id,
				'hide_empty' => false
			) );

			$term_options = get_option( 'taxonomy_metadata_resource-target_' . $top_level_term->term_id );

			if ( ! empty( $term_options['feature_image'] ) ) {
				$img_url = $term_options['feature_image']; // could also use feature_image_id
			} else {
				$img_url = 'http://placehold.it/445x297';
			}

			?>
			<div class="<?php esc_attr( $top_level_term->name ); ?> resource-target">
				<a class="resource-target-title" href="<?php echo get_term_link( $top_level_term ); ?>">
					<div class="resource-image">
						<img src="<?php echo esc_url( $img_url ); ?>" alt="resource">
						<div class="screen gradient40"></div>
					</div>
					<h2><?php echo $top_level_term->name; ?></h2>
				</a>
				<div class="resource-target-list-wrap">
					<p class="h1"><?php echo $top_level_term->name; ?></p>
					<nav class="resource-target-list" role="navigation">
						<p class="h6">Which describes you best?</p>
						<ul>
						<?php foreach ( $child_terms as $child_term ) : ?>
							<li><a href="<?php echo get_term_link( $child_term ); ?>"><?php echo $child_term->name; ?></a></li>
						<?php endforeach; ?>
						</ul>
					</nav>
				</div>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class="resource-target-bg"></div>

</section>