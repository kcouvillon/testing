<?php
$options = get_option( 'ws_options' );

$background = ( isset( $options['discovery_why_image'] ) ? $options['discovery_why_image'] : '' ); // can use image_id to get id
$text = ( isset( $options['discovery_why_text'] ) ? $options['discovery_why_text'] : '' );

?>
<div class="discover-why">
	<div class="discover-why-cta">
		<span class="h2"><?php echo apply_filters( 'the_content', $text ) ?></span>
		<a href="<?php echo esc_url( home_url( '/why-worldstrides/' ) ); ?>" class="btn btn-primary">Discover Why</a>
	</div>

	<?php if ( $background ) : ?>
		<div class="discover-why-img" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">
	<?php endif; ?>

	</div>
</div>