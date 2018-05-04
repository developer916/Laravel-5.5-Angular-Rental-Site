'use strict';

RentomatoApp.controller('DepositRelaysController', function ($rootScope, $scope, $http, $state, toaster, DepositRelayService, $cookies,UserService) {
    if(!($scope.role.indexOf('depositrelay') > -1)) {
        $rootScope.$state.go("dashboard");
        return;
    }
    DepositRelayService.getDepositRelays().then(function (response){
        $scope.depositRelays = response.depositRelays;
        $scope.deposit_role = response.role;
        $scope.user = response.user;
    });
    $scope.onChangeEditAmount = function (id, type) {
        console.log(id+ "change id");
        console.log("Tesds");
    };

    $scope.deleteEmail = function (id) {
        console.log("test");
    };


    $scope.onChangeClick = function(){
        console.log($("#depositRelayType").val());
        if($("#depositRelayType").val() == 'change_amount'){
            $scope.formData = {
                'id' :   $("#depositRelayID").val(),
                'type' : $("#depositRelayType").val(),
                'amount' : $("#amount").val()
            };
        }else if($("#depositRelayType").val() == 'change_date'){
            $scope.formData = {
                'id' :   $("#depositRelayID").val(),
                'type' : $("#depositRelayType").val(),
                'move_in_date' : $("#moved_in_date").val()
            };
        }
        DepositRelayService.changeAmountDepositRelays($scope.formData).then(function (response) {
            $("#edit-modal").modal('hide');
            $state.go($state.current, {}, {reload: true});
        });
    };

    $scope.onCancelClick = function(){
        $scope.formData = {
            'id' :   $("#depositRelayCancelID").val(),
            'cancel_reason' : $scope.cancel_reason
        };
        DepositRelayService.cancelDepositRelay($scope.formData).then(function (response) {
            $("#cancel-modal").modal('hide');
            $rootScope.cancelDepositRelay = 1;
            $state.go('dashboard', {}, {reload: 'dashboard'});
        });
    };

    $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams){
        if(toState.name == 'dashboard' && fromState.name== 'depositRelays' && $rootScope.cancelDepositRelay == 1){
            window.location.reload();
        }
    });
})