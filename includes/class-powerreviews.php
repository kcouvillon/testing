<?php
/**
 * Add PowerReviews and related html
 *
 * Class WS_PowerReviews
 */
class WS_PowerReviews {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_PowerReviews
	 */
	protected static $_instance = null;

	protected static $_xml = null;

	public static $powerreviews_url = 'https://wsreviews:reviewsINprogress@reviews.worldstrides.com/';

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_PowerReviews
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
		
		$response = wp_remote_get( self::$powerreviews_url . 'pwr/mx54y728/rawdata/review_data_summary.xml' );
		if( is_array($response) ) {
		  $header = $response['headers']; // array of http header lines
		  $body = $response['body']; // use the content
		}

		self::$_xml = simplexml_load_string( $body );

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
	public static function html_from_pr_page_id( $pr_page_id )  {
		$i = 0;
		$review_url = '';
		$review_html = '';

		while( $product = self::$_xml->product[$i++] ) {
			if( $pr_page_id == $product->pageid ) {
				$review_url = $product->inlinefiles->inlinefile;
			}
		}

		return self::$powerreviews_url . $review_url; // @todo: actually return the html
	}

}

WS_PowerReviews::instance();
