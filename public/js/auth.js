angular.module('auth', [])

.factory('AuthenticationService', function () {
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