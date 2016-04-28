<?php
/**
 * 
 * Modal that will pop up for our Middle School Washington DC contest
 * 
 */

if( !isset( $_COOKIE['ws_dc'] ) ) : ?>

<div id="dc-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img>
            </div>
            <div class="modal-body">
                <script src="//app-sjg.marketo.com/js/forms2/js/forms2.min.js"></script>
                <form id="mktoForm_2104"></form>
                <script>MktoForms2.loadForm("//app-sjg.marketo.com", "593-ASZ-675", 2104);</script>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        //Display DC Contest Window
        jQuery('#dc-modal').modal('toggle');
        //Test if ws_dc cookie is set, if not set it to expire in 1 day
        if (!Cookies.get('ws_dc')){
            Cookies.set('ws_dc', '1', { expires: 1 });
        }
    });

</script>
