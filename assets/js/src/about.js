/**
 * Created by LoganK on 4/21/2016.
 */

( function( $, window, undefined ) {

    'use strict';

    jQuery(document).ready(function(){
        //Hide all Groups when page loads
        jQuery('#organization-bios').hide();
        jQuery('#programs-regions-bios').hide();
        jQuery('#support-bios').hide();
    });

    jQuery('#group1').click(function(){
        //Show Organization group and hide others
        jQuery('#programs-regions-bios').hide(1000);
        jQuery('#support-bios').hide(1000);
        jQuery('#organization-bios').show(1000);
    });

    jQuery('#group2').click(function(){
        //Show Programs and Regions group and hide others
        jQuery('#organization-bios').hide(1000);
        jQuery('#support-bios').hide(1000);
        jQuery('#programs-regions-bios').show(1000);
    });

    jQuery('#group3').click(function(){
        //Show Programs and Regions group and hide others
        jQuery('#organization-bios').hide(1000);
        jQuery('#programs-regions-bios').hide(1000);
        jQuery('#support-bios').show(1000);
    });

})(jQuery,window);
