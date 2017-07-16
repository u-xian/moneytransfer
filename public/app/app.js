'use strict';

Stripe.setPublishableKey('pk_test_aWyIUltAAS04f7KyYnp1PmG8');

var app = angular.module('MoneyTransferApp', ['ngRoute',
                                              'ngAnimate',
                                              'angularSpinner',
                                              'ngMessages',
                                              'angularPayments', 
                                              'ui.bootstrap',
                                              'Authenticatecontrollers',
                                              'Blogcontrollers',
                                              'services']);

app.constant('API_URL', 'http://moneytransfer.dev:8082/api/');

app.run(["userService", function(userService) {
  var user = userService.GetCurrentUser();
  if (user) {
    userService.SetCurrentUser(user);
  }
}]);


 
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
                controller  : 'sendMOneyHomeController'
            })
        .when('/transfermoney', {
                templateUrl : 'views/partials/transfermoney.html',
                controller  : 'transferMoneyController'
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

    app.controller('sendMOneyHomeController', function($scope, $http, $routeParams, API_URL,$window,CheckStatusService,CurrencyService) {
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
        $scope.userid = $scope.param;

        CheckStatusService.getStatus(API_URL,id).then(function(d) { //2. so you can use .then()
            $scope.data = d;
            if($scope.data)
            {
                $scope.TransactionsTable = true;
                $scope.CustomerForm = false;
                $scope.usable = true;
            }
            else
            {
                $scope.TransactionsTable = false;
                $scope.CustomerForm = true;
                $scope.usable = false;
            }
        });

        

        
    });

     app.controller('customerController', function($scope, $rootScope, $window, $http, API_URL,$location,CheckStatusService) {
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
            }).then(function onSuccess(response) {
                CheckStatusService.getStatus(API_URL,response.data.userid).then(function(d) { //2. so you can use .then()
                    $scope.data = d;
                    if($scope.data)
                    {
                        $scope.TransactionsTable = true;
                        $scope.CustomerForm = false;
                        $scope.usable = true;
                    }
                    else
                    {
                        $scope.TransactionsTable = false;
                        $scope.CustomerForm = true;
                        $scope.usable = false;
                    }
               });

            }).catch(function onError(response) {
                console.log(response);
                alert('An error has occured. Please check the log for details');
            });
           
        }

    });

    app.controller('transferMoneyController', function($scope, $http,API_URL,CurrencyService) {

         $scope.onSubmit = function () {
            $scope.processing = true;
        };

        $scope.stripeCallback = function (code, result) {
            $scope.processing = false;
            $scope.userinfo = angular.fromJson(sessionStorage.user);
            $scope.hideAlerts();
            if (result.error) {
                $scope.stripeError = result.error.message;
            } else {
                var $payInfo = {
                    'token' : result.id,
                    'user_id' : $scope.userinfo.id,
                    'user_email' : $scope.userinfo.email,
                    'total':$scope.pay_amount,
                    'countrycode':$scope.countrycode,
                    'phonenumber':$scope.phonenumber
                };
                var url = API_URL + "pay";
                $http({
                    method: 'POST',
                    url: url,
                    data: $.param($payInfo),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function onSuccess(response) {
                    if(response.status=="OK"){
                        $scope.paid= true;
                        $scope.stripeToken = response.data.message;
                    }else{
                        $scope.paid= false;
                        $scope.stripeToken = response.data.message;
                    }
                }).catch(function onError(response) {
                    console.log(response);
                    alert('An error has occured. Please check the log for details');
                });
                
            }
        };

        $scope.hideAlerts = function () {
            $scope.stripeError = null;
            $scope.stripeToken = null;
        };

        CurrencyService.getCurrency(API_URL).then(function(d) { //2. so you can use .then()
            $scope.currencies = d;
        });
       

        $scope.status = {
            isFirstOpen: true,
            isFirstOpen2: true,
        };
        $scope.rates = {};
        $http.get(API_URL+'currency')
            .then(function(res) {
                $scope.rates = res.data;
                $scope.forExConvert();
            });
        $scope.forExConvert = function() {
            angular.forEach($scope.rates, function(value, key) {
                    if(value.phonecode == $scope.countrycode){
                        $scope.pay_amount = $scope.amount / value.exchange_rate;
                        $scope.pay_amount = Math.round($scope.pay_amount);
                    }   
                });
        };

        
     
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
        }).then(function onSuccess(response) {
            //location.reload();
            $('#myModal').modal('hide');
            $location.path('/sendmoney');
        }).catch(function onError(response) {
            console.log(response);
            alert('An error has occured. Please check the log for details');
        });
    }

    });