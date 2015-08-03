<div class="discover-why">
	<div class="discover-why-cta">
		<span class="h2">Discover why 2 million travelers choose to travel with WorldStrides each year</span>
		<button class="btn btn-primary">Discover Why</button>
	</div>
	<?php
	$options = get_option( 'ws_options' );

	$background = $options['discovery_why_image']; // can use image_id to get id
	?>
	<div class="discover-why-img" style="background-image:<?php echo ' url(' . $background . ')'; ?>;">

	</div>
</div>