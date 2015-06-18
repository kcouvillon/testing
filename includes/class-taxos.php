<?php
/**
 * Declare the Custom Taxonomies
 *
 * These could be spun out into their own separate classes for each one.
 * Not really objected oriented, but trying to keep functions.php clean
 */

class WS_Custom_Taxonomies {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Associated_Filter
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Custom_Taxonomies
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
		add_action( 'init', array( $this, 'setup_taxonomies' ) );
	}

	public function setup_taxonomies() {
		register_extended_taxonomy( 'filter',
			array(
				'post',
				'itinerary',
				'collection',
				'destination',
				'interest',
				'traveler',
				'resource'
			)
		);

		register_extended_taxonomy( '_collection',
			array(
				'itinerary',
				'event'
			),
			array(
				'rewrite'       => false,
				'show_in_menu'  => false,
				'show_tagcloud' => false,
				// 'hierarchical'  => false, // shouldn't have hierarchy, but prefer list to typing 'tags'
				'public'        => false
			)
		);

		register_extended_taxonomy( 'role',
			array(
				'bio'
			),
			array(
				'rewrite'       => false,
				'show_in_menu'  => true,
				'show_tagcloud' => true,
				'public'        => true
			)
		);

		register_extended_taxonomy( 'blog-type',
			array(
				'post'
			),
			array(
				'rewrite'       => false,
				'show_in_menu'  => false,
				'show_tagcloud' => false,
				'meta_box'      => 'radio',
				'public' => false
			)
		);

		register_extended_taxonomy( 'resource-target',
			array(
				'resource'
			),
			array(
				'rewrite'       => array(
					'slug' => '/resources'
				),
			)
		);

		register_extended_taxonomy( 'resource-type',
			array(
				'resource'
			),
			array(
				'rewrite'       => false,
			)
		);


		register_extended_taxonomy( 'product-lines',
			array(
				'post',
				'why-ws'
			),
			array(
				'rewrite'       => false,
				'show_in_menu'  => false,
				'show_tagcloud' => false,
				'meta_box'      => 'simple',
				'public' => false
			)
		);
	}
}

WS_Custom_Taxonomies::instance();