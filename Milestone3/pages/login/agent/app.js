var todo = angular.module('todo', []);




todo.directive('datepicker', function($parse) {
  var directiveDefinitionObject = {
    restrict: 'A',
    link: function postLink(scope, iElement, iAttrs) {
      iElement.datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
          scope.$apply(function(scope){
            $parse(iAttrs.ngModel).assign(scope, dateText);
          });
        }
      });
    }
  };
  return directiveDefinitionObject;
});


todo.directive('notification', ['$timeout', function ($timeout) {
			return {
				restrict: 'A',
				controller: ['$scope', function ($scope) {
					$scope.notification = {
						status: 'hide',
						type: 'success',
						message: 'Welcome! It\'s yet another angular alert ;)'
					};
				}],
				link: function(scope, elem, attrs) {
					// watch for changes
					attrs.$observe('notification', function (value) {
						if (value === 'show') {
							// shows alert
							$(elem).show();

							// and after 3secs
							$timeout(function () {
								// hide it
								$(elem).hide();

								// and update the show property
								scope.notification.status = 'hide';
							}, 2500);
						}
					});
				}
			};
		}]);

todo.controller('TodoController', function($scope, $http, $window){
    getTask(); // Load all available tasks
    gettodayTask();
    
    $scope.$watchCollection('[tasks,todayapp]', function(){
        $scope.restant = $scope.tasks.length;
        $scope.restanttoday = $scope.todayapp.length;
    }, true);

   
//    $scope.$watch('tasks', function(){
//       $scope.restant = $scope.tasks.length;
//    }, true);
//    $scope.pop = function(){
//            toaster.pop('success', "title", "text");};
    $scope.orderByField = 'date';
    $scope.reverseSort = false;
        $scope.loadeditmodal = function (appid,appwith,appdate,apptime) {
     
            $scope.appid = appid;
            $scope.appwith = appwith;
            $scope.appdate = appdate;
            $scope.apptime = apptime;
        }
   
     
       
   

   
        $scope.deltask = function (id) {
            if($window.confirm('are you sure to delete this appointment?')) {
            $http.post('deletetask.php', {'appid' : id}).
		success(function(data, status) {
                        $scope.notification.status = 'show';
			$scope.status = status;
			$scope.data = data;
                        getTask();
                        gettodayTask();
			
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
		});
           }    
       
        };

      
        function getTask(){
        $http.get("tasks.php").success(function(data){
        $scope.tasks = data;
        });
        };
        
        function gettodayTask(){
        $http.get("todayapp.php").success(function(data){
        $scope.todayapp = data;
        });
        };
        
        $scope.addTask = function () {
            
            $http.post("addtask.php", { "appointment" : $scope.appointment , "date" : $scope.date , "time" : $scope.time}).
		success(function(data, status) {
			$scope.status = status;
			$scope.data = data;
                        getTask();
                        gettodayTask();
                        $scope.appointment = "";
                        $scope.date = "";
                        $scope.time = "";
			
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
		});
       
        };
        
         $scope.taskdone = function (id) {
            
            $http.post('taskdone.php', {'appid' : id}).
		success(function(data, status) {
                        $scope.notification.status = 'show';
			$scope.status = status;
			$scope.data = data;
                        getTask();
                        gettodayTask();
			
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
		});
       
        };
        
        $scope.updatetask = function (appid,appwith,appdate,apptime) {
            
            $http.post('updatetask.php', {'appid' : appid, 'appwith' : appwith, 'appdate' : appdate, 'apptime' : apptime}).
		success(function(data, status) {
                        $scope.notification.status = 'show';
			$scope.status = status;
			$scope.data = data;
                        getTask();
                        gettodayTask();
                        
			
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
		});
       
        };

    
    
     
     
    

});