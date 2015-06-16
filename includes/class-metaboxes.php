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
		add_action( 'cmb2_init',  array( $this, 'bio_details' ) );
		add_action( 'cmb2_init',  array( $this, 'why_worldstrides_page_section_group' ) );
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
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-leadership.php' ),
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


	function bio_details() {
		$bio_details = new_cmb2_box( array(
			'id'           => 'ws_bio_details',
			'title'        => __( 'Bio Details', 'cmb2' ),
			'object_types' => array( 'bio' ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		$bio_details->add_field( array(
			'name' => __( 'Position', 'cmb2' ),
			'id'   => 'ws_bio_position',
			'type' => 'text_medium'
		) );
	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function why_worldstrides_page_section_group() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'why_worldstrides_section_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Why WorldStrides Sections', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/why-worldstrides.php' ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'group',
			'type'        => 'group',
			'description' => __( 'Generates Why WorldStrides sections', 'cmb2' ),
			'options'     => array(
				'group_title'   => __( 'Section {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Section', 'cmb2' ),
				'remove_button' => __( 'Remove Section', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		/**
		 * Group fields works the same, except ids only need
		 * to be unique to the group. Prefix is not needed.
		 *
		 * The parent field's id needs to be passed as the first argument.
		 */
		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Section Title', 'cmb2' ),
			'id'         => 'title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Description', 'cmb2' ),
			'description' => __( 'The text that appears in the section header', 'cmb2' ),
			'id'          => 'description',
			'type'        => 'textarea_small',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Section Image', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'    => __( 'Attached Why WS', 'cmb2' ),
			'desc'    => __( 'Drag Why WS from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_why_ws',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 10,
					'post_type' => 'why-ws',
				),
			)
		) );

	}
}

WS_Metaboxes::instance();
