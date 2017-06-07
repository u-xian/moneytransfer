var app = angular.module('MoneyTransferApp', ['ngRoute']);
        app.constant('API_URL', 'http://moneytransfer.dev:8082/api/');
 
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
		.when('/getpost/:id', {
				templateUrl : 'views/partials/post.html',
				controller  : 'getPostController'
			})

		
		
		.otherwise({
                redirectTo:'/'
            });
	});

	app.controller('mainController', function($scope, $http, API_URL) {

    });

    app.controller('howitworksController', function($scope, $http) {

    });
    
    app.controller('aboutusController', function($scope, $http) {

    });

    app.controller('helpsupportController', function($scope, $http) {

    });

    app.controller('blogController', function($scope, $http, API_URL) {
        //Format Date 
        $scope.getDateFormat = function(timestamp) {
            return new Date(timestamp);
        }
        //retrieve blog post listing from API
        $http.get(API_URL + "blogpost")
            .success(function(response) {
                $scope.blogposts = response;
        });


    });

    app.controller('getPostController', function($scope, $http, $routeParams,API_URL) {
        //Format Date 
        $scope.getDateFormat = function(timestamp) {
            return new Date(timestamp);
        }

    	$scope.param = $routeParams.id;
    	var id = $scope.param;

    	$http.get(API_URL + 'blogpost/' + id)
            .success(function(response) {
                $scope.posts = response;
        });
      
    });

    app.controller('usersController', function($scope, $http, API_URL) {
    	//save new record / update existing record
    $scope.save = function() {
        var url = API_URL + "user";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.users),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            console.log($scope.users);
            console.log(response);
            location.reload();
        }).error(function(response) {
            console.log(response);
            alert('An error has occured. Please check the log for details');
        });
    }

    });