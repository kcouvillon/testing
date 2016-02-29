<?php
/**
 * Custom query content display for about pages
 */
 get_header();
 $post = $row;
?>

<article id="post-<?php the_ID(); ?>" <?php echo post_class(); ?>>

        <?php the_post_thumbnail( 'thumbnail' ); ?>
        
		<header class="entry-header">
			<div class="entry-meta">
                <time datetime=""><?php the_time( 'F j, Y' ); ?></time>
					<?php echo get_the_category_list(); ?>
			</div>
			<h3 class="entry-title"><a href="<?php echo get_the_permalink() ?>"><?php echo the_title() ?></a></h3>
		</header>

	<div class="entry-content">
		

        <?php
			//echo '<a href="'. get_the_permalink($postid) .'">Keep Reading</a>';

            $itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );
            $highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );

            if ( 'no-destination' != $itinerary_type && !empty( $highlights[0]['image'] ) ) {
                echo '<p>' . wp_trim_words(get_the_excerpt(), 20) . '</p>';
            } else {
                the_excerpt();
            }
		?>

        
        <?php $section_num = 1; // set first section number ?>
        <?php if ( 'no-destination' != $itinerary_type ) : ?>
		<?php if ( ! empty( $highlights[0]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
		<?php
			$location = get_post_meta( $post->ID, 'itinerary_details_weather_location', true );
		?>
            
            <div id="result-map-<?php echo $post->ID; ?>" data-location='<?php echo json_encode( $location ); ?>' data-highlights='<?php echo esc_html(json_encode( $highlights )); ?>'></div>

            <p>
                <?php $number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true ); ?>
                <?php if (!empty($number_days)) : ?>
                    <a class="btn btn-sm btn-success" style="margin-right:20px;" href="#"><?php echo esc_html( $number_days ); ?></a>
                <?php endif; ?>

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
       
            <div class="pull-right"><a id="lnkShowMap" href="#" data-showmap="<?php echo $post->ID; ?>">See map <i class="icon icon-pin"></i></a></div>
            <img src="http://localhost:8080/worldstrides/wp-content/uploads/rating.jpg">

        <?php endif; // tour highlights ?>
        <?php endif; // end no-destination check ?>
        </p>
	</div>

	<footer class="entry-footer">

	</footer>
</article>

<style>
    .entry-content p {
        margin: 0 0 0.95em;
    }
</style>