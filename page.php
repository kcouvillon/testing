<?php
/**
 * Template Name: Default Page
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="primary-section">
				<header class="section-header pattern-8">
					<div class="ws-container">
						<div class="section-header-content">
							<h1><?php the_title(); ?></h1>
						</div>
					</div>
				</header>
			</section>

			<section class="section-content">
				<?php the_post(); ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

			</section>

		</main>
	</div>

<?php get_footer();