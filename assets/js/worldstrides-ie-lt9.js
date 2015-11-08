document.onreadystatechange = function () {
	'use strict';
    if (document.readyState === "complete") {
	var iediv = document.createElement('<div id="iediv"></div>');
	var ielt9popupimg = document.createElement('<img id="ielt9popupimg" usemap="#iemap">');
	var iemap = document.createElement('<map id="iemap" name="iemap"></map>');
	var iemapChromeArea = document.createElement('<area shape="rect" alt="Get Chrome" coords="32,316,274,376" href="https://www.google.com/intl/en/chrome/browser/desktop/index.html">');
	var iemapIeArea = document.createElement('<area shape="rect" alt="Get IE" coords="32,386,274,446" href="">');
	var iemapFirefoxArea = document.createElement('<area shape="rect" alt="Get Firefox" coords="32,456,274,516" href="">');

	iediv.appendChild(iemap);
	iemap.appendChild(iemapChromeArea);
	iemap.appendChild(iemapIeArea);
	iemap.appendChild(iemapFirefoxArea);

	ielt9popupimg.src = '/wp-content/themes/worldstrides/assets/images/worldstrides-ie-fallback-upgrade.png';
	document.body.insertBefore(iediv, document.body.firstChild);
	iediv.appendChild(ielt9popupimg);
   }
 };