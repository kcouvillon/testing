<?php
/**
 * Declare the Custom Post Types
 *
 * These could be spun out into their own separate classes for each one.
 * Not really objected oriented, but trying to keep functions.php clean
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

	public function setup_post_types() {
		/**
		 * Define trip custom post type
		 */
		register_extended_post_type( 'trip', array( 'menu_icon' => 'dashicons-location-alt' ), array( 'slug' => 'trips' ) );

		register_extended_post_type( 'event', array( 'menu_icon' => '' ), array( 'slug' => 'events' ) );
		register_extended_post_type( 'collection' );
		register_extended_post_type( 'destination' );
		register_extended_post_type( 'interest' );
		register_extended_post_type( 'traveler' );
		register_extended_post_type( 'season' );
		register_extended_post_type( 'group type' );
		register_extended_post_type( 'press', array(), array( 'plural' => 'Press' ) );
		register_extended_post_type( 'resource' );
		register_extended_post_type( 'review' );
		register_extended_post_type( 'campaign' );

		register_extended_post_type( 'leadership', array(), array( 'plural' => 'Leadership' ) );
	}
}

WS_Custom_Post_Types::instance();