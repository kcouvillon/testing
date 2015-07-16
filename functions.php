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
include WS_PATH . 'includes/cmb2-itinerary-activity/cmb2-itinerary-activity.php';
include WS_PATH . 'includes/cmb2-associated-itineraries/cmb2-associated-itineraries.php';

// Theme Includes
include WS_PATH . 'includes/class-associated-filter.php';
include WS_PATH . 'includes/class-collections.php';
include WS_PATH . 'includes/class-comments.php';
include WS_PATH . 'includes/class-cpts.php';
include WS_PATH . 'includes/class-helpers.php';
include WS_PATH . 'includes/class-marketo.php';
include WS_PATH . 'includes/class-metaboxes.php';
include WS_PATH . 'includes/class-metaboxes-blocks.php';
include WS_PATH . 'includes/class-metaboxes-collections.php';
include WS_PATH . 'includes/class-metaboxes-itineraries.php';
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

}

add_action( 'after_setup_theme', 'ws_setup' );

/**
 * Enqueue scripts and styles for front-end.
 */
function ws_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'jquery' );

	if ( is_page_template( 'templates/about-offices.php' ) ) {
		wp_enqueue_style( 'mapbox-style', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css', array(), WS_VERSION );
		wp_enqueue_script( 'mapbox', 'https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.js', array(), WS_VERSION, true );
	}

	wp_enqueue_script( 'ws', get_template_directory_uri() . "/assets/js/worldstrides{$postfix}.js", array( 'jquery' ), WS_VERSION, true );

	wp_enqueue_style( 'ws', get_template_directory_uri() . "/assets/css/worldstrides{$postfix}.css", array(), WS_VERSION );
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

function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

/**
 * Add class to body_class if there is a featured image
 */
function ws_add_body_classes( $classes ) {
	global $post;
	$about_id = get_id_by_slug( 'about' );

	if ( isset ( $post->ID ) && get_the_post_thumbnail( $post->ID ) && ! is_archive() && ! is_home() && ! is_singular( 'press' ) && ! is_page( 'history' ) ) {
		$classes[] = 'has-featured-image';

		if ( is_front_page() ) {
			$classesp[] = 'has-featured-image';
		}
	}

	if ( is_archive() || is_home() || is_page( 'about' ) || is_page( 'contact' ) || $about_id == $post->post_parent || is_page( 'resource-center' ) || is_singular( 'resource' ) ) {
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
 * @todo better location for this?
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
function customize_meta_boxes() {
	remove_meta_box( 'postcustom', 'post', 'normal' );
}
add_action( 'admin_init', 'customize_meta_boxes' );


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