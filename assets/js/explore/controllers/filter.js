exploreApp.controller('filterController', ['$scope', '$route', '$http', function( $scope, $route, $http ) {

	console.log( $route.current.params );

	var getDestinationFilters = $http.get( wsData.siteUrl + '/wp-json/wp/v2/terms/filter/?per_page=150&parent=6' ),
		getCollections = $http.get( wsData.siteUrl + '/wp-json/wp/v2/collection/?per_page=150'),
		getItineraries = $http.get( wsData.siteUrl + '/wp-json/wp/v2/itinerary/?per_page=150');

	getDestinationFilters.success(function (data) {
		$scope.destinationFilters = data;
	});
	getItineraries.success(function (data) {
		$scope.itineraries = data;		
	});
	getCollections.success(function (data) {
		$scope.collections = data;		
	});

	console.log( 'scope', $scope );

}]);