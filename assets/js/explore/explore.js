'use strict';

var exploreApp = angular.module('exploreApp', ['ngRoute']);

	exploreApp.config(['$routeProvider', function($routeProvider){		
			
		$routeProvider
			.when('/filter/:destination', {
				templateUrl: wsData.themeDir + '/views/explore-filter.html',
				controller: 'filterController'
			})
			.when('/filter/:destination/:interest', {
				templateUrl: wsData.themeDir + '/views/explore-filter.html',
				controller: 'filterController'
			})
			.when('/filter/:destination/:interest/:traveler', {
				templateUrl: wsData.themeDir + '/views/explore-filter.html',
				controller: 'filterController'
			})
			.when('/', {
				templateUrl: wsData.themeDir + '/views/explore-filter.html',
				controller: 'filterController'
			})
			.otherwise({
				redirectTo: '/'
			});

	}]);