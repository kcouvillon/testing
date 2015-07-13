<?php
/**
 * Module: Contact
 */

// @todo this is the same content that appears on other pages, where is it coming from?

$classes = 'contact-sidebar';

if( is_page( 'resource-center' ) || is_page( 'register' ) || is_page( 'make-a-payment' ) || is_post_type_archive( 'resource' ) || is_singular( 'resource' ) || is_tax( 'resource-target' ) ) {
	$classes = 'contact-sidebar wide';
}

?>

<aside class="<?php echo $classes; ?>">
	<h2>Contact us</h2>

	<div class="phone">
		<h3>Phone</h3>
		<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
	</div>

	<div class="email">
		<h3>Email</h3>
		<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
	</div>

	<div class="chat">
		<h3>Live Chat</h3>
		<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
	</div>
</aside>