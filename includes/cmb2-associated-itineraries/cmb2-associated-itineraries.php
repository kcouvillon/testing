<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Itinerary Activity
 * Description: Add an itinerary activity field
 * Author: eightface
 * Author URI: http://davekellam.com
 * Version: 0.1.0
 */

/**
 * Render 'associated_itineraries' custom field type
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
function cmb2_render_associated_itineraries_callback( $field, $value, $object_id, $object_type, $field_type_object ) {

	?>
	<div>
		<?php
			global $post;
			$term = $post->post_name;
			$template = get_post_meta( $post->ID, '_wp_page_template', true );

			// if the collection slugs change, these will need to change
			if ( 'templates/division-capstone.php' == $template ) {
				$term = 'capstone-programs';
			}

			$associated_itineraries = new WP_Query( array(
				'post_type' => 'itinerary',
				'tax_query' => array(
					array(
						'taxonomy' => '_collection',
						'field'    => 'slug',
						'terms'    => $term
					)
				),
				'posts_per_page' => 75
			) );
		?>

		<?php if ( $associated_itineraries->have_posts() ) : ?>
			<ul>
			<?php while ( $associated_itineraries->have_posts() ) : ?>
				<?php $associated_itineraries->the_post(); ?>
				<li>
					<?php echo get_the_post_thumbnail( $post->ID, array( 30, 30 ) ); ?>
					<a href="<?php echo get_edit_post_link( $post->ID ); ?>">
						<?php echo get_the_title(); ?>
					</a>
					<?php if ( 'publish' != $post->post_status ) : ?>
					<small>&ndash; <?php echo $post->post_status; ?></small>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
			</ul>
		<?php endif; ?>

	</div>

	<?php
	echo $field_type_object->_desc( true );
}
add_filter( 'cmb2_render_associated_itineraries', 'cmb2_render_associated_itineraries_callback', 10, 5 );
