RentomatoApp.factory('ContractWorkbenchService', function ($http, BaseService) {
    var ContractWorkbenchService = {
        getRentComponents: function () {
            var request = $http({
                url: '/contractWorkbench/getRentComponents',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        getPropertyUnits: function (property_id) {
            var request = $http({
                url: '/contractWorkbench/getPropertyUnits/' + property_id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
        createPostRentComponent: function (data) {
            var request = $http({
                url: '/contractWorkbench/postCreateRentComponent',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },
        deleteRentComponent: function (rent_component_id) {
            var request = $http({
                url: '/contractWorkbench/deleteRentComponent/' + rent_component_id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },
    }
    return ContractWorkbenchService;
})