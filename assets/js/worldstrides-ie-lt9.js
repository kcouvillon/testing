document.onreadystatechange = function () {
	'use strict';
    if (document.readyState === "complete") {
	var iediv = document.createElement('<div id="iediv"></div>');
	var ielt9popupimg = document.createElement('<img id="ielt9popupimg" usemap="#iemap">');
	var iemap = document.createElement('<map id="iemap" name="iemap"></map>');
	var iemapChromeArea = document.createElement('<area shape="rect" alt="Get Chrome" coords="32,316,274,376">');
	iemapChromeArea.href = 'https://www.google.com/intl/en/chrome/browser/desktop/index.html';
	var iemapIeArea = document.createElement('<area shape="rect" alt="Get IE" coords="32,386,274,446">');
	iemapIeArea.href = 'http://windows.microsoft.com/en-us/internet-explorer/download-ie';
	var iemapFirefoxArea = document.createElement('<area shape="rect" alt="Get Firefox" coords="32,456,274,516">');
	iemapFirefoxArea.href = 'https://www.mozilla.org/en-US/firefox/new/';
	var iemapCloseArea = document.createElement('<area id="iemapCloseArea" shape="rect" alt="close" coords="262,12,282,32" href="#">');

	iediv.appendChild(iemap);
	iemap.appendChild(iemapChromeArea);
	iemap.appendChild(iemapIeArea);
	iemap.appendChild(iemapFirefoxArea);
	iemap.appendChild(iemapCloseArea);

	ielt9popupimg.src = '/wp-content/themes/worldstrides/assets/images/worldstrides-ie-fallback-upgrade.png';
	document.body.insertBefore(iediv, document.body.firstChild);
	iediv.appendChild(ielt9popupimg);

	iemapCloseArea.onclick = function(){
		iediv.removeChild(ielt9popupimg);
		var myNav = navigator.userAgent.toLowerCase();
		var ieversion = (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
		if( ieversion && ieversion === 7 ) {
			document.styleSheets[0].disabled = true;
		} else if( ieversion && ieversion === 8 ) {
			document.querySelectorAll('.logo')[0].style.visibility = 'visible';
			document.querySelectorAll('.mobile-hero')[0].style.visibility = 'visible';
			document.querySelectorAll('.section-header-content')[0].style.visibility = 'visible';
			document.querySelectorAll('.icon-menu')[0].style.visibility = 'visible';
			document.body.style.background = 'none';
		}
	};

	scroll(0,0);
   }
 };