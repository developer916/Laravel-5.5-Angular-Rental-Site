RentomatoApp.factory('BaseService', function ($http, $q, toaster) {
    var BaseService = {
        apiCall: function (request, localErrorHandling) {
            var deferred = $q.defer();
            request.then(function (res) {
                deferred.resolve(res.data);
            },function (err) {
                if (localErrorHandling != true) {
                    if (err.data.error) {
                        toaster.pop('error', "Error", err.data.error.customMsg);
                    } else {
                        toaster.pop('error', "Error", "");
                    }
                }
                deferred.reject(err);
            });
            return deferred.promise;
        }
    };
    return BaseService;
});