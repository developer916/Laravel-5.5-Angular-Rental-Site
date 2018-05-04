(function () {

    RentomatoApp.factory('UtilService', ['$q', '$http', 'BaseService', UtilService]);

    function UtilService($q, $http, BaseService) {

        return {
            range: range
        };

       function range(min, max, step) {
            step = step || 1;
            var input = [];
            for (var i = min; i <= max; i += step) {
                input.push(i);
            }
            return input;
        };
    }
}());