<?php
/**
 * Custom query content display for about pages
 */
 get_header();
 $post = $row;
 ?>



<article id="post-<?php the_ID(); ?>" <?php echo post_class(); ?>>

        <?php the_post_thumbnail( 'thumbnail' ); ?>
        
        <?php

            $itinerary_type = get_post_meta( $post->ID, 'itinerary_type', true );
            $highlights = get_post_meta( $post->ID, 'itinerary_highlights_list', true );
        ?>

		<header class="entry-header">
            <h3 class="entry-title"><a href="<?php echo get_the_permalink() ?>"><?php echo the_title() ?></a></h3>
			<div class="entry-meta">
                <?php 
                    if (empty($highlights)) {
                        echo '<b><time datetime="">' .the_time( 'F j, Y' ) . '</time></b>';
                    }
                ?>
                <b><?php echo get_post_meta( $post->ID, 'itinerary_subtitle', true ); ?></b>
				<?php echo get_the_category_list(); ?>
			</div>
			
		</header>

	<div class="entry-content">
		
         <?php 
            if ( is_category() || is_archive() ) {
                $excerpt =  get_the_excerpt();
            } else {
                $excerpt =  get_the_content();
            } 

            if ( 'no-destination' != $itinerary_type && !empty($highlights) && !empty( $highlights[0]['image'] ) ) {
                echo '<p>' . wp_trim_words($excerpt, 18) . ' <a href="'. get_the_permalink($post->ID) .'">read more</a></p>';
            } else {
                echo '<p>' . wp_trim_words($excerpt, 35) . '</p>';
                echo '<a href="'. get_the_permalink($post->ID) .'">Read More</a>';
            }
		?>

        
        <?php $section_num = 1; // set first section number ?>
        <?php if ( 'no-destination' != $itinerary_type ) : ?>
		<?php if (!empty($highlights) && !empty( $highlights[0]['image'] ) ) : // have to check against a nested param (not just $highlights) ?>
		<?php
			$location = get_post_meta( $post->ID, 'itinerary_details_weather_location', true );
		?>
            
            <div id="result-map-<?php echo $post->ID; ?>" data-location='<?php echo json_encode( $location ); ?>' data-highlights='<?php echo esc_html(json_encode( $highlights )); ?>'></div>

            <p>
                <?php $number_days = get_post_meta( $post->ID, 'itinerary_details_duration', true ); ?>
                <?php if (!empty($number_days)) : ?>
                    <div class="btn btn-sm btn-success pull-left nohover" style="margin-right:20px;" href="#"><?php echo esc_html( $number_days ); ?></div>
                <?php endif; ?>

                <?php
			    $features = get_post_meta( $post->ID, 'itinerary_details_features', true );
			    if ( ! empty( $features ) ) : ?>
				    
                    <?php
                        $i = 0;
                        $len = count($features);
					    foreach ( $features as $feature ) {
                            if ($i == $len - 1) {
                                echo '<span class="spanFeatureText"> and ' . $feature . '</span>';
                            } else if ($i == 0) {
                                echo '<span class="spanFeatureText">' . $feature . '</span>';
                            } else {
                                echo '<span class="spanFeatureText">, ' . $feature . '</span>';
                            }
                            $i++;
					    }
				    ?>
                    
			    <?php endif; ?>
            
            </p>
            <p>
       
            <div class="showMapLink"><a id="lnkShowMap" href="#" data-imagemap="<?php echo get_post_meta( $post->ID, 'itinerary_details_trip_id', true ); ?>" data-showmap="<?php echo $post->ID; ?>">See map <i class="icon icon-pin"></i></a></div>
            <!--<img src="http://localhost:8080/worldstrides/wp-content/uploads/rating.jpg">-->
            <!-- echo WS_PowerReviews::html_from_pr_page_id( get_pr_page_id($post->ID), apply_filters( 'the_title', $display_title ) ); -->
            <?php echo WS_PowerReviews::snip_from_pr_page_id( get_pr_page_id($post->ID)); ?>

        <?php endif; // tour highlights ?>
        <?php endif; // end no-destination check ?>
        </p>
	</div>

	<footer class="entry-footer">

	</footer>
</article>
