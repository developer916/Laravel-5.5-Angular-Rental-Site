'use strict';

RentomatoApp.controller('PropertyServiceCostAccountsController', ['$scope', '$state', '$stateParams', '$filter', 'toaster', 'DocumentService', 'PropertyService','$timeout', function ($scope, $state, $stateParams, $filter, toaster, DocumentService, PropertyService,$timeout) {
    var vm = this;
    vm.form = {};
    vm.scaccount = {
        id: ($stateParams.scaccountId) ? $stateParams.scaccountId : null,        
        property_id: PropertyService.model.id,
        files: []
    };
    $scope.files = vm.scaccount.files;
    vm.property = {
        id: PropertyService.model.id
    }
    vm.costTypes = [];
    PropertyService.getCostTypes().then(function (response) {
        vm.costTypes = response;        
    });
    
    

    $scope.$watchCollection(function () {
        return vm.scaccount.files;
    }, function (newValue) {        
        if (newValue && newValue.length) {
            $scope.scaccountForm.$setPristine();
        }
    });


    vm.saveScaccount = function () {        
        // if (!vm.scaccount.files.length) {
        //     return false;
        // }

        if (vm.scaccount.year == '') {
            return false;
        }

        if (vm.scaccount.amount == '') {
            return false;
        }

        if (vm.scaccount.costID == '') {
            return false;
        }
        if($scope.cropper.croppedImage) {
            vm.scaccount.image = $scope.cropper.croppedImage;
        }

        PropertyService.createScaccount(vm.scaccount).then(function (response) {
            if (response.status == 1) {
                toaster.success($filter('translate')('Service Cost Account Created.'));                              
                
                $state.go('property-view.scaccounts',{id:vm.property.id});                                                
            }
        });
    }

    $scope.cropper = {};
    $scope.cropper.sourceImage = null;
    $scope.cropper.croppedImage   = null;
    $scope.test = function () {
        alert("Ok");
    }

}]);
