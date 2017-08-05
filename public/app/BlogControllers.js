var app = angular.module('Blogcontrollers', [])

app.controller('blogController', function($scope, $http) {
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
            $http.get("/api/blogpost?page="+pageNumber)
                .then(function onSuccess(response) {
                    $scope.blogposts = response.data.data;
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
        $http.get('/api/category')
            .then(function onSuccess(response) {
                $scope.categories = response.data;
        });

       //Get the archieve 
       $http.get('/api/archievepost')
            .then(function onSuccess(response) {
                $scope.archieve  = response.data;
        });




    });

    app.controller('getPostController', function($scope, $http, $routeParams) {
        //Format Date 
        $scope.getDateFormat = function(timestamp) {
            return new Date(timestamp);
        }

    	$scope.param = $routeParams.id;
    	var id = $scope.param;

    	$http.get('/api/blogpost/' + id)
            .then(function onSuccess(response) {
                $scope.posts = response.data;
        });
        
        $scope.getComments = function(pid){
            $http.get('/api/blogpostcomment/' + pid)
                .then(function onSuccess(response) {
                    $scope.comments = response.data;
            });
        }
        $scope.getComments(id);

        $scope.saveComment = function() {
            $scope.commentPost['on_post'] = id;
            var url = '/api/blogpostcomment';
            $http({
                method: 'POST',
                url: url,
                data: $.param( $scope.commentPost),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function onSuccess(response) { 
                  $scope.getComments(id);
                  $scope.personForm.$setPristine();
                }).catch(function onError(response) {
                    alert('An error has occured. Please check the log for details');
                });

        }
      
    });