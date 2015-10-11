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
	 * Function to generate WorldStrides custom form
	 *
	 * @param $attributes array attributes specified by author
	 *
	 * @return string WorldStrides form embed
	 */
	public function get_worldstrides_form() {
		
	}


	/**
	 * Determine maximizer product line from page context -- the product line term
	 * If there is Product-Line context on this page, it will pass through via a hidden field
	 * ORDER, IN CASE OF TIES: Discoveries > Perspectives > Capstone > OnStage > Excel Sports
	 * See LEAD ROUTING LOGIC DIAGRAM:
	 *  http://worldstridesdev.org/blog/lead-routing-logic-for-marketo-to-maximizer/
	 */
	public static function presubmit_max_product_from_context($product_lines) {
		if(false === $product_lines) {	// IF PRODUCT LINES ARE UNKNOWN, SKIP IT
			return 'Unknown';
		}
		foreach ( $product_lines as $division ) {
			if ( 'discoveries' == $division->slug ) {
				$product_line_maximizer = 'Middle School - History'; // default to History
				break;
			} elseif ( 'perspectives' == $division->slug ) {
				$product_line_maximizer = 'High School - International';
				break;
			} elseif ( 'capstone' == $division->slug ) {
				$product_line_maximizer = 'University'; // does not exist in Maximizer yet
				break;
			} elseif ( 'on-stage' == $division->slug ) {
				$product_line_maximizer = 'Performing';
				break;
			} elseif ( 'excel-sports' == $division->slug ) {
				$product_line_maximizer = 'Sports'; // does not exist in Maximizer yet
				break;
			} else {
				$product_line_maximizer = 'Unknown';
			}
		}
		if('Middle School - History' == $product_line_maximizer) {
			foreach ( $collections as $collection) {
				if ( 'science-discoveries' == $collection->slug )
					$product_line_maximizer = 'Middle School - Science'; // Science if it's in that collection
			}
		}
		return product_line_maximizer;
	}

	/**
	 * Make a comma-separated array of the slugs from the page terms:
	 * eg: arts-and-sciences-programs,business-programs,nyu,other-professional-programs
	 */
	public static function slugs_from_terms( $terms ) {
		if(false === $terms) return 'NO-WEBPAGE-CONTEXT-AVALIABLE';
		$slugs = '';
		foreach( $terms as $term ) {
			$slugs .= $term->slug . ',';
		}
		return substr($slugs,0,strlen($slugs) - 1);
	}

	/**
	 * Utility function.  Where are we???
	 */
	public static function current_page_url() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;		
	}

}

WS_Form::instance();	