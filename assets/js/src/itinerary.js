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

	var map,
		layer,
        style,
        pointsAdded,
        polyline,
		init_coords,
		marker_data,
		$slideshow,
		$slideshow_images,
        lastLine,
		sizeInvalidated = false;

	if ($('body').hasClass('single-itinerary') || $('body').hasClass('single-custom-page')) {

		L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';

		$(document).ready(function(){

			// Browser events
			$('body')
				.on('click', '.toggle-dates', function(e){
					if ( $( '.date-list' ).hasClass('all-dates') ) {
						$( '.date-range.hidden-dates' ).slideUp();
						$( '.date-list' ).removeClass('all-dates');
					} else {
						$( '.date-range.hidden-dates' ).slideDown();
						$( '.date-list' ).addClass('all-dates');
					}
					return false;
				})
				.on('click', 'a.slide-toggle', function(e){
					var $this = $( this ),
						target = $( $this.attr('href') ),
						$target = $( target );

					if ( $this.hasClass('active') ) {
						$this.removeClass('active');
						$target.slideUp(300);
						$this.text('Details');
					} else {
						$this.addClass('active');
						$target.slideDown(300);
						$this.text('Close');
					}
					return false;
				});


			if ( $('#tour-highlights-map').length > 0 ) {

				// Assign variables
				init_coords = $('.tour-highlights').data('location'),
					marker_data = $('#tour-highlights-data').data('highlights'),
					$slideshow = $('.tour-highlights-slider').cycle({ delay: 5000, timeout: 10000 }).on('cycle-before', cycleBefore)
					$slideshow_images = $slideshow.find('img').toArray();

				if ( marker_data ) {

					// Format marker data into geoJSON
					var collection = returnGeoJSON( marker_data );

					// Setup Map and Layer
					map = L.mapbox.map('tour-highlights-map', 'worldstrides.b898407f', {
						scrollWheelZoom: false,
						dragging: false,
						zoomControl: false,
						center: [ parseFloat(init_coords.latitude), parseFloat(init_coords.longitude) ],
						zoom: 13
					});
					layer = L.mapbox.featureLayer(collection).addTo(map);
					style = L.mapbox.styleLayer('mapbox://styles/worldstrides/cim6du4a000m39jm0ohknvp13').addTo(map);
					// Map Events
					map
						.on('ready resize', function(){
							map.invalidateSize();
							map.fitBounds( layer.getBounds(), { padding: [ 30, 30 ], maxZoom: 16 } );
						});

					// Layer Events
					layer
						.on('layeradd', function(e) {
							var marker = e.layer,
								feature = marker.feature;

							if (feature.properties.id == 0) {
							    marker.setIcon(L.icon(feature.properties.iconHover));
							    
							} else {
								marker.setIcon(L.icon(feature.properties.icon));
							}
						})
						.on('click', function(e){
							$slideshow.cycle( 'goto', e.layer.feature.properties.id );
						});

					    // create a new empty polyline array
					    polyline = L.polyline([]).addTo(map);

                        // look through each layer, find the first one and save its coordinates for use later
					    layer.eachLayer(function (layer) {

					        if (layer.feature.properties.id == 0) {
					            //set USA as starting point
					            polyline.addLatLng([39.0997265, -94.57856670000001]);

                                // add the first destination in and save it for use later
					            polyline.addLatLng(layer.getLatLng());
					            lastLine = layer.getLatLng();

                                // set the first destination icon to active
					            layer.setIcon(L.icon(layer.feature.properties.iconHover));

					        } else {
					            layer.setIcon(L.icon(layer.feature.properties.icon));
					        }
					    });


				}
			}

		});

	}

	if ($('body').hasClass('search-results') || $('body').hasClass('search-no-results')) {

		L.mapbox.accessToken = 'pk.eyJ1Ijoid29ybGRzdHJpZGVzIiwiYSI6ImNjZTg3YjM3OTI3MDUzMzlmZmE4NDkxM2FjNjE4YTc1In0.dReWwNs7CEqdpK5AkHkJwg';

		$(document).ready(function () {

			$(document).on('click', '#lnkShowMap', function () {
				return showMap($(this).data('showmap'), $(this).data('imagemap'));
			});
		});
	}

	function showMap(mapSectionName, mapImageName) {

		// remove map in case it already exists
		if (map != undefined) { map.remove(); map = undefined; }
		// remove image in case it already exists
		$('#tour-highlights-map').attr('style', 'background-image: none; background-repeat:no-repeat;');

		// check if custom map image exists and display it if so, otherwise fallback to the old mapbox api call
		$.get('./maps/maps_' + mapImageName + '.gif').done(function () {

			// load image into background
			$('#tour-highlights-map').attr('style', 'background-image: url("./maps/maps_' + mapImageName + '.gif"); background-repeat:no-repeat;');

		}).fail(function () {

			if ($('#tour-highlights-map').length > 0) {
				// Assign variables
				init_coords = $('#result-map-' + mapSectionName).data('location'),
					marker_data = $('#result-map-' + mapSectionName).data('highlights');

				if (marker_data) {

					// Format marker data into geoJSON
					var collection = returnGeoJSON(marker_data);

					// remove map in case it already exists
					if (map != undefined) { map.remove(); }

					// Setup Map and Layer
					map = L.mapbox.map('tour-highlights-map', 'worldstrides.b898407f', {
						scrollWheelZoom: false,
						dragging: false,
						zoomControl: false,
						center: [parseFloat(init_coords.latitude), parseFloat(init_coords.longitude)],
						zoom: 13
					});
					layer = L.mapbox.featureLayer(collection).addTo(map);

					// Map Events
					map
						.on('ready resize', function () {
							map.invalidateSize();
							map.fitBounds(layer.getBounds(), { padding: [30, 30], maxZoom: 16 });
						});

					// Layer Events
					layer
						.on('layeradd', function (e) {
							var marker = e.layer,
								feature = marker.feature;

							if (feature.properties.id == 0) {
								marker.setIcon(L.icon(feature.properties.iconHover));
							} else {
								marker.setIcon(L.icon(feature.properties.icon));
							}
						});
				}
			}
		})

		$('#feature-modal').modal('show');

		return false;
	}

	function returnGeoJSON(array) {
		var collection = {
			"type": "FeatureCollection",
			"features": []
		};

		$( array ).each( function( index ){
			var	point = {
				"type": "Feature",
				"geometry": {
					"type": "Point",
					"coordinates": [
						parseFloat(this.itinerary_highlights_location.longitude),
						parseFloat(this.itinerary_highlights_location.latitude)
					]
				},
				"properties": {
					"id": index,
					"icon": {
						"iconUrl": wsData.themeDir + "/assets/images/pin@2x.png",
						"iconSize": [20, 60], // size of the icon
						"iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
						"popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
						"className": "dot"
					},
					"iconHover": {
						"iconUrl": wsData.themeDir + "/assets/images/pin-orange@2x.png",
						"iconSize": [20, 60], // size of the icon
						"iconAnchor": [10, 30], // point of the icon which will correspond to marker's location
						"popupAnchor": [0, -30], // point from which the popup should open relative to the iconAnchor
						"className": "dot"
					}
				}
			};

			collection.features.push( point );
		});

		return collection;
	}


	function cycleBefore( event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag ){

	    var marker_id = $slideshow_images.indexOf(incomingSlideEl);
	    
		layer.eachLayer(function (layer) {
			if ( layer.feature.properties.id == marker_id ) {
                // draws the yellow (active) marker icon on the map
			    layer.setIcon(L.icon(layer.feature.properties.iconHover));

                // remove any previously drawn lines on the canvas
			    if (polyline instanceof L.Polyline) {
			        map.removeLayer(polyline);
			    }

                // create a new empty line holder
			    polyline = L.polyline([]).addTo(map);
			    
			    // add the new line to the map (it will be hidden at first due to css animation properties)
                // lastLine is the coordinates of the last visited spot on map (from) and layer.getLatLng gets coordinates to the new spot (to)
			    polyline.addLatLng(lastLine);
			    polyline.addLatLng(layer.getLatLng());

                // save the to coordinates for use next time as the from coordinates
			    lastLine = layer.getLatLng();

			} else {
                // these are the non active (blue) markers on the map
				layer.setIcon( L.icon( layer.feature.properties.icon ));
			}

		});

		// Check to make sure map is displaying properly
		if ( !sizeInvalidated ) {
			map.invalidateSize();
			map.fitBounds( layer.getBounds(), { padding: [ 30, 30 ], maxZoom: 16 } );
			sizeInvalidated = true;
		}
	}

} )( jQuery );