<?php
/**
 * Content display for default blog pages
 */

$blog_type = WS_Helpers::blog_type( $post->ID );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_page( 'about' ) ) : ?>
		<header class="entry-header">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-image hero">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<ul class="breadcrumbs list-unstyled list-inline">
							<li><a href="#">Stories</a></li>
							>
							<li><a href="#"><?php echo ucwords( $blog_type ); ?></a></li>
							>
							<li><a href="#">[Month 12, 2015]</a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h1 class="entry-title">
							<?php the_title(); ?>
						</h1>
					</div>
				</div>
			</div>
		</header>
	<?php endif; ?>

	<div class="entry-body container-fluid">

		<div class="entry-content row">
			<div class="col-md-9 col-lg-7 col-md-offset-1">
				<?php the_content(); ?>
			</div>
		</div>

		<div class="entry-meta row">
			<div class="col-md-9 col-lg-7 col-md-offset-1">

				<?php $posttags = get_the_tags(); ?>
				<?php if ( $posttags ) : ?>

					<ul class="entry-tags list-unstyled list-inline">
						<?php foreach ( $posttags as $tag ) : ?>
							<li>
								<a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="btn btn-sm btn-default "><?php echo $tag->name; ?></a>
							</li>
						<?php endforeach; ?>
					</ul>

				<?php endif; ?>

			</div>
		</div>

	</div>

	<footer class="entry-footer">
		<div class="request-form belt bg-gray-base container-fluid">
			<div class="row">
				<form class="col-md-offset-1 col-md-10">
					<h2>Learn about WorldStrides Music trips to Italy</h2>
					<input type="text" class="form-control" placeholder="Name" />
					<input type="text" class="form-control" placeholder="Email Address" />
					<input type="text" class="form-control" placeholder="Phone Number" />
					<input type="submit" value="Get Info" class="btn btn-primary" />
				</form>
			</div>
		</div>
		<div class="container-fluid">
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
		</div>
	</footer>
</article>