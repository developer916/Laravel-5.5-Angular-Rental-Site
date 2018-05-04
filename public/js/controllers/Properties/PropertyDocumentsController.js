'use strict';

RentomatoApp.controller('PropertyDocumentsController', ['$scope', '$state', '$stateParams', '$filter', 'toaster', 'DocumentService', 'PropertyService', function ($scope, $state, $stateParams, $filter, toaster, DocumentService, PropertyService) {
    var vm = this;
    vm.document = {
        id: ($stateParams.documentId) ? $stateParams.documentId : null,
        property_id: PropertyService.model.id,
        files: []
    };
    $scope.files = vm.document.files;
    vm.property = {
        id: PropertyService.model.id
    }

    if ($state.current.name == 'property-view.documents-edit') {
        if (!$stateParams.documentId) {
            DocumentService.createDoc($scope.formData).then(function (response) {
                response.data.privacy = 'Private';
                angular.extend(vm.document, response.data);
            });
        } else {
            DocumentService.getDoc($stateParams.documentId).then(function (response) {
                response.data.files = [
                    {
                        id: response.data.id,
                        file: response.data.file,
                        file_size: response.data.file_size
                    }
                ]
                angular.extend(vm.document, response.data);
            });
        }
    }

    $scope.$watchCollection(function () {
        return vm.document.files;
    }, function (newValue) {
        if (newValue && newValue.length) {
            $scope.documentForm.$setPristine();
        }
    });

    vm.updateDoc = function (id) {
        if (!vm.document.files.length) {
            return false;
        }
        DocumentService.updateDoc(vm.document).then(function (response) {
            if (response.status == 1) {
                toaster.success($filter('translate')('Document updated.'));
                $state.go('property-view.documents',{id:vm.property.id});
            }
        });
    }

}]);
