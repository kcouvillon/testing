<?php 
 /**
  * Modal window that appears once to welcome users -- checks a cookie to avoid reappearing.
  */

if( !isset( $ws_welcome_cookie ) && !isset( $_COOKIE['ws_welcome_cookie'] ) ) : ?>

<div id="welcome-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php _e( 'Welcome to WorldStrides!', 'worldstrides' ); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php _e( 'WorldStrides is proud to announce its newly redesigned website. ', 'worldstrides' ); ?></p>
        <p><?php _e( 'Here you will find everything you are looking for in one place, ', 'worldstrides' ); ?></p>
        <p><?php _e( 'and what a beautiful new place it is! ', 'worldstrides' ); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"><?php _e( 'Tell Me More', 'worldstrides' ); ?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Got It', 'worldstrides' ); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#welcome-modal').modal('toggle');
	});
</script>

 <?php
endif;