<?php
/**
 * Content display for default blog pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_page( 'about') ) : ?>
	<header class="entry-header row">
		<h1 class="entry-title col-md-offset-1 col-md-10">
			<?php the_title(); ?>
		</h1>
	</header>
	<?php endif; ?>

	<div class="entry-content row">
		<div class="col-md-6 col-md-offset-1">
			<?php the_content(); ?>
		</div>
	</div>

	<footer class="entry-footer">
		<div class="request-form">
			<h2>Request Information about a WorldStrides Trip</h2>
		</div>
		<div class="row">
			<article class="post col-md-4 col-md-offset-1">
				<h2><a href="#">Previous Post</a></h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at porttitor sem. Aliquam erat volutpat. Donec placerat nisl magna.</p>
			</article>
			<article class="post col-md-4 col-md-offset-2">
				<h2><a href="#">Next Post</a></h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at porttitor sem. Aliquam erat volutpat. Donec placerat nisl magna.</p>
			</article>
		</div>
	</footer>
</article>