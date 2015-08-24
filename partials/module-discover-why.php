<?php
$options = get_option( 'ws_options' );

$background = ( isset( $options['discovery_why_image'] ) ? $options['discovery_why_image'] : '' ); // can use image_id to get id
$text = ( isset( $options['discovery_why_text'] ) ? $options['discovery_why_text'] : '' );

?>
<div class="discover-why">
	<div class="discover-why-cta">
		<span class="h2"><?php echo apply_filters( 'the_content', $text ) ?></span>
		<button class="btn btn-primary">Discover Why</button>
	</div>

	<div class="discover-why-img" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">

	</div>
</div>