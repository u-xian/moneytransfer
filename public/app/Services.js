var app = angular.module('services', [])

app.factory('CheckStatusService', function($http) {
  return {
    getStatus: function(url_api,userid) {
      return $http.get(url_api + 'isCustomer/' + userid)
      .then(function onSuccess(response) {
             // Handle success
             var status = response.data.status;
             return status;
            
            });  //1. this returns promise
    }
  };
});

app.factory('CurrencyService', function($http) {
  return {
    getCurrency: function(url_api) {
      return $http.get(url_api + 'currency')
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});

app.factory('TransactionService', function($http) {
  return {
    getTransactions: function(url_api,userid) {
      return $http.get(url_api + 'transaction/' + userid)
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});



app.factory('accountService', ['$timeout', '$http','$q', 'userService', '$window', function($timeout, $http, $q, userService, $window) {
  var fac = {};
  fac.login = function(api_url,user) {

    var defer = $q.defer();
    $timeout(function() {
      var mockUser = {};
      var url = api_url + "login";
            $http({
                method: 'POST',
                url: url,
                data: $.param(user),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function onSuccess(response) {
               mockUser = response.data;
               userService.SetCurrentUser(mockUser);
               defer.resolve(mockUser);
            })
            .catch(function onError(response) {
                // Handle error
                console.log(response);
            });
      
    }, 2000);

    return defer.promise;
  }
  fac.logout = function() {
    userService.CurrentUser = null;
    userService.SetCurrentUser(userService.CurrentUser);
  }
  return fac;
}]);

app.factory('userService', function($rootScope) {
  var fac = {};
  fac.CurrentUser = null;
  fac.SetCurrentUser = function(user) {
    fac.CurrentUser = user;
    sessionStorage.user = angular.toJson(user);
    $rootScope.user = user;
  }
  fac.GetCurrentUser = function() {
    fac.CurrentUser = angular.fromJson(sessionStorage.user);
    return fac.CurrentUser;
  }
  return fac;
});


app.factory('currencyConverter', function() {
    var currencies = ['USD', 'EUR', 'CNY'],
    usdToForeignRates = {
          USD: 1,
          EUR: 0.74,
          CNY: 6.09
    };
    return {
      currencies: currencies,
      convert: convert
    };

    function convert(amount, inCurr, outCurr) {
      return amount * usdToForeignRates[outCurr] * 1 / usdToForeignRates[inCurr];
    }
  });