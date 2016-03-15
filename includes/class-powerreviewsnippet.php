<?php
/**
 * Add PowerReviews and related html
 *
 * Class WS_PowerReviewSnippet
 */
class WS_PowerReviewSnippet {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_PowerReviewSnippet
	 */
	protected static $_instance = null;

	protected static $_xml = null;

	public static $powerreviews_url = 'https://reviews.worldstrides.com/';

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_PowerReviewSnippet
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

	protected function _init() {
		$this::parse_xml();
	}

	/**
	 * Parse the PowerReviews XML file into the static $_xml
	 */
	protected function parse_xml() {
		
		$response = wp_remote_get( self::$powerreviews_url . 'pwr/dgw9fped/rawdata/review_data_summary.xml' );
		if( is_array($response) ) {
			// $header = $response['headers']; // array of http header lines
			$body = $response['body']; // use the content
			self::$_xml = simplexml_load_string( $body );
		}


		// if( WP_DEBUG ){
		// $json = json_encode( $xml );
		// $array = json_decode( $json, TRUE );
		// 	echo '<pre>';
		// 	wp_die( 'PARSING XML: ' . print_r($array) . '</pre>' );
		// }

		// if( WP_DEBUG ){
		// 	echo '<pre>';
		// 	wp_die( 'PARSING XML: ' . print_r($_xml->product[1]) . '</pre>' );
		// }

	}

	/**
	 * Pull out the associated HTML referred to in the XML
	 */
	public static function html_from_pr_page_id( $pr_page_id, $page_title )  {
		$review_uri = '';
		$review_html = '';
		$product = null;

		if( !( $product = self::product_obj_from_pr_page_id( $pr_page_id ) ) ) {
			return '';
		}

		$review_html .= '<div class="section-content pr-ws-nopadding">';
		$review_html .= '	<div class="ws-block block-single-col">';
		$review_html .= '		<div class="block-text">';
		$review_html .= '			<span class="h3">What do teachers and students think of WorldStrides\' ' . $page_title . ' Tours?</span>';

		$review_html .= '				<a name="pr-header-back-to-top-link"></a>';

		// @todo - import these the proper WordPress way?
		// @todo - make our own override css?
		//$review_html .= <link rel="stylesheet" href="https://reviews.worldstrides.com/pwr/engine/merchant_styles2.css" type="text/css" id="prMerchantOverrideStylesheet">';
		// prepend PR styles CSS
		$review_html .= '<link rel="stylesheet" href="//ui.powerreviews.com/stable/review-display/modern/styles.css" type="text/css" id="prBaseStylesheet">';
		// prepend full.js script
		$review_html .= '<script src="/pwr/engine/js/full.js"></script>';
		// prepend widget.js script
		$review_html .= '<script type="text/javascript" src="//static.powerreviews.com/widgets/v1/widget.js"></script>';
		// prepend PR styles JS
		$review_html .= '<script type="text/javascript" src="//ui.powerreviews.com/stable/review-display/modern/js/rd-styles.js"></script>';

		try {
			$review_uri = $product->inlinefiles->inlinefile;
			$response = wp_remote_get( self::$powerreviews_url . $review_uri );
			if( is_array($response) ) {
				// $header = $response['headers']; // array of http header lines
				$review_html .= $response['body']; // use the content
			}
		} catch ( Exception $e ) {
			return ''; // PowerReviews XML parsing badly, eh?
		}


		// then adjust the hyperlinks to work properly:
		$review_html = preg_replace( '/\/pwr/', self::$powerreviews_url . 'pwr', $review_html ); // prepend https://reviews.worldstrides.com 
		$review_html = preg_replace( '/https:/', '', $review_html ); // make all includes start with '//' rather than 'https://'
		$review_html .= '<script type="text/javascript">';
		$review_html .= '  POWERREVIEWS.display.engine(document);';
		$review_html .= '  var pr_zip_location="' . self::$powerreviews_url . '";';
		$review_html .= '</script>';
		$review_html .= '<a href="' . self::$powerreviews_url . 'reviews.php?pr_page_id=' . $pr_page_id . '">See all Reviews</a>';


		$review_html .= '		</div> <!-- .block-text -->';
		$review_html .= '	</div> <!-- .ws-block.block-single-col -->';
		$review_html .= '</div> <!-- .section-content.pr-ws-nopadding -->';

		return $review_html;

	}

	protected static function product_obj_from_pr_page_id( $pr_page_id ) {
		if( null === self::$_xml ) {
			return false; // bail!
		}

		$i = 0;
		$product_obj = null;

		try {
			while( $product = self::$_xml->product[$i++] ) {
				if( $pr_page_id == $product->pageid ) {
					$product_obj = $product;
				}
			}
		} catch ( Exception $e ) {
			return false; // PowerReviews XML parsing badly, eh?
		}

		return $product_obj;
	}

}

WS_PowerReviewSnippet::instance();
