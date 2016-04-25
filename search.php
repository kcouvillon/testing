<?php
/**
 * This is actually the main blog page. Please see front-page.php for the traditional 'home' page
 */

$recent_highlights = WS_Helpers::get_blog_sidebar_posts();

get_header();

$post_type = get_query_var( 'post_type' );
if ( 'post' == $post_type ) {
	$stories = true;
	$search_title = 'Stories';
} else {
	$stories = false;
	$search_title = 'All WorldStrides';
}

 
?>


<script type="text/javascript">
var pageNum = 1;

jQuery(document).ready(function() {
    jQuery(".pr-review-wrap").remove();
    jQuery(".pr-contents").remove();
    jQuery(".pr-review-sort").remove();
    jQuery(".pr-snapshot-consensus").remove();
    jQuery('[id=pr-snapshot-histogram]').remove();
    jQuery('div.pr-review-engine-max-width-560px').removeClass('pr-review-engine-max-width-560px'); 

});

	function DoBlockUI(msg) {
	    jQuery.blockUI({
	        css: {
	            border: 'none',
	            padding: '25px',
	            fontSize: '20pt',
	            backgroundColor: '#000',
	            '-webkit-border-radius': '10px',
	            '-moz-border-radius': '10px',
	            'border-radius': '10px',
	            opacity: .7,
	            color: '#fff'
	        },
	        message: msg
	    });
	}

	function pager(page) {
	    pageNum = page;
	    DoBlockUI('Loading results...');
	    jQuery.ajax({
	        url: "#",
	        type: 'post',
	        data: { "pager": page },
	        success: function (response) {
	            jQuery('.search-wrap').html(jQuery(response).find('.search-wrap').html());
	            jQuery.unblockUI();
	        },
	        error: function (jqXHR, textStatus, errorThrown) {
	            jQuery.unblockUI();
	            console.log(textStatus, errorThrown);
	        }
	    });
	}

</script>

<div id="primary" class="content-area">
	<main id="main" class="site-main search" role="main">

		<section class="search-header section-header">
			<div class="ws-container">
			
				<form role="search" method="get" class="search-results-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<i class="icon icon-search"></i>
					<input type="search" class="search-field" placeholder="<?php the_search_query(); ?>" value="" name="s" title="Search for:">
					<div class="search-options">
						<span>All of WorldStrides</span>
						<input type="radio" name="post_type" class="search-radio" value="all"<?php if ( ! $stories ) { echo ' checked="checked" '; } ?>>
						<span>Stories</span>
						<input type="radio" name="post_type" class="search-radio" value="post" <?php if ( $stories ) { echo ' checked="checked" '; } ?>>
					</div>
				</form>

			</div>
			
		</section>

		<div class="search-wrap">

			<section>
			<?php if ( ws_custom_exists() ) : ?>

				<h3 class="search-results-title"><span class="search-query"><?php the_search_query(); ?></span> in <?php echo $search_title; ?></h3>

				<?php /* Start the Loop */ ?>

                <?php
                      //Custom Search
                      foreach( ws_custom_search() as $row ) {
                          setup_postdata($row);
                          include 'partials/content-search.php';
                      }
                ?>

				<!-- echo paginate_links( get_pagination() ); -->
                
                <!-- Custom Paging -->
                <div id="divPager">
                    <?php echo get_pager() ?>
                </div>
                <!-- End Custom Paging -->

			<?php else : ?>

				<span class="h3">Sorry, we couldn't find anything. Try another search term or use the Explore links.</span>

			<?php endif; ?>

			</section>

            <aside class="sidebar" style="position:relative;">

				<?php get_template_part( 'partials/content', 'blog-sidebar-search-tags' ); ?>

			</aside>

		</div>

		<!--<section class="clearfix ws-container learn-more">
				<form action="#" class="ws-form">
					<div class="left">
						<h2 class="form-title">Ready to Learn More About Traveling with WorldStrides?</h2>
						<ul class="form-fields list-unstyled">
							<li class="field">
								I am an
								<select name="name">
									<option value="">Educator</option>
									<option value="">Parent</option>
									<option value="">Student</option>
								</select>
							</li>
							<li class="field">
								Interested in
								<select name="name">
									<option value="">Middle School Travel</option>
									<option value="">High School Travel</option>
									<option value="">University Travel</option>
								</select>
							</li>
							<li class="field">
								Do you have a tour scheduled?
								&nbsp;&nbsp;
								<input type="radio" name="tour" id="tour-yes" value="yes" />
								<label for="tour-yes">Yes</label>
								&nbsp;
								<input type="radio" name="tour" id="tour-no" value="no" />
								<label for="tour-no">No</label>
							</li>
						</ul>
					</div>
					<div class="right">
						<ul class="form-fields list-unstyled">
							<li class="field field-complex">
								<div class="field-left">
									<input type="text" name="first_name" value="" placeholder="First Name" />
								</div>
								<div class="field-right">
									<input type="text" name="last_name" value="" placeholder="Last Name" />
								</div>
							</li>
							<li class="field">
								<input type="email" name="email" value="" placeholder="Email Address" />
							</li>
							<li class="field">
								<input type="tel" name="phone" value="" placeholder="Phone Number" />
							</li>
							<li class="field">
								<input type="text" name="group_name" value="" placeholder="School or Group Name" />
							</li>
						</ul>
						<input type="submit" name="" value="Get Info" class="btn btn-primary" />
					</div>
				</form>
		</section>-->

	</main>
</div>

  <div id="feature-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Trip Features</h4>
        </div>
        <div class="modal-body">
            <div style="height: 300px; width: 100%; z-index:2; position: relative;" class="hide-print">
	            <div id="tour-highlights-map"><!-- MAP - check assets/js/src/itinerary.js for map code --></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



<?php get_footer(); ?>
