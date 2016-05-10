<?php
/**
 *
 * This modal will pop up on custom pages to allow the user to sign up for the info session. 
 *
 */
?>

<div id="info-modal" class="modal fade" tabindex="-1" style="margin-top: 75px; z-index: 9000">
    <div class="modal-dialog info-session-size">
        <div class="modal-content dc-modal-content" style="border: black !important; border-style: solid !important; border-width: 5px !important;">
            <div class="modal-header" style="background: url(<?php echo site_url() . "/wp-content/uploads/2016/05/popup-2.jpg"; ?>); background-repeat: round; width:100%;">
                <button type="button" class="close" data-keyboard="true" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="color: white; margin-top: 40%;">Sign up for our Info Session to stay connected and recieve updates!</h3>
            </div>
            <div class="modal-body" style="text-align: center">
                <script src="//app-sjg.marketo.com/js/forms2/js/forms2.min.js"></script>
                <form id="mktoForm_2126"></form>
                <script>MktoForms2.loadForm("//app-sjg.marketo.com", "593-ASZ-675", 2126);</script>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->