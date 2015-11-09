<?php
$options = get_option( 'ws_options' );

$background = ( isset( $options['request_info_image'] ) ? $options['request_info_image'] : '' ); // can use image_id to get id
$text = ( isset( $options['request_info_text'] ) ? $options['request_info_text'] : '' );
?>
<div class="blog-single-cta" style="background-image:<?php echo 'url(' . $background . ')'; ?>;">
	<span class="h2"><?php echo apply_filters( 'the_content', $text ) ?></span>
	<form id="module-request-info-form" action="/request-info/" method="post">
		<label for="selectMenu">My role is</label>
		<select id="selectMenu" name="role" title="Role">
			<option value="">Select...</option>
			<option value="Student">Student</option>
			<option value="Parent">Parent</option>
			<option value="Elementary">Elementary&nbsp;School&nbsp;Educator</option>
			<option value="Middle">Middle&nbsp;School&nbsp;Educator</option>
			<option value="High">High&nbsp;School&nbsp;Educator</option>
			<option value="Undergraduate">Undergraduate&nbsp;Educator</option>
			<option value="Graduate">Graduate&nbsp;Educator</option>
			<option value="Other">Other</option>
		</select>
		<input type="hidden" id="wsurl" name="wsurl" value="<?php echo WS_Form::current_page_url(); ?>" >
		<input type="submit" class="btn btn-primary" value="Get the Info">
	</form>
</div>