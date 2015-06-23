<?php
/**
 * Header used for the resource center landing page template
 */

$resources_page = get_page_by_path( 'resource-center' );
?>

<section class="primary-section">
	<header class="section-header resources-header">
		<div class="section-header-content">
			<h1><?php echo apply_filters( 'the_title', $resources_page->post_title ) ?></h1>

			<p class="description">
				<?php echo apply_filters( 'the_content', $resources_page->post_excerpt ) ?>
			</p>
		</div>
	</header>
</section>

<section class="section-content">

	<span class="h2">Answers just right for &hellip;</span>


	<nav class="resource-targets">
		<?php
		$top_level_terms = get_terms( 'resource-target', array(
			'parent' => 0
		) );
		?>

		<?php foreach ( $top_level_terms as $top_level_term ) : ?>
			<?php
			if ( 'featured' != strtolower( $top_level_term->name ) ) :

			$child_terms = get_terms( 'resource-target', array(
				'parent' => $top_level_term->term_id
			) );
			?>
			<div class="<?php esc_attr( $top_level_term->name ); ?>">
				<a href="<?php echo get_term_link( $top_level_term ); ?>"><h2><?php echo $top_level_term->name; ?></h2></a>
				<div class="resource-target-list">
					<span class="h3">Which describes you best?</span>
					<ul>
					<?php foreach ( $child_terms as $child_term ) : ?>
						<li><a href="<?php echo get_term_link( $child_term ); ?>"><?php echo $child_term->name; ?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</nav>

</section>