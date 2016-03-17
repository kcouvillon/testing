/**
 *
 * Cookie to grab first URL
 *
 */

( function( jQuery) {
    'use strict';
    //Wrap in if cookie does not exist block

    wsData.ppcCookie = function (url){
        if (!Cookies.get('ws_first_url')){
            return Cookies.set('ws_first_url',url, {expires:30});
        }
    }

} )( jQuery );