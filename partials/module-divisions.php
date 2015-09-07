<?php

$data = array(
	array(
		'slug' => 'discoveries',
		'meta' => 'Middle School',
	),
	array(
		'slug' => 'perspectives',
		'meta' => 'High School',
	),
	array(
		'slug' => 'capstone',
		'meta' => "University",
	),
	array(
		'slug' => 'on-stage',
		'meta' => 'Performing Arts'
	),
);

$options = get_option( 'ws_options' );

$title = ( isset( $options['divisions_title'] ) ? $options['divisions_title'] : '' );

?>
<section class="home-section programs">
	<div class="ws-container">
		<?php if ( $title ) : ?>
		<h2 class="section-title"><?php echo apply_filters( 'the_content', $title ) ?></h2>
		<?php endif; ?>

		<ul class="programs-list list-unstyled clearfix">
			<?php $count = 0; ?>

			<?php foreach ( $data as $item ) : ?>

				<?php $division_page = get_page_by_path( $item['slug'] ); ?>

				<?php
				if ( has_post_thumbnail( $division_page->ID ) ) {
					$thumb_id = get_post_thumbnail_id( $division_page->ID );
					$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'medium', true );
					$background = $thumb_url_array[0];
					$class = ' has-tile-image';
				} else {
					$background = get_template_directory_uri() . '/assets/images/src/patterns/ws_w_pattern' . ( ($count % 2 == 0 ) ? '5' : '8') . '.gif';
					$class = ' no-tile-image';
				}
				?>

				<li class="program tile tile-third<?php echo $class; ?>" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
					<div class="tile-content">
						<ul class="meta list-unstyled">
							<li class="list-tag-no-link"><?php echo $item['meta']; ?></li>
						</ul>
						<h2 class="tile-title">
							<a href="<?php echo get_the_permalink( $division_page->ID ); ?>">
								<?php echo apply_filters( 'the_title', $division_page->post_title ); ?>
							</a>
						</h2>
					</div>
				</li>

				<?php $count++; ?>
			<?php endforeach; ?>
		</ul>

	</div>
</section>