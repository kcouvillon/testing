<?php
/**
 * Adding Metaboxes and custom fields for Collections
 *
 * Class WS_Metaboxes_Collections
 */
class WS_Metaboxes_Collections {
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
		add_action( 'cmb2_init',  array( $this, 'collection_options' ) );
		add_action( 'cmb2_init',  array( $this, 'collection_why_ws' ) );
		add_action( 'cmb2_init',  array( $this, 'collection_resources' ) );
		add_action( 'cmb2_init',  array( $this, 'collection_blocks_before' ) );
		add_action( 'cmb2_init',  array( $this, 'collection_itineraries' ) );
		add_action( 'cmb2_init',  array( $this, 'collection_blocks_after' ) );
	}

	/**
	 * Options
	 */
	function collection_options() {

		$prefix = 'collection_options_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Collection Options', 'cmb2' ),
			'object_types' => array( 'collection', ),
		) );

		$cmb->add_field( array(
			'name' => 'Subtitle',
			'id' => $prefix . 'subtitle',
			'type' => 'text'
		) );

		$cmb->add_field( array(
			'name'             => 'Collection Type',
			'id'               => 'collection_type',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'Regular',
			'options'          => array(
				'regular' => __( 'Regular', 'cmb' ),
				'outlier'   => __( 'Outlier', 'cmb' ),
			),
		) );

		$cmb->add_field( array(
			'name'             => 'Discovery Why module',
			'id'               => 'discovery_why',
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
	 * Field group for Why WorldStrides page
	 */
	function collection_why_ws() {

		$prefix = 'collection_why_ws_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Why WorldStrides', 'cmb2' ),
			'object_types' => array( 'collection', )
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
	function collection_resources() {

		$prefix = 'collection_resources_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Resources', 'cmb2' ),
			'object_types' => array( 'collection', )
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
	function collection_blocks_before() {

		$prefix = 'collection_blocks_before_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Before Blocks', 'cmb2' ),
			'object_types' => array( 'collection', ),
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
					'posts_per_page' => 150,
					'post_type' => 'block',
				),
			)
		) );

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function collection_itineraries() {

		$prefix = 'collection_itineraries_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Associated Itineraries', 'cmb2' ),
			'object_types' => array( 'collection', ),
		) );

		$cmb->add_field( array(
			'name'       => __( 'List of Itineraries', 'cmb2' ),
			'id'         => 'title',
			'desc'       => 'Itineraries can be added or removed on the individual itinerary page',
			'type'       => 'associated_itineraries',
			'show_names' => false
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );
	}

	/**
	 * Sections of Blocks to show after itineraries
	 */
	function collection_blocks_after() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'collection_blocks_after_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'After Blocks', 'cmb2' ),
			'object_types' => array( 'collection', ),
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
					'posts_per_page' => 150,
					'post_type' => 'block',
				),
			)
		) );

	}
}

WS_Metaboxes_Collections::instance();
