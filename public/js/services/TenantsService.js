RentomatoApp.factory('TenantsService', function ($http, BaseService) {
    var TenantsService = {

        createNewTenant: function (data) {
            var request = $http({
                url: '/tenant/create',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },

        createSingleTenant: function (data) {
            var request = $http({
                url: '/tenant/create_single_tenant',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },


        updateTenant: function (data) {
            var request = $http({
                url: '/tenant/update',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },

        getTenants: function (limit, offset) {
            var request = $http({
                url: '/tenants',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        getTenant: function (id) {
            var request = $http({
                url: '/tenant/' + id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        deleteTenant: function (id) {
            var request = $http({
                url: '/tenants/delete/' + id,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        searchTenants: function (searchterm) {
            var request = $http({
                url: '/tenants/search/',
                method: 'POST',
                data: {term: searchterm}
            });
            return BaseService.apiCall(request);
        },



    };

    return TenantsService;
});
