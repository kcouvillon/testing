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
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	if( $term->parent > 0 ) : ?>

	<nav class="resource-nav section-nav">
		<?php wp_nav_menu( array( 'theme_location' => 'resource-types', 'menu_class' => 'section-menu' ) ); ?>
	</nav>

	<?php endif; ?>

</section>