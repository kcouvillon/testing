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
        
        //Change button to "Selected" state
        jQuery(this).addClass('selected-state').removeClass('unselected-state');
        jQuery('#group2').addClass('unselected-state').removeClass('select-state');
        jQuery('#group3').addClass('unselected-state').removeClass('select-state');

        //Toggle top nav items
        jQuery('#org-img').attr('src','https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_exec_on.png');
        jQuery('#reg-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_geo_off.png');
        jQuery('#sup-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_support_off.png');
    });

    jQuery('#group2').click(function(){
        //Show Programs and Regions group and hide others
        jQuery('#organization-bios').hide(1000);
        jQuery('#support-bios').hide(1000);
        jQuery('#programs-regions-bios').show(1000);

        //Change button to "Selected" state
        jQuery('#group1').addClass('unselected-state').removeClass('select-state');
        jQuery(this).addClass('select-state').removeClass('unselected-state');
        jQuery('#group3').addClass('unselected-state').removeClass('select-state');
        
        //Toggle top nav items
        jQuery('#org-img').attr('src','https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_exec_off.png');
        jQuery('#reg-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_geo_on.png');
        jQuery('#sup-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_support_off.png');
    });

    jQuery('#group3').click(function(){
        //Show Programs and Regions group and hide others
        jQuery('#organization-bios').hide(1000);
        jQuery('#programs-regions-bios').hide(1000);
        jQuery('#support-bios').show(1000);

        //Change button to "Selected" state
        jQuery('#group1').addClass('unselected-state').removeClass('select-state');
        jQuery('#group2').addClass('unselected-state').removeClass('select-state');
        jQuery(this).addClass('select-state').removeClass('unselected-state');
        
        //Toggle top nav items
        jQuery('#org-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_exec_off.png');
        jQuery('#reg-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_geo_off.png');
        jQuery('#sup-img').attr('src', 'https://dev.worldstrides.com/wp-content/uploads/2016/05/icon_lead_support_on.png');
    });

})(jQuery,window);
