/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( jQuery) {
	'use strict';

	// for one-time-modals

	wsData.incrementCookie = function(cookiename) {
		var currentcookie = wsData.getCookie(cookiename);
		if ( "" === currentcookie || isNaN( parseInt(currentcookie)) ) {
			return wsData.setCookie(cookiename,1);
		} else {
			return wsData.setCookie(cookiename,parseInt(currentcookie)+1);
		}
	}

	wsData.setCookie = function(cookiename,cvalue,exyears) {
		exyears = typeof exyears !== 'undefined' ?  exyears : 10;
	    var d = new Date();
	    d.setTime(d.getTime() + (exyears*365*24*60*60*1000));
	    var expires = "expires="+d.toUTCString();
	    document.cookie = cookiename + "=" + cvalue + "; " + expires;
	    return cvalue;
	}

	wsData.getCookie = function(cookiename) {
	    var name = cookiename + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
	    }
	    return "";
	}

	wsData.debugCookie = function(cookiename) {
		console.log('DEBUG: Cookie ' + cookiename + ' is: ' + wsData.getCookie(cookiename));
	}

 } )( jQuery );