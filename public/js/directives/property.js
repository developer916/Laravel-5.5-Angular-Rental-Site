RentomatoApp.directive('tenantVf', ['$filter', 'toaster', 'UtilService', 'PropertyService', function ($filter, toaster, UtilService, PropertyService) {
    return {
        templateUrl: '/views/properties/tenant_vf.html',
        scope: {
            model: '=?ngModel',
            property: '=',
            tenantModelUpdated: '&'
        },
        link: function (scope, element, attrs) {
            if (!scope.model) {
                scope.model = {
                    id: null,
                    tenant: {
                        id: null,
                        name: null,
                        email: null,
                    },
                    property_id: scope.property.id,
                    unit_id: null,
                    start_date: null,
                    end_date: null,
                    collection_day: 1,
                    errors: null
                };
            }
            scope.cancel = function () {
                element.parent().empty();
                scope.$destroy();
            };
            $(element).find('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            scope.hasError = function (modelCtrl, error) {
                return (modelCtrl.$dirty || scope.tenantForm.$submitted) && error
            }
            if (!scope.model.collection_day) {
                scope.model.collection_day = 1;
            }
            if (scope.model.start_date) {
                scope.model.start_date = $filter('date')(new Date(scope.model.start_date), 'yyyy-MM-dd');
            }
            if (scope.model.end_date) {
                scope.model.end_date = $filter('date')(new Date(scope.model.end_date), 'yyyy-MM-dd');
            }
            scope.tenantForm.start_date.$validators.endBeforeStart = function (modelValue, viewValue) {
                var value = modelValue || viewValue;
                if (scope.model.end_date) {
                    return (value < scope.model.end_date);
                }
                return true;
            };
            scope.tenantForm.end_date.$validators.startBeforeEnd = function (modelValue, viewValue) {
                var value = modelValue || viewValue;
                if (scope.model.start_date) {
                    return (value > scope.model.start_date || !value);
                }
                return true;
            };

            scope.save = function () {
                scope.tenantForm.$setSubmitted();
                if (scope.tenantForm.$invalid) {
                    return;
                }
                PropertyService.createUpdateTenant(scope.model).then(function (response) {
                    scope.model = response;
                    scope.property.tenants.push(scope.model);
                    if (!response.errors) {
                        scope.tenantModelUpdated({model: scope.model});
                        toaster.success($filter('translate')('Tenant created!'));
                        scope.cancel();
                    }
                });
            }
            scope.rangeCollectionDay = UtilService.range(1, 31);
        }
    }
}]);

