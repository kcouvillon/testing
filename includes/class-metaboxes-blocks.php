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
		add_action( 'cmb2_init',  array( $this, 'block_content_secondary' ) );
		add_action( 'cmb2_after_post_form_block_type_metabox', array( $this, 'js_boxes_show_hidden' ), 10, 2 );
		add_action( 'cmb2_init',  array( $this, 'block_image' ) );
		add_action( 'cmb2_init',  array( $this, 'block_slideshow' ) );
		add_action( 'cmb2_after_post_form_block_slideshow_metabox', array( $this, 'js_limit_group_repeat' ), 10, 2 );
	}

	function block_details() {

		$prefix = 'block_type_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Block Type', 'cmb2' ),
			'object_types' => array( 'block', ),
			'context'    => 'side',
			'priority'   => 'default',
			'show_names' => false
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

	function js_boxes_show_hidden( $post_id, $cmb ) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var block_type = $('#block_type'),
					content = $('#postdivrich'),
					content_secondary = $('#block_content_secondary_metabox'),
					image = $('#block_image_metabox'),
					slideshow = $('#block_slideshow_metabox'),
					slide_title = $('.slide-title');

				function toggle_metaboxes( current_type ) {
					switch ( current_type ) {
						case('image-right'):
							content.removeClass('hidden');
							content_secondary.addClass('hidden');
							image.removeClass('hidden');
							slideshow.addClass('hidden');
							break;
						case('image-left'):
							content.removeClass('hidden');
							content_secondary.addClass('hidden');
							image.removeClass('hidden');
							slideshow.addClass('hidden');
							break;
						case('column-one'):
							content.removeClass('hidden');
							content_secondary.addClass('hidden');
							image.addClass('hidden');
							slideshow.addClass('hidden');
							break;
						case('column-two'):
							content.removeClass('hidden');
							content_secondary.removeClass('hidden');
							image.addClass('hidden');
							slideshow.addClass('hidden');
							break;
						case('slideshow-basic'):
							content.addClass('hidden');
							content_secondary.addClass('hidden');
							image.addClass('hidden');
							slide_title.addClass('hidden');
							slideshow.removeClass('hidden');
							break;
						case('slideshow-tabbed'):
							content.addClass('hidden');
							content_secondary.addClass('hidden');
							image.addClass('hidden');
							slide_title.removeClass('hidden');
							slideshow.removeClass('hidden');
							break;
					}
				}

				toggle_metaboxes( block_type.val() );

				block_type.change(function () {
					var current_type = $(this).val();
					toggle_metaboxes( current_type );
				});
			});
		</script>
	<?php
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
			'title'        => __( 'Block Content - Second Column', 'cmb2' ),
			'object_types' => array( 'block', ),
		) );

		$cmb->add_field( array(
				'name'   => 'Secondary',
				'id'     => 'content_secondary',
				'show_names' => false,
				'type'   => 'wysiwyg'
			)
		);

	}

	function block_image() {

		$prefix = 'block_image_';

		$cmb = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Image', 'cmb2' ),
			'object_types' => array( 'block', ),
			'show_names'   => false
		) );

		$cmb->add_field( array(
				'name'   => 'Image',
				'desc'   => 'Image for Image Right/Left',
				'id'     => 'block_image',
				'type'   => 'file'
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
			'slideshow_rows_limit'   => 6, // custom attribute to use in our JS
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
			'name'       => __( 'Tab Title', 'cmb2' ),
			'desc'       => 'Only used on tabbed slideshows',
			'id'         => 'title',
			'type'       => 'text',
			'row_classes'=> 'slide-title'
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
			'options' => array(
				'url' => false,
			)
		) );
	}

	function js_limit_group_repeat( $post_id, $cmb ) {
		// Grab the custom attribute to determine the limit
		$limit = absint( $cmb->prop( 'slideshow_rows_limit' ) );
		$limit = $limit ? $limit : 0;
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				// Only allow $limit groups
				var limit            = <?php echo $limit; ?>;
				var fieldGroupId     = 'block_slideshow_list';
				var $fieldGroupTable = $( document.getElementById( fieldGroupId + '_repeat' ) );
				var countRows = function() {
					return $fieldGroupTable.find( '> .cmb-row.cmb-repeatable-grouping' ).length;
				};
				var disableAdder = function() {
					$fieldGroupTable.find('.cmb-add-group-row.button').prop( 'disabled', true );
				};
				var enableAdder = function() {
					$fieldGroupTable.find('.cmb-add-group-row.button').prop( 'disabled', false );
				};
				$fieldGroupTable
					.on( 'cmb2_add_row', function() {
						if ( countRows() >= limit ) {
							disableAdder();
						}
					})
					.on( 'cmb2_remove_row', function() {
						if ( countRows() < limit ) {
							enableAdder();
						}
					});
			});
		</script>
	<?php
	}
}

WS_Metaboxes_Blocks::instance();
