'use strict';

RentomatoApp.controller('ContractWorkbenchController', function ($rootScope, $scope, $http, $state, toaster, ContractWorkbenchService, $timeout,DTOptionsBuilder) {
    console.log($scope.role);
    if(!($scope.role.indexOf('administrator') > -1) && ! ($scope.role.indexOf('landlord') > -1) && !($scope.role.indexOf('manager') > -1)) {
        $rootScope.$state.go("dashboard");
        return;
    }
    var tabClasses;
    $scope.selectedTab = 1;
    $scope.rentComponents = {};
    $scope.selectRentComponents = {};
    $scope.addRentComponents = {};
    $scope.addRentComponents.loading = 0;
    function initTabs() {
        tabClasses = ["","",""];
    }
    $scope.getTabClass = function (tabNum) {
        return tabClasses[tabNum];
    };

    $scope.getTabPaneClass = function (tabNum) {
        return "tab-pane " + tabClasses[tabNum];
    }

    $scope.setActiveTab = function (tabNum) {
        initTabs();
        $scope.selectedTab = tabNum;
        tabClasses[tabNum] = "active";
        $scope.getResult();
    };


    $scope.getResult = function() {
        if($scope.selectedTab == 3 || $scope.selectedTab == 2) {                        // ALSO INITIALIZE FOR TAB 2, we need the dropdowns. fix later.
            ContractWorkbenchService.getRentComponents().then(function (response){
                $scope.rentComponents = response.rentComponents;
                $scope.addRentComponents.selectRentComponents = response.selectRentComponents;
                if($scope.addRentComponents.selectRentComponents.length > 0) {
                    $scope.addRentComponents.selectRentComponent = $scope.addRentComponents.selectRentComponents[0]['id'];
                }
                $scope.addRentComponents.properties = response.properties;
                if($scope.addRentComponents.properties.length >0){
                    $scope.addRentComponents.property = $scope.addRentComponents.properties[0]['id'];
                    $scope.getPropertyUnits($scope.addRentComponents.property);
                }
                $scope.addRentComponents.users = response.users;
                $scope.landlord = response.landlord;
                if($scope.addRentComponents.users.length >0 ){
                    $scope.addRentComponents.user = $scope.addRentComponents.users[0]['id'];
                }
                $timeout(function(){
                    $('.date-picker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true
                    });
                },100);
                $scope.addRentComponents.loading = 1;
            });
        }
    };
    $scope.changeProperty = function(){
        $scope.getPropertyUnits($scope.addRentComponents.property);
    }

    $scope.getPropertyUnits = function(property_id) {
        if(property_id == '' || property_id == null) {
            $scope.addRentComponents.units = {};
            return;
        }
        ContractWorkbenchService.getPropertyUnits(property_id).then(function (response){
           $scope.addRentComponents.units = response;
        });
    };

    $scope.onSaveRentComponent = function(isValid){
        if(isValid){
            var formData = {
                data_property: $scope.addRentComponents.selectRentComponent,
                property_id: $scope.addRentComponents.property,
                unit_id: $scope.addRentComponents.unit,
                user_id : $scope.addRentComponents.user,
                effective_date: $scope.addRentComponents.effectiveDate,
                amount : $scope.addRentComponents.amount
            }
            ContractWorkbenchService.createPostRentComponent(formData).then(function (response) {
                $('#addRentComponentModal').modal('hide');
                $scope.setActiveTab(3);
            });
        }
    }

    $scope.deleteRentComponent = function(rentComponentID) {
        var r = confirm("Are you sure?");
        if( r == true){
            ContractWorkbenchService.deleteRentComponent(rentComponentID).then(function(response) {
                $scope.setActiveTab(3);
            });
        } else {
            return;
        }

    }
    $scope.onShowModalAddRentComponent = function(){
        $('#addRentComponentModal').modal('show');
    }

    $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withOption('lengthMenu', [[10, 25, 50, -1], [10, 25, 50, "All"]]);

    initTabs();
    $scope.setActiveTab(1);
    
})