RentomatoApp.directive('transactionsGrid', ['$filter', '$window', '$compile', 'PropertyService', 'toaster', function ($filter, $window, $compile, PropertyService, toaster) {
    return {
        templateUrl: '/views/properties/transactions_grid.html',
        link: function (scope, element, attrs) {
            var cnt = 0;
            var table = element.find('#transactions-dt').DataTable({
                'scrollY': false,
                'scroller': true,
                'responsive': true,
                'serverSide': false,
                'ajax': {
                    'url': '/properties/transactions/' + scope.propertyTransactionsCtrl.property.id,
                    'dataType': 'JSON'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "transaction_category.title"},
                    {"data": "unit.unit"},
                    {"data": "transaction_recurring.title"},
                    {"data": "amount_total"},
                    {"data": "actions"}
                ],
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "targets": 2,
                        "defaultContent": '',
                        "render": function (data, type, row) {
                            if (!data) {
                                return '(' + $filter('translate')('Other') + ') ' + row.description;
                            } else {
                                if (row.description) {
                                    return '(' + data + ') ' + row.description;
                                }
                            }
                            return data;
                        }
                    },
                    {
                        "searchable": false,
                        "targets": 3,
                        "defaultContent": '<i>' + $filter('translate')('Not unit') + '</i>',
                    },
                    {
                        "searchable": false,
                        "targets": 4,
                        "defaultContent": '<i>' + $filter('translate')('Not set') + '</i>',
                    },
                    {
                        "searchable": false,
                        "targets": 5,
                        "render": function (data, type, row) {
                            if (data) {
                                return scope.app.userServiceData.user.profile.currency.symbol + ' ' + data;
                            }
                        }
                    },
                    {
                        "render": function (data, type, row) {
                            var html = '<a href="#" class="btn btn-xs btn-circle property-transactions-edit blue"><i class="fa fa-edit"></i><span class="hidden-480"></span></a>';
                            html = html + '<a href="#" class="btn btn-xs btn-circle property-transactions-remove red"><i class="fa fa-trash-o"></i><span class="hidden-480"></span></a>';
                            return html;
                        },
                        "targets": 6,
                        "searchable": false,
                        "orderable": false
                    }
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();


            scope.propertyTransactionsCtrl.transactionModelUpdated = function (model) {
                if (angular.isUndefined(model.index)) {
                    model.cnt = '';
                    model.actions = '';
                    var tableRow = table.row.add(model);
                    tableRow.draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                    scope.propertyTransactionsCtrl.property.cntTransactions++;
                    console.log(scope.propertyTransactionsCtrl.property.cntTransactions);
                } else {
                    var tableRow = table.row(model.index);
                    model.cnt = table.cell(model.index, 1).node().innerHTML;
                    table.row(model.index).data(model).draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                }
            }
            table.on('draw', function () {
                jQuery('#transactions-dt tbody tr').removeClass('highlight-changes');
            });
            jQuery('#transactions-dt tbody').on('click', '.property-transactions-edit', function (e) {
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                data.removeble = true;
                scope.propertyTransactionsCtrl.manageTransaction(data);
                e.preventDefault();
            });
            jQuery('#transactions-dt tbody').on('click', '.property-transactions-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this transaction'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                scope.propertyTransactionsCtrl.property.cntTransactions--;
                PropertyService.deleteTransactions({id: data.id}).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw();
                        toaster.success($filter('translate')('Transaction deleted!'));
                    } else {
                        toaster.error($filter('translate')('Transaction error!'));
                    }
                });
                e.preventDefault();
            });
        }
    }
}]);

