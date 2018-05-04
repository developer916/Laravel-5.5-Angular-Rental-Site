RentomatoApp.factory('TagService', function ($http, BaseService) {
    var TagService = {
        createTag: function(name) {
            var request = $http({
                url: '/tags',
                method: 'POST',
                data: {name: name}
            });
            return BaseService.apiCall(request);
        },

        updateTag: function(tag) {
            var request = $http({
                url: '/tags',
                method: 'PATCH',
                data: tag
            });
            return BaseService.apiCall(request);
        }
    };

    return TagService;
});