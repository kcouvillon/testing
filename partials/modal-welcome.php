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
        <h4 class="modal-title"><?php _e( 'Welcome to our new website!', 'worldstrides' ); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php _e( 'Every single page is designed to do one thing: ', 'worldstrides' ); ?>
        <?php _e( 'Bring you closer to the most unforgettable educational ', 'worldstrides' ); ?>
        <?php _e( 'travel experience of your life. ', 'worldstrides' ); ?></p>
      </div>
      <div class="modal-footer">
      	<span id="tellMeSpinnerSpan">   </span>
        <a id="tellMeLink" href="/2015/10/worldstrides-newly-redesigned-website/" role="button" class="btn btn-primary"><?php _e( 'Learn More', 'worldstrides' ); ?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Let&apos;s go!', 'worldstrides' ); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG; ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
    <?php if ( $debug ) : ?>
      console.log('DEBUG: Before drop/increment ws_welcome_cookie');
      wsData.debugCookie('ws_welcome_cookie');
    <?php endif; ?>

    wsData.incrementCookie('ws_welcome_cookie');

    <?php if ( $debug ) : ?>
      console.log('DEBUG: After drop/increment ws_welcome_cookie');
      wsData.debugCookie('ws_welcome_cookie');
    <?php endif; ?>

		jQuery('#welcome-modal').modal('toggle');
		jQuery('#tellMeLink').click(function(){
			var tellMeSpinner = new Spinner(wsData.spinnerParams);
			jQuery('#tellMeSpinnerSpan').after(tellMeSpinner.spin().el);
		});
	});
</script>

 <?php
endif;