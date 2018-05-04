'use strict';

RentomatoApp.controller('TenantsController', function ($rootScope, $scope, $stateParams, toaster, TenantsService, $filter, UserService, PropertyService) {

    $scope.inviteRows = [];
    $scope.properties = {};
    $scope.initCreateTenant = function () {
        UserService.getAuthUserPropertiesWithUnits().then(function (response) {
            if(response){
                for(var i=0;i<response.length;i++){
                    var item = response[i];
                    $scope.properties[item.id] = item;
                }
            }
        });

    }
    $scope.addRow = function () {
        $scope.inviteRows.push({
            tenant: {
                name: '',
                email: '',
            },
            errors: null
        });
    };

    if ($stateParams.propertyId) {
        $scope.property = {};
        PropertyService.getProperty($stateParams.propertyId).then(function (response) {
            $scope.property = response.data;
        });
    }

    // add first row

    if ($stateParams.id) {
        TenantsService.getTenant($stateParams.id).then(function (response) {
            $scope.tenant = response.data;
            $scope.inviteRows.push({
                tenant: response.data,
                errors: null
            });
        });
    } else {
        $scope.addRow();
    }

    $scope.updateTenantInfo = function () {
        TenantsService.updateTenant($scope.tenant).then(function (response) {
            if (response.status == 1) {
                toaster.success($filter('translate')('Tenant information updated'));
            }
        });
    };

    $scope.saveTenantRow = function (data) {
        TenantsService.createSingleTenant($scope.inviteRows[data]).then(function (response) {
            if($scope.inviteRows[data].tenant.property_tenant) {
                response.data.tenant.property_tenant = $scope.inviteRows[data].tenant.property_tenant;
            }
            $scope.inviteRows[data] = response.data;
            if (response.errors) {
                toaster.error($filter('translate')('An error occured!'));
            } else {
                toaster.success($filter('translate')('Tenant data saved'));
            }
        }, function (err) {
            toaster.error($filter('translate')('An error occured, please try again later'));
        });
    }

    $scope.searchTenants = function (searchTerm) {
        TenantsService.searchTenants(searchTerm).then(function (response) {
            return response.items;
        });
    }

});
