<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

get_header();

$blocks_before = get_post_meta( $post->ID, 'attached_blocks_before', true);
$blocks_after = get_post_meta( $post->ID, 'attached_blocks_after', true);

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'single-header' ); ?>

		<?php the_post(); ?>

		<?php if ( ! empty( $blocks_before ) ) : ?>
			<section class="ws-container ws-blocks tour-blocks-before print-page-break">
				<?php foreach ( $blocks_before as $block_id ) : ?>

					<?php echo WS_Helpers::get_content_block( $block_id ); ?>

				<?php endforeach; ?>
			</section>
		<?php endif; ?>

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

		<?php if ( ! empty( $blocks_after ) ) : ?>
			<section class="ws-container ws-blocks tour-blocks-after print-page-break">
				<?php foreach ( $blocks_after as $block_id ) : ?>

					<?php echo WS_Helpers::get_content_block( $block_id ); ?>

				<?php endforeach; ?>
			</section>
		<?php endif; ?>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
