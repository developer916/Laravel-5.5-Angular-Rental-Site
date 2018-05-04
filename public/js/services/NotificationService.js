RentomatoApp.factory('NotificationService', function ($http, BaseService) {
  var NotificationService = {
    getNotifications: function (data) {
      var request = $http({
        url: '/notifications',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    }
  };

  return NotificationService;
});
