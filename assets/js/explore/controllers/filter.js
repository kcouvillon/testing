exploreApp.controller('filterController', ['$scope', '$route', '$http', function( $scope, $route, $http ) {

	console.log( $route.current.params );

	var getCollections = $http.get( wsData.siteUrl + '/wp-json/wp/v2/collection/?per_page=5'),
		getItineraries = $http.get( wsData.siteUrl + '/wp-json/wp/v2/itinerary/?per_page=100');

	getItineraries.success(function (data) {
		$scope.itineraries = data;		
	});
	getCollections.success(function (data) {
		$scope.collections = data;		
	});

}]);