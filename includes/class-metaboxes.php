<?php
/**
 * Adding Metaboxes and custom fields
 *
 * @todo might need smaller classeses if this gets too big
 *
 * Class WS_Metaboxes
 */
class WS_Metaboxes {
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
		add_action( 'cmb2_init',  array( $this, 'leadership_attached_bios' ) );
	}

	/**
	 * Define the metabox and field configurations.
	 *
	 * @return array
	 */
	function leadership_attached_bios() {

		$example_meta = new_cmb2_box( array(
			'id'           => 'ws_attached_leadership_bios_field',
			'title'        => __( 'Attached Leadership Bios', 'cmb2' ),
			'object_types' => array( 'page' ), // Post type
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/page-about-leadership.php' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => false, // Show field names on the left
		) );

		$example_meta->add_field( array(
			'name'    => __( 'Attached Bios', 'cmb2' ),
			'desc'    => __( 'Drag bios from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'ws_attached_leadership_bios',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 25,
					'post_type' => 'bio',
					'tax_query' => array(
						array(
							'taxonomy' => 'role',
							'field'    => 'slug',
							'terms'    => 'leadership',
						),
					),
				),
			)
		) );

	}
}

WS_Metaboxes::instance();
