var app = angular.module('MoneyTransferApp', ['ngRoute']);
 
 // configure our routes
	app.config(function($routeProvider, $locationProvider) {
		$routeProvider
		.when('/', {
				templateUrl : 'views/partials/home.html',
				controller  : 'mainController'
			})
		.when('/howitworks', {
				templateUrl : 'views/partials/howitworks.html',
				controller  : 'howitworksController'
			})

		.when('/aboutus', {
				templateUrl : 'views/partials/aboutus.html',
				controller  : 'aboutusController'
			})

		.when('/helpsupport', {
				templateUrl : 'views/partials/helpsupport.html',
				controller  : 'helpsupportController'
			})

		.when('/blog', {
				templateUrl : 'views/partials/blog.html',
				controller  : 'blogController'
			})
		
		.otherwise({
                redirectTo:'/'
            });
	});

	app.controller('mainController', function($scope, $http) {

    });

    app.controller('howitworksController', function($scope, $http) {

    });
    
    app.controller('aboutusController', function($scope, $http) {

    });

    app.controller('helpsupportController', function($scope, $http) {

    });

    app.controller('blogController', function($scope, $http) {

    });