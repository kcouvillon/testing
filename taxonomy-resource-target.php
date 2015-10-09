<?php
/**
 * Template for the blog categories
 */

get_header();

$title = get_queried_object()->name;

$term_meta = Taxonomy_MetaData::get( 'resource-target', get_queried_object_id() );

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/resources', 'tax-header' ); ?>

		<section class="section-resource-questions">


		<?php if ( have_posts() ) : ?>

			<?php
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			
			if( $term->parent > 0 ) : ?>

				<h2>Questions About</h2>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'partials/resources', 'questions' ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php if ( ! empty( $term_meta['attached_blocks_before'] ) ) : ?>
					<section class="ws-container ws-blocks tour-blocks-before print-page-break">
					<?php foreach ( $term_meta['attached_blocks_before'] as $block_id ) : ?>

						<?php echo WS_Helpers::get_content_block( $block_id ); ?>

					<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php get_template_part( 'partials/resources', 'child-terms-list' ); ?>

				<?php if ( ! empty( $term_meta['attached_blocks_after'] ) ) : ?>
					<section class="ws-container ws-blocks tour-blocks-after print-page-break">
						<?php foreach ( $term_meta['attached_blocks_after'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					</section>
				<?php endif; ?>

			<?php endif; ?>

		<?php else : ?>

			<p>Nothing found</p>

		<?php endif; ?>

		</section>

		<?php get_template_part( 'partials/module', 'contact' ) ?>

	</main>
</div>

<?php get_footer(); ?>
