'use strict';

RentomatoApp.controller('SendRentIncreaseController', function ($rootScope, $scope, $http, $state, toaster,$filter, SendRentIncreaseService, $timeout) {
    if(!($scope.role.indexOf('administrator') > -1) && ! ($scope.role.indexOf('landlord') > -1) && !($scope.role.indexOf('manager') > -1)) {
        $rootScope.$state.go("dashboard");
        return;
    }
    $scope.sendSubmit  = 0;
    $scope.sendHide = 0;
    $scope.isAllSelected = false;
     SendRentIncreaseService.getSendRentIncreaseList().then(function (response){
         $scope.dataSet(response);
    });
     $scope.dataSet = function(response){
         $scope.tenants = response.tenants;
         if(response.tenants.length == 0) {
             $scope.sendHide = 1;
         }
         $scope.totalCurRent = response.totalCurRent;
         $scope.totalNewRent = response.totalNewRent;
         $scope.totalDiff = response.totalDiff;
         $scope.totalPercentDiff = response.totalPercentDiff;
         $scope.effectiveDate = response.effectiveDate;
         $scope.startDate = response.startDate;
         $scope.endDate = response.endDate;
         $scope.emailBody = (response.emailBody);
         $scope.emailSubject = response.emailSubject;
         $scope.sendMethod = "to-landlord";
         $timeout(function(){
             $('.date-picker').datepicker({
                 format: 'dd-mm-yyyy',
                 autoclose: true
             })
         },100);
     };

    $scope.toggleAll = function() {
        var toggleStatus = !$scope.isAllSelected;
        angular.forEach($scope.tenants, function(itm){ itm.selected = toggleStatus; });
        $scope.isAllSelected = toggleStatus;
    }

    $scope.optionToggled = function(){
        $scope.isAllSelected = $scope.tenants.every(function(itm){ return itm.selected; })
    }
    $scope.onSubmitRentIncrease =function(){
        $scope.sendSubmit  =1;
        $scope.emailSendBody = $("#emailBody").val();
        var data = [];
        for (var i = 0; i < $scope.tenants.length; i++) {
            if ($scope.tenants[i].selected) {
                data.push($scope.tenants[i]);
            }
        }
        if(data.length == 0) {
            toaster.error($filter('translate')('Please select any one.'));
            $scope.sendSubmit = 0;
            return;
        }
        var formData = {
            startData: $scope.startDate,
            endDate: $scope.endDate,
            effectiveDate: $scope.effectiveDate,
            emailSubject: $scope.emailSubject,
            emailBody : $scope.emailSendBody,
            sendMethod : $scope.sendMethod,
            tenants: data
        }
        SendRentIncreaseService.createPostCreate(formData).then(function (response) {
            $scope.sendSubmit = 0;
            $state.go($state.current, {}, {reload: true});
        });
    }
    $scope.sendRentIncrease = function(){
        var formData = {
            startData: $scope.startDate,
            endDate: $scope.endDate,
            effectiveDate: $scope.effectiveDate,
        }
        SendRentIncreaseService.reCalculateAmount(formData).then(function (response) {
            $scope.dataSet(response);
        });
    }

})