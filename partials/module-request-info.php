<?php
$options = get_option( 'ws_options' );

$background = ( isset( $options['request_info_image'] ) ? $options['request_info_image'] : '' ); // can use image_id to get id
$text = ( isset( $options['request_info_text'] ) ? $options['request_info_text'] : '' );

$url_params = parse_url(WS_Form::current_page_url());
if (isset($url_params['query'])){
	parse_str($url_params['query'], $uri);
}

if (isset($uri['src']) && isset($uri['wsmedium'])){
	$action_link = "/request-info/?src=" . $uri['src'] . "&wsmedium=" . $uri['wsmedium'];
}
else {
	$action_link = "/request-info/";
}

?>
<div class="blog-single-cta" style="background-image:<?php echo 'url(' . $background . ')'; ?>;">
	<span class="h2"><?php echo apply_filters( 'the_content', $text ) ?></span>
	<form id="module-request-info-form" action="<?php echo $action_link; ?>" method="post">
		<label for="selectMenu">My role is</label>
		<select id="selectMenu" name="role" title="Role">
			<option value="">Select...</option>
			<option value="Student">Student</option>
			<option value="Parent">Parent</option>
			<option value="Elementary">Elementary School Educator</option>
			<option value="Middle">Middle School Educator</option>
			<option value="High">High School Educator</option>
			<option value="Undergraduate">Undergraduate Educator</option>
			<option value="Graduate">Graduate Educator</option>
			<option value="Other">Other</option>
		</select>
		<input type="hidden" id="wsurl" name="wsurl" value="<?php echo WS_Form::current_page_url(); ?>" >
		<input type="submit" class="btn btn-primary" value="Get the Info">
	</form>
</div>