'use strict';

RentomatoApp.controller('PropertyUserTransactionsController', [
    "$scope",
    '$stateParams',
    '$filter',
    '$compile',
    'toaster',
    'PropertyService',
    function ($scope, $stateParams, $filter, $compile, toaster, PropertyService) {
        var vm = this;
        vm.propertyTenant = {
            id: $stateParams.ptid,
            tenant:null
        }

        PropertyService.getTenantByPropertyTenant($stateParams.ptid).then(function(response){
            vm.propertyTenant.tenant = response;
        });

        var cloneScope = null;
        vm.manageUserTransaction = function (model) {
            if (cloneScope) {
                cloneScope.$destroy();
            }
            cloneScope = $scope.$new();
            cloneScope.tmpModel = model;
            if (model) {
                var panel = angular.element('<div property-tenant="propertyUserTransactionsCtrl.propertyTenant" currency-symbol="{{app.userServiceData.user.profile.currency.symbol}}" ng-model="tmpModel" user-transaction-model-updated="propertyUserTransactionsCtrl.userTransactionModelUpdated(model)" property-user-transaction-vf></div>');
            } else {
                var panel = angular.element('<div property-tenant="propertyUserTransactionsCtrl.propertyTenant" currency-symbol="{{app.userServiceData.user.profile.currency.symbol}}" user-transaction-model-updated="propertyUserTransactionsCtrl.userTransactionModelUpdated(model)" property-user-transaction-vf></div>');
            }
            var compileFn = $compile(panel);
            compileFn(cloneScope);
            $('#action-panel').html(panel);
        }
    }]);