RentomatoApp.directive('propertyTransactionVf', ['$filter', 'PropertyService', 'toaster', function ($filter, PropertyService, toaster) {
    return {
        templateUrl: '/views/properties/transactions_vf.html',
        scope: {
            model: '=ngModel',
            currencySymbol: '@',
            units: '=',
            property: '=',
            transactionRecurrings: '=',
            transactionCategories: '=',
            transactionModelUpdated: '&'
        },
        controller: ['$scope', function ($scope) {
            if (!$scope.model) {
                $scope.model = {
                    status: 1,
                    description: null,
                    property_id: $scope.property.id,
                    unit_id: null,
                    amount: null,
                    amount_tax: null,
                    transaction_category_id: null,
                    transaction_recurring_id: null,
                    amount_tax_included: false,
                    amount_total: null,
                    removeble: true
                };
            }

            $scope.transactionCategoriesAssoc = {};
            if ($scope.model.amount_tax) {
                $scope.tax = true;
            }

            $scope.$watch('transactionCategories', function (newValue) {
                if (newValue) {
                    var length = newValue.length;
                    if (length) {
                        for (var i = 0; i <= length - 1; i++) {
                            $scope.transactionCategoriesAssoc[newValue[i]['id']] = newValue[i];
                        }
                        if (!$scope.model.transaction_category_id) {
                            $scope.model.transaction_category_id = newValue[0]['id'];
                            $scope.model.transaction_recurring_id = newValue[0]['transaction_recurring_id'];
                        }
                    }
                }
            });

            $scope.setDefaultRecurring = function () {
                $scope.model.transaction_recurring_id = $scope.transactionCategoriesAssoc[$scope.model.transaction_category_id]['transaction_recurring_id'];
            }

            $scope.taxChange = function () {
                if (!$scope.tax) {
                    $scope.model.amount_tax = null;
                    $scope.model.amount_tax_included = null;
                }
            }

            $scope.changeTotal = function () {
                $scope.model.amount_total = $scope.model.amount;
                if ($scope.model.amount_tax > 0 && !$scope.model.amount_tax_included) {
                    $scope.model.amount_total += +(($scope.model.amount * $scope.model.amount_tax / 100).toFixed(2));
                }
            }

            $scope.$watch('model.amount_tax', function (newValue) {
                if (newValue) {
                    $scope.model.amount_tax = Math.round(newValue);
                }
                $scope.changeTotal();
            });

        }],
        link: function (scope, element, attrs) {

            scope.cancel = function () {
                element.parent().empty();
                scope.$destroy();
            };

            scope.hasError = function (modelCtrl, error) {
                return (modelCtrl.$dirty || scope.transactionForm.$submitted) && error
            }

            scope.save = function () {
                scope.transactionForm.$setSubmitted();
                if (scope.transactionForm.$invalid) {
                    return;
                }
                PropertyService.createUpdateTransaction(scope.model).then(function (response) {
                    scope.model = response.data;
                    if (!response.errors) {
                        scope.transactionModelUpdated({model: scope.model});
                        toaster.success($filter('translate')('Transaction updated!'));
                        scope.cancel();
                    } else {
                        toaster.success($filter('translate')('Transaction error!'));
                    }
                });
            }
        }
    }
}]);
RentomatoApp.directive('tenantsGrid', ['$filter', '$window', '$compile', 'PropertyService', function ($filter, $window, $compile, PropertyService) {
    return {
        templateUrl: '/views/properties/tenants_grid.html',
        link: function (scope, element, attrs) {
            var cnt = 0;
            var table = element.find('#tenants-dt').DataTable({
                'scrollY': false,
                'scroller': true,
                'responsive': true,
                'serverSide': false,
                'ajax': {
                    'url': '/properties/tenants/' + scope.propertyTenantsCtrl.property.id,
                    'dataType': 'JSON'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "tenant.name"},
                    {"data": "unit"},
                    {"data": "collection_day"},
                    {"data": "start_date"},
                    {"data": "end_date"},
                    {"data": "actions"}
                ],
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 3,
                        "defaultContent": '<i>' + $filter('translate')('Not set') + '</i>'
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1
                    },
                    {
                        "searchable": false,
                        "targets": 5,
                        "defaultContent": '<i>' + $filter('translate')('Not set') + '</i>',
                        "render": function (data, type, row, meta) {
                            if (data) {
                                return moment(data, "YYYY-MM-DD").format("DD MMMM YYYY");
                            }
                        }
                    },
                    {
                        "searchable": false,
                        "targets": 6,
                        "render": function (data, type, row, meta) {
                            if (data) {
                                return moment(data, "YYYY-MM-DD").format("DD MMMM YYYY");
                            }
                        },
                        "defaultContent": '<i>' + $filter('translate')('Not set') + '</i>'
                    },
                    {
                        "render": function (data, type, row, meta) {
                            var html = '';
                            if (row.id) {
                                html = '<a href="#" class="btn btn-xs btn-circle blue property-tenant-edit" tooltip="' + $filter('translate')('Edit tenant contract') + '" title="' + $filter('translate')('Edit tenant contract') + '"><i class="fa fa-pencil-square-o"></i></a>';
                            } else {
                                html = '<a href="#" class="btn btn-xs btn-circle blue property-tenant-edit" tooltip="' + $filter('translate')('Assign tenant') + '" title="' + $filter('translate')('Assign tenant') + '"><i class="fa fa-user-plus"></i></a>';
                            }
                            html += '<a href="#/properties/view/tenant-transactions/' + scope.propertyTenantsCtrl.property.id + '/' + row.id + '" class="btn btn-xs green btn-circle" style="' + (row.id ? 'display:inline' : 'display:none') + '" tooltip="' + $filter('translate')('Assign transaction') + '"><i class="fa fa-plus"></i><i class="fa fa-money"></i></a>';
                            return html;
                        },
                        "searchable": false,
                        "orderable": false,
                        "targets": 7
                    }
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('draw', function () {
                jQuery('#transactions-dt tbody tr').removeClass('highlight-changes');
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();

            scope.propertyTenantsCtrl.tenantModelUpdated = function (model) {
                if (angular.isUndefined(model.index)) {
                    model.cnt = '';
                    model.actions = '';
                    var tableRow = table.row.add(model);
                    // table.row.add(model).draw(false);
                    tableRow.draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                } else {
                    var tableRow = table.row(model.index);
                    model.cnt = table.cell(model.index, 1).node().innerHTML;
                    table.row(model.index).data(model).draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                }
            }
            jQuery('#tenants-dt tbody').on('click', '.property-tenant-edit', function (e) {
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                scope.propertyTenantsCtrl.manageTenant(data);
                e.preventDefault();
            });
        }
    }
}]);

RentomatoApp.directive('propertyUnitVf', ['$filter', function ($filter) {
    return {
        templateUrl: '/views/properties/property_unit_vf.html',
        scope: {
            model: '=ngModel',
            index: '@'
        },
        controller: ['$scope', function ($scope) {
            if (typeof $scope.model.status === 'undefined') {
                $scope.model.status = 1;
            }
            $scope.remove = function () {
                $scope.model.status = 0;
                $scope.model.title = 'deleted';
            }
            if (angular.isUndefined($scope.model.valid)) {
                $scope.model.valid = false;
            }
        }],
        link: function (scope, element, attrs) {
        }
    }
}]);

RentomatoApp.directive('userTransactionsGrid', ['$filter', '$window', '$compile', 'toaster', 'PropertyService', function ($filter, $window, $compile, toaster, PropertyService) {
    return {
        templateUrl: '/views/properties/user_transactions_grid.html',
        link: function (scope, element, attrs) {
            var cnt = 0;
            var table = null;
            table = element.find('#user-transactions-dt').DataTable({
                'scrollY': false,
                'scroller': true,
                'responsive': true,
                'serverSide': false,
                'ajax': {
                    'url': '/properties/tenants-transactions/' + scope.propertyUserTransactionsCtrl.propertyTenant.id,
                    'dataType': 'JSON'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "transaction_categories_title"},
                    {"data": "unit"},
                    {"data": "transaction_recurrings_title"},
                    {"data": "amount_total"},
                    {"data": "amount"},
                    {"data": "actions"}
                ],
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "targets": 2,
                        "defaultContent": '',
                        "render": function (data, type, row) {
                            if (!data) {
                                return '(' + $filter('translate')('Other') + ') ' + row.description;
                            } else if (row.description) {
                                return '(' + data + ') ' + row.description;
                            }
                            return data;
                        }
                    },
                    {
                        "searchable": false,
                        "targets": 3,
                        "defaultContent": '<i>' + $filter('translate')('Not unit') + '</i>',
                    },
                    {
                        "searchable": false,
                        "targets": 4,
                        "defaultContent": '<i>' + $filter('translate')('Not set') + '</i>',
                    },
                    {
                        "searchable": false,
                        "targets": 5,
                        "render": function (data, type, row) {
                            if (data) {
                                return scope.app.userServiceData.user.profile.currency.symbol + ' ' + data;
                            }
                        }
                    },
                    {
                        "searchable": false,
                        "targets": 6,
                        "render": function (data, type, row) {
                            return scope.app.userServiceData.user.profile.currency.symbol + ' ' + ((data == null) ? 0 : data);
                        }
                    },
                    {
                        "render": function (data, type, row) {
                            var html = '<a href="#" class="btn btn-xs btn-circle property-user-transactions-edit blue" tooltip="Edit"><i class="fa fa-edit"></i><span class="hidden-480"></span></a>';
                            if (row.property_user_transactions_id) {
                                html = html + '<a href="#" class="btn btn-xs btn-circle property-user-transactions-remove green" tooltip="Remove transaction"><i class="fa fa-toggle-on"></i><span class="hidden-480"></span></a>';
                            } else {
                                html = html + '<a href="#" onclick="return false;" class="btn btn-xs btn-circle property-user-transactions-remove green disabled" tooltip="Remove transaction"><i class="fa fa-toggle-off"></i><span class="hidden-480"></span></a>';
                            }
                            if (row.property_transactions_user_id) {
                                html = html + '<a href="#" class="btn btn-xs btn-circle property-transactions-remove red" tooltip="Remove"><i class="fa fa-trash-o"></i><span class="hidden-480"></span></a>';
                            } else {
                                html = html + '<a href="#" onclick="return false;" class="btn btn-xs btn-circle red disabled" tooltip="Remove"><i class="fa fa-trash-o"></i><span class="hidden-480"></span></a>';
                            }
                            return html;
                        },
                        "searchable": false,
                        "orderable": false,
                        "targets": 7
                    }
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            scope.propertyUserTransactionsCtrl.userTransactionModelUpdated = function (model) {
                if (angular.isUndefined(model.index)) {
                    model.cnt = '';
                    model.actions = '';
                    var tableRow = table.row.add(model);
                    tableRow.draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                } else {
                    var tableRow = table.row(model.index);
                    model.cnt = table.cell(model.index, 1).node().innerHTML;
                    table.row(model.index).data(model).draw(false);
                    jQuery(tableRow.node()).addClass('highlight-changes');
                }
            }
            jQuery('#user-transactions-dt tbody').on('click', '.property-user-transactions-edit', function (e) {
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                scope.propertyUserTransactionsCtrl.manageUserTransaction(data);
                e.preventDefault();
            });
            jQuery('#user-transactions-dt tbody').on('click', '.property-transactions-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this transaction'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                PropertyService.deleteTransactions({id: data.id}).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw();
                        toaster.success($filter('translate')('User transaction deleted!'));
                    } else {
                        toaster.error($filter('translate')('User transaction error!'));
                    }
                });
                e.preventDefault();
            });
            jQuery('#user-transactions-dt tbody').on('click', '.property-user-transactions-remove', function (e) {
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                data.index = tableRow.index();
                var dataReq = {
                    id: data.property_user_transactions_id,
                }
                PropertyService.deleteUserTransaction(dataReq).then(function (response) {
                    if (response.status == 1) {
                        data.amount = 0;
                        data.property_user_transactions_id = null;
                        data.cnt = table.cell(data.index, 1).node().innerHTML;
                        tableRow.data(data);
                        toaster.success($filter('translate')('User transaction deleted!'));
                    } else {
                        toaster.error($filter('translate')('User transaction error!'));
                    }
                });
                e.preventDefault();
            });
            table.on('draw', function () {
                jQuery('#transactions-dt tbody tr').removeClass('highlight-changes');
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();
        }
    }
}]);
RentomatoApp.directive('propertyUserTransactionVf', ['$filter', 'toaster', 'PropertyService', function ($filter, toaster, PropertyService) {
    return {
        templateUrl: '/views/properties/user_transactions_vf.html',
        scope: {
            model: '=ngModel',
            currencySymbol: '@',
            propertyTenant: '=',
            userTransactionModelUpdated: '&'

        },
        link: function (scope, element, attrs) {
            if (!scope.model) {
                scope.model = {
                    id: null,
                    amount: null,
                    description: null,
                    transaction_recurring_id: null,
                    errors: null
                };
            }
            scope.cancel = function () {
                element.parent().empty();
                scope.$destroy();
            };
            if (scope.model.amount_total && !scope.model.amount) {
                scope.model.amount = scope.model.amount_total;
            }
            scope.hasError = function (modelCtrl, error) {
                return (modelCtrl.$dirty || scope.transactionForm.$submitted) && error
            }
            PropertyService.getTransactionRecurrings().then(function (response) {
                scope.transactionRecurrings = response.data;
            });
            scope.save = function () {
                scope.transactionForm.$setSubmitted();
                if (scope.transactionForm.$invalid) {
                    return;
                }
                var data = {
                    id: scope.propertyTenant.id,
                    model: scope.model
                }
                PropertyService.createUpdateUserTransaction(data).then(function (response) {
                    scope.model = response.data;
                    scope.userTransactionModelUpdated({model: scope.model});
                    if (!response.data.errors) {
                        toaster.success($filter('translate')('User transaction updated!'));
                        scope.cancel();
                    } else {
                        toaster.success($filter('translate')('User transaction error!'));
                    }
                });
            }
        }
    }
}]);


