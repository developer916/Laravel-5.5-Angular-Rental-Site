'use strict';

RentomatoApp.controller('DashboardController', function ($rootScope, $scope, DashboardService, $cookies) {

  DashboardService.getFirstLogin().then(function (response) {
    if (response.hasLogin == '0') {
      var language = $cookies.get('lang').replace('"', '');
      $('#first-login-' + language.replace('"', '')).modal('show');
      DashboardService.updateFirstLogin();
    }
  });
  DashboardService.getDepositRelay().then(function (response){
    $scope.depositRelay = response;
  });

  DashboardService.getWidgetsStats().then(function (response) {
    $scope.widgets = response;
  });

  DashboardService.getWidgetMonthlyRent().then(function (response) {
    $scope.widgetmonthlyrent = response;
  });

  DashboardService.getWidgetLatest().then(function (response) {
    $scope.widgetlast = response;
  });

});
