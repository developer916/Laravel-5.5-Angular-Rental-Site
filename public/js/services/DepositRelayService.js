RentomatoApp.factory('DepositRelayService', function ($http, BaseService) {
    var DepositRelayService = {
        getDepositRelays: function(){
            var request = $http({
                url: '/depositRelays/getRelays',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        changeAmountDepositRelays: function (data){
            var request = $http({
                data: data,
                url: '/depositRelays/saveRelay',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },
        cancelDepositRelay: function(data){
             var request = $http({
                data: data,
                url: '/depositRelay/cancel',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },
    }
    return DepositRelayService;
})