RentomatoApp.directive('documentsGrid', ['$filter', '$window', 'DocumentService', 'toaster', function ($filter, $window, DocumentService, toaster) {
    return {
        templateUrl: '/views/properties/documents_grid.html',
        link: function (scope, element, attrs) {
            var table = element.find('#documents-dt').DataTable({
                'scrollY': false,
                'scroller': true,
                'responsive': false,
                'processing': true,
                'serverSide': false,
                'ajax': {
                    'url': '/properties/documents/' + scope.propertyDocumentsCtrl.property.id,
                    'dataType': 'JSON'
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "targets": 3,
                        "searchable": false,
                        "render": function (data, type, row) {
                            if (row.status == 0) {
                                if (data) {
                                    return data + '<br>' + $filter('translate')('Document is in Pending');
                                }
                                return $filter('translate')('Document is in Pending');
                            }
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row) {
                            return '<a href="#/properties/view/documents/' + scope.propertyDocumentsCtrl.property.id + '/' + row.id + '" class="btn-delete btn btn-xs btn-circle "><i class="fa fa-pencil"></i><span class="hidden-480">' + $filter('translate')('Edit') + '</span></a>' +
                                '<a class="btn btn-xs btn-circle red document-remove"><i class="fa fa-trash-o"></i><span class="hidden-480">' + $filter('translate')('Delete') + '</span></a>';

                        },
                        "searchable": false,
                        "orderable": false,
                        "targets": 7
                    }
                ],
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "file"},
                    {"data": "description"},
                    {"data": "privacy"},
                    {"data": "date"},
                    {"data": "size"},
                    {"data": "actions"}
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();
            jQuery('#documents-dt tbody').on('click', '.document-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this document'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                DocumentService.deleteDoc(data.id).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw(false);
                        toaster.success($filter('translate')('Document deleted!'));
                    } else {
                        toaster.error($filter('translate')('Document error!'));
                    }
                });
                e.preventDefault();
            });
        }
    }
}]);

