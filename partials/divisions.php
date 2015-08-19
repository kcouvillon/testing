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

?>
<section class="home-section programs">
	<div class="ws-container">
		<h2 class="section-title">Our Educational Travel Opportunities</h2>
		<ul class="programs-list list-unstyled clearfix">
			<?php $count = 0; ?>

			<?php foreach ( $data as $item ) : ?>

				<?php $division_page = get_page_by_path( $item['slug'] ); ?>

				<?php
				if ( has_post_thumbnail( $division_page->ID ) ) {
					$thumb_id = get_post_thumbnail_id( $division_page->ID );
					$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'medium', true );
					$background = $thumb_url_array[0];
					// $scrim = 'linear-gradient( rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.45) ),';
					$scrim = '';
					$class = ' has-tile-image';
				} else {
					$background = get_template_directory_uri() . '/assets/images/src/patterns/ws_w_pattern' . ( ($count % 2 == 0 ) ? '5' : '8') . '.gif';
					$scrim = '';
					$class = ' no-tile-image';
				}
				?>

				<li class="program tile tile-third<?php echo $class; ?>" style="background-image:<?php echo $scrim . ' url(' . $background . ')'; ?>;">
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