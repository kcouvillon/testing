<?php
/**
 * Declare the Custom Post Types
 *
 * These could be spun out into their own separate classes for each one.
 * Not really objected oriented, but trying to keep functions.php clean.
 *
 * We're using a library to offer extended functionality for declaring
 * post types, but they could be declared natively.
 */
class WS_Custom_Post_Types {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Associated_Filter
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Associated_Filter
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
		add_action( 'init', array( $this, 'setup_post_types' ) );
	}

	/**
	 * Register our custom post types
	 */
	public function setup_post_types() {
		/**
		 * Define Itinerary custom post type
		 */
		register_extended_post_type( 'itinerary',
			array(
				'menu_icon' => 'dashicons-location-alt',
				'slug'      => 'trips'
			),
			array(
				'plural' => 'Itineraries'
			)
		);

		/**
		 * Define Event custom post type
		 */
		register_extended_post_type( 'event',
			array(
				'menu_icon' => 'dashicons-tickets-alt'
			),
			array(
				'slug' => 'events'
			)
		);

		/**
		 * Define Collections post type
		 */
		register_extended_post_type( 'collection',
			array(
				'menu_icon' => 'dashicons-format-gallery'
			)
		);

		/**
		 * Define Destinations post type
		 */
		register_extended_post_type( 'destination',
			array(
				'menu_icon' => 'dashicons-location'
			)
		);


		register_extended_post_type( 'interest',
			array(
				'menu_icon' => 'dashicons-awards'
			)
		);

		register_extended_post_type( 'traveler',
			array(
				'menu_icon' => 'dashicons-universal-access'
			)
		);

		register_extended_post_type( 'resource',
			array(
				'menu_icon' => 'dashicons-portfolio',
				'rewrite'   => array( 'slug' => 'resources/question' )
			)
		);

		register_extended_post_type( 'press',
			array(
				'menu_icon' => 'dashicons-media-document',
				'rewrite'   => array( 'slug' => 'about/press' )
			),
			array(
				'plural' => 'Press'
			)
		);

		register_extended_post_type( 'bio',
			array(
				'menu_icon' => 'dashicons-id',
				'exclude_from_search'    => false,
				'publicly_queryable'     => false
			)
		);

		register_extended_post_type( 'campaign',
			array(
				'menu_icon' => 'dashicons-feedback'
			)
		);

		register_extended_post_type( 'review',
			array(
				'menu_icon' => 'dashicons-testimonial'
			)
		);

		register_extended_post_type( 'why-ws',
			array(
				'menu_icon' => 'dashicons-format-image',
				'exclude_from_search'    => false,
				'publicly_queryable'   => false,
				'show_in_nav_menus'       => false
			),
			array(
				'plural' => 'Why WS'
			)
		);

		register_extended_post_type( 'block',
			array(
				'menu_icon' => 'dashicons-tagcloud',
				'exclude_from_search'    => false,
				'publicly_queryable'   => false,
				'show_in_nav_menus'       => false
			)
		);
	}
}

WS_Custom_Post_Types::instance();