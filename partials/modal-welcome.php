<?php 
 /**
  * Modal window that appears once to welcome users -- checks a cookie to avoid reappearing.
  */

if( !isset( $_COOKIE['ws_welcome_cookie'] ) || intval($_COOKIE['ws_welcome_cookie']) < 3 ) : ?>

<div id="welcome-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php _e( 'Welcome to WorldStrides!', 'worldstrides' ); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php _e( 'WorldStrides is proud to announce our newly redesigned website. ', 'worldstrides' ); ?></p>
        <p><?php _e( 'Here you will find everything you are looking for in one place, ', 'worldstrides' ); ?>
        <?php _e( 'and what a beautiful new place it is! ', 'worldstrides' ); ?></p>
      </div>
      <div class="modal-footer">
      	<span id="tellMeSpinnerSpan">   </span>
        <a id="tellMeLink" href="/2015/10/worldstrides-newly-redesigned-website/" role="button" class="btn btn-primary"><?php _e( 'Tell Me More', 'worldstrides' ); ?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Got It', 'worldstrides' ); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	jQuery(document).ready(function() {
    wsData.debugCookie('ws_welcome_cookie');
		jQuery('#welcome-modal').modal('toggle');
		jQuery('#tellMeLink').click(function(){
			var tellMeSpinner = new Spinner(wsData.spinnerParams);
			jQuery('#tellMeSpinnerSpan').after(tellMeSpinner.spin().el);
		});
	});
</script>

 <?php
endif;