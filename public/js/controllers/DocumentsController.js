'use strict';

RentomatoApp.controller('DocumentsController', [
    '$rootScope',
    '$scope',
    '$http',
    '$location',
    'toaster',
    '$filter',
    '$stateParams',
    'DocumentService',
    'LandlordService',
    function ($rootScope, $scope, $http, $location, toaster, $filter, $stateParams, DocumentService,LandlordService) {
        $scope.document = {
            id: ($stateParams.id) ? $stateParams.id : null,
            files: []
        };
        $scope.files = $scope.document.files;
        $scope.tenants = [];
        LandlordService.getTenants().then(function(response){
            $scope.tenants = response;
        });
        if (!$stateParams.id) {
            DocumentService.createDoc($scope.formData).then(function (response) {
                response.data.privacy = 'Private';
                angular.extend($scope.document, response.data);
            });
        } else {
            DocumentService.getDoc($stateParams.id).then(function (response) {
                response.data.files = [
                    {
                        id: response.data.id,
                        file: response.data.file,
                        file_size: response.data.file_size
                    }
                ]
                angular.extend($scope.document, response.data);
            });
        }

        $scope.$watchCollection('document.files', function (newValue) {
            if (newValue && newValue.length) {
                $scope.documentForm.$setPristine();
            }
        });

        $scope.updateDoc = function (id) {
            if (!$scope.document.files.length) {
                return false;
            }
            DocumentService.updateDoc($scope.document).then(function (response) {
                if (response.status == 1) {
                    toaster.success($filter('translate')('Document updated.'));
                    $location.path('/documents');
                }
            });
        }



    }]);
