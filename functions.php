<?php
/**
 * WorldStrides functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package WorldStrides
 * @since   0.1.0
 */

// Useful global constants
define( 'WS_VERSION', '0.1.0' );
define( 'WS_PATH', dirname( __FILE__ ) . '/' );
define( 'WS_IMAGE_URL', get_template_directory_uri() . '/assets/images/' );

// Disable file edit/mods from within WordPress
define( 'DISALLOW_FILE_EDIT', true ); // turn off edits
// define( 'DISALLOW_FILE_MODS', true ); // turn off all mods (includes plugin updates)

// Helper Libraries (worth checking for updates occasionally
include WS_PATH . 'includes/library-extended-cpts.php';
include WS_PATH . 'includes/library-extended-taxos.php';
include WS_PATH . 'includes/cmb2/init.php';
include WS_PATH . 'includes/cmb2-attached-posts/cmb2-attached-posts-field.php';
include WS_PATH . 'includes/cmb2-maps-google/cmb-field-map.php';
include WS_PATH . 'includes/cmb2-post-search/cmb2-post-search-field.php';
include WS_PATH . 'includes/taxonomy-metadata/Taxonomy_MetaData.php';
include WS_PATH . 'includes/taxonomy-metadata/Taxonomy_MetaData_CMB2.php';

// Theme Includes
include WS_PATH . 'includes/class-associated-filter.php';
include WS_PATH . 'includes/class-admin-options.php';
include WS_PATH . 'includes/class-collections.php';
include WS_PATH . 'includes/class-comments.php';
include WS_PATH . 'includes/class-cpts.php';
include WS_PATH . 'includes/class-helpers.php';
include WS_PATH . 'includes/class-marketo.php';
include WS_PATH . 'includes/class-marketo-abstract-authenticate.php';
include WS_PATH . 'includes/class-marketo-associate.php';
include WS_PATH . 'includes/class-marketo-requestcampaign.php';
include WS_PATH . 'includes/class-marketo-upsert.php';
include WS_PATH . 'includes/class-metaboxes.php';
include WS_PATH . 'includes/class-metaboxes-blocks.php';
include WS_PATH . 'includes/class-metaboxes-collections.php';
include WS_PATH . 'includes/class-metaboxes-divisions.php';
include WS_PATH . 'includes/class-metaboxes-itineraries.php';
include WS_PATH . 'includes/class-metaboxes-filter-endpoints.php';
include WS_PATH . 'includes/class-shortcodes.php';
include WS_PATH . 'includes/class-taxos.php';

/**
 * Set up theme defaults and register supported WordPress features.
 */
