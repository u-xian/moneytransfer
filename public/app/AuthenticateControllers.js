var app = angular.module('Authenticatecontrollers', [])

app.controller('loginController', function($scope, $http,$location,accountService) {
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

            accountService.login($scope.account).then(function(data) {
                if(data.status){
                    $('#myModal').modal('hide');
                    var id = data.id;
                    $scope.infouser = angular.fromJson(sessionStorage.user);
                    $location.path('/sendmoney/'+id);
                    this.account=null;
                    $('#loginform').children('input').val('');                
                }
                else{
                    console.log(data);
                    $location.path('/'); 
                }
            }, function(error) {
                console.log(error);
                $scope.message = error.error_description;
            })
        }
        $scope.logout = function() {
            accountService.logout();
            $location.path('/'); 
        }

        $scope.signup = function(usrs) {
            $scope.processing = true;
            $scope.users = usrs;
            var url = '/api/user';
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.users),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function onSuccess(response) {
                $scope.processing = false;
                delete $scope.users.c_password;
                $scope.login($scope.users);
            }).catch(function onError(response) {
                $scope.processing = false;
                $scope.stripeError = response.data.message;
                //alert('Please correct the following fields before continuing: ' + '<ul>'+response.data.message+'</ul>');
            });
    }
});
    
app.controller('signupController', function($scope) {
});