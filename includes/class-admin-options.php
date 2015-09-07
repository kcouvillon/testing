<?php
/**
 * CMB2 Theme Options
 */
class WS_Admin {
	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'ws_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'ws_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Site Options', 'ws' );
	}

	/**
	 * Initiate our hooks
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}

	/**
	 * Register our setting to WP
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array(
			$this,
			'admin_page_display'
		) );
		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key, array( 'cmb_styles' => false ) ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 */
	function add_options_page_metabox() {
		$cmb = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
		// Set our CMB2 fields
		$cmb->add_field( array(
			'name'    => __( 'Discover Why Image', 'ws' ),
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'discovery_why_image',
			'type'    => 'file',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Discover Why Text', 'ws' ),
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'discovery_why_text',
			'type'    => 'textarea_small',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Request Info Image', 'ws' ),
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'request_info_image',
			'type'    => 'file',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Request Info Text', 'ws' ),
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'request_info_text',
			'type'    => 'textarea_small',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Contact: Phone Info', 'ws' ),
			'default' => 'We can be reached via telephone at our toll-free number: 1-800-999-7676. To discuss particular programs, please visit our contact page for more information.',
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'contact_phone_info',
			'type'    => 'textarea_small',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Contact: Email Info', 'ws' ),
			'default' => 'We\'re available via email at <a href="mailto:customerservice@worldstrides.org">customerservice@worldstrides.org</a>. To discuss particular programs, please visit our contact page for more information.',
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'contact_email_info',
			'type'    => 'textarea_small',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Divisions Title', 'ws' ),
			// 'default' => '',
			// 'desc'    => __( 'field description (optional)', 'ws' ),
			'id'      => 'divisions_title',
			'type'    => 'text',
		) );
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 *
	 * @param  string $field Field to retrieve
	 *
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}

/**
 * Helper function to get/return the Ws_Admin object
 * @since  0.1.0
 * @return Ws_Admin object
 */
function ws_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new Ws_Admin();
		$object->hooks();
	}

	return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function ws_get_option( $key = '' ) {
	return cmb2_get_option( ws_admin()->key, $key );
}

// Get it started
ws_admin();