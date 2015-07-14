<?php
/**
 * Class WS_Comments
 *
 * @todo turn off all defaults comments
 * @todo add functionality to turn comments on/off
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
	public static function facebook_app_id() {
		$facebook_app_id = '1423041707927133';

		return $facebook_app_id;
	}

	/**
	 * Add Facebook app id to single blog posts
	 */
	public function facebook_app_meta() {
		$facebook_app_id = $this->facebook_app_id();

		if ( is_singular( 'post' ) ) {
			echo '<meta property="fb:app_id" content="' . $facebook_app_id . '" />' . "\n";
		}
	}

	public static function facebook_sdk() {
		ob_start(); ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=<?php echo WS_Comments::facebook_app_id(); ?>";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<?php
		$facebook_sdk = ob_get_clean();

		return $facebook_sdk;
	}
}

WS_Comments::instance();
