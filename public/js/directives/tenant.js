RentomatoApp.directive('inviteTenantForm', ['$filter', 'UtilService', 'PropertyService', 'toaster', function ($filter, UtilService, PropertyService, toaster) {
    return {
        restrict: 'A',
        templateUrl: '/views/tenants/invite_tenant_form.html',
        scope: {
            row: '=ngModel',
            index: '=',
            save: '&',
            properties: '=',
            currency: '@'
        },
        controller: ['$scope', function ($scope) {
            if(typeof $scope.row.tenant.status === "undefined") {
                $scope.row.tenant.status = 1;
            }
            if(!$scope.row.tenant.property_tenant){
                $scope.row.tenant.property_tenant = {
                    user_id: null
                };
            }

            $scope.$watch('row.tenant.id', function () {
                $scope.row.tenant.property_tenant.user_id = $scope.row.tenant.id;
            });

            if (!$scope.row.tenant.property_tenant.collection_day) {
                $scope.row.tenant.property_tenant.collection_day = 1;
            }
            if ($scope.row.tenant.property_tenant.start_date) {
                $scope.row.tenant.property_tenant.start_date = $filter('date')(new Date($scope.row.tenant.property_tenant.start_date), 'yyyy-MM-dd');
            }
            if ($scope.row.tenant.property_tenant.end_date) {
                $scope.row.tenant.property_tenant.end_date = $filter('date')(new Date($scope.row.tenant.property_tenant.end_date), 'yyyy-MM-dd');
            }
            $scope.rangeCollectionDay = UtilService.range(1, 31);
            $scope.assignTenantToProperty = function () {
                PropertyService.assignTenantToProperty($scope.row.tenant.property_tenant).then(function (response) {
                    if (response['status'] && response['status'] == 0) {
                        toaster.error($filter('translate')('An error occured, please try again later'));
                        return;
                    }
                    if (!response['data']['errors']) {
                        $('#assign_tenant_modal_' + $scope.index).modal('hide');
                        if($scope.row.tenant.property_tenant.id){
                            toaster.success($filter('translate')('Tenant assigned to property updated'));
                        }else{
                            toaster.success($filter('translate')('Tenant assigned to property'));
                        }
                    }
                    $scope.row.tenant.property_tenant = response.data;
                });

            }
        }],
        link: function (scope, element) {
            scope.assignTenantModal = function () {
                $('#assign_tenant_modal_' + scope.index).modal('show');
            }
            $(element).find('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        }

    }
}]);