<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<section class="primary-section">
	<header class="section-header resources-header">
		<div class="ws-container">
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
				<h1>{STATIC} Resources for Middle School Teachers</h1>
			</div>
		</div>
	</header>
	<nav class="resource-nav section-nav">
		<div class="ws-container">
			<ul class="section-menu">
				<?php
					$resource_types = get_terms( 'resource-type', array( 'hide_empty' => false ) );
					foreach( $resource_types as $type ) : ?>
					
					<li>
						<a href=""><?php echo $type->name; ?></a>
					</li>
					
				<?php endforeach; ?>
			</ul>
		</div>
	</nav>
</section>