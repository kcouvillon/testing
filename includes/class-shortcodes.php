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
		add_shortcode( 'button', array( $this, 'button' ) );
		add_shortcode( 'activity', array( $this, 'activity' ) );
		add_shortcode( 'formstack', array( $this, 'formstack' ) );
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
			<li class="timeline-event">
				<span class="timeline-year h6"><?php echo $atts['year'];?></span>
				<p class="timeline-content"><?php echo $content; ?>
			</li>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates a button shortcode.
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string link with button classes 
	 */
	public static function button( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'url' => '',
			'color' => 'orange',
			'new_window' => false
		), $atts, 'timeline-node' );

		if ( 'blue' == $atts['color'] ) {
			$class = 'btn-info';
		} else {
			$class = 'btn-primary';
		}

		if ( $atts['new_window'] ) {
			$target = 'target="_blank"';
		} else {
			$target = '';
		}

		ob_start();
		?>
		<a href="<?php echo $atts['url'];?>" class="btn <?php echo esc_attr( $class ); ?>"<?php echo $target; ?>><?php echo esc_html( $content ); ?></a>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates an activity shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string content wrapped in a unordered list
	 */
	public static function activity( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'title' => '',
		), $atts, 'activity' );

		ob_start();
		?>
		<li>
			<strong><?php echo $atts['title'];?></strong>
			<span><?php echo $content; ?></span>
		</li>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	/**
	 * Creates a Formstack shortcode
	 *
	 * @param $atts array shortcode attributes
	 * @param $content mixed content between shortcode
	 *
	 * @return string content wrapped in a unordered list
	 */
	public static function formstack( $atts ) {
		$atts = shortcode_atts( array(
			'slug' => '',
			'title' => '',
		), $atts, 'formstack' );

		ob_start();
		?>
		<script type="text/javascript" src="https://wsforms.formstack.com/forms/js.php/<?php echo $atts['slug'];?>"></script>
		<noscript><a href="https://wsforms.formstack.com/forms/<?php echo $atts['slug'];?>" title="<?php echo $atts['title'];?>"><?php echo $atts['title'];?></a></noscript>
		<?php
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}
}

WS_Shortcodes::instance();
