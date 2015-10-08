<?php
/**
 * Form shortcode and business logic
 *
 * Class WS_Form
 */
class WS_Form {
		/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Form
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Form
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
		add_shortcode( 'worldstrides-form', array( $this, 'worldstrides_form_shortcode' ) );
	}

	/**
	 * Shortcode to generate WorldStrides custom form
	 *
	 * @param $attributes array Shortcode attributes specified by author
	 *
	 * @return string WorldStrides form embed
	 */
	public function worldstrides_form_shortcode( $attributes ) {

		// Defaults can be set here
		$attributes = shortcode_atts( array(
			// No attributes defined yet
		), $attributes, 'worldstrides-form' );
		ob_start(); ?>

		<section class="learn-more clearfix ws-container">
			<?php get_template_part('partials/form','universal'); /* provide the universal form */ ?>
		</section>

		<?php 

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	public function get_worldstrides_form() {
		
	}

	public static function slugs_from_terms( $terms ) {
		if(false === $terms) return 'NO-WEBPAGE-CONTEXT-AVALIABLE';
		$slugs = '';
		foreach( $terms as $term ) {
			$slugs .= $term->slug . ',';
		}
		return substr($slugs,0,strlen($slugs) - 1);
	}

}

WS_Form::instance();	