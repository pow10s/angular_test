var app = angular.module('main', ['angularModalService']);
app.controller('tabsData', function($scope, $http) {

    $http({
        method : 'GET',
        url : 'questions'
    }).then(function successCallback(response) {
        $scope.allRecords = response.data;
    }, function errorCallback(response) {
        console.log(response.statusText);
    });

    $http({
        method : 'GET',
        url : 'questions/new'
    }).then(function successCallback(response) {
        $scope.newRecord = response.data;
    }, function errorCallback(response) {
        console.log(response.statusText);
    });

    $http({
        method : 'GET',
        url : 'questions/week'
    }).then(function successCallback(response) {
        $scope.weekRecord = response.data;
    }, function errorCallback(response) {
        console.log(response.statusText);
    });


    $http({
        method : 'GET',
        url : 'questions/month'
    }).then(function successCallback(response) {
        $scope.monthRecord = response.data;
    }, function errorCallback(response) {
        console.log(response.statusText);
    });


});

app.controller('postController', function($scope, $http,$window) {

    $scope.submitForm = function() {
        $http.post('questions/test',$scope.question)
          .success(function (data) {
            console.log(data);
            $window.location.href = "questions.html"

        })
        };
    });

app.controller('PopupController', ['$scope', 'ModalService', function($scope, ModalService) {

  $scope.customResult = null;

  $scope.showForm = function() {

    ModalService.showModal({
      templateUrl: "form.html",
      controller: "CloseController"
    }).then(function(modal) {
      modal.close.then(function(result) {
        $scope.customResult = "All good!";
      });
    });

  };

}]);

app.controller('CloseController', ['$scope', 'close', function($scope, close) {

  $scope.close = close;

}]);



