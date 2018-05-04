'use strict';

RentomatoApp.controller('PaymentPerTenantController', function ($rootScope, $scope, $http, $state, toaster,$filter, PaymentPerTenantService, $cookies) {
    $scope.payments = {};
    $scope.files = {};
    $scope.deregFiles ={};

    PaymentPerTenantService.getTenants().then(function (response){
          $scope.tenants = response.tenants;
            if(!$scope.payments.tenant) {
                $scope.payments.tenant = $scope.tenants[0].id;
            }
            $scope.payments.last_import_date = response.lastImportDate;
            $scope.paymentList = response.resultPayment;
            $scope.tenant_role = response.tenantRole;
    });
    $scope.updatePayment = function(){
        PaymentPerTenantService.getTenantPayment($scope.payments.tenant).then(function (response){
            $scope.paymentList = response.resultPayment;
        });
    }
    $scope.setFiles =function(element) {
        $scope.$apply(function(scope) {
            console.log('files:', element.files);
            // Turn the FileList object into an Array
            $scope.files = []
            for (var i = 0; i < element.files.length; i++) {
                $scope.files.push(element.files[i])
            }
            console.log($scope.files);
        });
    };
    $scope.importFileUpload = function(){
        if($scope.files.length == 0){
            toaster.error($filter('translate')('Please upload csv file'));
        }
        var fd = new FormData();
        for (var i in $scope.files) {
            fd.append("uploadedFile", $scope.files[i])
        }
        $http.post('/paymentPerTenant/importFileUpload', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(response){
            if(response.type == 'error'){
                toaster.error($filter('translate')(response.message));
            }
            if(response.type == 'success'){
                toaster.success($filter('translate')(response.success_messages));
                toaster.error($filter('translate')(response.error_messages));
                $state.go($state.current, {}, {reload: true});
            }
        })
        .error(function(){

        });
    }
    $scope.setDeregFiles =function(element) {
        $scope.$apply(function(scope) {
            console.log('files:', element.files);
            // Turn the FileList object into an Array
            $scope.deregFiles = []
            for (var i = 0; i < element.files.length; i++) {
                $scope.deregFiles.push(element.files[i])
            }
            console.log($scope.deregFiles);
        });
    };

    $scope.DeregFileUpload = function(){
        var fd = new FormData();
        for (var i in $scope.deregFiles) {
            fd.append("deregFile", $scope.deregFiles[i])
        }
        $http.post('/paymentPerTenant/deregFileUpload', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(response){
             if(response.type == 'error'){
                toaster.error($filter('translate')(response.message));
             }else if(response.type == 'success'){
                 toaster.success($filter('translate')(response.message));
                 $state.go($state.current, {}, {reload: true});
             }
        })
       .error(function(){

       });
    }
})

