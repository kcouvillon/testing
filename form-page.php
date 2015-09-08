<?php
/*
Template Name: Form Page
 */

 get_header(); ?>

<div id="primary" class="content-area form-page">
	<main id="main" class="site-main" role="main">

		<section class="primary-section">
			<header class="section-header pattern-3">
				<div class="section-header-content">
					<h1 class="section-title"><?php the_title(); ?></h1>
				</div>
			</header>
		</section>

		<?php the_post(); ?>

		<section class="section-content">

			<?php the_content(); ?>

		</section>

	</main>
</div>

<?php get_footer(); ?>
