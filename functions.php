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
 * @since 0.1.0
 */
 
 // Useful global constants
define( 'WS_VERSION', '0.1.0' );
define( 'WS_PATH', dirname( __FILE__ ) . '/' );
define( 'WS_IMAGE_URL', get_template_directory_uri() . '/assets/images/' );

include WS_PATH . 'includes/class-legacy-redirects.php';
include WS_PATH . 'includes/class-custom-post-type.php';


/**
 * Define custom post types
 */
new WS_Custom_Post_Type( 'trip' );
new WS_Custom_Post_Type( 'event' );
new WS_Custom_Post_Type( 'collection' );
new WS_Custom_Post_Type( 'destination' );
new WS_Custom_Post_Type( 'interest' );
new WS_Custom_Post_Type( 'traveler' );
new WS_Custom_Post_Type( 'season' );
new WS_Custom_Post_Type( 'group type' );
new WS_Custom_Post_Type( 'press' );
new WS_Custom_Post_Type( 'press' );
new WS_Custom_Post_Type( 'resource' );
new WS_Custom_Post_Type( 'review' );
new WS_Custom_Post_Type( 'lead' );
new WS_Custom_Post_Type( 'leadership' );


 /**
  * Set up theme defaults and register supported WordPress features.
  */
 function ws_setup() {
	/**
	 * Makes WorldStrides available for translation.
	 *
	 * Translations can be added to the /lang directory.
	 * If you're building a theme based on WorldStrides, use a find and replace
	 * to change 'ws' to the name of your theme in all template files.
	 */
	load_theme_textdomain( 'ws', get_template_directory() . '/languages' );
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