<?php
/**
 * Class WS_Comments
 */
class WS_Comments {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Comments
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Comments
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
		add_action( 'admin_menu', array( $this, 'remove_comments_menu' ) );
		add_action( 'admin_init', array( $this, 'disable_comments_admin_menu_redirect' ) );
		add_action( 'admin_init', array( $this, 'remove_comments_support' ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'remove_admin_bar_comments' ) );
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

	/**
	 * Print Facebook SDK
	 *
	 * For use immediately after the opening body tag in the header.
	 *
	 * @return string
	 */
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

	/**
	 * Remove items from the admin sidebar menu
	 */
	function remove_comments_menu() {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Redirect people who visit edit-comments.php directly
	 */
	function disable_comments_admin_menu_redirect() {
		global $pagenow;

		if ( $pagenow === 'edit-comments.php' ) {
			wp_redirect( admin_url() );
			exit;
		}
	}

	/**
	 * Remove comments/trackback support from posts
	 */
	function remove_comments_support() {
		remove_post_type_support ('post', 'comments' );
		remove_post_type_support( 'post', 'trackbacks' );
	}

	/**
	 * Remove comments from the admin bar
	 */
	function remove_admin_bar_comments() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	}
}

WS_Comments::instance();
