RentomatoApp.factory('LisaService', function ($http, $window, BaseService) {
  var LisaService = {
    getPageContent: function () {
      var request = $http({
        url: '/lisa',
        method: 'POST',
        data: {url: $window.location}
      });
      return BaseService.apiCall(request);
    }
  };

  return LisaService;
});
