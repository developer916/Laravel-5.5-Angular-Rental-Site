(function () {

    RentomatoApp.factory('PropertyService', ['$q', '$timeout', '$http', '$cacheFactory', 'BaseService', PropertyService]);

    function PropertyService($q, $timeout, $http, $cacheFactory, BaseService) {
        var service = {};
        service.model = {
            id: null,
            parent_id: null,
            status: 0
        }
        service.updateModel = function (model) {
            angular.extend(service.model, model);
        }

        service.assignTenantToProperty = function (data) {
            return BaseService.apiCall(
                $http({
                    url: '/property-tenants/create',
                    data: data,
                    method: 'POST',
                    cache: false
                }));
        }

        service.create = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/create',
                    data: data,
                    method: 'POST',
                    cache: false
                }));

        }

        service.updateMedia = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/update_media',
                    data: data,
                    method: 'POST',
                    cache: false
                }));

        }

        service.edit = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/edit',
                    method: 'POST',
                    data: {id: id},
                    cache: false
                }));
        }

        service.deletePhoto = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/delete_photo/' + data.property_id + '/' + data.id,
                    method: 'GET',
                    cache: false
                }));
        }

        service.updateStatus = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/update_status',
                    method: 'POST',
                    data: data,
                    cache: false
                }));
        }

        service.update = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/update',
                    method: 'POST',
                    data: data,
                    cache: false
                }));
        }

        service.getProperty = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/view/' + id,
                    method: 'GET',
                    cache: false
                }));
        }

        service.getPropertyOverview = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/overview/' + id,
                    method: 'GET',
                    cache: false
                }));
        }

        service.getBasicProperty = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/basic/' + id,
                    method: 'GET',
                    cache: false
                }));
        }

        service.getIdentityProperty = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/identity/' + id,
                    method: 'GET',
                    cache: false
                }));
        }

        service.getUnitsHttp = function (id) {
            return $http({
                url: 'properties/units/' + id,
                method: 'GET',
                cache: false
            })
        }

        service.getUnits = function (id) {
            return BaseService.apiCall(
                service.getUnitsHttp(id)
            );
        }

        service.getTransactionsHttp = function (id) {
            return $http({
                url: 'properties/transactions/' + id,
                method: 'GET',
                cache: false
            })
        }

        service.getTransactions = function (id) {
            return BaseService.apiCall(
                service.getTransactionsHttp(id)
            );
        };

        service.getCountTransactions = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/transactions-count/' + id,
                    method: 'GET',
                    cache: false
                }));
        };


        service.getTenants = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/tenants/' + id,
                    method: 'GET',
                }));
        };

        service.getAmenities = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/amenities/',
                    method: 'GET',
                }));
        };

        service.getTenantByPropertyTenant = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'property-tenants/tenant/' + id,
                    method: 'GET',
                }));
        };


        service.createUpdateTransaction = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/transaction',
                    data: data,
                    method: 'POST',
                }));
        };


        service.getTransactionCategories = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/transaction-categories',
                    method: 'GET',
                    cache: true
                }));
        }
        service.getTransactionRecurrings = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/transaction-recurrings',
                    method: 'GET',
                    cache: true
                }));
        }

        service.getTransactionTypes = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/transaction-types',
                    method: 'GET',
                    cache: true
                }));
        }


        service.getPropertyTypes = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/property-types',
                    method: 'GET',
                    cache: true
                }));
        };

        service.searchTenantByName = function (val) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/search_by_name',
                    data: {term: val},
                    method: 'POST',
                    cache: false
                }));
        }

        service.createUpdateTenant = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/create-update-tenant',
                    data: data,
                    method: 'POST',
                    cache: false
                }));

        }

        service.createUpdateUserTransaction = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/create-update-user-transaction',
                    data: data,
                    method: 'POST',
                    cache: false
                }));

        }

        service.deleteUserTransaction = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/delete-user-transaction/'+data.id,
                    method: 'GET',
                    cache: false
                }));

        }

        service.deleteTransactions = function (data) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/delete-transactions/'+data.id,
                    method: 'GET',
                    cache: false
                }));

        }

        // Service Cost Account
        service.getCostTypes = function () {
            return BaseService.apiCall(
                $http({
                    url: 'properties/cost-types/SCtype',
                    method: 'GET',
                    cache: false
                }));
        }

        service.createScaccount = function (data) {            
            return BaseService.apiCall(
                $http({
                    url: 'properties/create-scaccount',
                    data: data,
                    method: 'POST',
                    cache: false
                }));

        }

        service.delScaccount = function (id) {
            return BaseService.apiCall(
                $http({
                    url: 'properties/delete-scaccount/' + id,
                    method: 'GET',
                    cache: false
                }));            
        }
        //end Service Cost Account

        return service;
    }

}());
