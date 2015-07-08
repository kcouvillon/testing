<?php
/**
 * Terminal layout for Itineraries
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main itinerary" role="main">

		<?php the_post(); ?>

		<?php
		$background = '';
		if ( has_post_thumbnail() ) {
			$featured   = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url(' . $featured[0] . ')';
		} ?>
		<section class="primary-section">
			<header class="section-header pattern-<?php echo rand( 1, 9 ); ?>" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">
					<nav class="breadcrumbs">
						<a href="">Explore</a> > <a href="">Collections</a> > <a href="">High School</a> >
						<a href=""><?php the_title(); ?></a>
					</nav>
					<h1><?php the_title(); ?></h1>

					<p><?php the_title(); ?></p>
					<?php echo get_the_excerpt(); ?>
				</div>
			</header>

			<nav class="section-nav">
				<ul class="section-menu">
					<li>[TBD]</li>
					<li><a href="#tour-highlights">Tour Highlights</a></li>
					<li><a href="#education">Education</a></li>
					<li><a href="#itinerary">Itinerary</a></li>
					<li><a href="#resources">Resources</a></li>
				</ul>
			</nav>

		</section>

		<section class="tour-details">

			<div class="tour-duration">

				<?php if ( $number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true ) ) : ?>

					<span class="h3"><?php echo $number_days; ?> Days</span>

				<?php elseif ( $date_list = get_post_meta( $post->ID, 'itinerary_details_date_list', true ) ) : ?>

					<?php
					$start = $date_list[0]['itinerary_details_date_start'];
					$end   = $date_list[0]['itinerary_details_date_end'];
					?>

					<span class="h3"><?php echo $start; ?></span>
					<span class="h3"><?php echo $end; ?></span>

				<?php endif; ?>
			</div>

			<div class="tour-features">

				<span class="h3"><?php echo get_post_meta( $post->ID, 'itinerary_details_features_title', true ); ?></span>

				<div class="tour-feature-list">

					<?php
					$features = get_post_meta( $post->ID, 'itinerary_details_features', true );
					if ( ! empty( $features ) ) {
						foreach ( $features as $feature ) {
							echo '<span class="tour-feature">' . $feature . '</span>';
						}
					}
					?>

				</div>

			</div>

			<div class="tour-weather">

				<span class="h3">Local Weather</span>

				<div class="tour-local-time">
					<time>2:32 pm</time>
					<span>Current Time</span>
				</div>

				<div class="tour-local-weather">
					<span>60&#8457;</span>
					<span>Current Temp</span>
				</div>
			</div>

		</section>

		<?php $highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true ); ?>
		<?php if ( ! empty( $highlights[1]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
			<section class="tour-highlights">
				<div class="tour-highlights-slider cycle-slideshow">
					<div class="cycle-overlay"></div>
					<div class="cycle-prev"></div>
					<div class="cycle-next"></div>
					<?php foreach ( $highlights as $highlight ) { ?>
						<img src="<?php echo $highlight['image']; ?>"
						     alt=""
						     data-cycle-title="<?php echo $highlight['title']; ?>"
						     data-cycle-desc="<?php echo $highlight['caption']; ?>">
					<?php } ?>
					<div class="cycle-pager"></div>
				</div>

				<div class="tour-highlights-map">
					MAP
				</div>

			</section>
		<?php endif; ?>

		<?php $block_sections = get_post_meta( $post->ID, 'itinerary_blocks_before_list', true ); ?>

		<?php if ( ! empty( $block_sections ) ) : ?>
			<?php foreach ( $block_sections as $section ) : ?>

				<section class="ws-container ws-blocks tour-blocks-before">
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

		<section class="tour-itinerary">

			<h2>Your Adventure, Day by Day</h2>

			<?php
			$itinerary = get_post_meta( $post->ID, 'itinerary_days_list', true );
			$count         = 0;
			?>

			<?php foreach ( $itinerary as $day ) : ?>
				<?php $count ++; ?>
				<?php if ( ! empty( $day['title'] ) ) : ?>
					<article class="tour-day">
						<?php if ( ! empty( $day['image'] ) ) : ?>
							<div class="tour-hero" style="background-image: url(<?php echo $day['image']; ?>);"></div>
						<?php endif; ?>
						<header>
							<span class="tour-day-marker">Day</span>
							<span class="tour-day-number"><?php echo $count; ?></span>
							<span class="h3"><?php echo $day['title']; ?></span>
						</header>

						<?php $activities = $day['activity']; ?>

						<?php if ( ! empty( $activities ) ) : ?>

							<ul class="tour-activity-list">
								<?php foreach ( $activities as $activity ) {
									if ( ! empty( $activity['title'] ) ) { ?>
										<li>
											<strong><?php echo $activity['title']; ?></strong>
											<span><?php echo $activity['description']; ?></span>
										</li>
									<?php }
								} ?>
							</ul>

						<?php endif; ?>

						<div class="tour-related-post">
							<span class="h3">Related Post Title</span>

						</div>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>
		</section>

		<?php $block_sections = get_post_meta( $post->ID, 'itinerary_blocks_after_list', true ); ?>

		<?php if ( ! empty( $block_sections ) ) : ?>
			<?php foreach ( $block_sections as $section ) : ?>

				<section class="ws-container ws-blocks tour-blocks-after">
					<?php if ( ! empty( $section['title'] ) ) : ?>
						<h2><?php echo apply_filters( 'the_title', $section['title'] ); ?></h2>
					<?php endif; ?>

					<?php foreach ( $section['attached_blocks'] as $block_id ) : ?>

						<?php echo WS_Helpers::get_content_block( $block_id ); ?>

					<?php endforeach; ?>
				</section>

			<?php endforeach; ?>
		<?php endif; ?>

		<section class="clearfix ws-container learn-more">
			<form action="#" class="ws-form">
				<div class="left">
					<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
					<ul class="form-fields list-unstyled">
						<li class="field">
							I am an
							<select name="name">
								<option value="">Educator</option>
								<option value="">Parent</option>
								<option value="">Student</option>
							</select>
						</li>
						<li class="field">
							Interested in
							<select name="name">
								<option value="">Middle School Travel</option>
								<option value="">High School Travel</option>
								<option value="">University Travel</option>
							</select>
						</li>
						<li class="field">
							Do you have a tour scheduled?
							&nbsp;&nbsp;
							<input type="radio" name="tour" id="tour-yes" value="yes" />
							<label for="tour-yes">Yes</label>
							&nbsp;
							<input type="radio" name="tour" id="tour-no" value="no" />
							<label for="tour-no">No</label>
						</li>
					</ul>
				</div>
				<div class="right">
					<ul class="form-fields list-unstyled">
						<li class="field field-complex">
							<div class="field-left">
								<input type="text" name="first_name" value="" placeholder="First Name" />
							</div>
							<div class="field-right">
								<input type="text" name="last_name" value="" placeholder="Last Name" />
							</div>
						</li>
						<li class="field">
							<input type="email" name="email" value="" placeholder="Email Address" />
						</li>
						<li class="field">
							<input type="tel" name="phone" value="" placeholder="Phone Number" />
						</li>
						<li class="field">
							<input type="text" name="group_name" value="" placeholder="School or Group Name" />
						</li>
					</ul>
					<input type="submit" name="" value="Get Info" class="btn btn-primary" />
				</div>
			</form>
		</section>

	</main>
</div>

<?php get_footer(); ?>
