<?php
/**
 * Template Name: About - Careers
 *
 * This is the template for the Careers page. Make sure this page is selected from the template drop down
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php get_template_part( 'partials/about', 'header' ); ?>

		<?php the_post(); ?>

		<div class="about-wrap">

			<section class="about career section-content">
				<?php get_template_part( 'partials/content', 'about' ) ?>

				<a href="<?php echo esc_url('http://chc.tbe.taleo.net/chc01/ats/careers/jobSearch.jsp?org=WORLDSTRIDES&cws=1'); ?>" class="btn btn-primary career-btn">View our Current Openings</a>

				<?php
				$benefits_title       = get_post_meta( $post->ID, 'about_careers_benefits_title', true );
				$benefits_description = get_post_meta( $post->ID, 'about_careers_benefits_description', true );
				$benefits             = get_post_meta( $post->ID, 'about_careers_benefits_list', true );
				?>
				<section class="benefits">
					<h3><?php echo apply_filters( 'the_title', $benefits_title ); ?></h3>

					<?php echo apply_filters( 'the_content', $benefits_description ); ?>

					<div class="benefits-wrap">
						<?php if ( is_array( $benefits ) ) : ?>
							<?php foreach ( $benefits as $benefit ) : ?>
								<div class="benefit">
									<?php
									$image_url = '';
									if ( array_key_exists( 'image', $benefit ) && ! '' == $benefit['image'] ) {
										$image_url = $benefit['image'];
									} else {
										$image_url = 'http://placehold.it/80x80';
									}
									?>
									<img class="benefit-img" src="<?php echo esc_url( $image_url ); ?>" alt="">
									<span class="benefit-desc"><?php echo $benefit['description']; ?></span>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</section>

				<section class="career-examples">
					<?php
					$examples_title       = get_post_meta( $post->ID, 'about_careers_examples_title', true );
					$examples_description = get_post_meta( $post->ID, 'about_careers_examples_description', true );
					$examples             = get_post_meta( $post->ID, 'about_careers_examples_list', true );
					?>
					<h3><?php echo apply_filters( 'the_title', $examples_title ); ?></h3>

					<?php echo apply_filters( 'the_content', $examples_description ); ?>

					<div class="example-wrap">
						<?php if ( is_array( $examples ) ) : ?>
							<?php foreach ( $examples as $example ) : ?>
								<article class="example">
									<?php
									if ( array_key_exists( 'image', $example ) && ! '' == $example['image'] ) {
										$image_url = $example['image'];
										?>
										<div class="headshot">
											<img src="<?php echo esc_url( $image_url ); ?>" alt="">
										</div>
									<?php } else { ?>
										<div class="headshot-pattern pattern-<?php echo rand(1,9); ?>"></div>
									<?php } ?>
									<header class="entry-title">
										<h3 class="entry-name"><?php echo apply_filters( 'the_title', $example['name'] ); ?></h3>
										<span class="entry-desc"><?php echo apply_filters( 'the_title', $example['position'] ); ?></span>
									</header>
									<div class="entry-content">
										<?php echo apply_filters( 'the_content', $example['description'] ); ?>
									</div>
								</article>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</section>

			</section>

			<?php get_template_part( 'partials/module', 'contact' ) ?>

		</div>
		<!-- .about-wrap -->

	</main>
</div>

<?php get_footer(); ?>
