<?php
/**
 * Add explore
 *
 * Class WS_Explore
 */
class WS_Explore {
	/**
	 * Instance of this class, if it has been created.
	 *
	 * @var WS_Explore
	 */
	protected static $_instance = null;

	/**
	 * Get the instance of this class, or set it up if it has not been setup yet.
	 *
	 * @return WS_Explore
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
		add_action( 'init', array( $this, 'explore_endpoints' ) );
		add_action( 'template_redirect', array( $this, 'filter_requests' ) );
	}

	public function explore_endpoints() {
		add_rewrite_tag( '%api-filters%', '([^&]+)' );
		add_rewrite_rule( 'ws-api/v1/explore/results/([^&]+)/?', 'index.php?api-filters=$matches[1]', 'top' );
	}

	/**
	 *
	 */
	public static function filter_requests() {

		global $wp_query;

		$filters = $wp_query->get( 'api-filters' );
		$filters = explode( ',', $filters );

		if ( empty( $filters ) ) {
			return;
		}

		$filter_data = array();

		$args = array(
			'post_type'      => array( 'itinerary', 'collection' ),
			'posts_per_page' => 200, // very large, but better than -1
			'tax_query'      => array(
				array(
					'taxonomy' => 'filter',
					'field'    => 'slug',
					'terms'    => $filters,
					'operator' => 'AND'
				)
			),
			'no_found_rows'  => true,
			'orderby'        => 'title',
			'order'          => 'ASC'
		);

		$query_data = new WP_Query( $args );

		if ( $query_data->have_posts() ) {
			while ( $query_data->have_posts() ) {
				$query_data->the_post();

				$img_id        = get_post_thumbnail_id();
				$img           = wp_get_attachment_image_src( $img_id, 'large' );
				$post_type     = get_post_type();
				$terms = get_the_terms( get_the_ID(), 'filter' );
				$term_list = array();
				$meta_list = array();

				foreach ( $terms as $term ) {
					array_push( $term_list, array(
						'name' => $term->name,
						'slug' => $term->slug
					) );

					if ( in_array( $term->term_id, get_term_children( 222, 'filter' ) ) ) {
						array_push( $meta_list, array( 'name' => $term->name ) );
					}
				}

				$filter_data[$post_type][] = array(
					'title' => get_the_title(),
					'featured_image'  => esc_url( $img[0] ),
					'link' => get_the_permalink(),
					'filter' => $term_list,
					'meta' => $meta_list

				);
			}
			wp_reset_postdata();

			wp_send_json_success( $filter_data );

		} else {
			// This messed up the whole site...
			// wp_send_json_error( $filter_data );

		}

		return;
	}
}

WS_Explore::instance();
