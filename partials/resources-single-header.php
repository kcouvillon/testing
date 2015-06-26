<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<section class="primary-section">
	<header class="section-header resources-header">
		<div class="section-header-content">
			<nav class="breadcrumbs">
				<?php
				$resource_page = get_page_by_path('resource-center');
				?>
				<a href="<?php echo home_url( '/') . get_page_uri($resource_page->ID); ?>">Resource Center</a>
				>
				<a href="">Question</a>
				>
				<a href="">Do you book lorem ipsum dolor sit air travel?</a>
			</nav>
			<h1>{STATIC} Do you book lorem ipsum dolor sit air travel?</h1>
		</div>
	</header>
</section>