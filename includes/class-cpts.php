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
				'menu_icon' => 'dashicons-location-alt'
			),
			array(
				'plural' => 'Itineraries'
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
				'rewrite'   => array( 'slug' => 'about/press' ),
				'taxonomies' => array( 'category' )
			),
			array(
				'plural' => 'Press'
			)
		);

		/**
		 * Define bio post type
		 */
		register_extended_post_type( 'bio',
			array(
				'menu_icon' => 'dashicons-id',
				'rewrite'   => array( 'slug' => 'about/profile' ),
				'has_archive' => false,
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
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
				'show_in_nav_menus'       => false,

				'admin_cols' => array(
					// A featured image column:
					'featured_image' => array(
						'title'          => 'Icon',
						'featured_image' => 'thumbnail'
					),
					// A taxonomy terms column:
					'product_line' => array(
						'taxonomy' => 'product-line'
					),
					// The default Title column:
					'title',
					// A post field column:
					'last_modified' => array(
						'title'      => 'Last Modified',
						'post_field' => 'post_modified',
					),
				),
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
				'show_in_nav_menus'       => false,
				'supports' => array( 'title', 'thumbnail' )

			)
		);
	}
}

WS_Custom_Post_Types::instance();