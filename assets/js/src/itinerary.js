/**
 * WorldStrides
 * http://www.worldstrides.com
 *
 * Copyright (c) 2015 WorldStrides
 * Licensed under the GPLv2+ license.
 */
 
 ( function( $, window, undefined ) {
	'use strict';

	// Itineraries

	if ( $( 'body' ).hasClass('single-itinerary') ) {

		$(document).ready(function(){

			$('body')
				.on('click', '.toggle-dates', function(e){

					if ( $( '.date-list' ).hasClass( 'all-dates' ) ) {
						
						$( '.date-range.hidden-dates' ).slideUp();
						$( '.date-list' ).removeClass( 'all-dates' );
					
					} else {
				
						$( '.date-range.hidden-dates' ).slideDown();
						$( '.date-list' ).addClass('all-dates');
				
					}

					return false;
				});


			if ( $('#tour-highlights-map').length > 0 ) {

				L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';

				var init_coords = $('.tour-highlights').data('location'),
					map = L.mapbox.map('tour-highlights-map', 'worldstrides.b898407f', {
						scrollWheelZoom: false,
						zoomControl: false,
						center: [ parseFloat(init_coords.latitude), parseFloat(init_coords.longitude) ],
						zoom: 13
					});

				var marker_data = $('#tour-highlights-data').data('highlights'),
					layer = L.mapbox.featureLayer().addTo(map),
					marker_id = 0,
					$slideshow = $('.cycle-slideshow'),
					$slideshow_images = $slideshow.find('img').toArray(),
					collection = {
						"type": "FeatureCollection",
						"features": []
					};

				if ( marker_data ) {

					$(marker_data).each(function(){
						var point = {
						  "type": "Feature",
						  "geometry": {
						    "type": "Point",
						    "coordinates": [
						      parseFloat(this.itinerary_highlights_location.longitude),
						      parseFloat(this.itinerary_highlights_location.latitude)
						    ]
						  },
						  "properties": {
						  	"id": marker_id,
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

						collection.features.push( point );

						marker_id++;
					});

					layer
						.on('layeradd', function(e) {
						    var marker = e.layer,
						        feature = marker.feature;

							if ( feature.properties.id == 0 ) {
								marker.setIcon(L.icon(feature.properties.iconHover));
							} else {
								marker.setIcon(L.icon(feature.properties.icon));	
							}
						})
						.on('click', function(e){
							$slideshow.cycle( 'goto', e.layer.feature.properties.id );
						})
				
					map.on('ready', function( event ){

						layer.setGeoJSON(collection);
						setTimeout(function () {
							map.fitBounds(layer.getBounds());
							map.invalidateSize();
						}, 500);

					});

					$slideshow.on('cycle-after', function( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ){
						var marker_id = $slideshow_images.indexOf(incomingSlideEl);
						
						layer.eachLayer(function (layer) {

							if ( layer.feature.properties.id == marker_id ) {
								layer.setIcon( L.icon( layer.feature.properties.iconHover ));
							} else {
								layer.setIcon( L.icon( layer.feature.properties.icon ));
							}

						});
					});

				}
			}

		});

	}
	

 } )( jQuery );