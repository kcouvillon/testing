<?php
/**
 * Handles legacy redirects for WorldStrides.
 *
 * Uses a custom post type because it is much quicker than storing all of this data in post meta.
 * Uses post_name, since it's indexed and will be really quick to query.
 */

class WS_Legacy_Redirects {

	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Legacy_Redirects
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Legacy_Redirects
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
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'template_redirect', array( $this, 'maybe_redirect' ), 1 );
	}

	/**
	 * Register the post type for redirects.
	 */
	public function register_post_type() {
		$args = array(
			'public' => false,
		);
		register_post_type( 'worldstrides-redirect', $args );
	}

	/**
	 * If request is 404, checks to see if we have a legacy redirect entry for the url being accessed.
	 *
	 * Also redirects to centralmaine.com if kjonline or onlinesentinel are the request domains.
	 */
	public function maybe_redirect() {
		// A similar structure to this can check for things that are domain specific
		if ( false !== stripos( $_SERVER['HTTP_HOST'], 'oldurl.com' ) || false !== stripos( $_SERVER['HTTP_HOST'], 'otheroldurl.com' ) ) {
			wp_redirect( 'http://www.newurl.com' . parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
			exit;
		}

		if ( ! is_404() ) {
			return;
		}

		$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

		if ( false !== $path ) {
			$new_permalink = $this->get_redirect_url( $path );
			if ( false !== $new_permalink ) {
				wp_safe_redirect( $new_permalink, 301 );
				exit;
			}
		}
	}

	/**
	 * Gets the permalink to the new post if a redirect matches.
	 *
	 * @param string $path The path to the page that was requested.
	 *
	 * @return bool|string URL to the post if found, or false otherwise
	 */
	public function get_redirect_url( $path ) {
		global $wpdb;

		// Using $wpdb because we really don't need all the extra stuff that WP_Query or get_posts would return.
		$parent_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_parent FROM $wpdb->posts WHERE post_name = %s AND post_type = %s", md5( $path ), 'worldstrides-redirect' ) );
		if ( is_null( $parent_id ) ) {
			return false;
		}

		return get_permalink( $parent_id );
	}



	/* Static Helper Methods */

	/**
	 * Adds a redirect to the database.
	 *
	 * @param string $old_url The old url to redirect.
	 * @param integer $post_id The post ID to redirect to.
	 *
	 * @return integer The post id for the redirect
	 */
	public static function add_redirect( $old_url, $post_id ) {
		$path = parse_url( $old_url, PHP_URL_PATH );

		$redirect_id = wp_insert_post( array(
			'post_parent' => $post_id,
			'post_name' => md5( $path ), // Max characters + sanitize_title makes this a decent idea
			'post_title' => $path,
			'post_type' => 'worldstrides-redirect',
		) );

		return $redirect_id;
	}
}

// Ready, Set, Go!
WS_Legacy_Redirects::instance();
