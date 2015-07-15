<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Itinerary Activity
 * Description: Add an itinerary activity field
 * Author: eightface
 * Author URI: http://davekellam.com
 * Version: 0.1.0
 */

/**
 * Render 'itinerary_activity' custom field type
 *
 * @since 0.1.0
 *
 * @param array  $field              The passed in `CMB2_Field` object
 * @param mixed  $value              The value of this field escaped.
 *                                   It defaults to `sanitize_text_field`.
 *                                   If you need the unescaped value, you can access it
 *                                   via `$field->value()`
 * @param int    $object_id          The ID of the current object
 * @param string $object_type        The type of object you are working with.
 *                                   Most commonly, `post` (this applies to all post-types),
 *                                   but could also be `comment`, `user` or `options-page`.
 * @param object $field_type_object  The `CMB2_Types` object
 */
function cmb2_render_itinerary_activity_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	// make sure we specify each part of the value we need.
	$value         = wp_parse_args( $value, array(
		'title' => '',
		'description' => '',
	) );

	?>
	<div><p>
			<label for="<?php echo $field_type_object->_id( '_title' ); ?>"><?php echo esc_html( $field_type_object->_text( 'intinerary_activity_title_text', 'Title' ) ); ?></label>
		</p>
		<?php echo $field_type_object->input( array(
			'name'  => $field_type_object->_name( '[title]' ),
			'id'    => $field_type_object->_id( '_title' ),
			'value' => $value['title'],
		) ); ?>
	</div>
	<div><p>
			<label for="<?php echo $field_type_object->_id( '_description' ); ?>'"><?php echo esc_html( $field_type_object->_text( 'itinerary_activity_description_text', 'Description' ) ); ?></label>
		</p>
		<?php echo $field_type_object->input( array(
			'name'  => $field_type_object->_name( '[description]' ),
			'id'    => $field_type_object->_id( '_description' ),
			'value' => $value['description'],
		) ); ?>
	</div>

	<?php
	echo $field_type_object->_desc( true );
}

add_filter( 'cmb2_render_itinerary_activity', 'cmb2_render_itinerary_activity_callback', 10, 5 );

/**
 * The following snippets are required for allowing the itinerary activity field
 * to work as a repeatable field, or in a repeatable group
 */
function cmb2_sanitize_itinerary_activity_field( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {
	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		if ( $val['title'] == '' ) {
			unset( $meta_value[$key] );
		} else {
			$meta_value[ $key ] = array_map( 'sanitize_text_field', $val );
		}
	}

	return $meta_value;
}

add_filter( 'cmb2_sanitize_itinerary_activity', 'cmb2_sanitize_itinerary_activity_field', 10, 5 );

function cmb2_types_esc_itinerary_activity_field( $check, $meta_value, $field_args, $field_object ) {
	// if not repeatable, bail out.
	if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
		return $check;
	}

	foreach ( $meta_value as $key => $val ) {
		$meta_value[ $key ] = array_map( 'esc_attr', $val );
	}

	return $meta_value;
}

add_filter( 'cmb2_types_esc_itinerary_activity', 'cmb2_types_esc_itinerary_activity_field', 10, 4 );