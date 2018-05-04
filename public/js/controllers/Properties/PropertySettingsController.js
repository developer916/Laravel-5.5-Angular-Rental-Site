'use strict';

RentomatoApp.controller('PropertySettingsController', [
    '$scope',
    '$filter',
    'PropertyService',
    'toaster',
    function ($scope, $filter,
              PropertyService,
              toaster) {
        var vm = this;
        vm.property = {
            id: PropertyService.model.id
        }
        PropertyService.getBasicProperty(vm.property.id).then(function (response) {
            vm.property = response.data;
            if(response.data.media) {
                vm.property.media = angular.fromJson(response.data.media);
            }
        });

        vm.update = function () {
            PropertyService.updateMedia({
                property_id: vm.property.id,
                media: vm.property.media
            }).then(function (response) {
                toaster.success($filter('translate')('Property has been updated.'));
            });
        }
    }
])
;
