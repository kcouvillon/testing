<?php
/*
* Template Name: thanks page
* 
* Google Analytics goal page for all thank-yous.  This page receives variables as POST and forwards them to Marketo
*/
?>
<?php get_header(); ?>

<!-- Pull in Munchkin by hand. TODO: pull this in dynamically. -->
<script type="text/javascript" src="//munchkin.marketo.net//munchkin.js"></script>
<div class="ws-container">
	<h1>Thanks for your Interest in WorldStrides</h1>
	<p>&nbsp;</p>
	<p>POST VARIABLES RECEIVED:</p>
	<pre>
	<?php 
		print_r($_POST);
	?>
	</pre>
</div>
<?php get_footer(); ?>
