var exploreApp = angular.module('exploreApp', ['ngRoute', 'ngSanitize']);

exploreApp.config([ '$routeProvider', function($routeProvider){

	$routeProvider
		.when('/featured', {
			templateUrl: WS.explore + '/views/results.html',
			controller: 'ExploreController',
			controllerAs: 'ctrl'
		})
		.when('/:travelers/:interests/:destinations', {
			templateUrl: WS.explore + '/views/results.html',
			controller: 'ExploreController',
			controllerAs: 'ctrl'
		})
		.otherwise({
			redirectTo: '/featured'
		});

}]);

exploreApp.directive('termHref', function($route) {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {

   		function getUrl( slug, filterGroup ) {
			var params = angular.copy($route.current.params),
				keys = Object.keys(params),
				url = '';
			
			if ( Object.keys(params).length > 0 ) {
				if ( params[filterGroup].indexOf('all-') > -1 ) {
					params[filterGroup] = slug;
				} else if ( params[filterGroup].indexOf(slug) > -1 ) {
					params[filterGroup] = params[filterGroup];
				} else {
					params[filterGroup] += ',' + slug;
				}
				url = '#/' + params[keys[0]] +'/'+ params[keys[1]] +'/'+ params[keys[2]];	
			} else {
				params = {
					travelers: 'all-travelers',
					interests: 'all-interests',
					destinations: 'all-destinations'
				};
				params[filterGroup] = slug;
				url = '#/' + params.travelers +'/'+ params.interests +'/'+ params.destinations;
			}

			return url;
		}

		var hrefData = attrs.termHref.split(','),
			url = getUrl( hrefData[0], hrefData[1] );
		element.attr('href', url);
    }
  }
});

exploreApp.service('Terms', function($q, $http){

	var _this = this;

	_this.getAll = function( taxonomy ){
		return $q(function(resolve, reject){
			$http.get(WS.explore + "/" + taxonomy + ".json")
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

exploreApp.service('Posts', function($q, $http){

	var _this = this;

	_this.get = function( filters ){
		return $q(function(resolve, reject){
			var deferred, url;
			if ( filters == 'featured' ) {
				url = WS.exploreApi + '/data/' + filters;
				deferred = $http.get(url);
			} else {
				// parse filters and build url
				url = WS.exploreApi + '/results/' + filters;
				deferred = $http.get(url);
			}
			deferred.then(resolve, reject);
		});
	}

});

var ExploreController = function(Terms, Posts, $route){

	var _this = this,
		route = $route.current.params,
		query;

	_this.loading = true;
	_this.hasFilters = (Object.keys(route).length > 0) ? true : false;
	_this.WS = WS;
	_this.$route = $route;
	_this.travelers;
	_this.interests;
	_this.continents;
	_this.itineraries;
	_this.collections;
	_this.showInterestsList = 'interests-parent';
	_this.showDestinationsList = 'destinations-parent';

	if ( Object.keys(route).length > 0 ) {
		query = [];
		angular.forEach(route, function(value, key){
			if ( value !== 'all-destinations' && value !== 'all-interests' && value !== 'all-travelers' )
				query.push(value);
		});
		query = query.join(',');
	} else {
		query = 'featured';
	}

	Posts.get(query).then(function(response){
		_this.itineraries = response.data.itinerary;
		_this.collections = response.data.collection;
		_this.loading = false;
	}, function(error){
		console.log(error);
	});

	Terms.getAll('filters').then(function(response){
		_this.travelers = Terms.getChildrenOf('traveler', response.data);
		_this.interests = Terms.getChildrenOf('interest', response.data);
		_this.continents = Terms.getChildrenOf('destination', response.data);
	}, function(error){
		console.log(error);
	});

	// console.log(_this.formatUrl('china', 'destinations'));

};

ExploreController.prototype.showTermList = function( list, term ){
	if ( list == 'interest' ) {
		this.showInterestsList = term;
	} else if ( list == 'destination' ) {
		this.showDestinationsList = term;
	}
};

ExploreController.prototype.toggleFilterMenu = function( menu ) {
	var menu = angular.element(menu);
	if ( menu.hasClass('closed') ) {
		menu.removeClass('closed');
	} else {
		menu.addClass('closed');
	}
};



ExploreController.$inject = ['Terms', 'Posts', '$route'];
exploreApp.controller('ExploreController', ExploreController);














