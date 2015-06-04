<?php
/**
 * A collection of helper functions
 *
 * Class WS_Helpers
 */
class WS_Helpers {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Helpers
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Helpers
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
		// add_actions and add_filters here
	}

	/**
	 * Find the a blog post's type
	 *
	 * @parameter $post_id int post to retrieve blog type
	 *
	 * @return html content wrapped in a unordered list
	 */
	public static function blog_type( $post_id ) {
		$terms = get_the_terms( $post_id, 'blog-type' );
		$term_slug = $terms[0]->slug;

		return $term_slug;
	}
}

WS_Helpers::instance();
