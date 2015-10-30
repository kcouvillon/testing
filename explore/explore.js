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

   		function getUrl( slug, filterGroup, method ) {
   			// if ( !method || !slug || !filterGroup )
   			// 	console.log('Error: missing "method", "slug", or "filterGroup" arguments in "term-href" directive'); return;

			var params = angular.copy($route.current.params),
				keys = Object.keys(params),
				filterGroupArray,
				url = '';

			if ( !method )
				method = 'add';
			
			if ( Object.keys(params).length > 0 ) {
				
				filterGroupArray = params[filterGroup].split(',');

				if ( method == 'add' ){
					if ( params[filterGroup].indexOf('all-') > -1 ) {
						params[filterGroup] = slug;
					} else if ( params[filterGroup].indexOf(slug) > -1 ) {
						params[filterGroup] = params[filterGroup];
					} else {
						params[filterGroup] += ',' + slug;
					}

				} else if ( method == 'subtract' ) {
					if ( filterGroupArray.length > 1 ) {
						filterGroupArray.splice(filterGroupArray.indexOf(slug), 1);
						params[filterGroup] = filterGroupArray.join(',');
					} else {
						params[filterGroup] = 'all-' + filterGroup;
					}
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
			url;

		angular.forEach(hrefData, function(value, key){
			hrefData[key] = value.trim();
		});
		url = getUrl( hrefData[0], hrefData[1], hrefData[2] );
		element.attr('href', url);
    }
  }
});

exploreApp.service('Terms', function($q, $http){

	var _this = this;

	_this.get = function(){
		return $q(function(resolve, reject){
			$http.get(WS.exploreApi + "/data/filters/")
				.then(resolve, reject);
		});
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
	_this.itineraries = [];
	_this.collections = [];
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
		_this.itineraries = response.data.itinerary || [];
		_this.collections = response.data.collection || [];
		_this.loading = false;
	}, function(error){
		console.log(error);
	});

	Terms.get().then(function(response){
		_this.travelers = {
			terms: response.data.travelers,
			active: []
		}
		_this.interests = {
			terms: response.data.interests,
			active: []
		}
		_this.destinations = {
			terms: response.data.destinations,
			active: []
		}
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














