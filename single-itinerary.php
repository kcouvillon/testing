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
			<header class="section-header pattern-<?php echo rand(1, 9); ?>" style="background-image: <?php echo $background; ?>;">
				<div class="section-header-content">
					<nav class="breadcrumbs">
						<a href="">Explore</a> > <a href="">Collections</a> > <a href="">High School</a> > <a href=""><?php the_title(); ?></a>
					</nav>
					<h1><?php the_title(); ?></h1>
					<p><?php the_title(); ?></p>
					<?php echo get_the_excerpt(); ?>
				</div>
			</header>

			<nav class="section-nav">
				<ul class="section-menu">
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
					$start = $date_list[0][itinerary_details_date_start];
					$end = $date_list[0][itinerary_details_date_end];
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
					foreach( $features as $feature ) {
						echo '<span class="tour-feature">' . $feature . '</span>';
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

		<section class="tour-highlights">
			<?php $highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );
			// print_r($highlights);?>
			<div class="tour-highlights-slider cycle-slideshow"
				>
				<div class="cycle-overlay"></div>
				<div class="cycle-prev"></div>
				<div class="cycle-next"></div>
				<?php foreach( $highlights as $highlight ) { ?>
					<img src="<?php echo $highlight[image]; ?>"
					alt=""
					data-cycle-title="<?php echo $highlight[title]; ?>"
					data-cycle-desc="<?php echo $highlight[caption]; ?>">
				<?php } ?>
				<div class="cycle-pager"></div>
			</div>

			<div class="tour-highlights-map">
				
			</div>

		</section>

		<section class="tour-blocks-before">
			
		</section>

		<section class="tour-itinerary">

			<span class="h3">Your Adventure, Day by Day</span>

			<?php
			$itinerary = get_post_meta( $post->ID, 'itinerary_days_list', true );
			print_r($itinerary);
			$i = 0;
			foreach($itinerary as $day) { $i++; ?>
				<article class="tour-day">
					<div class="tour-hero" style="background-image: url(<?php echo $day[image]; ?>);"></div>
					<header>
						<span class="tour-day-marker">Day</span>
						<span class="tour-day-number"><?php echo $i; ?></span>
						<span class="h3"><?php echo $day[title]; ?></span>
					</header>

					<ul class="tour-activity-list">
						<?php $activity = $day[activity]; print_r($activities); ?>
							<li>
								<strong><?php echo $activity[title]; ?></strong>
								<span><?php echo $activity[description]; ?></span>
							</li>
					</ul>
				</article>
			<?php } ?>
		</section>

		<section class="tour-blocks-after">
			
		</section>

	</main>
</div>

<?php get_footer(); ?>
