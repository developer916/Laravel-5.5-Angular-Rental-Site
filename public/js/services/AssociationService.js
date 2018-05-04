RentomatoApp.factory('AssociationService', function ($http, BaseService) {
    var AssociationService = {        

        createAssociation: function (data) {            
            var request = $http({
                url: '/association/create',
                data: data,
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },
        

        getPropertyList: function (id) {            
            var request = $http({
                url: '/association/properties/' + id,                
                method: 'GET'
            });
            return BaseService.apiCall(request);
        }

    };
    ////

    return AssociationService;
});