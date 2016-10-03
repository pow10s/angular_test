var helloApp = angular.module("helloApp", [ 'ngResource' ]);
	helloApp.controller("HttpController", [ '$scope', '$resource',
			function($scope, $resource) {
				$scope.saveQuestion = function(){		
					var Question = $resource('questions/');

					// Call action method (save) on the class 
					Question.save({title:$scope.title, text:$scope.text, tags:$scope.tags,user:$scope.user}, function(response){
						$scope.message = response.message;
					});
					
					$scope.title='';
					$scope.text='';
					$scope.tags='';
					$scope.user='';
				}
			
			} 
			]);




