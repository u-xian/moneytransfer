var app = angular.module('MoneyTransferApp', ['ngRoute']);
        app.constant('API_URL', 'http://moneytransfer.dev:8082/api/');
        app.factory('AuthenticationService', function () {
  // private state
  var isAuthenticated = false;

  // getter and setter
  var authenticate = function (state) {
    if (typeof state !== 'undefined') { isAuthenticated = state; }
    return isAuthenticated;
  };

  // expose getter-setter
  return { isAuthenticated: authenticate };
});


 
 // configure our routes
	app.config(function($routeProvider, $locationProvider) {
		$routeProvider
		.when('/', {
				templateUrl : 'views/partials/home.html',
				controller  : 'mainController'
			})
        .when('/login', {
                templateUrl : 'views/partials/login.html',
                controller  : 'loginController'
            })
        .when('/signup', {
                templateUrl : 'views/partials/signup.html',
                controller  : 'signupController'
            })
        .when('/logout', {
                templateUrl : 'views/partials/login.html',
                controller  : 'logoutController'
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
        .when('/sendmoney/:id', {
                templateUrl : 'views/partials/home_sendmoney.html',
                controller  : 'sendMOneyController'
            })
        .when('/transfermoney', {
                templateUrl : 'views/partials/transfermoney.html',
                controller  : 'transferMoneyController'
            })

		
		
		.otherwise({
                redirectTo:'/'
            });
	});


	app.controller('mainController', function($scope, $http, $window, API_URL,AuthenticationService,$location) {
        $scope.$watch('globals', function(newVal, oldVal) {
            $scope.isAuthenticated = !AuthenticationService.isAuthenticated;
        }, true);

    });
    
    app.controller('headerController', function ($scope, AuthenticationService,$window,$location) {
         $scope.isAuthenticated = false;
        $scope.isAuthenticated = AuthenticationService.isAuthenticated;

        $scope.logout = function(){
            $window.sessionStorage.removeItem('id');
            AuthenticationService.isAuthenticated(false);
            $location.path('/');       
        }

    });


    app.controller('loginController', function($scope, $rootScope, $http, $window,$location, API_URL,AuthenticationService) {
        $scope.login = function() {
            var url = API_URL + "login";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.log),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(response) {
                $window.sessionStorage.setItem("id",response.id);
                $rootScope.currentUser = response;
                $scope.isAuthenticated = AuthenticationService.isAuthenticated(true);
                console.log($scope.isAuthenticated);
                //$('#myModal').modal('hide');
                var id = $rootScope.currentUser.id;
                $location.path('/sendmoney/'+id);
            }).error(function(response) {
                console.log(response);
                alert('An error has occured. Please check the log for details');
            });
        }
    });
    
    app.controller('signupController', function($scope, $rootScope, $window, $http, API_URL,$location) {
        $scope.save = function() {
        var url = API_URL + "user";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.users),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            //location.reload();
            $rootScope.currentUser = response;
            $location.path('/sendmoney/'+ response.id);
            //$('#customerModal').modal('show');
        }).error(function(response) {
            console.log(response);
            alert('An error has occured. Please check the log for details');
        });
    }

    });

    app.controller('logoutController', function($scope, $http,$window,$location,AuthenticationService) {
         $window.sessionStorage.removeItem('id');
         AuthenticationService.isAuthenticated(false);
         $location.path('/');

    });

    app.controller('howitworksController', function($scope, $http) {

    });
    
    app.controller('aboutusController', function($scope, $http) {

    });

    app.controller('helpsupportController', function($scope, $http) {

    });

    app.controller('sendMOneyController', function($scope, $http, $routeParams, API_URL,$window) {
        //Get the categories
        $scope.TransactionsTable = false;
        $scope.CustomerForm = false;
        $scope.usable = false;
        
        $scope.showMenu = function(menuname) {
           if (menuname === 1) {
                $scope.TransactionsTable = true;
                $scope.CustomerForm = false;
                $scope.TransferMoneyForm = false;
                $scope.PhoneBookForm = false;
           }
           if (menuname === 2) {
                $scope.TransactionsTable = false;
                $scope.CustomerForm = false;
                $scope.TransferMoneyForm = true;
                $scope.PhoneBookForm = false;
           }
           if (menuname === 3) {
                $scope.TransactionsTable = false;
                $scope.CustomerForm = false;
                $scope.TransferMoneyForm = false;
                $scope.PhoneBookForm = true;
           }
        }

       



        $scope.param = $routeParams.id;
        var id = $scope.param;

        $http.get(API_URL + 'checkuserstatus/' + id)
            .success(function(response) {
                $scope.isactivated = response;
                $scope.usable = true;
                var status = $scope.isactivated.status;
                if (status == 1 ){
                    $scope.TransactionsTable = true;
                    $scope.CustomerForm = false;
                    $scope.usable = true;
                }
                else{
                    $scope.TransactionsTable = false;
                    $scope.CustomerForm = true;
                    $scope.usable = false;
                }
        });
       


    });

     app.controller('customerController', function($scope, $rootScope, $window, $http, API_URL,$location) {
        $scope.years =[];
        $scope.months =[];
        $scope.days =[];
                            
        for(var i=1900; i<=2017; i++) {
            $scope.years.push({
                    yvrb: i
                });
        }

        for(var i=1; i<=12; i++) {
            $scope.months.push({
                    mvrb: i
                });
        }

        for(var i=1; i<=31; i++) {
            $scope.days.push({
                    dvrb: i
                });
        }

        $scope.saveCustomer = function() {
            var url = API_URL + "customer";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.record),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(response) {
                $http.get(API_URL + 'activate/' + $scope.record.user_id)
                    .success(function(response) {
                        $http.get(API_URL + 'checkuserstatus/' + $scope.record.user_id)
            .success(function(response) {
                $scope.isactivated = response;
                $scope.usable = true;
                var status = $scope.isactivated.status;
                if (status == 1 ){
                    $scope.TransactionsTable = true;
                    $scope.CustomerForm = false;
                    $scope.usable = true;
                }
                else{
                    $scope.TransactionsTable = false;
                    $scope.CustomerForm = true;
                    $scope.usable = false;
                }
        });
                });
                location.reload();
            }).error(function(response) {
                console.log(response);
                alert('An error has occured. Please check the log for details');
            });
           
        }

    });

     app.controller('transferMoneyController', function($scope, $http) {

    });

    app.controller('blogController', function($scope, $http, API_URL) {
        //Format Date 
        $scope.getDateFormat = function(timestamp) {
            return new Date(timestamp);
        }
        //retrieve blog post listing from API
        $scope.currentPage ;
        $scope.getPosts = function(pageNumber){
            if(pageNumber===undefined){
                pageNumber = '1';
            }
            $http.get(API_URL + "blogpost?page="+pageNumber)
                .success(function(response) {
                    $scope.blogposts = response.data;
                    currentPage = response.current_page;
                    $scope.totalPages   = response.last_page;
        
                    // Pagination Range
                    var pages = [];

                    for(var i=1;i<=response.last_page;i++) {          
                        pages.push(i);
                    }

                    $scope.range = pages; 
                });
        }

        $scope.nextPage = function() {
                if (currentPage < $scope.totalPages) {
                    currentPage++;
                    $scope.getPosts(currentPage);
                }
            };
        $scope.prevPage = function() {
                if (currentPage > 1) {
                    currentPage--;
                    $scope.getPosts(currentPage);
                }
            };
        $scope.getPosts(1);
       
       //Get the categories
        $http.get(API_URL + 'category')
            .success(function(response) {
                $scope.categories = response;
        });

       //Get the archieve 
       $http.get(API_URL + 'archievepost')
            .success(function(response) {
                $scope.archieve  = response;
                console.log($scope.archieve);
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
        
        $scope.getComments = function(pid){
            $http.get(API_URL + 'blogpostcomment/' + pid)
                .success(function(response) {
                    $scope.comments = response;
            });
        }
        $scope.getComments(id);

        $scope.saveComment = function() {
            $scope.commentPost['on_post'] = id;
            var url = API_URL + "blogpostcomment";
            $http({
                method: 'POST',
                url: url,
                data: $.param( $scope.commentPost),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(response) { 
                  $scope.getComments(id);
                  $scope.personForm.$setPristine();
                }).error(function(response) {
                    alert('An error has occured. Please check the log for details');
                });

        }
      
    });

    app.controller('usersController', function($scope, $window, $http, API_URL,$location) {
    	//save new record / update existing record
    $scope.save = function() {
        var url = API_URL + "user";
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.users),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            //location.reload();
            $('#myModal').modal('hide');
            $location.path('/sendmoney');
        }).error(function(response) {
            console.log(response);
            alert('An error has occured. Please check the log for details');
        });
    }

    });