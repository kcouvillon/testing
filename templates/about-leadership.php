<?php
/**
 * Template Name: About - Leadership
 *
 * The template for the Leadership page
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>
		
		<section class="section-content leadership-content">
			<?php get_template_part( 'partials/content', 'about' ) ?>
		</section>
		<p class="section-content" style="font-size: 32px; font-weight:bold">Programs</p>
		<section class="section-content leadership">
			<?php $associated_bios = get_post_meta( $post->ID, 'ws_attached_leadership_bios', true ); ?>

			<?php if ( 0 == count( $associated_bios ) ) : ?>
				<p>No leadership bios found.</p>
			<?php endif; ?>


			<?php
				$program_count = 0;
				$customer_contact_count = 0;
				$shared_support_count = 0;
			?>

			<?php //NEED TO RUN MULTIPLE TIMES IN ORDER TO SPLIT BIOS UP INTO GROUPS ?>

			<?php foreach ( $associated_bios as $bio_id ) : ?>
				<?php $post = get_post( $bio_id ); ?>
				<?php setup_postdata($post); ?>
				<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>
				<?php $group = get_post_meta( $post->ID, 'ws_bio_group', true ); ?>
				<?php if ($group == 'programs') : ?>
					<?php $program_count++; ?>

				<article <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="headshot clearfix">
								<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?></a>
							</div>
						<?php else : ?>
							<div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
								<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"></a>
							</div>
						<?php endif; ?>

						<h3 class="leader-name entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h3>

						<?php if ( $position ) : ?>
							<span class="entry-position"><?php echo esc_html( $position ); ?></span>
						<?php endif; ?>
					</header>

					<div class="entry-content">
						<?php
							if ( get_the_excerpt() ) {
								the_excerpt();
							} else {
								the_content();
							}
						?>
					</div>

					<footer class="entry-footer">
						<a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
					</footer>
				</article>
			<?php endif; ?>

			<?php endforeach; wp_reset_postdata(); ?>
			<?php if ($program_count > 0): ?>
			<br><br>
			<?php endif; ?>
			<p style="font-size: 32px; font-weight:bold; clear:both">Customer Contacts</p>
			<?php ////////////////////////////////////////////////////////////
			//SECOND ITERATION ?>
			<?php foreach ( $associated_bios as $bio_id ) : ?>
				<?php $post = get_post( $bio_id ); ?>
				<?php setup_postdata($post); ?>
				<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>
				<?php $group = get_post_meta( $post->ID, 'ws_bio_group', true ); ?>

				<?php if ($group == 'customer_contact') : ?>
					<?php $customer_contact_count++; ?>
					<article <?php post_class(); ?>>
						<header class="entry-header">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="headshot clearfix">
									<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?></a>
								</div>
							<?php else : ?>
								<div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
									<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"></a>
								</div>
							<?php endif; ?>

							<h3 class="leader-name entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h3>

							<?php if ( $position ) : ?>
								<span class="entry-position"><?php echo esc_html( $position ); ?></span>
							<?php endif; ?>
						</header>

						<div class="entry-content">
							<?php
							if ( get_the_excerpt() ) {
								the_excerpt();
							} else {
								the_content();
							}
							?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
						</footer>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if ($customer_contact_count > 0 ): ?>

			<?php endif; ?>
			<p style="font-size: 32px; font-weight:bold; clear:both">Shared Support</p>
			<?php /////////////////////////////////////////////////////
			/////////////////////THIRD ITERATION ?>
			<!--<h2>Shared Support</h2>-->
			<?php foreach ( $associated_bios as $bio_id ) : ?>
				<?php $post = get_post( $bio_id ); ?>
				<?php setup_postdata($post); ?>
				<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>
				<?php $group = get_post_meta( $post->ID, 'ws_bio_group', true ); ?>

				<?php if ($group == 'shared_support') : ?>
					<article <?php post_class(); ?>>
						<header class="entry-header">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="headshot clearfix">
									<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?></a>
								</div>
							<?php else : ?>
								<div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern(); ?>">
									<a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"></a>
								</div>
							<?php endif; ?>

							<h3 class="leader-name entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h3>

							<?php if ( $position ) : ?>
								<span class="entry-position"><?php echo esc_html( $position ); ?></span>
							<?php endif; ?>
						</header>

						<div class="entry-content">
							<?php
							if ( get_the_excerpt() ) {
								the_excerpt();
							} else {
								the_content();
							}
							?>
						</div>

						<footer class="entry-footer">
							<a href="<?php the_permalink(); ?>">Read more about <?php the_title(); ?></a>
						</footer>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>


	</main>
</div>

<?php get_footer(); ?>
