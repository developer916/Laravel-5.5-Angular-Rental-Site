RentomatoApp.factory('I18NService', function ($http, BaseService) {
  var I18NService = {
    getTranslations: function () {
      var request = $http({
        url: '/translations/',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },
    addItem: function (data) {
      var request = $http({
        url: '/translations/add',
        method: 'POST',
        data: data
      });
      return BaseService.apiCall(request);
    },
    updateItem: function (data, id) {
      var request = $http({
        url: '/translations/update/' + id,
        method: 'POST',
        data: data
      });
      return BaseService.apiCall(request);
    },
    publish: function (language_id) {
      var request = $http({
        url: '/translations/publish',
        method: 'POST',
        data: {language_id: language_id}
      });
      return BaseService.apiCall(request);
    },
    getLanguages: function () {
      var request = $http({
        url: '/translations/languages',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },
    index: function () {
      var request = $http({
        url: '/translations/index',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },
    setLocale: function (locale) {
      var request = $http({
        url: '/locale/' + locale,
        method: 'GET'
      });
      return BaseService.apiCall(request);
    }
  };

  return I18NService;
});
