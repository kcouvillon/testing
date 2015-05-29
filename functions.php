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

// Includes
include WS_PATH . 'includes/library-extended-cpts.php';
include WS_PATH . 'includes/library-extended-taxos.php';

include WS_PATH . 'includes/class-associated-filter.php';
include WS_PATH . 'includes/class-cpts.php';
include WS_PATH . 'includes/class-marketo.php';
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
		'primary' => __( 'Primary Menu', 'obsub' ),
		'secondary' => __( 'Quick Access Menu', 'obsub' ),
	) );
}

add_action( 'after_setup_theme', 'ws_setup' );

/**
 * Enqueue scripts and styles for front-end.
 */
function ws_scripts_styles() {
	$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'ws', get_template_directory_uri() . "/assets/js/worldstrides{$postfix}.js", array(), WS_VERSION, true );

	wp_enqueue_style( 'ws', get_template_directory_uri() . "/assets/css/worldstrides{$postfix}.css", array(), WS_VERSION );
}

add_action( 'wp_enqueue_scripts', 'ws_scripts_styles' );

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
