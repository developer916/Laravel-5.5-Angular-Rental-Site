'use strict';

RentomatoApp.controller('PropertyOverviewController', [
    "$scope",
    '$stateParams',
    'PropertyService',
    'GoogleMapService',
    function ($scope,
              $stateParams,
              PropertyService,
              GoogleMapService) {
        var vm = this;
        vm.sharedProperty = PropertyService.model;
        vm.property = {
            id: PropertyService.model.id
        }

        PropertyService.getPropertyOverview(vm.property.id).then(function (response) {
            vm.property = response.data;
            vm.property.rent_total = 0;
            if (vm.property.transactions) {
                for (var i = 0; i < vm.property.transactions.length; i++) {
                    var transaction = vm.property.transactions[i];
                    if (transaction.transaction_category_id == 1) {
                        vm.property.rent_total += transaction.amount_total;
                    }
                }
            }
            var lat = ( vm.property.lat) ? vm.property.lat : 52;
            var lng = ( vm.property.lng) ? vm.property.lng : 5;
            var map = GoogleMapService.create('gmap_geocoding', 10, {
                lat: lat,
                lng: lng
            });
            vm.setMap(map);
        });

        vm.setMap = function (map) {
            GoogleMapService.geocode(map, vm.property.address, vm);
        }
        vm.setGoogleMapResultComponents = function (results) {

        }
    }]);
