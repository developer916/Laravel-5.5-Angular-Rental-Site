RentomatoApp.factory('UserService', ['$q', '$http', 'BaseService',
  function ($q, $http, BaseService) {
    var service = {
      data: {
        profile: {
          currency_id: 1,
          currency: {}
        },
        role: {}
      }
    };

    service.getAuthUser = function () {
      var deferred = $q.defer();
      BaseService.apiCall($http.get('/admin/users/auth-user-data')).then(function (response) {
        angular.copy(response, service.data);
        deferred.resolve(response);
      }, function (err) {
        deferred.reject(err);
      });
      return deferred.promise;
    }

    service.setData = function (obData) {
      angular.copy(obData, service.data);
    }

    service.getUsers = function (filter, limit, offset) {
      var request = $http({
        url: '/users/get',
        method: 'POST',
        data: filter,
        cache: false
      });
      return BaseService.apiCall(request);
    }

    service.getUserById = function (id) {
      return BaseService.apiCall($http.get('/user/' + id));
    }

    service.getRecipients = function (id) {
      return BaseService.apiCall($http.get('/user/recipients'));
    }

    service.getVisibleUsers = function () {
      return BaseService.apiCall($http.get('/user/visible-users/'));
    }

    service.getAuthUserProfile = function () {
      return BaseService.apiCall($http.get('/admin/users/auth-user-profile'));
    }

    service.getAuthUserProperties = function () {
      return BaseService.apiCall($http.get('/admin/users/auth-user-properties'));
    }

    service.getAuthUserPropertiesWithUnits = function () {
      return BaseService.apiCall($http.get('/admin/users/auth-user-properties-with-units'));
    }

    service.setLanguage = function (data) {
        var request = $http({
            data: data,
            url: '/admin/users/setLanguages',
            method: 'POST'
        });
        return BaseService.apiCall(request);
    }


    service.disableDemoData= function () {
      return BaseService.apiCall($http.put('/status/demo'));
    }

    service.getTags = function() {
      return BaseService.apiCall($http.get('/user/get/tags'));
    }

    return service;
  }
]);
