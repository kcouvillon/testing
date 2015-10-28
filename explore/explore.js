var exploreApp = angular.module('exploreApp', ['ngRoute']);

exploreApp.config([ '$routeProvider', function($routeProvider){

	$routeProvider
		.when('/featured', {
			templateUrl: wsTheme.explore + '/views/featured.html',
			controller: 'ExploreController',
			controllerAs: 'ctrl'
		})
		.when('/:filters', {
			templateUrl: wsTheme.explore + '/views/filters.html',
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
			$http.get(wsTheme.explore + "/" + taxonomy + ".json")
				.then(function(response){
					resolve(response);
				}, function(error){
					reject(error);
				});
		});
	};

	_this.getChildrenOf = function( parent, data ){
		if ( !parent || !data )
			return false;

		var children = [],
			parentType = ( typeof parent == 'string' ) ? 'slug' : 'ID';

		angular.forEach(data, function(value, key){
			if ( value.parent && value.parent[parentType] == parent ) {
				if ( value.ID !== 384 ) // extra check to exclude faith-based & service
					children.push(value);
			}
		});

		return children;
	};

});

exploreApp.service('Itineraries', function($q, $http){

	var _this = this;

	_this.getAll = function(){
		return $q(function(resolve, reject){
			$http.get(wsTheme.explore + "/itineraries.json")
				.then(function(response){
					resolve(response);
				}, function(error){
					reject(error);
				});
		});
	}

});

var ExploreController = function(Terms, Itineraries){

	var _this = this;

	_this.loading = true;
	_this.wsTheme = wsTheme;
	_this.continents;
	_this.travelers;
	_this.interests;
	_this.itineraries;

	Itineraries.getAll().then(function(response){
		_this.itineraries = response.data;
	}, function(error){
		console.log(error);
	});

	Terms.getAll('filters').then(function(response){
		_this.continents = Terms.getChildrenOf('destination', response.data);
		_this.travelers = Terms.getChildrenOf('traveler', response.data);
		_this.interests = Terms.getChildrenOf('interest', response.data);
		_this.loading = false;
	}, function(error){
		console.log(error);
	});

};
ExploreController.$inject = ['Terms', 'Itineraries'];
exploreApp.controller('ExploreController', ExploreController);