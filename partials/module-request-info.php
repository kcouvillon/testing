<?php
$options = get_option( 'ws_options' );

$background = ( isset( $options['request_info_image'] ) ? $options['request_info_image'] : '' ); // can use image_id to get id
?>
<div class="blog-single-cta" style="background-image:<?php echo 'url(' . $background . ')'; ?>;">
	<span class="h2">Request Information about a WorldStrides Program</span>
	<form>
		<span>I am a</span>
		<select id="selectMenu">
			<option value="/request-info/?type=parent">Parent</option>
			<option value="/request-info/?type=traveler">Traveler</option>
			<option value="/request-info/?type=teacher">Teacher</option>
		</select>
		<input type="submit" class="btn btn-primary" value="Get the Info" onclick="window.open(selectMenu.options[selectMenu.selectedIndex].value)">
	</form>
</div>