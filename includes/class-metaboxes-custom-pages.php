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
		add_action( 'cmb2_init', array( $this, 'custom_page_details' ) );
		add_action( 'cmb2_init', array( $this, 'custom_page_itinerary' ) );
		add_action( 'cmb2_init', array( $this, 'custom_page_faculty' ) );
		add_action( 'cmb2_init', array( $this, 'custom_page_sections' ) );
	}


	/**
	 * Itinerary Details box
	 */
	function custom_page_details() {

		$prefix = 'itinerary_details_';

		$cmb = new_cmb2_box( array(
			'id'           => 'custom_page_details_metabox',
			'title'        => __( 'Custom Page Details', 'cmb2' ),
			'object_types' => array( 'custom-page', ),
		) );

		$cmb->add_field( array(
			'name' => __( 'Subtitle', 'cmb2' ),
			'id'   => 'itinerary_subtitle',
			'type' => 'text'
		) );

		$cmb->add_field( array(
			'name'             => 'Itinerary Type',
			'id'               => 'itinerary_type',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'Regular',
			'options'          => array(
				'regular' => __( 'Regular', 'cmb' ),
				'smithsonian'   => __( 'Smithsonian', 'cmb' ),
				'no-destination'   => __( 'No Destination', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => __( 'Price', 'cmb2' ),
			'id'   => $prefix . 'price',
			'type' => 'text_small'
		) );

		$cmb->add_field( array(
			'name' => __( 'Trip ID', 'cmb2' ),
			'id'   => $prefix . 'trip_id',
			'type' => 'text_small'
		) );

		$cmb->add_field( array(
			'name' => __( 'Register Now Button', 'cmb2' ),
			'id'   => $prefix . 'register_now',
			'type' => 'radio_inline',
			'default' => '0',
			'options' => array(
				'1' => __( 'Show', 'cmb' ),
				'0'   => __( 'Hide', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => 'Register by',
			'id' => $prefix . 'register_by',
			'type' => 'text_date'
		) );


		$cmb->add_field( array(
			'name' => 'Duration',
			'desc' => 'This will override the dates selected below.',
			'id' => $prefix . 'duration',
			'type' => 'text_small'
		) );

		$group_field_id = $cmb->add_field( array(
			'id'      => $prefix . 'date_list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Date Range {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Date Range', 'cmb2' ),
				'remove_button' => __( 'Remove Date Range', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		// Date(s) / Duration
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Start Date',
			'id' => $prefix . 'date_start',
			'type' => 'text_date'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'End Date',
			'id' => $prefix . 'date_end',
			'type' => 'text_date'
		) );

		$cmb->add_field( array(
			'name' => 'Inclusions',
			'desc' => 'Each inclusion should be its own row',
			'id' => $prefix . 'features',
			'type' => 'text',
			'repeatable' => true
		) );

		$cmb->add_field( array(
			'name' => __( 'Gift of Education', 'cmb2' ),
			'id'   => $prefix . 'gift_of_ed',
			'type' => 'radio_inline',
			'default' => '0',
			'options' => array(
				'1' => __( 'Show', 'cmb' ),
				'0'   => __( 'Hide', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => __( 'IFA Scholarship', 'cmb2' ),
			'id'   => $prefix . 'ifa_scholarship',
			'type' => 'radio_inline',
			'default' => '0',
			'options' => array(
				'1' => __( 'Show', 'cmb' ),
				'0'   => __( 'Hide', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => __( 'For Parents', 'cmb2' ),
			'id'   => $prefix . 'for_parents',
			'type' => 'radio_inline',
			'default' => '0',
			'options' => array(
				'1' => __( 'Show', 'cmb' ),
				'0'   => __( 'Hide', 'cmb' ),
			),
		) );
	}

	/**
	 * Field group for Itinerary Highlights
	 */
	function custom_page_faculty() {

		$prefix = 'custom_page_faculty_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => 'custom_page_faculty_metabox',
			'title'        => __( 'Faculty', 'cmb2' ),
			'object_types' => array( 'custom-page', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'list',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Faculty Member {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Faculty Member', 'cmb2' ),
				'remove_button' => __( 'Remove Faculty Member', 'cmb2' ),
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
			'name'       => __( 'Name', 'cmb2' ),
			'id'         => 'name',
			'type'       => 'text',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Title', 'cmb2' ),
			'id'         => 'title',
			'type'       => 'text',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Email', 'cmb2' ),
			'id'         => 'email',
			'type'       => 'text_email',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Description', 'cmb2' ),
			'id'          => 'description',
			'type'        => 'textarea_small',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Image', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );

	}

	function custom_page_itinerary() {
		$prefix = 'custom_page_itinerary_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Itinerary Highlights', 'cmb2' ),
			'object_types' => array( 'custom-page', ),
			'show_names'   => false
		) );

		$cmb->add_field( array(
			'name' => 'Itinerary Highlights',
			'id' => $prefix . 'highlights',
			'type' => 'wysiwyg'
		) );
	}

	function custom_page_sections() {
		$prefix = 'custom_page_sections_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Sections', 'cmb2' ),
			'object_types' => array( 'custom-page', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb->add_field( array(
			'id'          => $prefix . 'list',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Section {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Section', 'cmb2' ),
				'remove_button' => __( 'Remove Section', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Section Title',
			'id' => 'title',
			'type' => 'text_medium'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Section Content',
			'id' => 'content',
			'type' => 'textarea'
		) );
	}

}

WS_Metaboxes_Custom_Pages::instance();
