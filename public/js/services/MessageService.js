RentomatoApp.factory('MessageService', function ($http, BaseService) {
    var MessageService = {
        getMessages: function () {
            var request = $http({
                url: '/messages',
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        sendMessage: function(data) {
            var request = $http({
                url: '/messages/send',
                data: data,
                method: 'POST'
            });
            return BaseService.apiCall(request);
        },

        getReplyDetails: function(id, type) {
            var request = $http({
                url: '/messages/getReplyDetails/' + id + '/' + type,
                method: 'GET'
            });
            return BaseService.apiCall(request);
        },

        deleteMessage: function(id) {
            var request = $http({
                url: '/messages/delete/' + id,
                method: 'DELETE',
            });
            return BaseService.apiCall(request);
        },

        update: function(data) {
            var request = $http({
                url: '/messages',
                method: 'PUT',
                data: data
            });
            return BaseService.apiCall(request);
        },

        updateTags: function(data) {
            var request = $http({
                url: '/messages/tags',
                method: 'POST',
                data: data
            });
            return BaseService.apiCall(request);
        },

        deleteTag: function(id) {
            var request = $http({
                url: '/tags/' + id,
                method: 'DELETE',
            });
            return BaseService.apiCall(request);
        }

    };

    return MessageService;
});