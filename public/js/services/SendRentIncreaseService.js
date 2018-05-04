RentomatoApp.factory('SendRentIncreaseService', function ($http, BaseService) {
    var SendRentIncreaseService = {
        getSendRentIncreaseList: function(){
            var request = $http({
                url: '/sendRentIncrease/getList',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        createPostCreate: function (data) {
            var request = $http({
                url: '/sendRentIncrease/postCreate',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },
        reCalculateAmount: function (data) {
            var request = $http({
                url: '/sendRentIncrease/getList',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        }

    }
    return SendRentIncreaseService;
})