<?php
/**
 * Terminal layout for Custom Pages
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main itinerary" role="main">
		<?php if ( ! post_password_required() ) : ?>
			<?php the_post(); ?>

			<?php
			$terms          = get_the_terms( $post->ID, '_collection' );
			$term           = $terms[0];
			$phone          = get_post_meta( $post->ID, 'itinerary_phone', true );
			$itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );
			?>

			<?php
			$background = '';
			if ( has_post_thumbnail() ) {
				$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
				$background = 'url(' . $featured[0] . ')';
				$class      = '';
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
								`							<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore Educational Travel</a>>
								<?php if( ! empty( $term ) ) : ?>
									<a href="<?php echo esc_url( home_url( '/collections/' . $term->slug . '/' ) ); ?>"><?php echo $term->name; ?></a>>
								<?php endif; ?>
								<span><?php the_title(); ?></span>
							</nav>
							<span class="print-only"><?php the_permalink(); ?></span>
							<h1><?php the_title(); ?></h1>

							<?php $subtitle = get_post_meta( $post->ID, 'itinerary_subtitle', true ); ?>

							<?php if ( $subtitle ) : ?>
								<p class="header-subtitle"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
							<?php endif; ?>

							<?php the_content(); ?>

							<?php if ( $phone ) : ?>
								<p class="print-only">Call for more information: <?php echo $phone; ?></p>
							<?php endif; ?>
						</div>

					</div>

					<?php get_template_part( 'partials/content', 'tooltips' ); ?>

				</header>

				<nav class="section-nav hide-print">
					<div class="ws-container">
						<ul class="section-menu">
							<?php
							$section_link = 1;

							// Get highlights

							$highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );
							if ( ! empty( $highlights[1]['image'] ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>">Highlights</a></li>
							<?php endif; ?>

							<?php $faculty = get_post_meta( $post->ID, 'custom_page_faculty_list', true ); ?>

							<?php if ( ! empty( $faculty ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>">Faculty</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</nav>

			</section>

			<section class="tour-details">
				<div class="ws-container">
					<?php
					$number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true );
					$date_list   = get_post_meta( $post->ID, 'itinerary_details_date_list', true );
					if ( $date_list && count( $date_list ) >= 4 ) {
						$column_count = 2;
					} else {
						$column_count = 1;
					}
					?>

					<div class="tour-duration">

						<?php if ( $number_days ) : ?>

							<span class="h3"><i class="icon icon-calendar"></i> <?php echo esc_html( $number_days ); ?></span>

						<?php elseif ( $date_list ) : ?>

							<div class="h3"><i class="icon icon-calendar"></i> Dates</div>

							<ul class="date-list <?php echo 'columns-' . $column_count; ?> list-unstyled clearfix">
								<?php
								$count = 0;
								foreach ( $date_list as $list ) : ?>

									<?php
									$start      = $list['itinerary_details_date_start'];
									$end        = $list['itinerary_details_date_end'];
									$date_class = ( $count > 3 ) ? 'date-range hidden-dates' : 'date-range visible-dates';
									?>

									<li class="<?php echo $date_class; ?>"><strong>
											<?php echo $start; ?> <em class="small gray-light">to</em><br />
											<?php echo $end; ?>
										</strong></li>

									<?php $count ++; endforeach; ?>

								<?php if ( count( $date_list ) > 4 ) : ?>
									<li><a href="#" class="toggle-dates hide-print"></a></li>
								<?php endif; ?>

							</ul>

						<?php endif; ?>
					</div>

					<?php
					$features = get_post_meta( $post->ID, 'itinerary_details_features', true );
					if ( ! empty( $features ) ) : ?>

						<div class="tour-features">
							<span class="h3"><i class="icon icon-pin"></i> <?php echo get_post_meta( $post->ID, 'itinerary_details_features_title', true ); ?></span>

							<div class="tour-feature-list">
								<?php
								foreach ( $features as $feature ) {
									echo '<span class="tour-feature">' . $feature . '</span>';
								}
								?>
							</div>
						</div>

					<?php endif; ?>

					<div class="tour-weather hide-print">

						<?php
						$weather = WS_Helpers::get_weather_data( $post->ID );

						if ( is_object( $weather ) ) {

							$temp = round( $weather->main->temp, 0 );
							$icon = WS_Helpers::get_weather_icon( $weather->weather[0]->icon );

						} else {

							$temp = '—';
							$icon = '';

						} ?>

						<span class="h3"><i class="icon icon-weather icon-<?php echo $icon; ?>"></i> Local Conditions</span>

						<div class="weather-content">

							<div class="tour-local-weather">
								<span><?php echo $temp; ?>&#8457;</span>
								<span>Current Temp</span>
							</div>

							<?php $tz = get_post_meta( $post->ID, 'itinerary_details_timezone', true ); ?>

							<?php if ( $tz ) : ?>
								<?php if ( strrpos( $tz, 'UTC' ) !== false ) {
									$tz         = substr( $tz, 3 ); // "UTC-5.5" -> "-5.5"
									$local_time = WS_Helpers::get_local_time_by_offset( $tz );
								} else {
									$local_time = WS_Helpers::get_local_time_by_tz( $tz );
								}
								?>
								<div class="tour-local-time">
									<time><?php echo $local_time; ?></time>
									<span>Current Time</span>
								</div>
							<?php endif; ?>

						</div>

					</div>
				</div>
			</section>

			<?php $section_num = 1; // set first section number ?>

			<?php if ( ! empty( $highlights[0]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
				<?php
				$location = get_post_meta( $post->ID, 'itinerary_details_weather_location', true );
				?>
				<a name="section-<?php echo $section_num;
				$section_num ++; ?>"></a>
				<section class="tour-highlights hide-print" data-location='<?php echo json_encode( $location ); ?>'>

					<h3 class="slideshow-header">Highlights</h3>

					<div class="tour-highlights-slider cycle-slideshow"
					     data-cycle-auto-height="container"
					     data-cycle-fx="scrollHorz">

						<div class="cycle-overlay js-only"></div>

						<?php if ( count( $highlights ) > 1 ) : ?>
							<div class="cycle-prev"></div>
							<div class="cycle-next"></div>
						<?php endif; ?>

						<?php foreach ( $highlights as $highlight ) { ?>
							<?php
							$image_id  = $highlight['image_id'];
							$image_src = wp_get_attachment_image_src( $image_id, 'tour-highlights' );
							?>
							<img src="<?php echo $image_src[0]; ?>"
							     alt=""
							     data-cycle-title="<?php echo $highlight['title']; ?>"
							     data-cycle-desc="<?php echo $highlight['caption']; ?>">
							<div class="no-js-content">
								<h4><?php echo $highlight['title']; ?></h4>

								<p><?php echo $highlight['caption']; ?></p>
							</div>
						<?php } ?>

						<?php if ( count( $highlights ) > 1 ) : ?>
							<div class="cycle-pager"></div>
						<?php endif; ?>
					</div>

					<div id="tour-highlights-data" data-highlights='<?php echo esc_html( json_encode( $highlights ) ); ?>'></div>
					<div id="tour-highlights-map" class="hide-print"><!-- MAP - check assets/js/src/itinerary.js for map code --></div>

				</section>

				<!-- Print-only version of tour highlights -->
				<section class="tour-highlights-print print-only print-page-break">
					<h2>Tour Highlights</h2>
					<ul class="list-unstyled">
						<?php foreach ( $highlights as $highlight ) { ?>
							<li>
								<?php
								$lon    = $highlight['itinerary_highlights_location']['longitude'];
								$lat    = $highlight['itinerary_highlights_location']['latitude'];
								$map_id = 'worldstrides.b898407f';
								$pin    = urlencode( 'http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin-orange.png' );
								$src    = 'https://api.tiles.mapbox.com/v4/' . $map_id . '/url-' . $pin . '(' . $lon . ',' . $lat . ')/' . $lon . ',' . $lat . ',8/250x120.png?access_token=pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';
								?>
								<img src="<?php echo $src; ?>" width="250" height="120" />
								<h4><strong><?php echo $highlight['title']; ?></strong></h4>

								<p><?php echo $highlight['caption']; ?></p>
							</li>
						<?php } ?>
					</ul>
				</section>
				<!-- // -->

			<?php endif; ?>

			<?php if ( ! empty ( $faculty ) ) : ?>
			<section class="ws-container custom-page-faculty">
				<h3>Meet the Faculty</h3>
				<?php foreach ( $faculty as $faculty_member ) : ?>
					<?php
					$image_id  = $faculty_member['image_id'];
					$image_src = wp_get_attachment_image_src( $image_id, 'medium' );

					if ( $image_src[0] ) :
					?>
						<img src="<?php echo $image_src[0]; ?>">
					<?php endif; ?>

					<?php if ( ! empty( $faculty_member['name'] ) ) : ?>
						<h4><?php echo $faculty_member['name']; ?></h4>
					<?php endif; ?>

					<?php if ( ! empty( $faculty_member['title'] ) ) : ?>
						<span><?php echo $faculty_member['title']; ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $faculty_member['email'] ) ) : ?>
						<span><?php echo $faculty_member['email']; ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $faculty_member['description'] ) ) : ?>
						<p><?php echo $faculty_member['description']; ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
			</section>
			<?php endif; ?>

		<?php else : ?>

			<?php the_content(); ?>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
