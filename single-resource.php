<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'single-header' ); ?>

		<?php the_post(); ?>

		<section class="section-content">
			<div class="resource-content">
				<?php the_content(); ?>
			</div>

			<aside class="resource-related related-terms-list">
				<?php
					$terms = wp_get_post_terms( $post->ID, 'resource-target');
					if ( !empty( $terms ) ) { ?>

						<h6>Related to</h6>
						<ul>

						<?php foreach ( $terms as $term ) { ?>
								<li><a href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a></li>

							<?php
							}
						?>
						</ul>
					<?php	
					}
				?>
			</aside>
		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