// Service Cost Account
RentomatoApp.directive('serviceCostAccountsGrid', ['$filter', '$window', 'PropertyService', 'toaster', function ($filter, $window, PropertyService, toaster) {
    return {
        templateUrl: '/views/properties/service_cost_accounts_grid.html',
        link: function (scope, element, attrs) {
            var table = element.find('#scaccounts-dt').DataTable({
                'scrollY': false,
                'scroller': true,
                'responsive': false,
                'processing': true,
                'serverSide': false,
                'ajax': {
                    'url': '/properties/scaccounts/' + scope.propertyScaccountsCtrl.property.id,                    
                    'dataType': 'JSON'
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,                                                
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "targets": 3,
                        "searchable": false
                    },
                    {
                        "render": function (data, type, row) {
                            return '<a class="btn btn-xs btn-circle red scaccount-remove"><i class="fa fa-trash-o"></i><span class="hidden-480">' + $filter('translate')('Delete') + '</span></a>';
                        },
                        "searchable": false,
                        "orderable": false,
                        "targets": 6
                    }
                ],
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},                                        
                    {"data": "sca_type"},
                    {"data": "year"},
                    {"data": "amount"},
                    {"data": "file"},                    
                    {"data": "actions"}
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();
            jQuery('#scaccounts-dt tbody').on('click', '.scaccount-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this record'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                console.log('delete record');
                PropertyService.delScaccount(data.id).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw(false);
                        toaster.success($filter('translate')('Service cost account deleted!'));
                    } else {
                        toaster.error($filter('translate')('Service cost account error!'));
                    }
                });
                e.preventDefault();
            });
        }
    }
}]);
//end  Service Cost Account

