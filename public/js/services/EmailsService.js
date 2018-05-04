RentomatoApp.factory('EmailsService', function ($http, BaseService) {
    var EmailsService = {
        getEmailsList: function () {
            var request = $http({
                url: '/emails',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        deleteEmail: function (id) {
            var request = $http({
                url: '/emails/delete/' + id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        getEmailEvents: function () {
            var request = $http({
                url: '/emails/events',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        saveEmail: function (data) {
            var request = $http({
                data: data,
                url: '/emails/save',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        }
    };

    return EmailsService;
})
;