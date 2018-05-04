RentomatoApp.factory('ContractTemplateService', function ($http, BaseService) {
    var ContractTemplateService = {
        getTemplate: function (typeId, countryId, propertyId) {
            var request = $http({
                url: '/contracts/getTemplate/' + typeId + "/" + countryId + "/" + propertyId,                
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
               
        saveTemplate: function (data) {
            var request = $http({
                url: '/contracts/saveTemplate',
                data: data,
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },        

    };
    ////

    return ContractTemplateService;
});