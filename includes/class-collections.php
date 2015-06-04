<?php
/**
 * Helper functions for collections.
 *
 * Create a shadow taxonomy that allows a trip or event to be associated with a collection term to allow for faster querying.
 * This is necessary because a collection might not necessarily be a filter, so we need a way to grab all trips in that
 * collection without a meta query.
 *
 * Class WS_Collections
 */
class WS_Collections {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Collections
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Collections
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
		add_action( 'save_post', array( $this, 'update_shadow_taxonomy' ) );
		add_action( 'before_delete_post', array( $this, 'delete_shadow_tax_term' ) );
	}

	/**
	 * Creates a shadow taxonomy term on save, if one doesn't exist already.
	 *
	 * @param $post_id
	 */
	public function update_shadow_taxonomy( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// If we're not working with a collection, don't create a term
		if ( 'collection' !== get_post_type( $post_id ) ) {
			return;
		}

		// If we can't retrieve the collection, don't create a term
		$collection = get_post( $post_id );
		if ( null === $collection ) {
			return;
		}

		// If the collection already exists, don't create a term.
		$term = get_term_by( 'name', $collection->post_title, '_collection' );
		if ( false === $term && 'Auto Draft' !== $collection->post_title ) {
			// Create the term
			wp_insert_term( $collection->post_title, '_collection' );
		}

	}

	/**
	 * Remove a term from the shadow taxonomy upon post delete.
	 *
	 * @param $post_id
	 */
	function delete_shadow_tax_term( $post_id ) {
		// If we're running an auto-save, don't delete a term
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// If we're not working with a collection, don't delete a term
		if ( 'collection' !== get_post_type( $post_id ) ) {
			return;
		}

		// If we can't retrieve the collection, don't delete a term
		$collection = get_post( $post_id );
		if ( null === $collection ) {
			return;
		}

		// If the collection already exists, don't delete anything.
		$term = get_term_by( 'name', $collection->post_title, '_collection' );
		if ( false === $term ) {
			// Delete the term
			wp_delete_term( $term->term_id, '_collection' );
		}
	}
}

WS_Collections::instance();
