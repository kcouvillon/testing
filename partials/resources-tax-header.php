<?php
/**
 * Header used for the resources taxonomy pages
 */
?>

<section class="primary-section">
	<header class="section-header resources-header">
		<div class="section-header-content">
			<h1><?php echo apply_filters( 'the_title', $wp_query->query_vars['taxonomy_name'] ) ?></h1>
		</div>
	</header>
</section>