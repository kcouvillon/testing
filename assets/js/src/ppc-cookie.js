/**
 *
 * Cookie to grab first URL
 *
 */

( function( jQuery) {
    'use strict';

    wsData.ppcCookie = function (url){
        return Cookies.set('ws_first_url',url, {expires:30});
    }

} )( jQuery );