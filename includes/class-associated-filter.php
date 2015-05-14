<?php

/**
 * Provides associated filter functionality. Allows a post to be associated with a term in the filter taxonomy to allow for faster querying.
 *
 * WS_Associated_Filter::get_associated_filter( $post_id );
 * WS_Associated_Filter::get_associated_filter_id( $post_id );
 *
 * Class WS_Associated_Filter
 */
class WS_Associated_Filter {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Associated_Filter
	 */
	protected static $_instance = null;

	/**
	 * Set the priority to selected a filter
	 *
	 * @var array
	 */
	public static $_filter_priority = array( 'filter-2', 'filter-3', 'filter-1' );


	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Associated_Filter
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
		add_action( 'post_submitbox_misc_actions', array( $this, 'submitbox' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_action( 'is_protected_meta', array( $this, 'is_protected_meta' ), 10, 2 );
	}

	public function is_protected_meta( $protected, $meta_key ) {
		$hide = array(
			'ws-associated-filter-id',
		);

		if ( in_array( $meta_key, $hide ) ) {
			$protected = true;
		}

		return $protected;
	}

	public function supports_filters() {
		global $pagenow;
		$support = false;

		if ( is_singular() || ( is_admin() && 'post.php' == $pagenow ) ) {
			$post_id = get_the_ID();
			$taxonomies = get_object_taxonomies( get_post_type( $post_id ) );

			if ( in_array( 'filter', $taxonomies ) ) {
				$support = true;
			}
		}

		return $support;
	}

	/**
	 * Adds a dropdown to the submitbox to select an associated filter
	 */
	public function submitbox() {
		if ( ! $this->supports_filters() ) {
			return;
		}

		$post_id = get_the_ID();
		$associated_filter_id = self::get_associated_filter_id( $post_id );
		//$filters = wp_get_object_terms( $post_id, 'filter' );

		$filters = get_terms( 'filter', array( 'hide_empty' => 0 ) );
		?>
		<div class="misc-pub-section">
			<label for="ws-associated-filter"><strong>Associated Filter</strong></label>
			<select name="ws-associated-filter" id="ws-associated-filter" class="widefat">
				<option value="-1">Select a filter</option>
				<?php
				foreach ( $filters as $filter ) {
					// Skip 'Uncategorized'
					if ( 'Uncategorized' == $filter->name ) {
						continue;
					}
					?>
					<option value="<?php echo intval( $filter->term_id ); ?>" <?php selected( $filter->term_id, $associated_filter_id ); ?>><?php echo esc_html( $filter->name ); ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<?php
		wp_nonce_field( 'save-associated-filter', 'ws-associated-filter-nonce' );
	}

	/**
	 * Saves the associated filter on the save_post hook
	 *
	 * @param $post_id
	 */
	public function save_post( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Nonce also serves as post type check, since its only output on the correct post types (The ones that support filters)
		if ( ! isset( $_POST['ws-associated-filter-nonce'] ) || ! wp_verify_nonce( $_POST['ws-associated-filter-nonce'], 'save-associated-filter' ) ) {
			return;
		}

		$taxonomies = get_object_taxonomies( get_post_type( $post_id ) );
		if ( ! in_array( 'filter', $taxonomies ) ) {
			// For cases where the pagenow will support filters, but the post type may not
			return;
		}

		if ( isset( $_POST['ws-associated-filter'] ) ) {
			if (intval( $_POST['ws-associated-filter'] ) > 0 ) {
				self::set_associated_filter_id( $post_id, $_POST['ws-associated-filter'] );
			} else {
				self::delete_associated_filter_id( $post_id );
			}
		}

	}

	/**
	 * Determines if a post has an associated filter - get_associated_filter falls back to the first filter, so this can
	 * be used to determine if an associated filter exists for the post or not, with no fallback.
	 */
	public static function has_associated_filter( $post_id = 0 ) {
		if ( 0 == $post_id ) {
			$post_id = get_the_ID();
		}

		return (bool) self::get_associated_filter_id( $post_id );
	}

	/**
	 * Returns the term object that corresponds to the associated filter on the post.
	 *
	 * @param int $post_id The post ID to get the associated filter for. Defaults to current post ID.
	 *
	 * @return stdClass The term object for the associated filter.
	 */
	public static function get_associated_filter( $post_id = 0 ) {
		if ( 0 == $post_id ) {
			$post_id = get_the_ID();
		}

		$filter = false;

		$filter_id = self::get_associated_filter_id( $post_id );

		if ( $filter_id ) {
			$filter = get_term( (int) $filter_id, 'filter' );
			if ( is_wp_error( $filter ) && is_null( $filter ) ) {
				$filter = false;
			}
		}

		if ( ! $filter ) {
			$filters = wp_get_object_terms( $post_id, 'filter' );
			if ( ! is_wp_error( $filters ) && count( $filters ) > 0 ) {

				foreach ( self::$_filter_priority as $priority ) {
					foreach ( $filters as $filter ) {
						if ( $priority === $filter->slug ) {
							return $filter;
						}
					}
				}
			} else {
				$filter = false;
			}
		}

		return $filter;
	}

	/**
	 * Returns the term ID for the associated filter.
	 *
	 * @param int $post_id The post ID to get the associated filter id for. Defaults to current post ID.
	 *
	 * @return int The display filter id.
	 */
	public static function get_associated_filter_id( $post_id = 0 ) {
		if ( 0 == $post_id ) {
			$post_id = get_the_ID();
		}

		return (int) get_post_meta( $post_id, 'ws-associated-filter-id', true );
	}

	/**
	 * Sets the associated filter id for a particular post.
	 *
	 * @param int $post_id The post ID to set associated filter for.
	 * @param int $filter_id The filter ID to set as the associated filter on the post.
	 *
	 * @return mixed The result of update post meta.
	 */
	public static function set_associated_filter_id( $post_id, $filter_id ) {
		return update_post_meta( $post_id, 'ws-associated-filter-id', intval( $filter_id ) );
	}

	/**
	 * Deletes the associated filter relationship for the specified post.
	 *
	 * @param int $post_id The post ID to delete the associated filter relationship for.
	 *
	 * @return mixed The result of delete_post_meta
	 */
	public static function delete_associated_filter_id( $post_id ) {
		return delete_post_meta( $post_id, 'ws-associated-filter-id' );
	}
}

WS_Associated_Filter::instance();
