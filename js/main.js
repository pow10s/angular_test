var app = angular.module('tabs', []);
app.controller('tabsData', function($scope, $http) {
  $http.get("tab1.php").then(function (response) {
      $scope.myData = response.data.records;
  });

  $http.get("tab2.php").then(function (response) {
      $scope.myData2 = response.data.records;
  });
});

