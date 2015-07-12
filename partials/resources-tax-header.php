<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<?php
$title = get_queried_object()->name;
$parent_id = get_queried_object()->parent;
if ( !empty ($parent_id) ) {
	$parent = get_term( $parent_id, 'resource-target' );
	$parent_link = get_term_link( $parent, 'resource-target' );
}
?>


<section class="primary-section">
	<header class="section-header resources-header pattern-8">
		<div class="section-header-content">
			<nav class="breadcrumbs">
				<?php // @todo needs to be dynamic ?>
				<a href="<?php echo get_permalink(); ?>">Resource Center</a>
				<?php if( !empty ( $parent ) ) { ?>

				>
				<a href="<?php echo $parent_link; ?>"><?php echo $parent->name; ?></a>

				<?php } ?>
				>
				<?php echo $title; ?>
			</nav>
			<h1><?php echo $title; ?></h1>
		</div>
	</header>

	<?php
	$shared_terms = array();
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	// Only display this nav on child terms
	if( $term->parent > 0 ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$terms = wp_get_post_terms( $post->ID, 'resource-type' );

			// Get terms from each post and add to array
			foreach ( $terms as $term ) {
				$shared_terms[] = $term->term_id;
			}
			?>

		<?php endwhile; ?>

		<?php
		$shared_terms = array_unique( $shared_terms );

		$resource_types = get_terms( 'resource-type', array(
			'hide_empty' => false,
			'include'    => $shared_terms
		) );

		// @todo we may want to store these menus in transients or some sort of cache if they proove problematic
		?>

		<nav class="resource-nav section-nav">
			<div class="section-menu">
				<ul>
					<?php foreach( $resource_types as $type ) : ?>

						<li>
							<a href=""><?php echo $type->name; ?></a>
						</li>

					<?php endforeach; ?>
				</ul>
			</div>
		</nav>

	<?php endif; ?>

</section>