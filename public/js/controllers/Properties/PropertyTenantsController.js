'use strict';

RentomatoApp.controller('PropertyTenantsController', [
    "$scope",
    '$stateParams',
    '$filter',
    '$compile',
    'toaster',
    'PropertyService',
    function ($scope, $stateParams, $filter, $compile, toaster, PropertyService) {
        var vm = this;
        vm.property = {
            id: PropertyService.model.id,
            tenants: [],
            units: null
        }

        PropertyService.getBasicProperty(vm.property.id).then(function (response) {
            if (response.data.units) {
                var units = [];
                for (var i = 0; i < response.data.units.length; i++) {
                    var e = response.data.units[i];
                    units.push({id: e.id, title: e.unit})
                }
                response.data.units = units;
            }
            if (!response.data.tenants) {
                response.data.tenants = [];
            }
            vm.property = response.data;
        });

        var cloneScope = null;
        vm.manageTenant = function (model) {
            if (cloneScope) {
                cloneScope.$destroy();
            }
            cloneScope = $scope.$new();
            cloneScope.tmpTenantModel = model;
            if (model) {
                var panel = angular.element('<div property="propertyTenantsCtrl.property" ng-model="tmpTenantModel" tenant-model-updated="propertyTenantsCtrl.tenantModelUpdated(model)" tenant-vf></div>');
            } else {
                var panel = angular.element('<div property="propertyTenantsCtrl.property" tenant-model-updated="propertyTenantsCtrl.tenantModelUpdated(model)" tenant-vf></div>');
            }
            var compileFn = $compile(panel);
            compileFn(cloneScope);
            $('#action-panel').html(panel);
        }
    }]);