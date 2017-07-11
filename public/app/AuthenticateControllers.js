var app = angular.module('Authenticatecontrollers', [])

app.controller('loginController', function($scope, $http,$location, API_URL,accountService) {
        $scope.account = {
            email: '',
            password: ''
        }
        $scope.users = {
            email: '',
            password: '',
            c_password:''
        }
        $scope.login = function(acc) {
            $scope.account = acc;

            accountService.login(API_URL,$scope.account).then(function(data) {
                if(data.status){
                    $('#myModal').modal('hide');
                    var id = data.id;
                    $location.path('/sendmoney/'+id); 
                    this.account=null;
                    $('#loginform').children('input').val('');                
                }
                else{
                    alert(data.message);
                    $location.path('/'); 
                }
            }, function(error) {
                $scope.message = error.error_description;
            })
        }
        $scope.logout = function() {
            accountService.logout();
            $location.path('/'); 
        }

        $scope.signup = function(usrs) {
            $scope.users = usrs;
            var url = API_URL + "user";
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.users),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function onSuccess(response) {
                delete $scope.users.c_password;
                $scope.login($scope.users);
            }).catch(function onError(response) {
                console.log(response);
                alert('An error has occured. Please check the log for details');
            });
    }
});
    
app.controller('signupController', function($scope, $rootScope, $window, $http, API_URL,$location) {
        

});