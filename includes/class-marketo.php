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

		ob_start(); ?>

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
		/*
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
		*/
		
		// echo do_shortcode( "[marketo id=$form_id mdrapi=true]" );

		echo do_shortcode( "[marketo id=1699 mdrapi=true]" ); // remove form_id logic -- just give the universal
	}
	
	public static function submit_marketo_data() {
		$debug_submit = false;

		if($debug_submit) {
	 		echo '<h4>Post Data (processed by WS_Marketo::submit_marketo_data):</h4>';
			echo '<pre>';
		}

		if($debug_submit) {
			if( "" === trim($_POST['Email']) ) {
				echo 'no email address submitted.';
				echo '</pre>';
				return;
			}
		}

		if($debug_submit) {
			print_r($_COOKIE['_mkto_trk']);
		}
		
		$mkto_cookie = urlencode("mkto_trk=".$_COOKIE['_mkto_trk']); // use cookie for associate lead
		
		// sanitize and populate lead object:
		$lead = new stdClass();
		
		// loop through POST array
		foreach( $_POST as $leadattr => $leadval ) {
			if( is_array( $leadattr ) ) {
				foreach( $leadattr as $thing ) {
					// echo $thing;	// code here for array elements ...
				}
			} else {
				if($leadattr !== 'action'){
					$lead->{$leadattr} = sanitize_text_field($leadval);
				}
			}
		}

		$lead->wsProduct = WS_Form::postsubmit_derive_product($lead);

		if($debug_submit) {
			print_r($lead);
			print_r("\ncalling WS_MktoUpsertLeads() ... \n");
		}
		
		$upsert = new WS_MktoUpsertLeads();
		$upsert->input = array($lead);
		$upsert_result = $upsert->postData();
		$upsert_obj = json_decode($upsert_result);

		if($debug_submit) {
			print_r("\n\nUpsert Result:\n");
			print_r($upsert_result);
			print_r("\n\nResult Status:\n");
		}
		// alias the status:
		$upsert_status = $upsert_obj->result[0]->status;
		if($debug_submit) {
			print_r($upsert_status);
		}


		if( !$upsert_obj->success ){ // Upsert fails
			if($debug_submit) {
				print_r("\nFailed Upsert call means abort\n"); // DEBUGGING!
				echo '</pre>'; // DEBUGGING!
			}
			return; // (NOT DEBUGGING, ABORT!)
		}

		if( !isset($upsert_obj->result[0]->id ) ){
			if($debug_submit) {
				print_r("\nUpsert call without a result id.  Lead already exists?  No id means abort.\n"); // DEBUGGING!
				echo '</pre>'; // DEBUGGING!
			}
			return; // (NOT DEBUGGING, ABORT!)
		}

		// alias the id:
		$upsert_id = $upsert_obj->result[0]->id;
		if($debug_submit) {
			print_r("\n\nUpsert ID:\n");
			print_r($upsert_id);
		}

		if($upsert_status === 'created') {
			$associate = new WS_MktoAssociateLead($upsert_id,$mkto_cookie);
			if($debug_submit) {
				print_r("\n\ncalling WS_MktoAssociateLead() ...\n");
				print_r($associate->getData());
			}
		} else {
			if($debug_submit) {
				print_r("\n\nNOT calling WS_MktoAssociateLead() because lead is not new (not created) ...\n");
			}
		}

		if($debug_submit) {
			echo '</pre>'; // DEBUGGING!
		}
		// return; // DEBUGGING!

		/////////////////////////////////////////////////////////////////////////////////////
		////////////   SHORTCUT OUT - DEBUGGING  ////////////
		/////////////////////////////////////////////////////////////////////////////////////

		if($debug_submit) {
			print_r("\n\ncalling WS_MktoRequestCampaign() ...\n");
		}
		$request = new WS_MktoRequestCampaign();
		$request_lead = new stdClass();
		$request_lead->id = $upsert_id; // reuse the Lead ID from the Upsert call
		$request->leads = array($request_lead);
		if($debug_submit) {
			print_r($request->postData());
		}

		if($debug_submit) {
			echo '</pre>';
		}
		// return what?;
	}
}

WS_Marketo::instance();