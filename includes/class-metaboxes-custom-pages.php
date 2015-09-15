<?php
/**
 * Adding Metaboxes and custom fields for Custom Pages
 *
 * Class WS_Custom_Pages
 */
class WS_Metaboxes_Custom_Pages {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Metaboxes
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Metaboxes
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
		add_action( 'cmb2_init', array( $this, 'itinerary_details' ) );
	}

	/**
	 * Field group for Custom Itineraries page
	 */
	function itinerary_details() {

		$prefix = 'itinerary_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Itinerary Details', 'cmb2' ),
			'object_types' => array( 'custom-page', ),
		) );

		$cmb->add_field( array(
			'name' => __( 'Trip ID', 'cmb2' ),
			'id'   => $prefix . 'trip_id',
			'type' => 'text_small'
		) );

		$cmb->add_field( array(
			'name' => __( 'Price', 'cmb2' ),
			'id'   => $prefix . 'price',
			'type' => 'text_small'
		) );
	}
}

WS_Metaboxes_Custom_Pages::instance();
