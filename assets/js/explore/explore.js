'use strict';

var exploreApp = angular.module('exploreApp', ['ngRoute']);

	exploreApp.config(['$routeProvider', function($routeProvider){		
			
		$routeProvider
			.when('/filter', {
				templateUrl: wsData.themeDir + '/views/explore-filter.html',
				controller: 'filterController'
			})
			.otherwise({
				redirectTo: '/filter'
			});

	}]);