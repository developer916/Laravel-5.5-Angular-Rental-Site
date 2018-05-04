RentomatoApp.factory('CountryService', ['$q', '$http', 'BaseService',
    function ($q, $http, BaseService) {
        var service = {
            assocCountryList: []
        };

        service.getList = function () {
            var deferred = $q.defer();
            BaseService.apiCall($http.get('/properties/countries')).then(function (response) {
                for (var i = 0; i < response.length; i++) {
                    service.assocCountryList[response[i].title] = response[i].id;
                }
                deferred.resolve(response);
            }, function (err) {
                deferred.reject(err);
            });
            return deferred.promise;
        }

        return service;
    }]);