<?php
/**
 * Header used across the resources page templates
 */

$resources_page = get_page_by_path( 'resources' );
?>

<header class="resources">
	<h1><?php echo apply_filters( 'the_title', $resources_page->post_title ) ?></h1>

	<p class="description">
		<?php echo apply_filters( 'the_content', $resources_page->post_excerpt ) ?>
	</p>
</header>

<nav class="resources-target">
	<ul>
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
				<h2><a href="<?php echo get_term_link( $top_level_term ); ?>"><?php echo $top_level_term->name; ?></a></h2>

				<?php foreach ( $child_terms as $child_term ) : ?>
					<ul>
						<h3>Which describes you best?</h3>
						<li><a href="<?php echo get_term_link( $child_term ); ?>"><?php echo $child_term->name; ?></a></li>
					</ul>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
</nav>

<?php if ( ! is_single() ) : ?>

<h2>Common Questions</h2>

<?php endif; ?>