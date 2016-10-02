var app = angular.module('tabs', []);
app.controller('tabsData', function($scope, $http) {

  $http({
    method : 'GET',
    url : 'questions'
}).then(function successCallback(response) {
    $scope.myData = response.data;
}, function errorCallback(response) {
    console.log(response.statusText);
});

});

