<?php
/*
Plugin Name: CMB2 Field Type: Google Maps
Plugin URI: https://github.com/mustardBees/cmb_field_map
Description: Google Maps field type for CMB2.
Version: 2.1.1
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+

NOTE: If this is replaced... setup_admin_scripts() was modified to use custom url, rather than plugins_url(),
so, it can live in the theme, rather than being a plugin
*/

/**
 * Class PW_CMB2_Field_Google_Maps
 */
class PW_CMB2_Field_Google_Maps {

	/**
	 * Current version number
	 */
	const VERSION = '2.1.1';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_filter( 'cmb2_render_pw_map', array( $this, 'render_pw_map' ), 10, 5 );
		add_filter( 'cmb2_sanitize_pw_map', array( $this, 'sanitize_pw_map' ), 10, 4 );
	}

	/**
	 * Render field
	 */
	public function render_pw_map( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {
		$this->setup_admin_scripts();

		echo '<input type="text" class="large-text pw-map-search" id="' . $field->args( 'id' ) . '" />';

		echo '<div class="pw-map"></div>';

		$field_type_object->_desc( true, true );

		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args('_name') . '[latitude]',
			'value'      => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'class'      => 'pw-map-latitude',
			'desc'       => '',
		) );
		echo $field_type_object->input( array(
			'type'       => 'hidden',
			'name'       => $field->args('_name') . '[longitude]',
			'value'      => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'class'      => 'pw-map-longitude',
			'desc'       => '',
		) );
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public function sanitize_pw_map( $override_value, $value, $object_id, $field_args ) {
		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( ! empty( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
			}

			if ( ! empty( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function setup_admin_scripts() {
		$dir = trailingslashit( dirname( __FILE__ ) );

		if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) ) {
			// Windows
			$content_dir = str_replace( '/', DIRECTORY_SEPARATOR, WP_CONTENT_DIR );
			$content_url = str_replace( $content_dir, WP_CONTENT_URL, $dir );
			$url = str_replace( DIRECTORY_SEPARATOR, '/', $content_url );

		} else {
			$url = str_replace(
				array( WP_CONTENT_DIR, WP_PLUGIN_DIR ),
				array( WP_CONTENT_URL, WP_PLUGIN_URL ),
				$dir
			);
		}

		$url = set_url_scheme( $url );

		wp_register_script( 'pw-google-maps-api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places', null, null );
		wp_enqueue_script( 'pw-google-maps', $url . 'js/script.js', array( 'pw-google-maps-api' ), self::VERSION );
		wp_enqueue_style( 'pw-google-maps', $url . 'css/style.css', array(), self::VERSION );
	}
}
$pw_cmb2_field_google_maps = new PW_CMB2_Field_Google_Maps();