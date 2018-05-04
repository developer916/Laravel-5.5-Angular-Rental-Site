(function () {

    RentomatoApp.factory('CurrencyService', ['$q', '$http', 'BaseService', CurrencyService]);

    function CurrencyService($q, $http, BaseService) {
        var getList = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/currencies/',
                    method: 'GET',
                    cache: true
                }));
        };
        return {
            getList: getList,
        };
    }
}());