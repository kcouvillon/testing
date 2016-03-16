/**
 *
 * Cookie to grab first URL
 *
 */

( function( jQuery) {
    //'use strict';

    // for one-time-modals


    wsData.ppcCookie = function (){
        return Cookies.set('ws_first_url',"future_url", {expires:30});
    }


} )( jQuery );