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
				.then(resolve, reject);
		});
	};

	_this.getChildrenOf = function( parent, data ){
		if ( !parent || !data )
			return false;

		var children = [],
			parentType = ( typeof parent == 'string' ) ? 'slug' : 'ID';

		angular.forEach(data, function(term, key){
			if ( term.parent && term.parent[parentType] == parent ) {
				if ( term.ID !== 384 ) { // extra check to exclude faith-based & service
					term.children = [];
					angular.forEach(data, function(childTerm, key){
						if ( childTerm.parent && childTerm.parent.ID == term.ID ) {
							term.children.push(childTerm);
						}
					});
					children.push(term);
				}
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
				.then(resolve, reject);
		});
	}

});

exploreApp.service('Collections', function($q, $http){

	var _this = this;

	_this.getAll = function(){
		return $q(function(resolve, reject){
			$http.get(wsTheme.explore + "/collections.json")
				.then(resolve,reject);
		});
	}

});

var ExploreController = function(Terms, Itineraries, Collections){

	var _this = this;

	_this.loading = true;
	_this.wsTheme = wsTheme;
	_this.travelers;
	_this.interests;
	_this.continents;
	_this.itineraries;
	_this.collections;
	_this.showInterestsList = 'interests-parent';
	_this.showDestinationsList = 'destinations-parent';

	Itineraries.getAll().then(function(response){
		_this.itineraries = response.data;
	}, function(error){
		console.log(error);
	});

	Collections.getAll().then(function(response){
		_this.collections = response.data;
	}, function(error){
		console.log(error);
	});

	Terms.getAll('filters').then(function(response){
		_this.travelers = Terms.getChildrenOf('traveler', response.data);
		_this.interests = Terms.getChildrenOf('interest', response.data);
		_this.continents = Terms.getChildrenOf('destination', response.data);
		_this.loading = false;
	}, function(error){
		console.log(error);
	});

};

ExploreController.prototype.showTermList = function( list, term ){
	if ( list == 'interest' ) {
		this.showInterestsList = term;
	} else if ( list == 'destination' ) {
		this.showDestinationsList = term;
	}
}




ExploreController.$inject = ['Terms', 'Itineraries', 'Collections'];
exploreApp.controller('ExploreController', ExploreController);














