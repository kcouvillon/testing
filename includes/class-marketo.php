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
	 * The 9-character code for WorldStrides and Marketo
	 */
	public function marketo_id() { 
		return '593-ASZ-675';
	}
	
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

		// Defaults can be set here
		$attributes = shortcode_atts( array(
			'id' => '',
			'mdrapi' => 'false'
		), $attributes, 'marketo' );

		$form_id = $attributes['id'];

		$include_mdrapi = ( 'true' === strtolower( $attributes['mdrapi'] ) );
		if( $include_mdrapi ) {
			$mdr_include_js = "<script src='https://apis.worldstrides.com/mdrapi/js/ws_mdrapiBrowserDetection.js'></script>";
		} else {
			$mdr_include_js = "";
		}

		ob_start() ?>

			<div class="embedded-marketo-form">
				<?php echo $mdr_include_js; ?>
				<script src="//app-sjg.marketo.com/js/forms2/js/forms2.min.js"></script>
				<form id="mktoForm_<?php echo esc_attr( $form_id ); ?>"></form>

				<script>
					MktoForms2.loadForm( "//app-sjg.marketo.com", "<?php echo esc_js( $this->marketo_id() ); ?>", <?php echo esc_js( $form_id ); ?> );
				</script>
			</div>

		<?php
		$output = ob_get_contents();

		ob_end_clean();

		return $output;
	}

	public static function get_marketo_form( $post_id ) {
		$form_id = '';
		$product_lines = get_the_terms( $post_id, 'product-line' );

		foreach ( $product_lines as $division ) {

			if ( 'discoveries' == $division->slug ) {
				$current_id = 1699;
			} elseif ( 'perspectives' == $division->slug ) {
				$current_id = 1699;
			} elseif ( 'capstone' == $division->slug ) {
				$current_id = 1708;
			} elseif ( 'on-stage' == $division->slug ) {
				$current_id = 1709;
			} elseif ( 'excel-sports' == $division->slug ) {
				$current_id = 1712;
			} else {
				$current_id = 1699;
			}

			// ORDER: Discoveries > Perspectives > Capstone > OnStage > Excel Sports
			// Works because of current form numbers, may need to be worked if changed
			if ( ! $form_id ) {
				$form_id = $current_id;
			} elseif ( $current_id < $form_id ) {
				$form_id = $current_id;
			}
		}
		
		echo do_shortcode( "[marketo id=$form_id mdrapi=true]" );
	}
	
	public static function submit_marketo_data() {

 		echo '<h4>Post Data (processed by WS_Marketo::submit_marketo_data):</h4>';
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
/*		print_r("\nResult: \n");
		
		$lead1 = new stdClass();
		// $lead1->email = "upsert.test@marketo.com";
		if(isset($_POST['email'])) {
			$lead1->email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
		}
		print_r($lead1);
 */
		//$upsert = new WS_MktoUpsertLeads();
		//$upsert->input = array($lead1);
		//print_r($upsert->postData());

		// return what?;
	}
}

WS_Marketo::instance();