'use strict';

RentomatoApp.controller('PropertiesController', [
    '$scope',
    '$state',
    '$stateParams',
    'PropertyService',
    function ($scope, $state, $stateParams, PropertyService) {
        var vm = this;
        vm.property = PropertyService.model;
        vm.property.photo = null;
        $scope.$watch(function(){
            return $state.current.name;
        },function(newValue){
            vm.currentState = newValue;
        });

        if ($stateParams.id) {
            PropertyService.model.id = $stateParams.id;
            PropertyService.getIdentityProperty($stateParams.id).then(function (response) {
                response.photo = response.photos;
                response.photos = null;
                angular.extend( PropertyService.model, response);
            });
        } else {
            PropertyService.create({}).then(function (response) {
                PropertyService.model.id = response.data.id;
                $state.go('property-view.info',{id:response.data.id});
            })
        }
        vm.go = function (state) {
            if (vm.property.id && vm.property.status) {
                $state.go(state);
            }
            return false;
        }
    }]);
