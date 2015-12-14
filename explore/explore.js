var exploreApp = angular.module('exploreApp', ['ngRoute', 'ngSanitize', 'ngAnimate']);

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

exploreApp.directive('filterLink', ['$location', function($location) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var hrefData = attrs.filterLink.split(','), 
				url;

			// Only check available filters when NOT on the featured page
			if ( $location.$$path !== '/featured' ){
				scope.$watch('ctrl.availableFilters', function(newValue, oldValue){
					if ( newValue && newValue.indexOf( hrefData[0] ) == -1 ) {
						element
							.attr('href', '')
							.addClass('disabled');
					}
				});
			}

			angular.forEach(hrefData, function(value, key){
				hrefData[key] = value.trim();
			});
			url = scope.ctrl.getUrl( hrefData[0], hrefData[1], hrefData[2] );
			element.attr('href', url);
		}
	};
}]);

exploreApp.directive('sticky', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var $window = jQuery(window),
				$currentFilters = angular.element('.current-filters'),
				currentFiltersTop = $currentFilters.offset().top;		

			$window.on('scroll', function(){
				var scrollTop = $window.scrollTop();
				if ( scrollTop >= currentFiltersTop ) {
					$currentFilters.addClass('fixed');
				} else {
					$currentFilters.removeClass('fixed');
				}
			});
		}	
	};
});

exploreApp.directive('stickToBottom', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var $window = jQuery(window),
				$resultsCount = angular.element('.results-count'),
				$results = jQuery('.explore-results');

			$window.on('scroll', function(){
				var scrollTop = $window.scrollTop();
				if ( scrollTop >= $results.offset().top - 500 ) {
					$resultsCount.removeClass('visible');
				} else {
					$resultsCount.addClass('visible');
				}
			});
		}	
	};
});

exploreApp.service('Terms', function($q, $http){

	var _this = this;

	_this.data = {
		travelers: null,
		interests: null,
		destinations: null,
		loaded: false
	};

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

	var ctrl = this, query;

	ctrl.WS = WS;
	ctrl.$route = $route;
	ctrl.loading = true;
	// Filters
	ctrl.terms = Terms.data;
	ctrl.activeFilters = ctrl.getActiveFilters();
	ctrl.visibleInterestsList = 'interests-parent';
	ctrl.visibleDestinationsList = 'destinations-parent';
	// Results
	ctrl.itineraries = [];
	ctrl.itinerariesLimit = 9;
	ctrl.collections = [];
	ctrl.collectionsLimit = 3;
	if ( Object.keys($route.current.params).length === 0 ) {
		ctrl.isFeatured = true;
	}

	query = ctrl.getQuery();

	if ( !Terms.data.loaded ) {
		Terms.get().then(function(response){
			Terms.data = response.data;
			Terms.data.loaded = true;
			ctrl.terms = Terms.data;
		}, function(error){
			throw error;
		});
	}

	Posts.get(query).then(function(response){
		ctrl.itineraries = response.data.itinerary || [];
		ctrl.collections = response.data.collection || [];
		ctrl.availableFilters = response.data.availableFilters || [];
		ctrl.loading = false;
	}, function(error){
		ctrl.loading = false;
		ctrl.postsError = true;
		throw error;
	});

};

ExploreController.prototype.getUrl = function( slug, filterGroup, method ) {
	// if ( !method || !slug || !filterGroup )
	// 	console.log('Error: missing "method", "slug", or "filterGroup" arguments in "term-href" directive'); return;

	var params = angular.copy(this.$route.current.params),
		keys = Object.keys(params),
		filterGroupArray,
		url = '';

	if ( !method )
		method = 'add';
	
	if ( keys.length > 0 ) {
		
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

		if ( params[keys[0]] == 'all-'+keys[0] &&
			 params[keys[1]] == 'all-'+keys[1] &&
			 params[keys[2]] == 'all-'+keys[2] ) {
			url = '#/featured';
		} else {
			url = '#/' + params[keys[0]] +'/'+ params[keys[1]] +'/'+ params[keys[2]];
		}

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

ExploreController.prototype.getQuery = function(){
	var route = this.$route.current.params,
		queryArray, queryString;

	if ( Object.keys(route).length > 0 ) {
		queryArray = [];
		angular.forEach(route, function(value, key){
			if ( value !== 'all-destinations' && value !== 'all-interests' && value !== 'all-travelers' ){
				queryArray.push(value);
			}
		});
		queryString = queryArray.join(',');
	} else {
		queryString = 'featured';
	}

	return queryString;
};

ExploreController.prototype.getActiveFilters = function(){
	var route = this.$route.current.params,
		active = {
			travelers: [],
			interests: [],
			destinations: []
		};

	if ( Object.keys(route).length > 0 ) {

		angular.forEach(route, function(value, key){
			if ( value !== 'all-destinations' && value !== 'all-interests' && value !== 'all-travelers' ){
				value = value.split(',');
				angular.forEach(value, function(term){
					term = {
						name: term.split('-').join(' '),
						slug: term
					};
					active[key].push(term);
				});
			}
		});

		return active;

	} else {
		return false;
	}
};

ExploreController.prototype.showTermList = function( list, term ){
	if ( list == 'interest' ) {
		this.visibleInterestsList = term;
	} else if ( list == 'destination' ) {
		this.visibleDestinationsList = term;
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

ExploreController.prototype.toggleLimit = function( source, min, max ) {
	var ctrl = this;

	if ( ctrl[source + 'Limit'] >= max ) {
		ctrl[source + 'Limit'] = min;
		jQuery('html, body').animate({ scrollTop: jQuery('.'+source).offset().top });
	} else {
		ctrl[source + 'Limit'] = ctrl[source + 'Limit'] + min;
	}
};

ExploreController.prototype.smoothScroll = function(target, offset) {
	var top = jQuery(target).offset().top;
	if ( offset ) {
		top = top + offset;
	}
	jQuery('html, body').animate({scrollTop: top});
}

ExploreController.$inject = ['Terms', 'Posts', '$route'];
exploreApp.controller('ExploreController', ExploreController);