RentomatoApp.directive('propertyOverviewUnits', ['$filter', 'toaster', 'UtilService', 'PropertyService', function ($filter, toaster, UtilService, PropertyService) {
    return {
        templateUrl: '/views/properties/overview-units.html',
        scope: {
            overview: '=',
            currency: '@'
        },
        link: function (scope, element, attrs) {
        }
    }
}]);


RentomatoApp.directive('rtAmenities', ['$filter', 'toaster', 'UtilService', 'PropertyService', function ($filter, toaster, UtilService, PropertyService) {
    return {
        templateUrl: '/views/properties/amenities.html',
        scope: {
            amenitiesList: '=',
            propertyAmenities: '=',
            propertyTypeId: '='
        },
        link: function (scope, element, attrs) {
            scope.propertyTypeAmenities = [];

            scope.$watch('amenitiesList', function (newValue) {
                if (newValue) {
                    scope.propertyTypeAmenities = newValue[(scope.propertyTypeId ? scope.propertyTypeId : 1)];
                }
            });
            scope.$watch('propertyTypeId', function (newValue) {
                if (newValue) {
                    scope.propertyTypeAmenities = scope.amenitiesList[newValue];
                }
            });

        }
    }
}])
RentomatoApp.directive('stringToNumber', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return '' + value;
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value, 10);
            });
        }
    };
});


