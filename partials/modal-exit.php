<?php
/**
 *
 * File containing the modal that pops up when user tries to leave site
 *
 *
*/
?>
<div id="exit-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content" style="width:502px; height: 380px">
        <div class="modal-body" style="background: url('<?php echo content_url(); ?>/uploads/2016/04/popup-image.jpg'); height:303px">
            <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>SSS
        </div>
        <div class="modal-footer">
            <span id="tellMeSpinnerSpan">   </span>
            <!--<a id="tellMeLink" href="/2015/11/worldstrides-newly-redesigned-website/" role="button" class="btn btn-primary"><?php //_e( 'Learn More', 'worldstrides' ); ?></a> -->
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Thanks', 'worldstrides' ); ?></button>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
    jQuery(document).ready(function(){
        ouibounce(false,  {
            aggressive: true,
            delay: 500,
            callback: function() {
                jQuery('#exit-modal').modal('show');
                console.log("fired");
            }
        });
    });

</script>