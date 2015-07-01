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
		add_action( 'cmb2_init',  array( $this, 'about_partnerships' ) );
		add_action( 'cmb2_init',  array( $this, 'about_careers_benefits' ) );
		add_action( 'cmb2_init',  array( $this, 'about_careers_examples' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices_programs' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices_locations' ) );
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
			'name'       => __( 'Title', 'cmb2' ),
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
					'posts_per_page' => 70,
					'post_type' => 'why-ws',
				),
			)
		) );

	}

	/**
	 * Field groupings for the About - Partnerships page
	 */
	function about_partnerships() {

		$sections = array( 'Accreditation', 'Educational Organizations', 'Travel Associations' );

		// Allows us to reuse the Parnership group
		foreach ( $sections as $section ) {
			// Start with an underscore to hide fields from custom fields list
			$prefix = 'about_partnerships_' . sanitize_title( $section ) . '_';

			/**
			 * Repeatable Field Groups
			 */
			$cmb_group = new_cmb2_box( array(
				'id'           => $prefix . 'metabox',
				'title'        => __( $section, 'cmb2' ),
				'object_types' => array( 'page' ),
				'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-partnerships.php' ),
			) );

			// $group_field_id is the field id string
			$group_field_id = $cmb_group->add_field( array(
				'id'      => $prefix . 'partners',
				'type'    => 'group',
				'options' => array(
					'group_title'   => __( 'Partnership {#}', 'cmb2' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Partnership', 'cmb2' ),
					'remove_button' => __( 'Remove Partnership', 'cmb2' ),
					'sortable'      => true, // beta
				)
			) );

			$cmb_group->add_group_field( $group_field_id, array(
				'name' => __( 'Title', 'cmb2' ),
				'id'   => 'title',
				'type' => 'text',
				// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
			) );

			$cmb_group->add_group_field( $group_field_id, array(
				'name' => __( 'Partnership Logo', 'cmb2' ),
				'id'   => 'image',
				'type' => 'file',
			) );

			$cmb_group->add_field( array(
				'name' => __( 'Notes', 'cmb2' ),
				'id'   => $prefix . 'notes',
				'type' => 'textarea_small',
			) );
		}
	}

	/**
	 * Benefits for the About - Careers page
	 */
	function about_careers_benefits() {

		$prefix = 'about_careers_benefits_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Benefits', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-careers.php' ),
		) );

		$cmb_group->add_field( array(
			'name' => __( 'Title', 'worldstrides' ),
			'id'   => $prefix . 'title',
			'type' => 'text',
			'default' => 'Benefits of Working at WorldStrides'
		) );

		$cmb_group->add_field( array(
			'name' => __( 'Description', 'worldstrides' ),
			'id'   => $prefix . 'description',
			'type' => 'textarea_small',
			'default' => 'In addition to our fun and inspiring environment, WorldStrides offers a number of benefits for our full-time, year-round staff:'
		) );

		// $group_field_id is the field id string
		$group_field_id = $cmb_group->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Benefit {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Benefit', 'worldstrides' ),
				'remove_button' => __( 'Remove Benefit', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Icon', 'worldstrides' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Description', 'worldstrides' ),
			'id'   => 'description',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}

	/**
	 * Career examples the About - Careers page
	 */
	function about_careers_examples() {

		$prefix = 'about_careers_examples_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Career Examples', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-careers.php' ),
		) );

		$cmb_group->add_field( array(
			'name' => __( 'Title', 'worldstrides' ),
			'id'   => $prefix . 'title',
			'type' => 'text',
			'default' => 'Learn what you can do at WorldStrides'
		) );

		$cmb_group->add_field( array(
			'name' => __( 'Description', 'worldstrides' ),
			'id'   => $prefix . 'description',
			'type' => 'textarea_small',
			'default' => 'WorldStrides offers a variety of careers in Marketing, Sales, Account Management, Customer Service, Finance, and Human Resources. Meet some of our team members and learn what their roles entail.'
		) );

		// $group_field_id is the field id string
		$group_field_id = $cmb_group->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Career Example {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Career Example', 'worldstrides' ),
				'remove_button' => __( 'Remove Career Example', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Name', 'worldstrides' ),
			'id'   => 'name',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Position', 'worldstrides' ),
			'id'   => 'position',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Photo', 'worldstrides' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Description', 'worldstrides' ),
			'id'   => 'description',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}

	/**
	 * Main offices for the About - Offices page
	 */
	function about_offices_locations() {

		$prefix = 'about_offices_locations_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Office Locations', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-offices.php' ),
		) );

		// $group_field_id is the field id string
		$group_field_id = $cmb_group->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Location {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Location', 'worldstrides' ),
				'remove_button' => __( 'Remove Location', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Name', 'worldstrides' ),
			'id'   => 'name',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		// Location (weather)
		$cmb_group->add_group_field( $group_field_id, array(
			'name' => 'Location',
			'id' => $prefix . 'coordinates',
			'type' => 'pw_map',
			// 'split_values' => true, // Save latitude and longitude as two separate fields
		) );


	}

	/**
	 * Main offices for the About - Offices page
	 */
	function about_offices() {

		$prefix = 'about_offices_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Offices', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-offices.php' ),
		) );

		// $group_field_id is the field id string
		$group_field_id = $cmb_group->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Office {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Office', 'worldstrides' ),
				'remove_button' => __( 'Remove Office', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Location', 'worldstrides' ),
			'id'   => 'location',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Location Extra', 'worldstrides' ),
			'id'   => 'location_extra',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Photo', 'worldstrides' ),
			'id'   => 'image',
			'type' => 'file',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Description', 'worldstrides' ),
			'id'   => 'description',
			'type' => 'textarea',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Office Address', 'worldstrides' ),
			'id'   => 'address',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Express Mail Address', 'worldstrides' ),
			'id'   => 'mail_address',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}

	/**
	 * Main offices for the About - Offices page
	 */
	function about_offices_programs() {

		$prefix = 'about_offices_program_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'International Programs', 'worldstrides' ),
			'object_types' => array( 'page' ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-offices.php' ),
		) );

		// $group_field_id is the field id string
		$group_field_id = $cmb_group->add_field( array(
			'id'      => $prefix . 'list',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Program {#}', 'worldstrides' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Program', 'worldstrides' ),
				'remove_button' => __( 'Remove Program', 'worldstrides' ),
				'sortable'      => true, // beta
			)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Title', 'worldstrides' ),
			'id'   => 'title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Phone Details', 'worldstrides' ),
			'id'   => 'phone',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Office Address', 'worldstrides' ),
			'id'   => 'address',
			'type' => 'textarea_small',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}
}

WS_Metaboxes::instance();
