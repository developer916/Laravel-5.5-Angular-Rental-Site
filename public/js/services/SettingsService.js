RentomatoApp.factory('SettingsService', function ($http, BaseService) {
  var SettingsService = {
    savePersonalInfo: function (data) {
      var request = $http({
        data: data,
        url: '/settings/save/personal',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },
    updatePassword: function (data) {
      var request = $http({
        data: data,
        url: '/settings/save/password',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },
    updateAvatar: function (avatar) {
      var request = $http({
        data: {avatar:avatar},
        url: '/settings/save/avatar',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },
    updatePrivacy: function (data) {
      var request = $http({
        data: data,
        url: '/settings/save/privacy',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },

    updateCurrency: function (data) {
      var request = $http({
        data: data,
        url: '/settings/save/currency',
        method: 'POST'
      });
      return BaseService.apiCall(request);
    },

    getAccountData: function () {
      var request = $http({
        url: '/settings/get',
        method: 'GET'
      });
      return BaseService.apiCall(request);
    },
    deleteAccount : function (data){
        var request = $http({
            data: data,
            url: '/settings/delete/account',
            method: 'POST'
        });
        return BaseService.apiCall(request);
    },
    passwordCheck : function (data) {
        var request = $http({
            data: data,
            url: '/settings/password/check',
            method: 'POST'
        });
        return BaseService.apiCall(request);
    },
    removeFileUpload : function (){
        var request = $http({
            url: '/settings/removeFileUpload',
            method: 'GET'
        });
        return BaseService.apiCall(request);
    }
  };

  return SettingsService;
});
