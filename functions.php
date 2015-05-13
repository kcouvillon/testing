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
 * Define trip custom post type
 */
register_extended_post_type( 'trip', array( 'menu_icon' => 'dashicons-location-alt' ), array( 'slug' => 'trips' ) );

register_extended_post_type( 'event', array( 'menu_icon' => '' ), array( 'slug' => 'events' ) );
register_extended_post_type( 'collection' );
register_extended_post_type( 'destination' );
register_extended_post_type( 'interest' );
register_extended_post_type( 'traveler' );
register_extended_post_type( 'season' );
register_extended_post_type( 'group type' );
register_extended_post_type( 'press', array(), array( 'plural' => 'Press' ) );
register_extended_post_type( 'resource' );
register_extended_post_type( 'review' );
register_extended_post_type( 'lead' );

register_extended_post_type( 'leadership', array(), array( 'plural' => 'Leadership' ) );