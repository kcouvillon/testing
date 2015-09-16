<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<section class="primary-section">
	<header class="section-header resources-header pattern-<?php echo rand(1, 9); ?>">
		<div class="ws-container">
			<div class="section-header-content">
				<nav class="breadcrumbs">
					<?php
					$resource_page = get_page_by_path('resource-center');
					?>
					<a href="<?php echo home_url( '/') . get_page_uri($resource_page->ID); ?>">Resource Center</a>
					>
					<span><?php the_title(); ?></span>
				</nav>
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</header>
</section>