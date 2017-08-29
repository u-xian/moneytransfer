var app = angular.module('services', [])

app.factory('CheckStatusService', function($http) {
  return {
    getStatus: function(userid) {
      return $http.get('/api/isCustomer/' + userid)
      .then(function onSuccess(response) {
             // Handle success
             //var status = response.data.status;
             //return status;     
             return  response.data;       
            });  //1. this returns promise
    }
  };
});

app.factory('CurrencyService', function($http) {
  return {
    getCurrency: function() {
      return $http.get('/api/allcurrencies')
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});

app.factory('CountryService', function($http) {
  return {
    getCountry: function() {
      return $http.get('/api/allcountries')
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});

app.factory('TransactionService', function($http) {
  return {
    getTransactions: function(userid,pageNumber) {
      return $http.get('/api/transaction/' + userid +'?page='+pageNumber)
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});

app.factory('CountriesService', function($http) {
  return {
    getCountries: function(pageNumber) {
      return $http.get('/api/country/'+'?page='+pageNumber)
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});

app.factory('CurrenciesService', function($http) {
  return {
    getCurrencies: function(pageNumber) {
      return $http.get('/api/currency/'+'?page='+pageNumber)
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }
  };
});



app.factory('accountService', ['$timeout', '$http','$q', 'userService', '$window', function($timeout, $http, $q, userService, $window) {
  var fac = {};
  fac.login = function(user) {

    var defer = $q.defer();
    $timeout(function() {
      var mockUser = {};
      var url = "/api/login";
            $http({
                method: 'POST',
                url: url,
                data: $.param(user),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function onSuccess(response) {
               mockUser = response.data;
               if(mockUser.status){
                  userService.SetCurrentUser(mockUser);          
               } 
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

app.service('CustomerInfo', ['$http','$q', function ($http,$q) {

    this.save = function(model,file){
      //
        var defer = $q.defer();
        var mockUser = {};
        var fd = new FormData();
        fd.append('first_name',model.first_name );
        fd.append('last_name',model.last_name );
        fd.append('sex',model.sex );
        fd.append('prefix_code',model.prefix_code );
        fd.append('phonenumber',model.phonenumber );
        fd.append('year',model.year );
        fd.append('month' ,model.month);
        fd.append('day',model.day );
        fd.append('image_file', file);
        fd.append('nationality',model.nationality );
        fd.append('nid',model.nid );
        fd.append('user_id',model.user_id);

        $http.post('/api/customer', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .then(function onSuccess(response) {
            mockUser = response.data;
            defer.resolve(mockUser);          
        })
        .catch(function onError(response) {
          // Handle error
          console.log(response);
        });

        return defer.promise;
    };

    this.getPendingCust = function(userid,pageNumber) {
      return $http.get('/api/pendingcustomers/'+'?page='+pageNumber)
      .then(function onSuccess(response) {
             // Handle success
             return  response.data;            
            });  //1. this returns promise
    }


    
}]);