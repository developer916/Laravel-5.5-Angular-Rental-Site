RentomatoApp.factory('LandlordService', function ($http, BaseService) {
    var LandlordService = {

        getTenants: function () {
            return BaseService.apiCall(
                $http({
                    url: '/landlord/tenants-list',
                    method: 'GET',
                }));
        }

    };
    //
    return LandlordService;
});
