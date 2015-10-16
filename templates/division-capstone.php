<?php
/**
 * Template Name: Division - Capstone
 */

$section_link = 1;
$section_num = 1;

$associated_why_ws = get_post_meta( $post->ID, 'attached_why_ws', true);
$associated_resources = get_post_meta( $post->ID, 'attached_resources', true);
$before_block_sections = get_post_meta( $post->ID, 'division_blocks_before_list', true );
$after_block_sections = get_post_meta( $post->ID, 'division_blocks_after_list', true );
$associated_bios = get_post_meta( $post->ID, 'attached_bios', true );
$partnerships = get_post_meta( $post->ID, 'division_partnerships_partners', true );
$partnerships_small = get_post_meta( $post->ID, 'division_partnerships_small_partners', true );

$display_title = get_post_meta( $post->ID, 'general_display_title', true );

if ( ! $display_title ) {
	$display_title = get_the_title();
}

$post_obj = $wp_query->get_queried_object();

$associated_collections_override = get_post_meta( $post->ID, 'associated_collections', true );

if ( $associated_collections_override ) {
	$associated_collections = new WP_Query( array(
		'post_type'              => 'collection',
		'posts_per_page'         => 75,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'post__in'               => $associated_collections_override,
		'orderby'                => 'post__in'
	) );
} else {
	$post_obj = $wp_query->get_queried_object();

	$associated_collections = new WP_Query( array(
		'post_type'              => 'collection',
		'tax_query'              => array(
			array(
				'taxonomy' => 'product-line',
				'field'    => 'slug',
				'terms'    => $post_obj->post_name
			)
		),
		'posts_per_page'         => 75,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'order'                  => 'ASC',
		'orderby'                => 'title'
	) );
}

