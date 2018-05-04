RentomatoApp.factory('DashboardService', function ($http, BaseService) {
  var DashboardService = {
    getDepositRelay: function() {
        var request = $http({
            url: '/dashboard/get/deposit',
            method: 'GET'
        });
        return BaseService.apiCall(request);
    },
    getWidgetsStats: function () {
      var request = $http({
        url: '/dashboard/widgets/stats',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },

    getWidgetMonthlyRent: function () {
      var request = $http({
        url: '/dashboard/widgets/stats/thismonthsrent',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },

    getWidgetLatest: function () {
      var request = $http({
        url: '/dashboard/widgets/stats/latest',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },

    updateFirstLogin: function () {
      var request = $http({
        url: '/user/update/first/login',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },

    getFirstLogin: function () {
      var request = $http({
        url: '/user/get/first/login',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    }
  };


  return DashboardService;
});
