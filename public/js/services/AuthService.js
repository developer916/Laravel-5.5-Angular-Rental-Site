RentomatoApp.factory('AuthService', function ($http, BaseService) {
    var AuthService = {
        login: function (data) {
            var request = $http({
                data: data,
                url: '/auth/login',
                method: 'POST'
            });
            return BaseService.apiCall(request);
        }
    };

    return AuthService;
});