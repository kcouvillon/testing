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
			$trip_id   = get_post_meta( $post->ID, 'itinerary_details_trip_id', true );
			$register_now  = get_post_meta( $post->ID, 'itinerary_details_register_now', true );
			$register_by  = get_post_meta( $post->ID, 'itinerary_details_register_by', true );
			$gift_of_education   = get_post_meta( $post->ID, 'itinerary_details_gift_of_ed', true );
			$ifa_scholarship   = get_post_meta( $post->ID, 'itinerary_details_ifa_scholarship', true );
			$for_parents   = get_post_meta( $post->ID, 'itinerary_details_for_parents', true );
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
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>>
								<a href="<?php echo esc_url( home_url( '/explore/' ) ); ?>">Explore Educational Travel</a>>
								<span><?php the_title(); ?></span>
							</nav>
							<span class="print-only"><?php the_permalink(); ?></span>
							<h1><?php the_title(); ?></h1>

							<?php $subtitle = get_post_meta( $post->ID, 'itinerary_subtitle', true ); ?>

							<?php if ( $subtitle ) : ?>
								<p class="header-subtitle"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
							<?php endif; ?>

							<?php the_content(); ?>

						</div>

					</div>

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

							<?php $itinerary_description = get_post_meta( $post->ID, 'custom_page_itinerary_description', true ); ?>

							<?php if ( ! empty( $itinerary_description ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>">Itinerary Description</a></li>
							<?php endif; ?>

							<?php $sections = get_post_meta( $post->ID, 'custom_page_sections_list', true ); ?>

							<?php if ( ! empty( $sections ) ) : ?>
								<?php foreach ( $sections as $section ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>"><?php echo $section['title']; ?></a></li>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php $faculty = get_post_meta( $post->ID, 'custom_page_faculty_list', true ); ?>

							<?php if ( ! empty( $faculty ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>">Faculty</a></li>
							<?php endif; ?>
						</ul>
						<?php if ( $register_now && $trip_id ) : ?>
							<form method="post" action="http://olr.worldstrides.net/scripts/cgiip.exe/RegisterOnline/OLRPassporttotravel.htm">
								<input id="hidden_trip_id" type="hidden" name="tid" value="<?php echo (int) $trip_id; ?>">
								<input id="cs_register_button" type="submit" class="btn btn-primary subnav-cta hide-print" value="Register Now" >
							</form>
						<?php endif; ?>
					</div>
				</nav>

			</section>

			<section class="tour-details">
				<div class="ws-container">
					<?php
					$number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true );
					$date_list   = get_post_meta( $post->ID, 'itinerary_details_date_list', true );
					$price   = get_post_meta( $post->ID, 'itinerary_details_price', true );
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

						<?php if ( $price ) : ?>
							<div class="h3">Price: <?php echo esc_html( $price ); ?></div>
						<?php endif; ?>

						<?php if ( $trip_id ) : ?>
							<div class="h3">Trip ID: <?php echo esc_html( $trip_id ); ?></div>
						<?php endif; ?>

						<?php if ( $register_by ) : ?>
							<div class="h3">Register By: <?php echo esc_html( $register_by ); ?></div>
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

			<?php if ( ! empty ( $itinerary_description ) ) : ?>
				<section class="ws-container custom-page-itinerary-description">
					<h3>Itinerary Description</h3>

					<?php echo apply_filters( 'the_content', $itinerary_description ); ?>

				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $sections ) ) : ?>
				<?php foreach ( $sections as $section ) : ?>
					<section class="ws-container custom-page-section">
						<h3><?php echo $section['title']; ?></h3>

						<?php if ( ! empty( $section['content'] ) ) : ?>
							<p><?php echo $section['content']; ?></p>
						<?php endif; ?>
					</section>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if ( ! empty ( $ifa_scholarship ) ) : ?>
				<section class="ws-container custom-page-itinerary-description">
					<h3>International Financial Assistance Program</h3>

					<p>
						WorldStrides is committed to making international travel accessible for students.
						<a href="">Read about applying for financial assistance</a> through the Foundation of International Education.
					</p>

				</section>
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

			<?php if ( ! empty ( $gift_of_education ) ) : ?>
				<section class="ws-container custom-page-itinerary-description">
					<h3>Gift of Education</h3>

					<p>
						Looking to fundraise? Personalize a <a href="">Gift of Education eCard</a> to request contributions from friends and family.
						A great way to celebrate your birthday or holidays, and so much better than another ugly sweater!
					</p>

				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $for_parents ) ) : ?>
				<section class="ws-container custom-page-itinerary-description">
					<h3>For Parents</h3>

					<p>Thank you for considering this global opportunity for your students,
						and for trusting us with the important responsibility of educating them.
						In addition to building their resume and their network, we believe a
						program like this builds essential perspective that will set them on a path to
						becoming more global citizens!
					</p>

					<p>
						We have chosen WorldStrides as an educational travel partner because of their reputation
						for excellence in logistics, educational content, and most importantly, safety and security.
						<a href="">Read more about WorldStrides</a>.
					</p>

				</section>
			<?php endif; ?>

		<?php else : ?>

			<?php the_content(); ?>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
