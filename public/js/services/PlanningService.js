RentomatoApp.factory('PlanningService', function ($http, BaseService) {
    var PlanningService = {
        getTasks: function(data) {
            var request = $http({
                url: '/tasks',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        deleteTask: function(id) {
            var request = $http({
                url: '/tasks/' + id,
                method: 'DELETE',
            });
            return BaseService.apiCall(request);
        },

        updateTask: function(data) {
            var request = $http({
                url: '/tasks/' + data.id,
                method: 'PATCH',
                data: data
            });
            return BaseService.apiCall(request);
        }
    };

    return PlanningService;
});