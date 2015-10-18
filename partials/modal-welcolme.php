<?php 
 /**
  * Modal window that appears once to welcome users -- cookies user to avoid reappearing.
  */


$ws_welcome_cookie = setcookie( 'ws_welcome_cookie', true, time() + 60*60*24*365*10, '/' );

?>
	<div>
		<h2>TEST OUTSIDE IF</h2>
	</div>
<?php

if( !isset( $ws_welcome_cookie ) && !isset( $_COOKIE['ws_welcome_cookie'] ) ) : ?>

	<div>
		<h2>TEST INSIDE IF</h2>
	</div>

 <?php
endif;