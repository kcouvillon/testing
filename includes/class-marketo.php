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
	 public static $marketo_id = '593-ASZ-675';
	
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
					MktoForms2.loadForm( "//app-sjg.marketo.com", "<?php echo esc_js( self::$marketo_id ); ?>", <?php echo esc_js( $form_id ); ?> );
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
		$lead1 = new stdClass();
		$lead1->email = "upsert.test@marketo.com";

		$upsert = new WS_MktoUpsertLeads();
		$upsert->input = array($lead1);
		print_r($upsert->postData());
	}
}

/**
 * WS_MktoUpsertLeads
 *
 * Update or insert leads into Marketo database.  From here:
 * http://developers.marketo.com/documentation/rest/createupdate-leads/
 */

class WS_MktoUpsertLeads{
	private $host = "https://" . WS_Marketo::$marketo_id . ".mktorest.com";
	private $clientId = "45c494eb-4c74-490d-917d-84e5f7e1c3b9";
	private $clientSecret = "Ih0ugeoKgeOMjAnPMyG0mrAeC73QD70U";
	public $input; //an array of lead records as objects
	public $lookupField; //field used for deduplication
	public $action; //operation type, createOnly, updateOnly, createOrUpdate, createDuplicate
	
	public function postData(){
		$url = $this->host . "/rest/v1/leads.json?access_token=" . $this->getToken();
		$ch = curl_init($url);
		$requestBody = $this->bodyBuilder();
		print_r($requestBody);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_getinfo($ch);
		$response = curl_exec($ch);
		return $response;
	}
	
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
	private function bodyBuilder(){
		$body = new stdClass();
		if (isset($this->action)){
			$body->action = $this->action;
		}
		if (isset($this->lookupField)){
			$body->lookupField = $this->lookupField;
		}
		$body->input = $this->input;
		$json = json_encode($body);
		return $json;
	}
	private static function csvString($fields){
		$csvString = "";
		$i = 0;
		foreach($fields as $field){
			if ($i > 0){
				$csvString = $csvString . "," . $field;
			}elseif ($i === 0){
				$csvString = $field;
			}
		}
		return $csvString;
	}
}

WS_Marketo::instance();
