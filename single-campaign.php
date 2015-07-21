<?php
/**
 * Default terminal page, used by blog posts and another post type that doesn't have their own single
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<?php  
				$background = '';
				if ( has_post_thumbnail() ) {
					$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'hero' );
					$background = 'background-image: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ), url(' . $featured[0] . ')';
				}
			?>

			<section class="section-header primary-section pattern-1" style="background-image: <?php echo $background; ?>;">

				<div class="section-header-content">
					<h1><?php echo get_the_title(); ?></h1>
					<?php the_content(); ?>
				</div>

			</section>

			<div class="campaign-single-wrap">				

				<div class="campaign-single-content left">
					<h2>We’re Psyched You Want To Refer Your Friends!</h2>
					<p>Each Referral you make gets you a <strong>$25 Visa Gift Card</strong> (up to five referrals). Plus, we’ll automatically enter you into <strong>our weekly drawing for a $250 cash reward</strong>. Watch your email later this week to see who’s winning!</p>
					<p>Tell us a little bit about yourself, and then start referring. You’ll have the option to enter as many as you’d like.</p>
				</div>

				<div class="campaign-single-content right">
					
					<form class="ws-form">
						<ul class="ws-form-fields list-unstyled">
							<li class="field field-complex">
								<div class="field-left">
									<input type="text" name="" value="" placeholder="First Name">
								</div>
								<div class="field-right">
									<input type="text" name="" value="" placeholder="Last Name">
								</div>
							</li>
							<li class="field">
								<input type="email" name="" value="" placeholder="Email Address">
							</li>
							<li class="field">
								<input type="text" name="" value="" placeholder="Field Name">
							</li>
							<li class="field">
								<input type="text" name="" value="" placeholder="Field Name">
							</li>
						</ul>
						<input type="submit" name="" value="Submit and Refer Again!" class="btn btn-primary">
					</form>

					<h2>We’re Psyched You Want To Refer Your Friends!</h2>
					<p>Each Referral you make gets you a <strong>$25 Visa Gift Card</strong> (up to five referrals). Plus, we’ll automatically enter you into <strong>our weekly drawing for a $250 cash reward</strong>. Watch your email later this week to see who’s winning!</p>
					<p>Tell us a little bit about yourself, and then start referring. You’ll have the option to enter as many as you’d like.</p>
				
				</div>

			</div>
			<!-- campaign-single-wrap -->

			<?php endwhile; ?>

		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
