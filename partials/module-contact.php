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
		<p>We can be reached via telephone at our toll-free number: 1-800-999-7676. To discuss particular programs, please visit our contact page for more information.</p>
	</div>

	<div class="email">
		<h3>Email</h3>
		<p>We're available via email at <a href="mailto:customerservice@worldstrides.org">customerservice@worldstrides.org</a>. To discuss particular programs, please visit our contact page for more information.</p>
	</div>

</aside>