RentomatoApp.directive('documentsUserGrid', ['$filter', '$window', 'DocumentService', 'toaster', function ($filter, $window, DocumentService, toaster) {
    return {
        link: function (scope, element, attrs) {
            var table = $('#documents-dt').DataTable({
                'scrollY': false,
                'deferRender': false,
                'scroller': true,
                'responsive': false,
                'processing': true,
                'serverSide': false,
                'ajax': {
                    'url': '/documents',
                    'dataType': 'JSON'
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 7,
                        "defaultContent": ''
                    }
                ],
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "file"},
                    {"data": "description"},
                    {"data": "privacy"},
                    {"data": "date"},
                    {"data": "size"},
                    {"data": "actions"}
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();
            jQuery('#documents-dt tbody').on('click', '.document-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this document'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                DocumentService.deleteDoc(data.id).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw(false);
                        toaster.success($filter('translate')('Document deleted!'));
                    } else {
                        toaster.error($filter('translate')('Document error!'));
                    }
                });
                e.preventDefault();
            });
        }
    }
}]);

RentomatoApp.directive('tenantsUserGrid', ['$filter', '$window', 'TenantsService', 'toaster', function ($filter, $window, TenantsService, toaster) {
    return {
        link: function (scope, element, attrs) {
            var table = $('#tenants-dt').DataTable({
                'scrollY': false,
                'deferRender': false,
                'scroller': true,
                'responsive': false,
                'processing': true,
                'serverSide': false,
                'ajax': {
                    'url': '/tenants',
                    'dataType': 'JSON'
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 1,
                        "defaultContent": ''
                    },
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 7,
                        "defaultContent": ''
                    }
                ],
                "columns": [
                    {"data": "id"},
                    {"data": "cnt"},
                    {"data": "name"},
                    {"data": "hasProperty"},
                    {"data": "unit"},
                    {"data": "start_date"},
                    {"data": "end_date"},
                    {"data": "actions"}
                ],
                "order": [[0, 'desc']],
                language: $window.dtTableHeaders
            });
            table.on('order.dt search.dt', function () {
                table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    $(cell).html(i + 1);
                });
            }).draw();
            jQuery('#tenants-dt tbody').on('click', '.item-remove', function (e) {
                if (!confirm($filter('translate')('Are you sure you want to delete this tenant'))) {
                    e.preventDefault();
                    return false;
                }
                var $row = $(this).closest('tr');
                var tableRow = table.row($row);
                var data = tableRow.data();
                TenantsService.deleteTenant(data.id).then(function (response) {
                    if (response.status == 1) {
                        tableRow.remove().draw(false);
                        toaster.success($filter('translate')('Tenant deleted!'));
                    } else {
                        toaster.error($filter('translate')('Operation error!'));
                    }
                });
                e.preventDefault();
            });
        }
    }
}]);