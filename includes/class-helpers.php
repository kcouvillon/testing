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
		$terms     = get_the_terms( $post_id, 'blog-type' );

		if ( $terms ) {
			$term_slug = $terms[0]->slug;
		} else {
			$term_slug = 'general';
		}

		return $term_slug;
	}

	/**
	 * Helper function for retrieving and formatting value propositions
	 *
	 * @param $post_id
	 *
	 * @return string Our html output
	 */
	public static function get_value_proposition( $post_id ) {
		$value_prop = get_post( $post_id );
		ob_start();
		{ ?>
			<div class="value-prop">
				<?php $icon = get_the_post_thumbnail( $post_id, array( 300, 300 ), array(
					'class' => 'value-prop-img'
				) ); ?>

				<?php if ( $icon ) : ?>
					<?php echo $icon; ?>
				<?php else : ?>
					<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
				<?php endif; ?>

				<span class="value-prop-title"><?php echo $value_prop->post_title; ?></span>

				<p class="value-prop-desc"><?php echo $value_prop->post_content; ?></p>
			</div>
			<?php
			$html = ob_get_contents();
			ob_get_clean();

			return $html;
		}
	}
}

WS_Helpers::instance();