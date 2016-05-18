<?php
/**
 * Terminal layout for Itineraries
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main itinerary" role="main">

		<?php the_post(); ?>

		<?php
		//iOS Detection
		if (stripos($_SERVER['HTTP_USER_AGENT'], "iPod") || stripos($_SERVER['HTTP_USER_AGENT'], "iPhone") || stripos($_SERVER['HTTP_USER_AGENT'], "iPad") ) {
			$iOS = true;
		}
		else {
			$iOS = false;
		}
		//echo "OS: " . $iOS;
		?>

		<?php
		$terms = get_the_terms( $post->ID, '_collection' );
		$term  = $terms[0];
		$phone = get_post_meta( $post->ID, 'itinerary_phone', true );
		$is_itinerary = true;
		$itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );

		$itinerary_title = get_post_meta( $post->ID, 'itinerary_title', true );
		if ( $itinerary_title ) {
			$itinerary_title = apply_filters( 'the_title', $itinerary_title );
		} else {
			$itinerary_title = 'Itinerary';
		}
		?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
			$background = 'url(' . $featured[0] . ')';
			$class = '';
		} else {
			$class = ' ' . WS_Helpers::get_random_pattern() . ' ';
		} ?>

		<section class="primary-section">
			<header class="section-header<?php echo $class; ?>" style="background-image: <?php echo $background; ?>;">

				<div class="mobile-hero">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>

				<div class="ws-container">
					<div class="section-header-content">

						<?php get_template_part('partials/breadcrumbs'); ?>
						
						<span class="print-only"><?php the_permalink(); ?></span>
						<h1><?php the_title(); ?></h1>

						<?php $subtitle = get_post_meta( $post->ID, 'itinerary_subtitle', true ); ?>

						<?php if ( $subtitle ) : ?>
							<p class="header-subtitle"><?php echo apply_filters( 'the_title', $subtitle ); ?></p>
						<?php endif; ?>

						<?php the_content(); ?>

						<?php if ( 'smithsonian' == $itinerary_type ) : ?>
							<h3 class="hide-print"><img class="smithsonian" alt="smithsonian" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smithsonian.png' ); ?>" /></h3>
						<?php endif; ?>

						<?php if ( $phone ) : ?>
						<p class="print-only">Call for more information: <?php echo $phone; ?></p>
						<?php endif; ?>
					</div>

				</div>

				<?php get_template_part( 'partials/content', 'tooltips' ); ?>

			</header>

			<nav id="section-nav" class="section-nav hide-print">
				<div class="ws-container">
					<ul class="section-menu">
						<?php
						$section_link = 1;

						// Get highlights

						$highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );
						if ( ! empty( $highlights[1]['image'] ) && 'no-destination' != $itinerary_type ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Highlights</a></li>
						<?php endif; ?>

						<?php
						// Get Before Blocks
						$before_block_sections = get_post_meta( $post->ID, 'itinerary_blocks_before_list', true ); ?>

						<?php if ( ! empty( $before_block_sections ) ) : ?>
							<?php foreach ( $before_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php
						// Get Itinerary
						$itinerary = get_post_meta( $post->ID, 'itinerary_days_list', true ); ?>

						<?php if ( ! empty( $itinerary ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $itinerary_title; ?></a></li>
						<?php endif; ?>

						<?php
						// Get After Blocks
						$after_block_sections = get_post_meta( $post->ID, 'itinerary_blocks_after_list', true ); ?>

						<?php if ( ! empty( $after_block_sections ) ) : ?>
							<?php foreach ( $after_block_sections as $section ) : ?>
								<?php if ( ! empty ( $section['title'] ) ) : ?>
									<li><a href="#section-<?php echo $section_link; $section_link++; ?>"><?php echo $section['title']; ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<?php $associated_resources = get_post_meta( $post->ID, 'attached_resources', true); ?>
						<?php if ( ! empty( $associated_resources ) ) : ?>
							<li><a href="#section-<?php echo $section_link; $section_link++; ?>">Resources</a></li>
						<?php endif; ?>

						</ul>
						<?php if ($iOS){ ?>
							<a data-toggle="collapse" id="btnRequestInfo" href="lead-form" class="btn btn-primary subnav-cta hide-print collapsed"><span class="toggleLabel">Request Info</span><span class="toggleLabel" style="display:none">Hide<i class="icon-close" style="margin-left:20px"></i></span></a>
						<?php } else { ?>
					<a data-toggle="collapse" id="btnRequestInfo" href="#" class="btn btn-primary subnav-cta hide-print collapsed"><span class="toggleLabel">Request Info</span><span class="toggleLabel" style="display:none">Hide<i class="icon-close" style="margin-left:20px"></i></span></a>
					<?php } ?>
				</div>

			</nav>

			<?php if ( has_post_thumbnail() ) : ?>
			<a href="#section-nav" class="content-cta">
				<span class="hide">Skip to Content</span>
				<i class="icon-arrow-down"></i>
			</a>
			<?php endif; ?>



		</section>

       <!-- <div class="subnavFormFixed"> -->
            <div class="subnavForm" id="collapseForm" style="position: fixed">
		        <section class="clearfix ws-container learn-more hide-print">
				        <?php get_template_part('partials/form','universal'); ?>
		        </section>
            </div>
        <!-- </div> -->

		<?php $section_num = 1; // set first section number ?>

		<?php if ( 'no-destination' != $itinerary_type ) : ?>
		<section class="tour-details">
			<div class="ws-container">

				<?php
				$number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true );
				$date_list = get_post_meta( $post->ID, 'itinerary_details_date_list', true );
				if ( $date_list && count($date_list) >= 4 ) {
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

						<ul class="date-list <?php echo 'columns-'.$column_count; ?> list-unstyled clearfix">
							<?php
							$count = 0;
							foreach ( $date_list as $list ) : ?>

								<?php
								$start = $list['itinerary_details_date_start'];
								$end   = $list['itinerary_details_date_end'];
								$date_class = ( $count > 3 ) ? 'date-range hidden-dates' : 'date-range visible-dates';
								?>

								<li class="<?php echo $date_class; ?>"><strong>
									<?php echo $start; ?> <em class="small gray-light">to</em><br/>
									<?php echo $end; ?>
								</strong></li>

							<?php $count++; endforeach; ?>

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
							<?php if ( strrpos( $tz, 'UTC') !== false ) {
								$tz = substr( $tz, 3 ); // "UTC-5.5" -> "-5.5"
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

		<section class="tour-sharing hide-print">
			<?php $pdf = get_post_meta( $post->ID, 'itinerary_pdf' ); ?>
			<ul class="sharing-links list-unstyled">
				<li><a href="<?php echo 'mailto:?subject=Here\'s a WorldStrides trip you might really like: ' . esc_html( get_the_title() ) . '&body=I thought you might find this trip interesting. Looks like a lot of fun to me!%0D%0A%0D%0A' . esc_url( get_the_permalink() ); ?>"><i class="icon icon-email"></i> Email Itinerary</a></li>
				<li><a href="javascript:window.print()"><i class="icon icon-print"></i> Print Itinerary</a></li>
				<?php if ( $pdf ) : ?>
				<li><a href="<?php echo $pdf[0]; ?>"><i class="icon icon-pdf"></i> Download PDF</a></li>
				<?php endif; ?>
				<li>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_the_permalink() ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook">
			   			<i class="icon-facebook"></i> Share on Facebook
					</a>
				</li>
				<li>
					<a href="https://twitter.com/share?url=<?php echo urlencode( get_the_permalink() ); ?>&via=worldstrides&text=<?php echo urlencode( get_the_title() ); ?>"
					   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
					   target="_blank" title="Share on Twitter">
					   <i class="icon-twitter"></i> Share on Twitter
				   </a>
				</li>
			</ul>
		</section>

		<?php if ( ! empty( $highlights[0]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
			<?php
			$location = get_post_meta( $post->ID, 'itinerary_details_weather_location', true );
			?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="tour-highlights hide-print" data-location='<?php echo json_encode( $location ); ?>'>

				<h3 class="slideshow-header">Highlights</h3>
				<div class="tour-highlights-slider"
					data-cycle-auto-height="container"
					data-cycle-fx="scrollHorz">

					<div class="cycle-overlay js-only"></div>

					<?php if ( count($highlights) > 1 ) : ?>
					<div class="cycle-prev"></div>
					<div class="cycle-next"></div>
					<?php endif; ?>

					<?php foreach ( $highlights as $highlight ) { ?>
						<?php
							$image_id = $highlight['image_id'];
							$image_src = wp_get_attachment_image_src( $image_id, 'tour-highlights' );

							if ( array_key_exists( 'title', $highlight ) ) {
								$highlight_title = $highlight['title'];
							} else {
								$highlight_title = '';
							}

							if ( array_key_exists( 'caption', $highlight ) ) {
								$highlight_caption = $highlight['caption'];
							} else {
								$highlight_caption = '';
							}
						?>
						<img src="<?php echo $image_src[0]; ?>"
						     alt=""
						     data-cycle-title="<?php echo $highlight_title; ?>"
						     data-cycle-desc="<?php echo $highlight_caption; ?>">
						<div class="no-js-content">
							<h4><?php echo $highlight_title; ?></h4>
							<p><?php echo $highlight_caption; ?></p>
						</div>
					<?php } ?>

					<?php if ( count($highlights) > 1 ) : ?>
					<div class="cycle-pager"></div>
					<?php endif; ?>
				</div>

				<div id="tour-highlights-data" data-highlights='<?php echo esc_html(json_encode( $highlights )); ?>'></div>
				<div class="tour-highlights-map-wrap" class="hide-print">
					<div id="tour-highlights-map"><!-- MAP - check assets/js/src/itinerary.js for map code --></div>
				</div>

			</section>

			<!-- Print-only version of tour highlights -->
			<section class="tour-highlights-print print-only print-page-break">
				<h3 class="h2">Tour Highlights</h3>
				<ul class="list-unstyled">
				<?php foreach ( $highlights as $highlight ) { ?>
					<li>
						<?php
							$lon = $highlight['itinerary_highlights_location']['longitude'];
							$lat = $highlight['itinerary_highlights_location']['latitude'];
							$map_id = 'worldstrides.b898407f';
							$pin = urlencode('http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin-orange.png');
							$src = 'https://api.tiles.mapbox.com/v4/'.$map_id.'/url-'.$pin.'('.$lon.','.$lat.')/'.$lon.','.$lat.',8/250x120.png?access_token=pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';
						?>
						<img src="<?php echo $src; ?>" width="250" height="120" />
						<h4><strong><?php echo $highlight['title']; ?></strong></h4>
						<p><?php echo $highlight['caption']; ?></p>
					</li>
				<?php } ?>
				</ul>
			</section>
			<!-- // -->

		<?php endif; // tour highlights ?>
		<?php endif; // end no-destination check ?>


		<?php if ( ! empty( $before_block_sections ) ) : ?>

			<section class="ws-container ws-blocks tour-blocks-before">

			<?php foreach ( $before_block_sections as $section ) : ?>

					<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
					<?php if ( ! empty( $section['title'] ) ) : ?>
						<h2 class="section-content"><?php echo apply_filters( 'the_title', $section['title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>

			<?php endforeach; ?>

			</section>

		<?php endif; ?>

		<?php if ( ! empty ( $itinerary ) ) : ?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="tour-itinerary">

				<?php
				if ( ! $itinerary_title || 'Itinerary' === $itinerary_title ) {
					$itinerary_title = "Your Adventure, Day by Day";
				}
				?>
				<h2><?php echo $itinerary_title; ?></h2>

				<?php $count = 0; ?>

				<?php foreach ( $itinerary as $day ) : ?>
					<?php $count ++; ?>
					<?php if ( ! empty( $day['title'] ) ) : ?>
						<article class="tour-day">
							<?php if ( ! empty( $day['image_id'] ) ) : ?>
								<?php
								$featured = wp_get_attachment_image_src( $day['image_id'], 'itinerary' );
								$background = 'url(' . $featured[0] . ')';
								?>
								<div class="tour-hero hide-print" style="background-image: <?php echo $background; ?>"></div>
							<?php else : ?>
								<div class="tour-hero tour-hero-pattern hide-print pattern-3"></div>
							<?php endif; ?>
							<header>
								<span class="tour-day-marker">Day</span>
								<span class="tour-day-number"><?php echo $count; ?></span>
								<span class="h3"><?php echo $day['title']; ?></span>
							</header>

							<div class="day-wrap">

							<?php $activities = $day['activity_list']; ?>

							<?php if ( ! empty( $activities ) ) : ?>

								<ul class="tour-activity-list">
									<?php echo do_shortcode( $activities ); ?>
								</ul>

							<?php endif; ?>

							<?php
							$related = ( ! empty( $day['related_content'] ) ? $day['related_content'] : '' );
							$related_title = ( ! empty ( $day['related_content_title'] ) ? $day['related_content_title'] : '' );
							$related_image = '';
							$related_image_title = '';

							$related_type = 'other';

							$related_posts = explode( ',', $related );
							$related_post_count = 0;

							if ( ! empty ( $related ) ) : ?>
								<div class="tour-related-posts">

								<?php foreach ( $related_posts as $related ) :
									$related_post_count++;

									$post  = get_post( $related );
									$class         = 'pattern-' . rand( 1, 9 );

									if ( in_array( $post->post_type, array( 'post', 'resource', 'block' ) ) ) {
										$related_type = $post->post_type;
									}

									$related_image_title = $post->post_title;

									if ( $related_type === 'block' ) {
										$related_description = apply_filters( 'the_content', $post->post_content );
									} else {
										$related_description = esc_html( wp_trim_words( $post->post_content, 40 ) );
									}

									$related_url = get_permalink( $post->ID );

									$block_image_id = get_post_meta( $post->ID, 'block_image_id', true );

									if ( has_post_thumbnail( $related ) || $block_image_id ) {

										$class = 'no-pattern';

										if ( $block_image_id ) {
											$image = wp_get_attachment_image_src( $block_image_id, 'large' );
										} else {
											$image      = wp_get_attachment_image_src( get_post_thumbnail_id( $related ), 'large' );
										}

										$related_image = 'url(' . $image[0] . ')';

									}

									if ( $related_image ) {
										$class = 'no-pattern';
									}

							?>

								<div class="tour-related-post hide-print">
									<?php if ( $related_title && $related_type != 'post' && $related_post_count == 1 ) : ?>
										<span class="h3"><?php echo apply_filters( 'the_title', $related_title ); ?></span>
									<?php elseif ( empty ( $related_title ) && $related_type === 'resource' ) : ?>
										<span class="h3">Have Questions?<br>We Have Answers</span>
									<?php endif; ?>
									<header class="<?php echo $class; ?>" style="background-image: <?php echo $related_image; ?>;">
										<?php if( $related_type === 'post' ) : ?>
											<?php include( locate_template( 'partials/content-blog-author.php' ) ); ?>
										<?php endif; ?>

										<?php if( $related_type === 'resource' ) : ?>

											<ul class="meta list-unstyled">
												<?php $targets = wp_get_object_terms( $post->ID, 'resource-target' ); ?>
												<?php $target_parents = array(); ?>

												<?php foreach ( $targets as $target ) : ?>
													<?php if ( 'Featured' != $target->name ) : ?>

														<?php $parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' ); ?>

														<?php if ( ! in_array( $parent->term_id, $target_parents ) ) : ?>
															<?php $target_parents[] = $parent->term_id; ?>

															<li><a href="<?php echo esc_url( home_url( '/resources/' . $parent->slug . '/' ) ) ; ?>"><?php echo $parent->name; ?></a></li>

														<?php endif; ?>

													<?php endif; ?>
												<?php endforeach; ?>

											</ul>

										<?php endif; ?>


										<?php if( $related_url && $related_type == 'post' ) echo '<a href="'. $related_url . '">'; ?>
										<h3><?php echo $related_image_title; ?></h3>
										<?php if( $related_url && $related_type == 'post' ) echo '</a>'; ?>
									</header>

									<?php if ( $related_type != 'resource' ) : ?>
										<p><?php echo $related_description; ?></p>
									<?php endif; ?>

									<?php if( $related_url && $related_type == 'post' ) : ?>
										<a href="<?php echo $related_url; ?>" class="btn btn-primary">Keep Reading</a>
									<?php endif; ?>


								</div><!-- end .tour-related-post -->
								<?php endforeach; ?>
								</div>
							<?php endif; ?>

							</div><!-- end .day-wrap -->

						</article>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $after_block_sections ) ) : ?>
			<?php foreach ( $after_block_sections as $section ) : ?>
				<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
				<section class="ws-container ws-blocks tour-blocks-after">
					<?php if ( ! empty( $section['title'] ) ) : ?>
						<h2><?php echo apply_filters( 'the_title', $section['title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $section['attached_blocks'] ) ) : ?>
						<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

							<?php echo WS_Helpers::get_content_block( $block_id ); ?>

						<?php endforeach; ?>
					<?php endif; ?>
				</section>

			<?php endforeach; ?>
		<?php endif; ?>

		<?php wp_reset_query(); ?>


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
						$title = apply_filters( 'the_title', $resource->post_title );
						$url = get_the_permalink( $resource_id );
						$meta_list = array();

						foreach ( $targets as $target ) {
							if ( 'Featured' != $target->name ) {
								$parent = WS_Helpers::get_term_top_most_parent( $target->term_id, 'resource-target' );
								if ( ! in_array( $parent->term_id, $target_parents ) ) {
									$target_parents[] = $parent->term_id;
									array_push( $meta_list, array( "name" => $parent->name, "url" => home_url( '/resources/' . $parent->slug . '/' ) ) );
								}
							}
						}

						if( has_post_thumbnail( $resource_id ) ) {
							$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $resource_id ), 'medium' );
							$background = 'url(' . $featured[0] . ')';
							$class = '';
						} else {
							$class = ' ' . WS_Helpers::get_random_pattern('dark');
						} ?>

						<li class="resource tile tile-third <?php echo $class; ?>" style="background-image: <?php echo $background; ?>">
							<?php include( locate_template( 'partials/tile-content.php' ) ); ?>
						</li>

					<?php endforeach; ?>
					<?php $resource = null; ?>
				</ul>

			</section>
		<?php endif; ?>
		<?php wp_reset_query(); ?>

		<?php $blog_post_ids = array_map( 'intval', explode( ',', get_post_meta( $post->ID, 'related_blog_posts', true) ) ); ?>
		<?php if ( $blog_post_ids ) : ?>
			<?php
			$blog_posts = new WP_Query( array(
				'post_type' => 'post',
				'post__in' => $blog_post_ids,
				'posts_per_page' => 3,
				'no_found_rows' => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			));
			?>

			<?php if ( $blog_posts->have_posts() ) : ?>
				<section class="home-section blog">
					<div class="ws-container">
						<h2 class="section-title"><a class="text-color-link" href="<?php echo home_url('/blog/'); ?>">Related Stories from the WorldStrides Blog</a></h2>
					</div>

					<?php $sidebar_open = false; ?>

					<div class="blog-wrap">
						<?php $count = 0; ?>
						<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>

					<?php if ( 0 == $count ) : ?>
						<section class="section-one <?php if ( 1 == $blog_posts->post_count) { echo "only"; } ?>">
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
			if ( $iOS ) {
			?>
			<section class="clearfix ws-container learn-more hide-print">
				<section class="clearfix ws-container learn-more">
					<h2 class="form-title" name="lead-form">Ready to Learn More About Traveling with WorldStrides?</h2>
					<?php get_template_part('partials/form','universal'); ?>
				</section>
			</section>
		<?php } ?>
		
	</main>
</div>

<?php get_footer(); ?>

