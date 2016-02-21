<?php
/**
 * Custom query content display for about pages
 */
 get_header();
$postid = $row->post_id;
?>

<article id="post-<?php echo $postid ?>" <?php echo post_class(); ?>>

        <?php  echo get_the_post_thumbnail( $postid, 'post-thumbnail' ); ?>
        
		<header class="entry-header">
			<div class="entry-meta">
                <time datetime=""><?php echo get_the_date( 'F j, Y', $postid ); ?></time>
					<?php echo get_the_category_list($postid); ?>
			</div>
			<h3 class="entry-title"><a href="<?php echo get_the_permalink($postid) ?>"><?php echo get_the_title($postid) ?></a></h3>
		</header>

	<div class="entry-content">
		<?php
            the_excerpt($postid);
			//echo '<a href="'. get_the_permalink($postid) .'">Keep Reading</a>';
            $highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );
		?>


        <?php $section_num = 1; // set first section number ?>
        <?php if ( 'no-destination' != $itinerary_type ) : ?>
		<?php if ( ! empty( $highlights[0]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
			<?php
			$location = get_post_meta( $post->ID, 'itinerary_details_weather_location', true );
			?>
			<a name="section-<?php echo $section_num; $section_num++; ?>"></a>
			<section class="tour-highlights hide-print" data-location='<?php echo json_encode( $location ); ?>'>

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


        <p>
            <?php $number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true ); ?>
            <a class="btn btn-success" href="#"><?php echo esc_html( $number_days ); ?></a>
            <?php
			$features = get_post_meta( $post->ID, 'itinerary_details_features', true );
			if ( ! empty( $features ) ) : ?>
				<b>
                <?php
                    $i = 0;
                    $len = count($features);
					foreach ( $features as $feature ) {
                        if ($i == $len - 1) {
                            echo '<span>and ' . $feature . '</span>';
                        } else {
                            echo '<span>' . $feature . ', </span>';
                        }
                        $i++;
					}
				?>
                </b>
			<?php endif; ?>
            
        </p>
        <p>
            <div class="pull-right"><a href="#">See map</a></div>
            <img src="http://localhost:8080/worldstrides/wp-content/uploads/rating.jpg">
        </p>
	</div>

	<footer class="entry-footer">

	</footer>
</article>