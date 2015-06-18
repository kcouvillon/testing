<?php
/**
 * Default content display
 */
?>

<?php
if( has_post_thumbnail( $post->ID ) ) {
	$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	$background = 'linear-gradient( rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22) ), url('. $featured[0] .')';
}
?>

<section class="primary-section">
	<header class="section-header" style="background-image: <?php echo $background; ?>;">
		<div class="section-header-content">
			<h1 class="page-title section-title">Why Travel With WorldStrides?</h1>
			<?php the_content(); ?>
		</div>
	</header>

	<nav class="section-nav">
		<ul class="section-menu">
			<li><a href="#trust">Trust</a></li>
			<li><a href="#service">World-Class Service</a></li>
			<li><a href="#quality">Quality with a Purpose</a></li>
			<li><a href="#excellence">Educational Excellence</a></li>
		</ul>
	</nav>
</section>

<section>
	<a name="trust"></a>
	<header class="section-header" style="background-image: <?php echo $background; ?>;">
		<div class="section-header-content">
			<h1 class="page-title section-title">Trust</h1>
			<p>We've been a leader in educational travel for the past 50 years - taking students of all ages around the globe, and into some of the most important learning adventures of their lives. Our parents, teachers, professors and college administrators give us consistently high ratings for our proven safety process and policies. And we back our travelers with the best insurance coverage in the business.</p>
		</div>
	</header>

	<div class="section-content why-content">
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
	</div>
</section>

<section>
	<a name="service"></a>
	<header class="section-header" style="background-image: <?php echo $background; ?>;">
		<div class="section-header-content">
			<h1 class="page-title section-title">World-Class Service</h1>
			<p>We've been a leader in educational travel for the past 50 years - taking students of all ages around the globe, and into some of the most important learning adventures of their lives. Our parents, teachers, professors and college administrators give us consistently high ratings for our proven safety process and policies. And we back our travelers with the best insurance coverage in the business.</p>
		</div>
	</header>

	<div class="section-content why-content">
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
	</div>
</section>

<section>
	<a name="quality"></a>
	<header class="section-header" style="background-image: <?php echo $background; ?>;">
		<div class="section-header-content">
			<h1 class="page-title section-title">Quality with a Purpose</h1>
			<p>We've been a leader in educational travel for the past 50 years - taking students of all ages around the globe, and into some of the most important learning adventures of their lives. Our parents, teachers, professors and college administrators give us consistently high ratings for our proven safety process and policies. And we back our travelers with the best insurance coverage in the business.</p>
		</div>
	</header>

	<div class="section-content why-content">
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
	</div>
</section>

<section>
	<a name="excellence"></a>
	<header class="section-header" style="background-image: <?php echo $background; ?>;">
		<div class="section-header-content">
			<h1 class="page-title section-title">Educational Excellence</h1>
			<p>We've been a leader in educational travel for the past 50 years - taking students of all ages around the globe, and into some of the most important learning adventures of their lives. Our parents, teachers, professors and college administrators give us consistently high ratings for our proven safety process and policies. And we back our travelers with the best insurance coverage in the business.</p>
		</div>
	</header>

	<div class="section-content why-content">
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
		<div class="value-prop">
			<img class="value-prop-img" src="http://placehold.it/300x300" alt="">
			<span class="value-prop-title">We're On It.</span>
			<p class="value-prop-desc">In-house risk-management team and proven, formalized policies, including contingency/emergency plans.</p>
		</div>
	</div>
</section>