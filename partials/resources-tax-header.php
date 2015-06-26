<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<?php
$title = get_queried_object()->name;
?>


<section class="primary-section">
	<header class="section-header resources-header">
		<div class="section-header-content">
			<nav class="breadcrumbs">
				<?php // @todo needs to be dynamic ?>
				{STATIC}
				<a href="">Resource Center</a>
				>
				<a href="">Educators</a>
				>
				<a href="">High School</a>
			</nav>
			<h1><?php echo $title; ?></h1>
		</div>
	</header>

	<?php
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	if( $term->parent > 0 ) : ?>

	<nav class="resource-nav section-nav">
		<ul class="section-menu">
			<?php
				$resource_types = get_terms( 'resource-type', array( 'hide_empty' => false ) );
				foreach( $resource_types as $type ) : ?>
				
				<li>
					<a href=""><?php echo $type->name; ?></a>
				</li>

			<?php endforeach; ?>
		</ul>
	</nav>

	<?php endif; ?>

</section>