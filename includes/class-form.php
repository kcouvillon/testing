<?php
/**
 * Form business logic and convenience function
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
	 * Determine maximizer product line from page context -- terms
	 * If there is Product-Line context on this page, it will pass through via a hidden field
	 * ORDER, IN CASE OF TIES: Discoveries > Perspectives > Capstone > OnStage > Excel Sports
	 * Itineraries in a science collection get sent to science ETS's
	 * See LEAD ROUTING LOGIC DIAGRAM:
	 *  http://worldstridesdev.org/blog/lead-routing-logic-for-marketo-to-maximizer/
	 */
	public static function presubmit_max_product_from_context($product_lines, $filters, $collections) {
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
		return $product_line_maximizer;
	}
	/**
	 * Determine the wsProduct from a combination of page and user-posted data
	 * See LEAD ROUTING LOGIC DIAGRAM:
	 *  http://worldstridesdev.org/blog/lead-routing-logic-for-marketo-to-maximizer/
	 */
	public static function postsubmit_derive_product($lead) {
		$wsProduct = '';
		if( empty($lead->wsMaxProductLine) || 'Unknown' == $lead->wsMaxProductLine ) { // no Product Line context on the form page
			if ( 'History-Culture Themed Programs (K-12)' == $lead->leadFormProduct ) {
				if( !empty($lead->domesticOrInternational ) && 'us' == $lead->domesticOrInternational ) {
					$wsProduct = 'Middle School - History'; // default to History
				} else {
					$wsProduct = 'High School - International'; // abroad means Perspectives Division
				}
			} elseif ( 'Science Themed Programs (K-12)' == $lead->leadFormProduct ) {
				$wsProduct = 'Middle School - Science';
			} elseif ( 'Undergraduate Tours' == $lead->leadFormProduct || 
					   'Graduate-Level Tours' ==  $lead->leadFormProduct ) {
				$wsProduct = 'University'; // does not exist in Maximizer yet
			} elseif ( 'Music Festivals' == $lead->leadFormProduct ||
					   'Concert and Performing Tours' == $lead->leadFormProduct ||
					   'Marching Band Opportunities' == $lead->leadFormProduct ||
					   'Dance-Cheer Opportunities' == $lead->leadFormProduct ||
					   'Theatre Opportunities' == $lead->leadFormProduct ) {
				$wsProduct = 'Performing';
			} elseif ( 'Sports Tours' == $lead->leadFormProduct ) {
				$wsProduct = 'Sports'; // does not exist in Maximizer yet
			} else {
				$wsProduct = 'Unknown';
			}
		} else {
			$wsProduct = $lead->wsMaxProductLine;
		}
		return $wsProduct;
	}


	/**
	 * Make a comma-separated array of the slugs from the page terms:
	 * eg: arts-and-sciences-programs,business-programs,nyu,other-professional-programs
	 */
	public static function slugs_from_terms( $terms ) {
		if(false === $terms) return 'COULD-NOT-DETERMINE-FROM-PAGE';
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
		if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
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