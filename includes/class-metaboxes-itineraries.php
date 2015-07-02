<?php
/**
 * Adding Metaboxes and custom fields for Itineraries
 *
 * Class WS_Metaboxes_Itineraries
 */
class WS_Metaboxes_Itineraries {
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
		add_action( 'cmb2_init',  array( $this, 'itinerary_hero_tooltips' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_details' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_highlights' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blocks_before' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_days' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blocks_after' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blog_post' ) );
	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_hero_tooltips() {

		$prefix = 'itinerary_hero_tooltips_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Hero Tooltips', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Tooltip {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Tooltip', 'cmb2' ),
				'remove_button' => __( 'Remove Tooltip', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => 'title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => 'caption',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_details() {

		$prefix = 'itinerary_details_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Itinerary Details', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		// Date(s) / Duration
		// @todo duration and date-range select
		$cmb->add_field( array(
			'name' => 'Date',
			'id' => $prefix . 'date',
			'type' => 'text_date'
		) );

		// Destinations / Activities
		$cmb->add_field( array(
			'name' => 'Features title',
			'desc' => 'e.g. Destinations Visited, Optional Activites, etc.',
			'id' => $prefix . 'features_title',
			'type' => 'text'
		) );

		$cmb->add_field( array(
			'name' => 'Features',
			// 'desc' => 'List of destinations/activities',
			'id' => $prefix . 'features',
			'type' => 'text',
			'repeatable' => true
		) );

		// Timezone
		$cmb->add_field( array(
			'name' => 'Timezone',
			'desc' => 'Set the itinerary timezone',
			'id' => $prefix . 'timezone',
			'type' => 'select_timezone',
		) );

		// Location (weather)
		$cmb->add_field( array(
			'name' => 'Weather Location',
			'desc' => 'Drag the marker to set the exact location',
			'id' => $prefix . 'weather_location',
			'type' => 'pw_map',
			// 'split_values' => true, // Save latitude and longitude as two separate fields
		) );
	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_highlights() {

		$prefix = 'itinerary_highlights_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Tour Highlights', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'list',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Location {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Location', 'cmb2' ),
				'remove_button' => __( 'Remove Location', 'cmb2' ),
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
			'name'       => __( 'Title', 'cmb2' ),
			'id'         => 'title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Caption', 'cmb2' ),
			'description' => __( 'The text that appears in the section header', 'cmb2' ),
			'id'          => 'caption',
			'type'        => 'textarea_small',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Image', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
				'name' => 'Location',
				'desc' => 'Drag the marker to set the exact location',
				'id' => $prefix . 'location',
				'type' => 'pw_map',
				// 'split_values' => true, // Save latitude and longitude as two separate fields
		) );

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_blocks_before() {

		$prefix = 'itinerary_blocks_before_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Before Blocks', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		$cmb->add_field( array(
			'name' => 'Section Title',
			'id' => $prefix . 'title',
			'type' => 'text_medium'
		) );

		$cmb->add_field( array(
			'name' => 'Section Slug',
			'desc' => 'The anchor that gets linked to in the navigation bar',
			'id' => $prefix . 'slug',
			'type' => 'text_medium'
		) );

		$cmb->add_field( array(
			'name'        => __( 'Blocks' ),
			'id'          => 'itinerary_block_before',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'block',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'checkbox'
		) );

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_days() {

		$prefix = 'itinerary_days_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Itinerary Days', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$day_group = $cmb->add_field( array(
			'id'          => $prefix . 'list',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Day {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Day', 'cmb2' ),
				'remove_button' => __( 'Remove Day', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		$cmb->add_group_field( $day_group, array(
			'name'       => __( 'Title', 'cmb2' ),
			'id'         => 'title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $day_group, array(
			'name' => __( 'Header Image', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb->add_group_field( $day_group, array(
			'name'       => __( 'Activity', 'cmb2' ),
			'id'         => 'activity',
			'type'       => 'itinerary_activity',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $day_group, array(
			'name'        => __( 'Related Content' ),
			'id'          => 'related_content',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'block',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'radio'
		) );
	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_blocks_after() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'itinerary_blocks_after_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'After Blocks', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		$cmb->add_field( array(
			'name' => 'Section Title',
			'id' => $prefix . 'title',
			'type' => 'text_medium'
		) );

		$cmb->add_field( array(
			'name' => 'Section Slug',
			'desc' => 'The text that gets linked to in the navigation bar',
			'id' => $prefix . 'slug',
			'type' => 'text_medium'
		) );

		$cmb->add_field( array(
			'name'        => __( 'Blocks' ),
			'id'          => 'itinerary_block_after',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'block',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'checkbox'
		) );

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function itinerary_blog_post() {

		$prefix = 'itinerary_blog_post_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Blog Post', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
		) );

		$cmb->add_field( array(
			'name'        => __( 'Blog post' ),
			'id'          => 'itinerary_block_after',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'post',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'radio'
		) );
	}
}

WS_Metaboxes_Itineraries::instance();
