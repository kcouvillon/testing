<?php
/**
 * Custom query content display for about pages
 */
 get_header();
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
            the_excerpt();
			//echo '<a href="'. get_the_permalink() .'">Keep Reading</a>';
		?>
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