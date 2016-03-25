/**
 *
 * Cookie to grab first URL
 *
 */

( function( jQuery) {
    'use strict';
   //Set cookie to grab the first URL that is visited
    jQuery(document).ready(function(){
            if (!Cookies.get('ws_first_url')){
                return Cookies.set('ws_first_url',window.location.href, {expires:30});
            }
    });


} )( jQuery );