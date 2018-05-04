RentomatoApp.factory('PaymentPerTenantService', function ($http, BaseService) {
    var PaymentPerTenantService = {
        getTenants: function(){
            var request = $http({
                url: '/paymentPerTenant/tenants',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        getTenantPayment: function(id){
            var request = $http({
                url: '/paymentPerTenant/getTenantPayment/' + id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        paymentImportFileUpload: function (data){
            var request = $http({
                data: data,
                url: '/paymentPerTenant/importFileUpload',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },
        paymentDeregFileUpload: function (data) {
            var request = $http({
                data: data,
                url: '/paymentPerTenant/deregFileUpload',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        }
    }
    return PaymentPerTenantService;
})