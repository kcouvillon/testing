<?php
/**
 * Module: Contact
 */

$classes = 'contact-sidebar';

if( is_page( 'resource-center' ) || is_page( 'register' ) || is_page( 'make-a-payment' ) || is_post_type_archive( 'resource' ) || is_singular( 'resource' ) || is_tax( 'resource-target' ) ) {
	$classes = 'contact-sidebar wide';
}

$options = get_option( 'ws_options' );

$phone_info = ( isset( $options['contact_phone_info'] ) ? $options['contact_phone_info'] : '' );
$email_info = ( isset( $options['contact_email_info'] ) ? $options['contact_email_info'] : '' );


?>

<aside class="<?php echo $classes; ?>">
	<h2>Contact us</h2>

	<div class="phone">
		<h3>Phone</h3>
		<p><?php echo apply_filters( 'the_content', $phone_info ); ?></p>
	</div>

	<div class="email">
		<h3>Email</h3>
		<p><?php echo apply_filters( 'the_content', $email_info ); ?></p>
	</div>

</aside>