var app = angular.module('tabs', []);
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

