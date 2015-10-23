<?php
/**
 * Adding Metaboxes and custom fields for Destinations, Interests and Travelers
 *
 * There's a lot of similarity with Collections, and it could probably be reengineered to avoid duplication.
 *
 * Class WS_Resources
 */
class WS_Metaboxes_Resources {
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
		add_action( 'cmb2_init',  array( $this, 'resource_options' ) );
		add_action( 'cmb2_init',  array( $this, 'resource_target_options' ) );
	}

	/**
	 * Adding fields to Taxonomy terms
	 */
	function resource_options() {

		$prefix = 'resource_options';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Blocks', 'cmb2' ),
			'object_types' => array( 'resource', ),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Before Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks_before',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => - 1,
					'post_type'      => 'block',
				),
			)
		) );

		$cmb->add_field( array(
			'name'    => __( 'After Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks_after',
			'type'    => 'custom_attached_posts',
			'options' => array(
				'show_thumbnails' => true,  // Show thumbnails on the left
				'filter_boxes'    => true,  // Show a text box for filtering the results
				'query_args'      => array( // override the get_posts args
					'posts_per_page' => - 1,
					'post_type'      => 'block',
				),
			)
		) );
	}

	/**
	 * Adding fields to Taxonomy terms
	 */
	function resource_target_options() {

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

		$cmb->add_field( array(
			'name'    => __( 'Before Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks_before',
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

		$cmb->add_field( array(
			'name'    => __( 'After Blocks', 'cmb2' ),
			'desc'    => __( 'Drag blocks from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
			'id'      => 'attached_blocks_after',
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
}

WS_Metaboxes_Resources::instance();
