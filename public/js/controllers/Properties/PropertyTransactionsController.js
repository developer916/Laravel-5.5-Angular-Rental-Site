'use strict';

RentomatoApp.controller('PropertyTransactionsController', [
    "$scope",
    '$stateParams',
    '$filter',
    '$compile',
    '$q',
    'toaster',
    'PropertyService',
    function ($scope, $stateParams, $filter, $compile, $q, toaster, PropertyService) {
        var vm = this;
        var cloneScope = null;
        vm.property = {
            id: PropertyService.model.id,
            cntTransactions: 0
        }
        vm.units = [];
        PropertyService.getTransactionCategories().then(function (response) {
            vm.transactionCategories = response.data;
        });
        PropertyService.getTransactionRecurrings().then(function (response) {
            vm.transactionRecurrings = response.data;
        });

        var addRentTransaction = function () {
            vm.manageTransaction({
                status: 1,
                description: null,
                property_id: vm.property.id,
                unit_id: null,
                amount: null,
                amount_tax: null,
                transaction_category_id: 1,
                transaction_recurring_id: 3,
                amount_tax_included: false,
                amount_total: null,
                removeble: false
            });
        }

        $scope.$watch(function () {
            return vm.property.cntTransactions;
        }, function (newValue, oldValue) {
            if (newValue == 0 && oldValue > 0) {
                addRentTransaction();
            }
        });


        PropertyService.getCountTransactions(vm.property.id).then(function (response) {
            vm.property.cntTransactions = response.count;
            if (!vm.property.cntTransactions) {
                addRentTransaction();
            }
        });

        PropertyService.getUnits(vm.property.id).then(function (response) {
            if (response.status == 1) {
                for (var i = 0; i <= response.data.length - 1; i++) {
                    var e = response.data[i];
                    vm.units.push({id: e.id, title: e.unit})
                }
            }
        });

        vm.manageTransaction = function (model) {
            if (cloneScope) {
                cloneScope.$destroy();
            }
            cloneScope = $scope.$new();
            cloneScope.tmpModel = model;
            model = model ? model : {
                    status: 1,
                    description: null,
                    property_id: vm.property.id,
                    unit_id: null,
                    amount: null,
                    amount_tax: null,
                    transaction_category_id: 1,
                    transaction_recurring_id: 3,
                    amount_tax_included: false,
                    amount_total: null,
                    removeble: true
                };

            if (model) {
                var panel = angular.element('<div property="propertyTransactionsCtrl.property" ' +
                    'currency-symbol="{{app.userServiceData.user.profile.currency.symbol}}" ' +
                    'transaction-recurrings="propertyTransactionsCtrl.transactionRecurrings" ' +
                    'transaction-categories="propertyTransactionsCtrl.transactionCategories" ' +
                    'units="propertyTransactionsCtrl.units"' +
                    'ng-model="tmpModel" ' +
                    'transaction-model-updated="propertyTransactionsCtrl.transactionModelUpdated(model)" ' +
                    'property-transaction-vf></div>');
            } else {
                var panel = angular.element('<div property="propertyTransactionsCtrl.property" ' +
                    'currency-symbol="{{app.userServiceData.user.profile.currency.symbol}}" ' +
                    'transaction-recurrings="propertyTransactionsCtrl.transactionRecurrings" ' +
                    'transaction-categories="propertyTransactionsCtrl.transactionCategories" ' +
                    'units="propertyTransactionsCtrl.units"' +
                    'transaction-model-updated="propertyTransactionsCtrl.transactionModelUpdated(model)" ' +
                    'property-transaction-vf></div>');
            }
            var compileFn = $compile(panel);
            compileFn(cloneScope);
            $('#action-panel').html(panel);
        }
    }]);