function ws_setup() {
	load_theme_textdomain( 'ws', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	register_nav_menus( array(
		'primary'        => __( 'Primary Menu', 'worldstrides' ),
		'secondary'      => __( 'Quick Access Menu', 'worldstrides' ),
		'footer'         => __( 'Footer Menu 1', 'worldstrides' ),
		'footer2'        => __( 'Footer Menu 2', 'worldstrides' ),
		'footer3'        => __( 'Footer Menu 3', 'worldstrides' ),
		'footer4'        => __( 'Footer Menu 4', 'worldstrides' ),
		'about'          => __( 'About Menu', 'worldstrides' ),
		'resource-types' => __( 'Resource Type Menu', 'worldstrides' ),
	) );

	add_post_type_support( 'page', 'excerpt' );

	add_image_size( 'hero', 1500 );
	add_image_size( 'square', 1030, 900, true );
	add_image_size( 'itinerary', 1500, 400, true );
	add_image_size( 'tour-highlights', 990, 743, true );

}

add_action( 'after_setup_theme', 'ws_setup' );

/**
 * Enqueue scripts and styles for front-end.
 */
function ws_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_script( 'mixitup', get_template_directory_uri() . '/assets/js/vendor/jquery.mixitup.min.js', array(), WS_VERSION, true );
	wp_enqueue_script( 'jquery' );

	if ( is_page_template( 'templates/about-offices.php' ) || is_page_template( 'templates/division-capstone.php' ) || is_singular( 'itinerary' ) ) {
		wp_enqueue_style( 'mapbox-style', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css', array(), WS_VERSION );
		wp_enqueue_script( 'mapbox', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js', array(), WS_VERSION, true );
	}
	
	// if ( is_singular( 'itinerary' ) ) {
	// wp_enqueue_script( 'mustache', get_template_directory_uri() . "/assets/js/vendor/mustache.min.js", array(), WS_VERSION, true );
	// }

	if ( is_singular( 'collection' ) ) {
		wp_enqueue_script( 'mixitup' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}

	if ( is_page_template( 'templates/explore.php' ) ) {
		wp_enqueue_script( 'mixitup' );
	}

	wp_enqueue_script( 'jquery-ui-autocomplete' ); // used on form submissions, available on all pages
	
	wp_enqueue_script( 'ws', get_template_directory_uri() . "/assets/js/worldstrides{$postfix}.js", array( 'jquery' ), WS_VERSION, true );
	wp_enqueue_style( 'ws', get_template_directory_uri() . "/assets/css/worldstrides{$postfix}.css", array(), WS_VERSION );

	wp_localize_script( "ws",
		'worldstrides_ajax',
		array(
			'ajaxUrl' => admin_url( "admin-ajax.php" ), //url for php file that process ajax request to WP
			'nonce' => wp_create_nonce( "worldstrides_ajax_nonce" ),// this is a unique token to prevent form hijacking
			//'someData' => 'extra data you want  available to JS'
		)
	);
}

add_action( 'wp_enqueue_scripts', 'ws_scripts_styles' );

/**
 * Enqueue scripts in the admin area
 */
function ws_admin_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'ws-admin', get_template_directory_uri() . "/assets/css/admin{$postfix}.css", array(), WS_VERSION );
}

add_action( 'admin_enqueue_scripts', 'ws_admin_scripts_styles' );

/**
 * Find a post/page id via slug
 *
 * @param $page_slug
 *
 * @return int|null
 */
function get_id_by_slug( $page_slug ) {
	$page = get_page_by_path( $page_slug );
	if ( $page ) {
		return $page->ID;
	} else {
		return null;
	}
}

/**
 * Add class to body_class if there is a featured image
 *
 * @param $classes
 *
 * @return array original classes plus ones we've added
 */
function ws_add_body_classes( $classes ) {
	global $post;
	$about_id       = get_id_by_slug( 'about' );
	$is_about_child = false;

	if ( $post && $about_id == $post->post_parent ) {
		$is_about_child = true;
	}

	if ( isset ( $post->ID ) && get_the_post_thumbnail( $post->ID ) && ! is_archive() && ! is_home() && ! is_singular( 'press' ) && ! is_page( 'history' ) && ! is_singular( 'bio' ) && ! is_page( 'contact' ) ) {
		$classes[] = 'has-featured-image';

		if ( is_front_page() ) {
			$classesp[] = 'has-featured-image';
		}
	}

	if ( is_archive() || is_home() || is_page( 'about' ) || is_page( 'contact' ) || $is_about_child || is_page( 'resource-center' ) || is_singular( 'resource' ) || is_singular( 'bio' ) || is_404() || is_search() || is_page_template( 'form-page.php' ) ) {
		$classes[] = 'solid-header';

		if ( is_front_page() ) {
			$classes[] = 'transparent-header';
		}
	} else {
		$classes[] = 'transparent-header';
	}

	return $classes;
}
add_filter( 'body_class', 'ws_add_body_classes' );

/**
 * Customize ellipsis after the_excerpt
 */
function ws_new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'ws_new_excerpt_more' );


/**
 * Remove cruft from header
 *
 * This could potentially be replaced by Yoast SEO functionality
 */
// remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );

// do autop after shortcode, was necessary for timeline shortcode
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );

/**
 * Remove default custom fields box
 */
function customize_admin_init() {
	remove_meta_box( 'postcustom', 'post', 'normal' );
	remove_post_type_support( 'post', 'comments' );
}
add_action( 'admin_init', 'customize_admin_init' );

/**
 * Modify default areas in specific areas of the site
 *
 * @param $query
 */
function ws_modified_queries( $query ) {
	if ( is_tax( 'resource-target' ) && ! is_admin() ) {
		$query->set( 'posts_per_page', '100' );
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );

		return;
	}
}
add_action( 'pre_get_posts', 'ws_modified_queries', 1 );

