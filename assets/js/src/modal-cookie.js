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

	wsData.incrementCookie = function(cookiename,exyears) {
		exyears = typeof exyears !== 'undefined' ?  exyears : 10;
		var currentcookie = Cookies.get(cookiename);
		if ( "" === currentcookie || isNaN( parseInt(currentcookie)) ) {
			return Cookies.set(cookiename,'1',{ expires: exyears * 365 });
		} else {
			return Cookies.set(cookiename,parseInt(currentcookie)+1,{ expires: exyears * 365 });
		}
	}

	wsData.sessionCookie = function(cookiename,val) {
		val = typeof val !== 'undefined' ?  val : 'true';
		Cookies.set(cookiename, val);
	}

	wsData.debugCookie = function(cookiename) {
		console.log('DEBUG: Cookie ' + cookiename + ' is: ' + Cookies.get(cookiename));
	}

	wsData.checkCookie = function(cookiename){
		if (Cookies.get(cookiename)){
			//Cookie exists
			return true;
		}
		else {
			//Cookie does not exist
			return false;
		}

	}

	wsData.dayCookie = function(cookiename){
		var currentcookie = Cookies.get(cookiename);
		if ( "" === currentcookie || isNaN( parseInt(currentcookie)) ) {
			return Cookies.set(cookiename,'1',{ expires: 1 });
		} else {
			return Cookies.set(cookiename,parseInt(currentcookie)+1,{ expires: 1 });
		}

	}

 } )( jQuery );