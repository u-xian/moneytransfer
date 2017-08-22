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
            $scope.processing = true;

            accountService.login($scope.account).then(function(response) {
                $scope.processing = false;
                $('#loginform').children('input').val('');
                if(response.status){
                    $('#myModal').modal('hide');
                    var id = response.id;
                    $scope.infouser = angular.fromJson(sessionStorage.user);
                    if($scope.infouser.is_admin){
                        this.account=null;
                        $location.path('/adminhome/'+id);                       
                    }
                    else{
                        this.account=null;
                        $location.path('/sendmoney/'+id);
                    }                   
                    
                                    
                }
                else{
                    $scope.loginError = response.message;
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