/**
 * Set image sizes
 */
function ws_image_sizes() {
	update_option( 'thumbnail_size_w', 270 );
	update_option( 'thumbnail_size_h', 270 );
	update_option( 'thumbnail_crop', 1 );
	update_option( 'medium_size_w', 480 );
	update_option( 'medium_size_h', 480 );
	update_option( 'large_size_w', 1030 );
	update_option( 'large_size_h', 1030 );
}
add_action( 'switch_theme', 'ws_image_sizes' );

/**
 * Add author type field to Co-Authors Plus
 */
function ws_filter_guest_author_fields( $fields_to_return, $groups ) {

	if ( in_array( 'all', $groups ) || in_array( 'name', $groups ) ) {
		$fields_to_return[] = array(
			'key'   => 'author_type',
			'label' => 'Author Type',
			'group' => 'name',
		);

		$fields_to_return[] = array(
			'key'   => 'facebook_profile_url',
			'label' => 'Facebook Profile URL',
			'group' => 'name',
		);
	}

	return $fields_to_return;
}
add_filter( 'coauthors_guest_author_fields', 'ws_filter_guest_author_fields', 10, 2 );

/**
 * Use Co-Authors for OpenGraph author url, rather than WordPress users
 *
 * @param $profile_url
 *
 * @return mixed
 */
function ws_seo_og_filter_facebook_author( $profile_url ) {
	global $post;

	// Get the Co-Authors for the post
	$co_authors = get_coauthors( $post->ID );

	if ( $co_authors ) {
		$profile_url = $co_authors[0]->facebook_profile_url;
	}
	return $profile_url;
}
add_filter( 'wpseo_opengraph_author_facebook', 'ws_seo_og_filter_facebook_author', 10, 1 );

/**
 * Use filter endpoint template for destinations, interests, and travelers
 *
 * @param $template
 *
 * @return mixed
 */
function ws_filter_endpoints( $template ) {
	$filter_types = array( 'destination', 'interest', 'traveler' );
	$post_type    = get_post_type();

	if ( ! in_array( $post_type, $filter_types ) ) {
		return $template;
	}

	return get_stylesheet_directory() . '/single-filter-endpoint.php';
}
add_filter( 'template_include', 'ws_filter_endpoints' );


/**
 * Include metabox on front page
 *
 * @todo   find a better place for this to live.
 *
 * @author Ed Townend
 * @link   https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool  $display
 * @param array $meta_box
 *
 * @return bool display metabox
 */
function ws_metabox_include_front_page( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) ) {
		return $display;
	}

	if ( 'front-page' !== $meta_box['show_on']['key'] ) {
		return $display;
	}

	$post_id = 0;

	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! $post_id ) {
		return $display;
	}

	// Get ID of page set as front page, 0 if there isn't one
	$front_page = get_option( 'page_on_front' );

	// there is a front page set and we're on it!
	return $post_id == $front_page;
}
add_filter( 'cmb2_show_on', 'ws_metabox_include_front_page', 10, 2 );

/**
 * Remove items from the admin sidebar menu
 */
function remove_admin_menu_itmes() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_admin_menu_itmes' );

/**
 * Remove widgets from the dashboard
 */
function remove_dashboard_widgets() {
	remove_meta_box( 'arve_dashboard_widget', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * Send submitted form data to Marketo using munchkin API
 */
 function data_to_marketo() {
	 WS_Marketo::submit_marketo_data();
	 wp_die();
 }
add_action( 'wp_ajax_data_to_marketo', 'data_to_marketo' );
add_action( 'wp_ajax_nopriv_data_to_marketo', 'data_to_marketo' );

/**
 * Add schema.org markup for Site Name to header
 */
function ws_head_add_schema() {
?>
	<script type="application/ld+json">
		{
		  "@context" : "http://schema.org",
		  "@type" : "WebSite",
		  "name" : "WorldStrides",
		  "alternateName" : "<?php echo get_bloginfo( 'name' ); ?>",
		  "url" : "<?php echo esc_url( home_url( '/' ) ); ?>"
		}
	</script>
<?php
}
add_action( 'wp_head', 'ws_head_add_schema' );