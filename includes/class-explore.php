<?php
/**
 * Add explore
 *
 * Class WS_Explore
 */
class WS_Explore {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Explore
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Explore
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
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route( 'worldstrides/v1', '/filter/(?P<slug>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'filters' )
		) );
	}

	/**
	 *
	 */
	public static function filters() {

		$filters = array( 'high-school', 'china' );

		$itinerary_args = array(
			'post_type' => 'itinerary',
			'posts_per_page' => 500, // very large, but better than -1
			'tax_query' => array(
				array(
					'taxonomy' => 'filter',
					'field'	   => 'slug',
					'terms'    => $filters,
					'operator' => 'AND'
				)
			),
			'no_found_rows'          => true,
			'orderby' => 'title',
			'order' => 'ASC'
		);

		$itineraries = new WP_Query( $itinerary_args );

		// echo '<h2>' . $itineraries->post_count . '</h2>';
		// var_dump( $itineraries );

		return $itineraries;
	}
}

WS_Explore::instance();
