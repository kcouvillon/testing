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
			$faq   = get_post_meta( $post->ID, 'itinerary_details_faq', true );
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
			<section class="custom-page primary-section">
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

							<?php $itinerary_highlights = get_post_meta( $post->ID, 'custom_page_itinerary_highlights', true ); ?>

							<?php if ( ! empty( $itinerary_highlights ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>">Itinerary Highlights</a></li>
							<?php endif; ?>

							<?php $custom_content = get_post_meta( $post->ID, 'custom_page_content', true ); ?>
							<?php $custom_content_title = get_post_meta( $post->ID, 'custom_page_content_title', true ); ?>

							<?php if ( ! empty( $custom_content ) ) : ?>
								<li><a href="#section-<?php echo $section_link;
									$section_link ++; ?>"><?php echo apply_filters( 'the_title ', $custom_content_title ); ?></a></li>
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

					</div>

					<?php
					$features = get_post_meta( $post->ID, 'itinerary_details_features', true );
					if ( ! empty( $features ) ) : ?>

						<div class="tour-features">
							<span class="h3"><i class="icon icon-pin"></i>Inclusions</span>

							<div class="tour-feature-list">
								<?php
								foreach ( $features as $feature ) {
									echo '<span class="tour-feature">' . $feature . '</span>';
								}
								?>
							</div>
						</div>

					<?php endif; ?>

					<?php
					$info_session = get_post_meta( $post->ID, 'itinerary_details_info_session', true );
					$info_session_title = get_post_meta( $post->ID, 'itinerary_details_info_session_title', true );
					if ( ! empty( $info_session ) ) : ?>
						<div class="tour-info-session">

							<?php // get info sessions stuff ?>

							<span class="h3"><?php echo apply_filters( 'the_title ', $info_session_title ); ?></span>

							<div class="info-session-content">
								<?php echo apply_filters( 'the_content', $info_session ); ?>
							</div>

						</div>
					<?php endif; ?>
				</div>
			</section>

			<section class="tour-sharing hide-print">
				<?php $pdf = get_post_meta( $post->ID, 'itinerary_pdf' ); ?>
				<ul class="sharing-links list-unstyled">
					<li><a href="<?php echo 'mailto:?subject=Here\'s a WorldStrides trip you might really like: ' . esc_html( get_the_title() ) . '&body=I thought you might find this trip interesting. Looks like a lot of fun to me!%0D%0A%0D%0A' . esc_url( get_the_permalink() ); ?>"><i class="icon icon-email"></i> Email Itinerary</a></li>
					<li><a href="javascript:window.print()"><i class="icon icon-print"></i> Print Itinerary</a></li>
				</ul>
			</section>

			<?php $section_num = 1; // set first section number ?>

			<?php if ( ! empty ( $itinerary_highlights ) ) : ?>
				<section class="ws-container custom-page-itinerary-highlights">
					<h3>Itinerary Highlights</h3>

					<?php echo apply_filters( 'the_content', $itinerary_highlights ); ?>

				</section>
			<?php endif; ?>

			<?php if ( $price || $trip_id || $register_by ) : ?>
				<section class="ws-container custom-page-meta">
					<?php if ( $price ) : ?>
						<div class="price"><span class="h4">Price:</span> <?php echo esc_html( $price ); ?></div>
					<?php endif; ?>

					<?php if ( $trip_id ) : ?>
						<div class="trip-id"><span class="h4">Trip ID:</span> <?php echo esc_html( $trip_id ); ?></div>
					<?php endif; ?>

					<?php if ( $register_by ) : ?>
						<div class="register-by"><span class="h4">Register By:</span> <?php echo esc_html( $register_by ); ?></div>
					<?php endif; ?>
				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $custom_content ) ) : ?>
				<section class="ws-container custom-page-content">
					<h3><?php echo apply_filters( 'the_title ', $custom_content_title ); ?></h3>

					<?php if ( ! empty( $custom_content ) ) : ?>
						<p><?php echo $custom_content; ?></p>
					<?php endif; ?>
				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $faculty ) ) : ?>
			<section class="ws-container custom-page-faculty">
				<h3>Meet the Faculty</h3>
				<?php foreach ( $faculty as $faculty_member ) : ?>
					<div class="faculty-member">
						<?php
						$image_id  = $faculty_member['image_id'];
						$image_src = wp_get_attachment_image_src( $image_id, 'thumbnail' );

						if ( $image_src[0] ) :
						?>
							<img src="<?php echo $image_src[0]; ?>">
						<?php endif; ?>

						<div class="faculty-member-content">
							<?php if ( ! empty( $faculty_member['name'] ) ) : ?>
								<h4><?php echo $faculty_member['name']; ?></h4>
							<?php endif; ?>

							<?php if ( ! empty( $faculty_member['title'] ) ) : ?>
								<h5><?php echo $faculty_member['title']; ?></h5>
							<?php endif; ?>

							<?php if ( ! empty( $faculty_member['email'] ) ) : ?>
								<span class="email"><?php echo $faculty_member['email']; ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $faculty_member['description'] ) ) : ?>
								<div class="description">
									<?php echo $faculty_member['description']; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</section>
			<?php endif; ?>

			<?php if ( ! empty ( $ifa_scholarship ) ) : ?>
				<section class="ws-container custom-page-itinerary-ifa">
					<h3>International Financial Assistance Program</h3>

					<p>
						WorldStrides is committed to making international travel accessible for students.
						<a href="">Read about applying for financial assistance</a> through the Foundation of International Education.
					</p>

				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $gift_of_education ) ) : ?>
				<section class="ws-container custom-page-gift-of-education">
					<h3>Gift of Education</h3>

					<p>
						Looking to fundraise? Personalize a <a href="">Gift of Education eCard</a> to request contributions from friends and family.
						A great way to celebrate your birthday or holidays, and so much better than another ugly sweater!
					</p>

				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $for_parents ) ) : ?>
				<section class="ws-container custom-page-for-parents">
					<h3>For Parents</h3>

					<?php
					$faculty_count = count( $faculty );

					// Deal with pluralization
					if ( 1 === $faculty_count ) {
						$word_1 = 'I';
						$word_2 = 'me';
					} else {
						$word_1 = 'we';
						$word_2 = 'us';
					}
					?>

					<p>Thank you for considering this global opportunity for your students,
						and for trusting <?php echo $word_2; ?> with the important responsibility of educating them.
						In addition to building their resume and their network, <?php echo $word_1; ?> believe a
						program like this builds essential perspective that will set them on a path to
						becoming more global citizens!
					</p>

					<p>
						<?php echo ucwords( $word_1 ); ?> have chosen WorldStrides as an educational travel partner because of their reputation
						for excellence in logistics, educational content, and most importantly, safety and security.
						<a href="/about/">Read more about WorldStrides</a>.
					</p>

				</section>
			<?php endif; ?>

			<?php if ( ! empty ( $faq ) ) : ?>
				<section class="ws-container custom-page-faq">
					<h3>FAQ</h3>

					<p>Questions? <a href="<?php echo esc_url( home_url( '/resource-center/') ); ?>">Click here</a> to see answers
						to commonly asked questions about WorldStrides educational travel programs for university students.
					</p>

				</section>
			<?php endif; ?>

		<?php else : ?>

			<?php the_content(); ?>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
