<?php
/**
 * 
 * Modal that will pop up for our Middle School Washington DC contest
 * 
 */

if( !isset( $_COOKIE['ws_dc'] ) ) : ?>

<div id="dc-modal" class="modal fade" tabindex="-1" style="margin-top: 75px; z-index: 9000">
    <div class="modal-dialog">
        <div class="modal-content dc-modal-content" style="border: black !important; border-style: solid !important; border-width: 5px !important;">
            <div class="modal-header" style="background: url('https://worldstrides.com/wp-content/uploads/2016/05/dcpic_notext.jpg'); background-repeat: no-repeat; background-size: 100% 100%; width:100%;">
                <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span id="x-button" aria-hidden="true">&times;</span></button>
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


<script src="https://www.google-analytics.com/analytics.js"></script>
<script type="text/javascript">
    //With hide.bs.moodal(triggers when modal disappears), we need to check to see if the "X" button had already been pushed
    var clicked_x = false;

    jQuery(document).ready(function(){
        //Create GA
        ga('create','UA-65576002-1');
        //Send GA Event
        ga('send', 'event', 'Pop Ups', 'Appears', 'Contest');
        //Display DC Contest Window
        jQuery('#dc-modal').modal('toggle');
        //Test if ws_dc cookie is set, if not set it to expire in 1 day
        if (!Cookies.get('ws_dc')){
            Cookies.set('ws_dc', '1', { expires: 1 });
        }

        setTimeout(function(){
            //Centering Agree to terms field - Need to delay since modal needs to pop up
            jQuery('.mktoFieldDescriptor').eq(10).addClass('mkto-center');
        },1200);

        //Send GA Event telling us the user
        jQuery('#x-button').click(function(){
            ga('send', 'event', 'Pop Ups', 'Clicks X', 'Contest');
            clicked_x = true;
        });

        jQuery('#dc-modal').on('hide.bs.modal', function(e){
            if (!clicked_x){
                ga('send', 'event', 'Pop Ups', 'Clicks Backdrop', 'Contest');
            }

        });

    });
</script>
<?php endif; ?>