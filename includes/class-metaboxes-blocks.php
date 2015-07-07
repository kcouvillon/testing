<?php
/**
 * Adding Metaboxes and custom fields to Content Blocks
 *
 * Class WS_Metaboxes
 */
class WS_Metaboxes_Blocks {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Metaboxes_Blocks
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Metaboxes_Blocks
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
		add_action( 'cmb2_init',  array( $this, 'block_details' ) );
		add_action( 'cmb2_init',  array( $this, 'block_content_main' ) );
		add_action( 'cmb2_init',  array( $this, 'block_content_secondary' ) );
		add_action( 'cmb2_init',  array( $this, 'block_slideshow' ) );
	}

	function block_details() {

		$prefix = 'block_details_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Block Details', 'cmb2' ),
			'object_types' => array( 'block', ),
		) );

		$cmb->add_field( array(
			'name'             => 'Block Type',
			'id'               => 'block_type',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'image-right',
			'options'          => array(
				'image-right' => __( 'Image Right', 'cmb' ),
				'image-left'   => __( 'Image Left', 'cmb' ),
				'column-one'     => __( 'One Column', 'cmb' ),
				'column-two'     => __( 'Two Column', 'cmb' ),
				'slideshow-basic'     => __( 'Basic Image Slideshow', 'cmb' ),
				'slideshow-tabbed'     => __( 'Tabbed Image Slideshow', 'cmb' ),
			),
		) );
	}

	function block_content_main() {

		$prefix = 'block_content_main_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Block Content - Main', 'cmb2' ),
			'object_types' => array( 'block', ),
		) );

		$cmb->add_field( array(
				'name'   => 'Main',
				'id'     => 'content_main',
				'type'   => 'wysiwyg'
			)
		);

	}

	function block_content_secondary() {

		$prefix = 'block_content_secondary_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Block Content - Secondary', 'cmb2' ),
			'object_types' => array( 'block', ),
		) );

		$cmb->add_field( array(
				'name'   => 'Secondary',
				'desc'   => 'Content for the second column',
				'id'     => 'content_secondary',
				'type'   => 'wysiwyg'
			)
		);

	}

	/**
	 * Field group for Why WorldStrides page
	 */
	function block_slideshow() {

		$prefix = 'block_slideshow_';

		/**
		 * Repeatable Field Groups
		 */
		$cmb_group = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Slideshow', 'cmb2' ),
			'object_types' => array( 'block', ),
		) );

		// $group_field_id is the field id string, so in this case: $prefix . 'demo'
		$group_field_id = $cmb_group->add_field( array(
			'id'          => $prefix . 'list',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Slide {#}', 'cmb2' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Slide', 'cmb2' ),
				'remove_button' => __( 'Remove Slide', 'cmb2' ),
				'sortable'      => true, // beta
			),
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'       => __( 'Title', 'cmb2' ),
			'desc'       => 'Only used on tabbed slideshows',
			'id'         => 'title',
			'type'       => 'text'
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Caption', 'cmb2' ),
			'id'          => 'caption',
			'type'        => 'textarea_small',
		) );

		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Image', 'cmb2' ),
			'id'   => 'image',
			'type' => 'file',
		) );
	}
}

WS_Metaboxes_Blocks::instance();
