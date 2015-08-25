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
		add_action( 'cmb2_init',  array( $this, 'general_options' ) );
		add_action( 'cmb2_init',  array( $this, 'hero_tooltips' ) );
		add_action( 'cmb2_init',  array( $this, 'hero_tooltips_pages' ) );
		add_action( 'cmb2_init',  array( $this, 'leadership_attached_bios' ) );
		add_action( 'cmb2_init',  array( $this, 'bio_details' ) );
		add_action( 'cmb2_init',  array( $this, 'blog_details' ) );
		add_action( 'cmb2_init',  array( $this, 'contact_fields' ) );
		add_action( 'cmb2_init',  array( $this, 'why_worldstrides_page_section_group' ) );
		add_action( 'cmb2_init',  array( $this, 'about_partnerships' ) );
		add_action( 'cmb2_init',  array( $this, 'about_careers_benefits' ) );
		add_action( 'cmb2_init',  array( $this, 'about_careers_examples' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices_locations' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices' ) );
		add_action( 'cmb2_init',  array( $this, 'about_offices_programs' ) );
		add_action( 'cmb2_init',  array( $this, 'taxonomy_metadata_cmb2_init' ) );
		add_action( 'cmb2_init',  array( $this, 'home_resources' ) );
		add_action( 'cmb2_init',  array( $this, 'home_select_programs' ) );
	}

	/**
	 * A general option metabox
	 *
	 * Currently used on Destinations, Interests, Travelers and Collections
	 */
	function general_options() {

		$prefix = 'general_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Options', 'cmb2' ),
			'object_types' => array( 'interest', 'destination', 'traveler', 'collection' ),
		) );

		$cmb->add_field( array(
			'name'             => 'Display Title',
			'id'               => $prefix . 'display_title',
			'type'             => 'text'
		) );

	}

	/**
	 * Hero tooltips field group
	 */
	function hero_tooltips() {

		$prefix = 'hero_tooltips_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Hero Tooltips', 'cmb2' ),
			'object_types' => array( 'itinerary', 'collection', 'destination', 'interest', 'traveler' ),
		) );

		$cmb->add_field( array(
			'name' => 'Top Right',
			'id'   => 'tooltip_section_title_top',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_top',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_top',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Middle Right',
			'id'   => 'tooltip_section_title_middle',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_middle',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_middle',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Bottom Right',
			'id'   => 'tooltip_section_title_bottom',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_bottom',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_bottom',
			'type' => 'text',
		) );
	}

	/**
	 * Duplicating hero tooltips for homepage.
	 *
	 * Couldn't sort out how to isolate the metaboxes to both specific post types AND the home page
	 *
	 * @todo figure out how to avoid the duplication here
	 */
	function hero_tooltips_pages() {

		$prefix = 'hero_tooltips_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'home_metabox',
			'title'        => __( 'Hero Tooltips', 'cmb2' ),
			'object_types' => array( 'page' ),
			'show_on'      => array(
				'key' => 'page-template', 'value' => array(
					'templates/division-capstone.php',
					'templates/division-discoveries.php',
					'templates/division-on-stage.php',
					'templates/division-perspectives.php',
				),
				'key' => 'front-page', 'value' => ''
			),
		) );

		$cmb->add_field( array(
			'name' => 'Top Right',
			'id'   => 'tooltip_section_title_top',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_top',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_top',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Middle Right',
			'id'   => 'tooltip_section_title_middle',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_middle',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_middle',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => 'Bottom Right',
			'id'   => 'tooltip_section_title_bottom',
			'type' => 'title'
		));

		$cmb->add_field( array(
			'name' => __( 'Title', 'cmb2' ),
			'id'   => $prefix . 'title_right_bottom',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Caption', 'cmb2' ),
			'id'   => $prefix . 'caption_right_bottom',
			'type' => 'text',
		) );
	}

	function contact_fields() {

		$prefix = 'contact_fields_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Contact Sections', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/contact.php' ),
			// 'show_names'   => false, // Show field names on the left
		) );

		$group_field_id = $cmb->add_field( array(
			'id'      => $prefix . 'sections',
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Section {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Section', 'cmb2' ),
				'remove_button' => __( 'Remove Section', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );
		
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Section Title',
			'id' => $prefix . 'section_title',
			'type' => 'text'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Section Content',
			'id' => $prefix . 'section_content',
			'type' => 'wysiwyg'
		) );

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

	function blog_details() {
		$cmb = new_cmb2_box( array(
			'id'           => 'ws_blog_details',
			'title'        => __( 'Blog Details', 'cmb2' ),
			'object_types' => array( 'post' ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		$cmb->add_field( array(
			'name'        => __( 'Related Content' ),
			'desc'        => 'A collection, itinerary or blog post to appear in the sidebar (bottom on travelogues)',
			'id'          => 'ws_blog_related_content',
			'type'        => 'post_search_text',
			'post_type'   => 'itinerary', // this gets overridden
			'select_type' => 'checkbox'
		) );

		$cmb->add_field( array(
			'name' => __( 'Facebook Comments', 'cmb2' ),
			'id'   => 'facebook_comments',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'false',
			'options'          => array(
				'true' => __( 'On', 'cmb' ),
				'false'   => __( 'Off', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name' => __( 'Old Url', 'cmb2' ),
			'id'   => 'ws_blog_old_url',
			'type' => 'text_url'
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

		$sections = array();

		for ( $i = 1; $i <= 8; $i++ ) {
			$sections[] = "Section " . $i;
		}

		// Allows us to reuse the Partnership group
		foreach ( $sections as $section ) {
			// Start with an underscore to hide fields from custom fields list
			$prefix = 'about_partnerships_' . strtolower( str_replace(' ', '_', $section ) ) . '_';

			/**
			 * Repeatable Field Groups
			 */
			$cmb_group = new_cmb2_box( array(
				'id'           => $prefix . 'metabox',
				'title'        => __( $section, 'cmb2' ),
				'object_types' => array( 'page' ),
				'show_on'      => array( 'key' => 'page-template', 'value' => 'templates/about-partnerships.php' ),
			) );

			$cmb_group->add_field( array(
					'name' => 'Title',
					'id' => $prefix . 'title',
					'type' => 'text'
				)
			);

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
				'name' => __( 'URL', 'cmb2' ),
				'id'   => 'url',
				'type' => 'text_url',
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

	function taxonomy_metadata_cmb2_init() {

		$metabox_id = 'cat_options';

		/**
		 * Semi-standard CMB metabox/fields registration
		 */
		$cmb = new_cmb2_box( array(
			'id'           => $metabox_id,
			'object_types' => array( 'key' => 'options-page', 'value' => array( 'unknown', ), ),
		) );

		$cmb->add_field( array(
			'name' => __( 'Featured Image', 'taxonomy-metadata' ),
			'id'   => 'feature_image', // no prefix needed since the options are one option array.
			'type' => 'file',
		) );

		// (Recommended) Use wp-large-options
		if ( ! defined( 'wlo_update_option' ) ) {
			// require_once( 'wp-large-options/wp-large-options.php' );
		}

		// wp-large-options overrides
		$wlo_overrides = array(
			//'get_option'    => 'wlo_get_option',
			//'update_option' => 'wlo_update_option',
			//'delete_option' => 'wlo_delete_option',
		);

		/**
		 * Instantiate our taxonomy meta class
		 */
		$cats = new Taxonomy_MetaData_CMB2( 'resource-target', $metabox_id, __( 'Resource Target Settings', 'taxonomy-metadata' ), $wlo_overrides );
	}

	/**
	 * Resources to display
	 */
	function home_resources() {

		$prefix = 'home_resources_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Resources', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'front-page', 'value' => ''
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
	 * Resources to display
	 */
	function home_select_programs() {

		$prefix = 'home_programs_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Select Programs', 'cmb2' ),
			'object_types' => array( 'page', ),
			'show_on'      => array(
				'key' => 'front-page', 'value' => ''
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Select itineraries and collections', 'cmb2' ),
			'desc'    => __( 'Drag Collections or Itineraries from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_programs',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => 300,
					'order' => 'ASC',
					'post_type' => array( 'collection', 'itinerary' ),
				),
			)
		) );
	}

}

WS_Metaboxes::instance();
