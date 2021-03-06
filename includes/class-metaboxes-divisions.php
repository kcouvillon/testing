<?php
/**
 * Adding Metaboxes and custom fields for Divisions
 *
 * Class WS_Metaboxes_Divisions
 */
class WS_Metaboxes_Divisions {
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
		add_action( 'cmb2_init',  array( $this, 'division_options' ) );
		add_action( 'cmb2_init',  array( $this, 'division_why_ws' ) );
		add_action( 'cmb2_init',  array( $this, 'division_resources' ) );
		add_action( 'cmb2_init',  array( $this, 'division_blocks_before' ) );
		add_action( 'cmb2_init',  array( $this, 'division_locations' ) );
		add_action( 'cmb2_init',  array( $this, 'division_collections' ) );
		add_action( 'cmb2_init',  array( $this, 'division_team' ) );
		add_action( 'cmb2_init',  array( $this, 'division_partnerships' ) );
		add_action( 'cmb2_init',  array( $this, 'division_partnerships_small' ) );
		add_action( 'cmb2_init',  array( $this, 'division_blocks_after' ) );
		add_action( 'cmb2_init',  array( $this, 'division_blog_posts' ) );
		add_action( 'cmb2_init',  array( $this, 'division_additional_info' ) );
	}

	/**
	 * Division Options
	 */
	function division_options() {

		$prefix = 'division_options_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Division Options', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name' => 'Subtitle',
			'id' => $prefix . 'subtitle',
			'type' => 'text'
		) );

		$cmb->add_field( array(
			'name'             => 'Discover Why module',
			'id'               => 'discover_why',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'On',
			'options'          => array(
				'on' => __( 'On', 'cmb' ),
				'off'   => __( 'Off', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name'             => 'Blog module',
			'id'               => 'blog',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'On',
			'options'          => array(
				'on' => __( 'On', 'cmb' ),
				'off'   => __( 'Off', 'cmb' ),
			),
		) );
	}

	/**
	 * Select Why Worldstrides posts to display
	 */
	function division_why_ws() {

		$prefix = 'division_why_ws_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Why WorldStrides', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name'       => __( 'Title', 'cmb2' ),
			'id'         => $prefix . 'title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_field( array(
			'name'    => __( 'Attached Why WS', 'cmb2' ),
			'desc'    => __( 'Drag Why WS from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_why_ws',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 70,
					'post_type' => 'why-ws',
				),
			)
		) );

	}

	/**
	 * Resources to display
	 */
	function division_resources() {

		$prefix = 'division_resources_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Resources', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name'       => __( 'Title', 'cmb2' ),
			'id'         => $prefix . 'title',
			'type'       => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_field( array(
			'name'    => __( 'Attached Resources', 'cmb2' ),
			'desc'    => __( 'Drag Resources from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_resources',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 100,
					'post_type' => 'resource',
				),
			)
		) );

	}

	/**
	 * Sections of blocks to show before itineraries
	 */
	function division_blocks_before() {

		$prefix = 'division_blocks_before_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Before Blocks', 'cmb2' ),
			'object_types' => array( 'page' ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
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
	 * Locations for a division landing page
	 */
	function division_locations() {

		$prefix = 'division_locations_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Locations', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/division-capstone.php' ),
		) );

		$cmb->add_field( array(
			'name' => __( 'CSV List', 'worldstrides' ),
			'id'   => $prefix . 'csv_list',
			'type' => 'textarea',
			'description' => 'City, Latitude, Longitude'
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		/*

		// $group_field_id is the field id string
		$group_field_id = $cmb->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Location {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Location', 'worldstrides' ),
				'remove_button' => __( 'Remove Location', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => __( 'Name', 'worldstrides' ),
			'id'   => 'name',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		// Location (weather)
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Location',
			'id' => $prefix . 'coordinates',
			'type' => 'text',
			// 'split_values' => true, // Save latitude and longitude as two separate fields
		) );

		*/
	}

	/**
	 * Show associated itineraries
	 */
	function division_collections() {

		$prefix = 'division_collections_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Collections', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Attached Collections', 'cmb2' ),
			'desc'    => __( 'Drag itineraries from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'associated_collections',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => -1,
					'post_type' => 'collection',
				),
			)
		) );
	}

	/**
	 * Attach bios for the Division Team
	 */
	function division_team() {

		$cmb = new_cmb2_box( array(
			'id'           => 'division_team',
			'title'        => __( 'Attached Bios', 'cmb2' ),
			'object_types' => array( 'page' ), // Post type
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/division-capstone.php' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => false, // Show field names on the left
		) );

		$cmb->add_field( array(
			'name'    => __( 'Attached Bios', 'cmb2' ),
			'desc'    => __( 'Drag bios from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_bios',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 50,
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


	/**
	 * Add Partnerships for the Capstone division
	 */
	function division_partnerships() {

		$prefix = 'division_partnerships_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => 'Partnerships',
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/division-capstone.php' ),
		) );

		$cmb_group->add_field( array(
				'name' => 'Title',
				'id' => $prefix . 'title',
				'type' => 'text'
			)
		);

		// $group_field_id is the field id string
		$partnerships = $cmb_group->add_field( array(
			'id'      => $prefix . 'partners',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Partnership {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Partnership', 'cmb2' ),
				'remove_button' => __( 'Remove Partnership', 'cmb2' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => 'title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'URL', 'cmb2' ),
			'id'   => 'url',
			'type' => 'text_url',
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'Description', 'cmb2' ),
			'id'   => 'description',
			'type' => 'textarea_small',
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'Partnership Logo', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );

	}

	/**
	 * Add small Partnerships for the Capstone division
	 */
	function division_partnerships_small() {

		$prefix = 'division_partnerships_small_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => 'Small Partnerships',
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/division-capstone.php' ),
		) );

		$cmb_group->add_field( array(
				'name' => 'Title',
				'id' => $prefix . 'title',
				'type' => 'text'
			)
		);

		// $group_field_id is the field id string
		$partnerships = $cmb_group->add_field( array(
			'id'      => $prefix . 'partners',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Partnership {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Partnership', 'cmb2' ),
				'remove_button' => __( 'Remove Partnership', 'cmb2' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => 'title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $partnerships, array(
			'name' => __( 'URL', 'cmb2' ),
			'id'   => 'url',
			'type' => 'text_url',
		) );
	}


	/**
	 * Sections of Blocks to show after itineraries
	 */
	function division_blocks_after() {

		$prefix = 'division_blocks_after_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'After Blocks', 'cmb2' ),
			'object_types' => array( 'page' ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
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
	function division_blog_posts() {

		$prefix = 'division_blog_posts_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Blog Posts', 'cmb2' ),
			'object_types' => array( 'page' ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name'        => __( 'Blog posts' ),
			'id'          => 'attached_blog_posts',
			'type'        => 'post_search_text', // This field type
			// post type also as array
			'post_type'   => 'post',
			// checkbox/radio, used in the modal view to select the post type
			'select_type' => 'checkbox'
		) );
	}

	/**
	 * Additonal info box
	 */
	function division_additional_info() {

		$prefix = 'additional_info_x_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Additional Info and Email', 'cmb2' ),
			'object_types' => array( 'page' ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-general.php'
				)
			),
		) );

		$cmb->add_field( array(
			'name'             => 'Request information module',
			'id'               => $prefix . 'request_box',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'On',
			'options'          => array(
				'on' => __( 'On', 'cmb' ),
				'off'   => __( 'Off', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => 'Additional Info',
			'id'   => $prefix . 'text',
			'type' => 'textarea_small',
			'desc' => 'The [button] shortcode can be used here'
		) );

		$cmb->add_field( array(
			'name' => 'Email Title',
			'id'   => $prefix . 'email_title',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Email Text',
			'id'   => $prefix . 'email_text',
			'type' => 'textarea_small',
		) );

	}
}

WS_Metaboxes_Divisions::instance();
