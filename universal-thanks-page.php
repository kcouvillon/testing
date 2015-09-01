<?php
/*
* Template Name: thanks page
* 
* Google Analytics goal page for all thank-yous.  This page receives variables as POST and forwards them to Marketo
*/
?>
<?php // get_header(); // TODO: reinstate this once it's wired up properly ?>
<h1>Thanks for your Interest in WorldStrides</h1>
<p>&nbsp;</p>
<p>POST VARIABLES RECEIVED:</p>
<pre>
<?php 
	print_r($_POST);
?>
</pre>
<?php // get_footer(); // TODO: reinstate this once it's wired up properly ?>
