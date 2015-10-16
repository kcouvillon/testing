/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// MAPBOX MAPS

	$(document).ready(function() {

		if ( $('#office-map').length > 0 ) {

			L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';
			
			var map = L.mapbox.map('office-map', 'worldstrides.b898407f', {
					scrollWheelZoom: false,
					zoomControl: false,
					center: [38.030266, -78.48363499999999],
					zoom: 13
				}),
				data = JSON.parse( $('#offices-json').text() ),
				collection = {
					"type": "FeatureCollection",
					"features": []
				},
				layer = L.mapbox.featureLayer().addTo(map),
				prefix = $('#offices-json').data('prefix');

			if ( data ) {

				$(data).each(function(){

					var lon = parseFloat(this[prefix + 'coordinates']['longitude']),
						lat = parseFloat(this[prefix + 'coordinates']['latitude']),
						point;
					
					if ( !lon || !lat ) {
						return;
					}

					point = {
					  "type": "Feature",
					  "geometry": {
					    "type": "Point",
					    "coordinates": [lon,lat]
					  },
					  "properties": {
					    "title": this.name,
					    "icon": {
				            "iconUrl": "http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin@2x.png",
				            "iconSize": [20, 60], // size of the icon
				            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
				            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
				            "className": "dot"
				        },
				        "iconHover": {
				            "iconUrl": "http://wsbeta.co/wp-content/themes/worldstrides/assets/images/pin-orange@2x.png",
				            "iconSize": [20, 60], // size of the icon
				            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
				            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
				            "className": "dot"
				        }
					  }
					};

					collection.features.push(point);
				});

				layer
					.on('layeradd', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;
					    marker.setIcon(L.icon(feature.properties.icon));
					})
					.on('mouseover', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;
					    marker.openPopup();
						marker.setIcon(L.icon(feature.properties.iconHover));
					})
					.on('mouseout', function(e) {
					    var marker = e.layer,
					        feature = marker.feature;
						marker.closePopup();
						marker.setIcon(L.icon(feature.properties.icon));
					})
				
				map.on('ready', function(){
					// console.log(map);
					// console.log(collection);
					// $(collection.features).each(function(){
					// 	console.log(this.properties.title);
					// 	console.log(this.geometry.coordinates[0]);
					// 	console.log(this.geometry.coordinates[1]);
					// 	console.log('---');
					// });
					layer.setGeoJSON(collection);
					map.fitBounds(layer.getBounds());
				});

			}
			
		}

	});

 } )( jQuery );