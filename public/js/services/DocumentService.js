RentomatoApp.factory('DocumentService', function ($http, BaseService) {
    var DocumentService = {

        createDoc: function (data) {
            var request = $http({
                url: '/document/new',
                data: data,
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },
        deleteDoc: function (id) {
            var request = $http({
                url: '/documents/delete/' + id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        getDoc: function (data) {
            var request = $http({
                url: '/document/' + data,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        updateDoc: function (data) {
            var request = $http({
                url: '/documents/update',
                data: data,
                method: 'POST'
            });
            return BaseService.apiCall(request);
        }
    };
    ////

    return DocumentService;
});
