<?php
/**
 * 
 * Modal that will pop up for our Middle School Washington DC contest
 * 
 */

if( !isset( $_COOKIE['ws_dc'] ) ) : ?>

<div id="dc-modal" class="modal fade" tabindex="-1" style="margin-top: 75px">
    <div class="modal-dialog">
        <div class="modal-content dc-modal-content" style="border: black !important; border-style: solid !important; border-width: 5px !important;">
            <div class="modal-header" style="background: url('https://dev.worldstrides.com/wp-content/uploads/2016/04/dcpic_notext.jpg'); background-repeat: round; width:100%;">
                <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="color: white; margin-top: 40%;">Win a trip to Washington DC for you and 10 of your students!</h3>
            </div>
            <div class="modal-body" style="text-align: center">
                <p>We're giving away a trip for you and 10 of your students to Washington D.C. Sign up below to enter for a chance to win the trip of a lifetime!</p>
                <script src="//app-sjg.marketo.com/js/forms2/js/forms2.min.js"></script>
                <form id="mktoForm_2104" style="width:100% !important"></form>
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
