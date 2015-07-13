<?php
/**
 * Class WS_Comments
 */
class WS_Comments {
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
		add_action( 'wp_head', array( $this, 'facebook_app_id' ) );
	}

	/**
	 * Add Facebook app id to single blog posts
	 */
	public function facebook_app_id() {
		$facebook_app_id = '1423041707927133';

		if ( is_singular( 'post' ) ) {
			echo '<meta property="fb:app_id" content="' . $facebook_app_id . '" />' . "\n";
		}
	}

}

WS_Comments::instance();
