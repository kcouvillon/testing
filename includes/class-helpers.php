<?php
/**
 * A collection of helper functions.
 */
class WS_Helpers {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Helpers
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Helpers
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new static();
			self::$_instance->_init();
		}

		return self::$_instance;
	}

	public function __construct() {
		// I don't do anything
	}

	/**
	 * Sets up actions and filters.
	 */
	protected function _init() {
		// add_actions and add_filters here
	}

	/**
	 * Find the a blog post's type
	 *
	 * @parameter $post_id int post to retrieve blog type
	 *
	 * @return string the post's blog type
	 */
	public static function blog_type( $post_id ) {
		$terms = get_the_terms( $post_id, 'blog-type' );

		if ( $terms ) {
			$term_slug = $terms[0]->slug;
		} else {
			$term_slug = 'general';
		}

		return $term_slug;
	}

	/**
	 * Helper function for retrieving and formatting value propositions
	 *
	 * @param $post_id
	 *
	 * @return string Our html output
	 */
	public static function get_value_proposition( $post_id ) {
		$value_prop = get_post( $post_id );
		ob_start();
		{ ?>
			<div class="value-prop">
				<?php $icon = get_the_post_thumbnail( $post_id, array( 300, 300 ), array(
					'class' => 'value-prop-img'
				) ); ?>

				<?php if ( $icon ) : ?>
					<?php echo $icon; ?>
				<?php else : ?>
					<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
				<?php endif; ?>

				<span class="value-prop-title"><?php echo $value_prop->post_title; ?></span>

				<p class="value-prop-desc"><?php echo $value_prop->post_content; ?></p>
			</div>
			<?php
			$html = ob_get_contents();
			ob_get_clean();

			return $html;
		}
	}

	/**
	 * Helper function for retrieving and formatting content blocks
	 *
	 * @param $post_id
	 *
	 * @return string Our html output
	 */
	public static function get_content_block( $post_id ) {
		$block      = get_post( $post_id );
		$block_type = get_post_meta( $post_id, 'block_type', true );
		ob_start();
		?>

		<?php if ( 'image-left' == $block_type || 'image-right' == $block_type ) : ?>

			<div class="ws-block block-<?php echo esc_attr( $block_type ); ?>">
				<div class="block-image">
					<?php
					$block_image_id = get_post_meta( $post_id, 'block_image_id', true );

					if ( $block_image_id ) {
						$image = wp_get_attachment_image( $block_image_id, 'square' );
						echo $image;
					} else {
							echo '<img src="http://placehold.it/1030x900" alt="">';
					}
					?>
				</div>
				<div class="block-text">
					<span class="h3"><?php echo apply_filters( 'the_title', $block->post_title ); ?></span>
					<?php echo apply_filters( 'the_content', $block->post_content ); ?>
				</div>
			</div>

		<?php elseif ( 'column-one' == $block_type ) : ?>

			<div class="ws-block block-single-col">
				<div class="block-text">
					<?php echo apply_filters( 'the_content', $block->post_content ); ?>
				</div>
			</div>

		<?php elseif ( 'column-two' == $block_type ) : ?>

			<div class="ws-block block-two-col">
				<div class="block-text">
					<div class="block-text-columns">
						<?php echo apply_filters( 'the_content', $block->post_content ); ?>
					</div>
				</div>
			</div>

		<?php elseif ( 'slideshow-basic' == $block_type || 'slideshow-tabbed' == $block_type ) : ?>

			<?php if ( 'slideshow-tabbed' == $block_type ) {
				$classes           = 'block-slideshow-tabbed';
				$pager             = 'data-cycle-pager="#slideshow-tabs-' . $post_id . '"';
			} else {
				$classes           = 'block-slideshow';
				$pager             = '';
			} ?>

			<div class="ws-block <?php echo esc_attr( $classes ); ?> cycle-slideshow"
				<?php echo $pager . "\n"; ?>
				data-cycle-auto-height="container"
				data-cycle-fx="scrollHorz">
				<div class="cycle-overlay"></div>
				<div class="cycle-prev"></div>
				<div class="cycle-next"></div>

				<?php $slides = get_post_meta( $post_id, 'block_slideshow_list', true ); ?>

				<?php foreach( $slides as $slide ) : ?>
					<?php $slide_image = wp_get_attachment_image_src( $slide['image_id'], 'hero' ); ?>
					<?php echo "\n"; ?>
					<img src="<?php echo $slide_image[0] ?>"
					     alt=""
					     data-cycle-desc="<?php echo $slide['caption']; ?>"
						 <?php if ( 'slideshow-tabbed' == $block_type ) { echo "data-cycle-pager-template='<a href=#>" . $slide['title'] . "</a>'"; } ?>>
				<?php endforeach; ?>

				<?php if ( 'slideshow-simple' == $block_type ) : ?>
					<?php echo "\n"; ?>
					<div class="cycle-pager"></div>
				<?php endif; ?>
			</div>
			<?php if ( 'slideshow-tabbed' == $block_type ) : ?>
				<?php echo "\n"; ?>
				<div id="<?php echo 'slideshow-tabs-' . $post_id; ?>" class="slideshow-tabs"></div>
			<?php endif; ?>

		<?php endif; ?>

		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	// determine the topmost parent of a term
	public static function get_term_top_most_parent( $term_id, $taxonomy ) {

		// start from the current term
		$parent  = get_term_by( 'id', $term_id, $taxonomy);

		// climb up the hierarchy until we reach a term with parent = '0'
		while ( $parent->parent != '0' ){
			$term_id = $parent->parent;

			$parent  = get_term_by( 'id', $term_id, $taxonomy);
		}

		return $parent;
	}

	/**
	 * Helper function for retrieving a destination from the filter taxonomy
	 *
	 * @param $post_id
	 * @param $parent
	 *
	 * @return string Our html output
	 */
	public static function get_subtitle( $post_id, $parent = 'destination' ) {
		$subtitle_term = '';
		$subtitle = '';

		$subtitle_term_parent  = get_term_by( 'slug', $parent, 'filter' );
		$subtitle_term_parent_id = $subtitle_term_parent->term_id;

		$terms = wp_get_post_terms( $post_id, 'filter' );

		foreach ( $terms as $term ) {
			$subtitle_parent = WS_Helpers::get_term_top_most_parent( $term->term_id, 'filter' );

			//var_dump( $parent );
			if ( $subtitle_parent->term_id == $subtitle_term_parent_id ) {
				$subtitle_term = $term;
				break;
			}
		}

		if ( ! empty( $subtitle_term) ) {
			$subtitle = $subtitle_term->name;
		}

		return $subtitle;

		// loop through terms, see if parent id equals destination id, get first term that's true

		// var_dump( $terms );
	}

	/**
	 * Generate Google Tag Manager embed
	 *
	 * @return string GTM embed code
	 */
	public static function ws_google_tag_manager() {
		$tag_manager_id = 'GTM-KQ3K7D';

		ob_start();
		?>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $tag_manager_id; ?>"
		                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo $tag_manager_id; ?>');</script>
		<!-- End Google Tag Manager -->
		<?php

		$html = ob_get_clean();

		return $html;
	}

	/**
	 * @return array ids of the most recent travelogue and postcard
	 */
	public static function get_blog_sidebar_posts() {

		$recent_highlights = array();

		$recent_travelogue = new WP_Query( array(
			'posts_per_page' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'blog-type',
					'field'    => 'slug',
					'terms'    => 'travelogue',
				),
			),
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		) );

		$recent_postcard = new WP_Query( array(
			'posts_per_page' => 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'blog-type',
					'field'    => 'slug',
					'terms'    => 'postcard',
				),
			),
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		) );

		if ( $recent_travelogue->have_posts() ) {
			global $post;
			$recent_travelogue->the_post();
			$recent_highlights[] = $post->ID;
		}

		if ( $recent_postcard->have_posts() ) {
			global $post;
			$recent_postcard->the_post();
			$recent_highlights[] = $post->ID;
		}

		return $recent_highlights;
	}

	/**
	 * Get the weather data.
	 * http://openweathermap.org/api
	 */
	public static function get_weather_data( $post_id ) {

		if ( ! $post_id )
			return false;
		
		$weather = get_transient( 'weatherData_' . $post_id );

		if ( $weather ) {

			return $weather;

		} else {

			$location = get_post_meta( $post_id, 'itinerary_details_weather_location', true );

			if ( is_array( $location ) ) {

				$latitude = $location['latitude'];
				$longitude = $location['longitude'];
				$data = wp_remote_get( 'http://api.openweathermap.org/data/2.5/weather?lat=' . $latitude . '&lon=' . $longitude . '&units=imperial&APPID=c5f43ae748001fdf50e591cab7c57476' );
				
				if ( ! is_wp_error( $data ) ) {

					$json = json_decode( $data['body'] );
					set_transient( 'weatherData_' . $post_id, $json, 300 );
					return $json;

				} else {

					return false;

				}

			} else {

				return false;

			}

		}

	}

	/**
	 * Get the weather icon.
	 * Icon codes based off of http://openweathermap.org/weather-conditions.
	 */
	public static function get_weather_icon( $iconCode ) {
		
		if ( ! $iconCode )
			return;

		$icon = '';

		if ( $iconCode == '01n' ) {
			$icon = 'moon';
		} elseif ( $iconCode == '02d' ) {
			$icon = 'cloudy';
		} elseif ( $iconCode == '02n' ) {
			$icon = 'cloud2';
		} elseif ( in_array( $iconCode, array( '03d', '03n', '04d', '04n' ) ) ) {
			$icon = 'cloud';
		} elseif ( in_array( $iconCode, array( '11d', '11n' ) ) ) {
			$icon = 'lightning';
		} elseif ( in_array( $iconCode, array( '09d', '09n', '10d', '10n' ) ) ) {
			$icon = 'rainy';
		} elseif ( in_array( $iconCode, array( '13d', '13n' ) ) ) {
			$icon = 'snowy';
		} elseif ( in_array( $iconCode, array( '50d', '50n' ) ) ) {
			$icon = 'mist';
		} else {
			$icon = 'sun';
		}

		return $icon;

	}

	/**
	 * Get the local time.
	 */
	public static function get_local_time( $tz_offset ) {

		// code to generate time based on a numerical offset (i.e. "-4") 

		// $tz_offset = floatval( $tz_offset ) * 60 * 60;
		// $time = time() + $tz_offset;
		// $local_time = date( 'g:i a', $time );
		//return $local_time;

		// code to generate time based on city string (i.e. "America/New_York")

		date_default_timezone_set( $tz_offset );
		$local_time = date( 'g:i a' );
		return $local_time;

	}
}
























WS_Helpers::instance();