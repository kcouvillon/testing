var exploreApp = angular.module('exploreApp', ['ngRoute']);

exploreApp.config([ '$routeProvider', function($routeProvider){

	$routeProvider
		.when('/featured', {
			templateUrl: wsExplore.path + '/views/featured.html',
			controller: 'ExploreController',
			controllerAs: 'ctrl'
		})
		.when('/:filters', {
			templateUrl: wsExplore.path + '/views/filters.html',
			controller: 'ExploreController',
			controllerAs: 'ctrl'
		})
		.otherwise({
			redirectTo: '/featured'
		});


}]);

exploreApp.service('Terms', function($q, $http){

	var _this = this;

	_this.getAll = function( taxonomy ){
		return $q(function(resolve, reject){
			$http.get("http://ws.local/wp-json/wp/v2/terms/" + taxonomy)
				.then(function(response){
					resolve(response);
				}, function(error){
					reject(error);
				});
		});
	}

});

exploreApp.service('Itineraries', function($q, $http){

	var _this = this;

	_this.getAll = function(){
		return $q(function(resolve, reject){
			$http.get("http://ws.local/wp-json/wp/v2/posts")
				.then(function(response){
					resolve(response);
				}, function(error){
					reject(error);
				});
		});
	}

});

var ExploreController = function(Terms){

	var _this = this;

	_this.loading = true;

	Terms.getAll('filter').then(function(response){
		console.log(response);
		_this.loading = false;
	}, function(error){
		console.log(error);
		_this.loading = false;
	});

};
ExploreController.$inject = ['Terms'];
exploreApp.controller('ExploreController', ExploreController);