if ( 'discoveries' == $post->post_name ) {
	$division_target = 'Middle School';
} elseif ( 'perspectives' == $post->post_name ) {
	$division_target = 'High School';
} elseif ( 'capstone' == $post->post_name ) {
	$division_target = 'Capstone';
} elseif ( 'on-stage' == $post->post_name ) {
	$division_target = 'Performing Arts';
} else {
	$division_target = get_the_title();
}

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main collection" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
			$class = '';
		} else {
			$class = ' pattern-' . rand( 3, 9 );
		} ?>
		<section class="primary-section">
			<header class="section-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
				<div class="mobile-hero">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
				<div class="ws-container">
					<div class="section-header-content">
						<nav class="breadcrumbs hide-print">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>>
							<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore Educational Travel</a>>
							<span><?php echo apply_filters( 'the_title', $division_target ); ?></span>
						</nav>
						<h1><?php echo apply_filters( 'the_title', $display_title ); ?></h1>

						<?php $subtitle = get_post_meta( $post->ID, 'division_options_subtitle', true ); ?>

						<?php if ( $subtitle ) : ?>
							<p class="header-subtitle"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
						<?php endif; ?>

						<?php the_content(); ?>
					</div>

				</div>
				
				<?php get_template_part( 'partials/content', 'tooltips' ); ?>

			</header>

			<nav class="section-nav">
				<div class="ws-container">
					<ul class="section-menu hide-print">

						<?php if ( ! empty( $associated_why_ws ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Why WorldStrides?</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $associated_resources ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Resources</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $before_block_sections ) ) : ?>
							<?php foreach ( $before_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['division_blocks_before_title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['division_blocks_before_title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php if ( $associated_collections->have_posts() ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Collections</a></li>
						<?php endif; ?>

						<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Global Reach</a></li>

						<?php if ( ! empty( $associated_bios ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Team</a></li>
						<?php endif; ?>
						<?php if ( ! empty( $partnerships ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Affiliations</a></li>
						<?php endif; ?>

						<?php if ( ! empty( $after_block_sections ) ) : ?>
							<?php foreach ( $after_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['division_blocks_after_title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['division_blocks_after_title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

					</ul>

					<a href="<?php echo esc_url( home_url( '/request-info/' ) ); ?>" class="btn btn-primary subnav-cta">Request Info</a>
				</div>
			</nav>

		</section>

		<?php if ( ! empty( $associated_why_ws ) ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content why-content">

			<?php foreach ( $associated_why_ws as $why_ws ) : ?>

				<?php echo WS_Helpers::get_value_proposition( $why_ws ); ?>

			<?php endforeach; ?>

		</section>

		<?php endif; ?>

		<?php $display_discover_why = get_post_meta( $post->ID, 'discover_why', true); ?>
		<?php if ( 'on' == $display_discover_why ) : ?>
		<?php get_template_part( 'partials/module', 'discover-why' ); ?>
		<?php endif; ?>

		<?php if ( $associated_resources ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="section-content resources">
			<h2 class="section-title">Have Questions? We Have Answers.</h2>

			<ul class="resources-list list-unstyled clearfix">

				<?php foreach ( $associated_resources as $resource_id ) : ?>
					
					<?php 
					$resource = get_post( $resource_id );
					$background = '';
					$targets = wp_get_object_terms( $resource_id, 'resource-target' );
					$target_parents = array();
					$url = get_the_permalink( $resource_id );
					$title = apply_filters( 'the_title', $resource->post_title );
					$meta_list = array();
					
					foreach ( $targets as $target ) {
						if ( 'Featured' != $target->name ) {
							$parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' );
							if ( ! in_array( $parent->term_id, $target_parents ) ) {
								$target_parents[] = $parent->term_id;
								$target_url = home_url( '/resources/' . $parent->slug . '/' );
								$target_name = $parent->name;
								array_push( $meta_list , array( 'url' => $target_url, 'name' => $target_name ) );
							}

						}
					}

					if( has_post_thumbnail( $resource_id ) ) {
						$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $resource_id ), 'large' );
						$background = 'url(' . $featured[0] . ');';
						$class = ' has-tile-image';
					} else {
						$class = ' ' . WS_Helpers::get_random_pattern('dark');
					}
					?>

					<li class="resource tile tile-third <?php echo esc_attr($class); ?>" style="background-image:<?php echo $background; ?>);">
						<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
					</li>

				<?php endforeach; ?>

			</ul>
		</section>
		<?php endif; ?>

		<?php if ( ! empty( $before_block_sections ) ) : ?>

		<section class="ws-container ws-blocks tour-blocks-before print-page-break">

			<?php foreach ( $before_block_sections as $section ) : ?>
				<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
				<?php if ( ! empty( $section['division_blocks_before_title'] ) ) : ?>
					<h2 class="ws-blocks-title"><?php echo apply_filters( 'the_title', $section['division_blocks_before_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
					<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

						<?php echo WS_Helpers::get_content_block( $block_id ); ?>

					<?php endforeach; ?>
				<?php endif; ?>

			<?php endforeach; ?>

		</section>

		<?php endif; ?>

		<?php if ( $associated_collections->have_posts() ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

			<section class="section-content programs">
				<h2 class="section-title ws-container">Collections</h2>
				<ul class="programs-list bleed-container list-unstyled clearfix">
					<?php while ( $associated_collections->have_posts() ) : ?>
						
						<?php 
						$associated_collections->the_post();
						$background = '';
						$title = get_the_title();
						$url = get_the_permalink();
						$meta_list = array();
						if( has_post_thumbnail( $post->ID ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
							$background = 'url(' . $featured[0] . ')';
							$class = ' has-tile-image';
						} else {
							$class = ' ' . WS_Helpers::get_random_pattern('dark');
						}
						?>

						<li class="program tile tile-third<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>	
						</li>

					<?php endwhile; ?>
				</ul>

			</section>
		<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

		<section class="section-content bleed-container global-reach">

			<h2 class="section-title ws-container">Global Reach</h2>

			<div id="office-map"></div>
			<div id="offices-json" data-prefix="division_locations_" style="display: none;">
				<?php echo json_encode( get_post_meta( $post->ID, 'division_locations_list', true ) ); ?>
			</div>

		</section>

		<?php if ( ! empty( $associated_bios ) ) : ?>
		<section class="section-content">
		
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>

			<h2>University Team</h2>

			<div class="leadership">
			
			<?php foreach ( $associated_bios as $bio_id ) : ?>
				<?php $post = get_post($bio_id); ?>
				<?php setup_postdata( $post ); ?>
				<?php $position = get_post_meta( $post->ID, 'ws_bio_position', true ); ?>

				<article <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="headshot clearfix">
								<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
							</div>
						<?php else : ?>
							<div class="headshot-pattern <?php echo WS_Helpers::get_random_pattern('dark'); ?>">

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
				</article>

			<?php endforeach; wp_reset_postdata(); ?>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( ! empty( $partnerships ) ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="section-content partners">
				<h2 class="h3"><?php echo apply_filters( 'the_title', get_post_meta( $post->ID, 'division_partnerships_title', true ) ); ?></h2>
				<div class="partner-wrap">
					<?php foreach ( $partnerships as $partnership ) : ?>
						<div class="partner">
							<?php if ( $partnership['image'] ) : ?>
							<a href="<?php echo $partnership['url']; ?>" target="_blank">
								<img src="<?php echo $partnership['image']; ?>" class="partner-img" />
							</a>
							<?php endif; ?>
							<h3 class="h5"><a href="<?php echo $partnership['url']; ?>" target="_blank"><?php echo $partnership['title']; ?></a></h3>
							<p><?php echo $partnership['description']; ?></p>
						</div>
					<?php endforeach;?>
				</div>

				<h2 class="h3"><?php echo apply_filters( 'the_title', get_post_meta( $post->ID, 'division_partnerships_small_title', true ) ); ?></h2>
				<?php if ( ! empty( $partnerships_small ) ) : ?>
					<?php foreach ( $partnerships_small as $partnership ) : ?>
						<h3 class="h5"><a href="<?php echo $partnership['url']; ?>"><?php echo $partnership['title']; ?></a></h3>
					<?php endforeach;?>
				<?php endif; ?>

				<a href="<?php echo esc_url( home_url( '/about/partnerships/' ) ); ?>" class="btn btn-primary">For more, visit Partnerships</a>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $after_block_sections ) ) : ?>
		<?php foreach ( $after_block_sections as $section ) : ?>
		<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
		<section class="ws-container ws-blocks tour-blocks-after">
			<?php if ( ! empty( $section['division_blocks_after_title'] ) ) : ?>
				<h2 class="ws-blocks-title"><?php echo apply_filters( 'the_title', $section['division_blocks_after_title'] ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
				<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

					<?php echo WS_Helpers::get_content_block( $block_id ); ?>

				<?php endforeach; ?>
			<?php endif; ?>
		</section>

		<?php endforeach; ?>
		<?php endif; ?>

		<?php $display_blog = get_post_meta( $post->ID, 'division_options_blog', true); ?>
		<?php if ( 'on' == $display_blog ) : ?>
		<?php
		$blog_posts = new WP_Query( array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'no_found_rows' => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		));
		?>

		<?php if ( $blog_posts->have_posts() ) : ?>
		<section class="home-section blog">
			<div class="ws-container">
				<h2 class="section-title"><a class="text-color-link" href="<?php echo home_url('/blog/'); ?>">Latest Stories from the WorldStrides Blog</a></h2>
			</div>

			<?php $sidebar_open = false; ?>

			<div class="blog-wrap">
				<?php $count = 0; ?>
				<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>

			<?php if ( 0 == $count ) : ?>
				<section class="section-one">
					<?php get_template_part( 'partials/content', 'blog' ); ?>
				</section>
			<?php endif; ?>

			<?php if ( 1 == $count ) : ?>
				<aside class="sidebar">
					<?php $sidebar_open = true; ?>
					<?php get_template_part( 'partials/content', 'blog-sidebar' ); ?>
					<?php endif; ?>

					<?php if ( 2 == $count ) : ?>
						<?php get_template_part( 'partials/content', 'blog-sidebar' ); ?>
					<?php endif; ?>

					<?php $count++; ?>
					<?php endwhile; ?>

					<?php if ( $sidebar_open ) : ?>
				</aside>
			<?php endif; ?>

			</div>

		</section>
		<?php endif; ?>
		<?php endif; ?>


		<?php
		$additional_info_request_box = get_post_meta( $post->ID, 'additional_info_request_box', true );
		$additional_info_text = get_post_meta( $post->ID, 'additional_info_text', true );
		$additional_info_email_title = get_post_meta( $post->ID, 'additional_info_email_title', true );
		$additional_info_email_text = get_post_meta( $post->ID, 'additional_info_email_text', true );
		?>

		<?php if ( 'on' == $additional_info_request_box ) : ?>
			<?php get_template_part( 'partials/module', 'request-info' ); ?>
		<?php endif; ?>

		<?php if ( $additional_info_text && $additional_info_email_title && $additional_info_email_text ) : ?>
		<section class="info-cta">

			<div class="additional-info">
				<h3>Additional Information</h3>
				<?php echo apply_filters( 'the_content', $additional_info_text ); ?>
			</div>

			<div class="email-updates">
				<h3><?php echo apply_filters( 'the_title', $additional_info_email_title ); ?></h3>
				<p><?php echo apply_filters( 'the_content', $additional_info_email_text ); ?></p>

				<form action="">
					<input type="email" placeholder="Email Address">
					<input type="submit" class="btn btn-primary" value="Sign Up">
				</form>
			</div>
		</section>
		<?php endif; ?>

		<?php // get_template_part( 'partials/request-info' ); ?>

	</main>
</div>

<?php get_footer();
