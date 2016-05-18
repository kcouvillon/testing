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

		if ( $('.office-map, .locations-map').length > 0 ) {

			L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';
			
			var map = L.mapbox.map('ws-map', 'worldstrides.b898407f', {
					scrollWheelZoom: false,
					zoomControl: false,
					center: [38.030266, -78.48363499999999],
					zoom: 13
				}),
				data = JSON.parse( $('#map-json').text() ),
				formattedData = [],
				collection,
				layer = L.mapbox.featureLayer().addTo(map),
				prefix = $('#map-json').data('prefix');

			if ( data ) {

				if ( $('.locations-map').length > 0 ) { // Locations map uses a different field type
					$(data).each(function(){
						formattedData.push({
							name: this[0],
							latitude:  this[1],
							longitude: this[2]
						});
					});
				} else {
					$(data).each(function(){
						formattedData.push({
							name: this.name,
							latitude:  this[prefix + 'coordinates']['latitude' ],
							longitude: this[prefix + 'coordinates']['longitude']
						});
					});
				}

				collection = makeGeoJSON(formattedData);

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
					layer.setGeoJSON(collection);
					map.fitBounds(layer.getBounds());
				});

			}
			
		}

	});

	function makeGeoJSON(data) {
		var collection = {
			"type": "FeatureCollection",
			"features": []
		};

		if ( !data )
			return collection;

		$(data).each(function(){

			var lon = parseFloat( this.longitude ),
				lat = parseFloat( this.latitude  ),
				point;
			
			if ( !lon || !lat ) {
				return;
			}

			point = {
			  "type": "Feature",
			  "geometry": {
			    "type": "Point",
			    "coordinates": [ lon, lat ]
			  },
			  "properties": {
			    "title": this.name,
			    "icon": {
		            "iconUrl": "https://worldstrides.com/wp-content/themes/worldstrides/assets/images/pin@2x.png",
		            "iconSize": [20, 60], // size of the icon
		            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
		            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
		            "className": "dot"
		        },
		        "iconHover": {
		            "iconUrl": "https://worldstrides.com/wp-content/themes/worldstrides/assets/images/pin-orange@2x.png",
		            "iconSize": [20, 60], // size of the icon
		            "iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
		            "popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
		            "className": "dot"
		        }
			  }
			};

			collection.features.push(point);
		});

		return collection;
	}

 } )( jQuery );