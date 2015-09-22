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
		add_action( 'cmb2_init',  array( $this, 'itinerary_details' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_highlights' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blocks_before' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_days' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blocks_after' ) );
		add_action( 'cmb2_init',  array( $this, 'itinerary_blog_post' ) );
	}

	/**
	 * Itinerary Details box
	 */
	function itinerary_details() {

		$prefix = 'itinerary_details_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Itinerary Details', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
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
			),
		) );

		$cmb->add_field( array(
			'name' => __( 'PDF', 'cmb2' ),
			'id'   => 'itinerary_pdf',
			'type' => 'file'
		) );

		$cmb->add_field( array(
			'name' => __( 'Phone Number', 'cmb2' ),
			'id'   => 'itinerary_phone',
			'type' => 'text'
		) );

		$cmb->add_field( array(
			'name' => 'Duration',
			'desc' => 'Number of days',
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

		$cmb->add_field( array(
			'name' => __( 'Internal Trip ID', 'cmb2' ),
			'id'   => $prefix . 'trip_id',
			'type' => 'text_small'
		) );

		$cmb->add_field( array(
			'name' => __( 'Old Url', 'cmb2' ),
			'id'   => $prefix . 'old_url',
			'type' => 'text_url'
		) );
	}

	/**
	 * Field group for Itinerary Highlights
	 */
	function itinerary_highlights() {

		$prefix = 'itinerary_highlights_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Highlights', 'cmb2' ),
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
	 * Attach before block sections
	 */
	function itinerary_blocks_before() {

		$prefix = 'itinerary_blocks_before_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Before Blocks', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
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
			'name' => 'Section Slug',
			'id' => $prefix . 'slug',
			'type' => 'text_medium'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name'    => __( 'Attached Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => -1,
					'post_type' => 'block',
				),
			)
		) );

	}

	/**
	 * Itinerary Days
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
			'name'       => __( 'Activity List', 'cmb2' ),
			'id'         => 'activity_list',
			'type'       => 'textarea',
			'desc'       => 'Use the activity shortcode - [activity title="Title"]Description[/activity]'
		) );

		$cmb->add_group_field( $day_group, array(
			'name'       => __( 'Related Content Title', 'cmb2' ),
			'id'         => 'related_content_title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $day_group, array(
			'name'        => __( 'Related Content Picker' ),
			'id'          => 'related_content',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'block',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'radio'
		) );
	}

	/**
	 * Sections of Blocks to appear after itineraries
	 */
	function itinerary_blocks_after() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'itinerary_blocks_after_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'After Blocks', 'cmb2' ),
			'object_types' => array( 'itinerary', ),
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
			'id' => $prefix . 'title',
			'type' => 'text_medium'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Section Slug',
			'id' => $prefix . 'slug',
			'type' => 'text_medium'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name'    => __( 'Attached Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => -1,
					'post_type' => 'block',
				),
			)
		) );

	}

	/**
	 * Featured blog posts
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
			'id'          => 'related_blog_post',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'post',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'radio'
		) );
	}
}

WS_Metaboxes_Itineraries::instance();
