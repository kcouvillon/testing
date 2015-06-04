<?php
/**
 * Add shortcodes
 *
 * Class WS_Shortcodes
 */
class WS_Shortcodes {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Shortcodes
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Shortcodes
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
		add_shortcode( 'timeline', array( $this, 'timeline' ) );
		add_shortcode( 'timeline-node', array( $this, 'timeline_node' ) );
	}

	/**
	 * Create a timeline shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return html content wrapped in a unordered list
	 */
	public static function timeline( $atts, $content = "" ) {
		$content = '<ul class="timeline">' . do_shortcode( $content ) . '</ul>';
		$content = str_replace( '\r\n', "\n", $content );
		return $content;
	}

	/**
	 * Creates a year shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return html content wrapped in a unordered list
	 */
	public static function timeline_node( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'year' => '',
		), $atts, 'timeline-node' );

		ob_start();
		?>
			<li class="year">
				<span class="icon"></span>
				<h6><?php echo $atts['year'];?></h6>
				<p><?php echo $content; ?>
			</li>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}
}

WS_Shortcodes::instance();
