RentomatoApp.factory('ContractService', ['$q', '$http', 'BaseService',
    function ($q, $http, BaseService) {
        var service = {
            ContractTypeList: [],
            formFields:[],  // constants which has property id
            formFields1:[] // constants which has null property id
        };

        service.getContractTypes = function () {
            var deferred = $q.defer();
            BaseService.apiCall($http.get('/contracts/types')).then(function (response) {
                for (var i = 0; i < response.length; i++) {
                    service.ContractTypeList[response[i].title] = response[i].id;
                }
                deferred.resolve(response);
            }, function (err) {
                deferred.reject(err);
            });
            return deferred.promise;
        }

        service.getFormFields = function (typeId) {
            var deferred = $q.defer();
            BaseService.apiCall($http.get('/contracts/getFormFields/' + typeId)).then(function (response) {                                
                var fields = [];
                var temp;
                for (var i = 0; i < response.length; i++) {
                    temp = response[i].name
                    fields.push({text: temp, value: "#" + temp + "#"})
                }
                if(typeId == 2) {                    
                    service.formFields1 = fields;
                } else {
                    service.formFields = fields;
                }                

                deferred.resolve(response);
            }, function (err) {
                deferred.reject(err);
            });
            return deferred.promise;
        }

        return service;
    }]);