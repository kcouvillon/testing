<?php
/**
 * Module: Contact
 */

$classes = 'contact-sidebar';

if( is_page( 'resource-center' ) || is_post_type_archive( 'resource' ) || is_singular( 'resource' ) || is_tax( 'resource-target' ) ) {
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
		<div><?php echo apply_filters( 'the_content', $phone_info ); ?></div>
	</div>

	<div class="email">
		<h3>Email</h3>
		<div><?php echo apply_filters( 'the_content', $email_info ); ?></div>
	</div>

	<?php if ( is_page( 'make-a-payment' ) || is_page( 'register' ) ) { ?>
		<p><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-info">Contact Worldstrides</a></p>
	<?php } ?>

</aside>