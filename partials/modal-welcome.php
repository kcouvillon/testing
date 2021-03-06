<?php 
 /**
  * Modal window that appears once to welcome users -- checks a cookie to avoid reappearing.
  */

  if( !isset( $_COOKIE['ws_maint'] ) ) : ?>

  <div id="welcome-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?php _e( 'Planned System Maintenance Alert', 'worldstrides' ); ?></h4>
        </div>
        <div class="modal-body">
          <p>
              <?php _e( 'WorldStrides computer systems will be undergoing planned maintenance ', 'worldstrides' ); ?>
              <?php _e( 'from 6pm ET on Friday February 26th through approximately 6pm ET Sunday February 28th. ', 'worldstrides' ); ?>
              <?php _e( 'Our program registration, payment and account management systems will not be available during this timeframe. ', 'worldstrides' ); ?>
          </p>
          <p>
            <?php _e('If you’re trying to register for a trip or make a payment and have an upcoming deadline during the maintenance, don’t worry! You’ll still be able to complete the process once service is restored.' , 'worldstrides'); ?>
          </p>
          <p>
            <?php _e('We apologize for this inconvenience.', 'worldstrides'); ?>
          </p>
        </div>
        <div class="modal-footer">
        	<span id="tellMeSpinnerSpan">   </span>
          <!--<a id="tellMeLink" href="/2015/11/worldstrides-newly-redesigned-website/" role="button" class="btn btn-primary"><?php //_e( 'Learn More', 'worldstrides' ); ?></a> -->
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Thanks', 'worldstrides' ); ?></button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <?php $debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG; ?>

  <script type="text/javascript">
  	jQuery(document).ready(function() {
      //Check if cookie exists
      if (!wsData.checkCookie('ws_maint')){
        <?php if ( $debug ) : ?>
          console.log('DEBUG: Before drop/increment ws_hi');
          wsData.debugCookie('ws_hi');
          // wsData.debugCookie('ws_sessiond_hi');
        <?php endif; ?>

        wsData.dayCookie('ws_maint');
        // wsData.sessionCookie('ws_sessiond_hi');

        <?php if ( $debug ) : ?>
          console.log('DEBUG: After drop/increment ws_hi');
          wsData.debugCookie('ws_hi');
          // wsData.debugCookie('ws_sessiond_hi');
        <?php endif; ?>

    		jQuery('#welcome-modal').modal('toggle');
    		jQuery('#tellMeLink').click(function(){
    			var tellMeSpinner = new Spinner(wsData.spinnerParams);
    			jQuery('#tellMeSpinnerSpan').after(tellMeSpinner.spin().el);
    		});
      }
  	});
  </script>

   <?php
  endif;
