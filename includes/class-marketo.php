
<?php

/**
 * Marketo poc
 *
 * Class WS_Marketo
 */
class WS_Marketo {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Marketo
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Marketo
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
		add_shortcode( 'marketo', array( $this, 'marketo_shortcode' ) );
	}

	/**
	 * Shortcode to generate Marketo embeds
	 *
	 * @param $attributes array Shortcode attributes specified by author
	 *
	 * @return string Marketo embed
	 */
	public function marketo_shortcode( $attributes ) {
		$attributes = shortcode_atts( array(
			'id' => '',
		), $attributes, 'marketo' );

		$marketo_id = '593-ASZ-675'; // this id should come from a settings page

		$form_id = $attributes['id'];
		// $form_id = (int) '1679'; // marketo sample form

		ob_start() ?>
			<div class="embedded-marketo-form">
				<script src="//app-sjg.marketo.com/js/forms2/js/forms2.min.js"></script>
				<form id="mktoForm_<?php echo esc_attr( $form_id ); ?>"></form>

				<script>
					MktoForms2.loadForm( "//app-sjg.marketo.com", "<?php echo esc_js( $marketo_id ); ?>", <?php echo esc_js( $form_id ); ?> );
				</script>
			</div>

			<div class="debug">
				<pre>
					<?php echo "<pre>Marketo ID: " . $marketo_id . '</pre>'; ?>
					<?php echo "<pre>Form ID: " . $form_id . '</pre><br>'; ?>
				</pre>
			</div>
		<?php
		$output = ob_get_contents();

		ob_end_clean();

		return $output;
	}
}

WS_Marketo::instance();
