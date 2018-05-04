'use strict';

RentomatoApp.controller('PropertyBasicsController', [
    "$scope",
    "$cookies",
    "$log",
    '$stateParams',
    'PropertyService',
    'GoogleMapService',
    'CountryService',
    'CurrencyService',
    'UserService',
    'toaster',
    '$filter',
    function ($scope,
              $cookies,
              $log,
              $stateParams,
              PropertyService,
              GoogleMapService,
              CountryService,
              CurrencyService,
              UserService,
              toaster,
              $filter) {
        var vm = this;
        var addressComponents = {};
        vm.form = {};
        vm.propertiesTypes = {};
        vm.property = {
            id: PropertyService.model.id,
            photos: [],
            units: null,
            media: null,
            amenities: {},
            plan: 'free',
            status: 0
        };
        vm.amenities = [];
        if (vm.property.id) {
            PropertyService.getBasicProperty(vm.property.id).then(function (response) {
                if (!response.data.property_type_id) {
                    response.data.property_type_id = 1;
                }
                if (!response.data.amenities) {
                    response.data.amenities = {};
                } else {
                    var amenities = {};
                    for (var i = 0; i < response.data.amenities.length; i++) {
                        amenities[response.data.amenities[i].amenity_id] = response.data.amenities[i].value;
                    }
                    response.data.amenities = amenities;
                }
                vm.property = response.data;

                vm.setMap();
            });
        }
        vm.countries = CountryService.getList();
        PropertyService.getPropertyTypes().then(function (response) {
            vm.propertiesTypes = response;
        });
        vm.amenities = PropertyService.getAmenities().then(function (response) {
            vm.amenities = response.data;
        });
        var map = GoogleMapService.create('gmap_geocoding', 10, {
            lat: 52,
            lng: 5
        });
        vm.saveProperty = function () {
            RT.blockUI({
                target: '#tab_property',
                animate: true
            });
            vm.property.status = 1;
            PropertyService.update(vm.property).then(function (response) {
                vm.property.units = response.original.data.units;
                angular.extend(PropertyService.model, vm.property);
                toaster.success($filter('translate')('Property has been updated.'));
            }).finally(unblock);
        }


        function unblock() {
            RT.unblockUI("#tab_property");
        }

        vm.setMap = function () {
            GoogleMapService.geocode(map, vm.property.address, vm);
        }

        vm.setGoogleMapResultComponents = function (results) {
            addressComponents = GoogleMapService.getComponent(results);
            $scope.$apply(function () {
                if (CountryService.assocCountryList[addressComponents['country']]) {
                    vm.property.country_id = CountryService.assocCountryList[addressComponents['country']];
                }
                vm.property.city = addressComponents['locality'];
                vm.property.street_no = addressComponents['street_number'];
                vm.property.street = addressComponents['route'];
                vm.property.post_code = addressComponents['postal_code'];
                vm.property.state = addressComponents['administrative_alea_level_1'];
                vm.property.lat = results['geometry']['location']['H'];
                vm.property.lng = results['geometry']['location']['L'];
            });
        }

        vm.addUnit = function () {
            if (!vm.property.units) {
                vm.property.units = [];
            }
            vm.property.units.push(
                {status: 1, valid: false}
            );
        }

        vm.removeFileFromUpload = function (file) {
            if (file && typeof file === 'object') {
                var data = {
                    property_id: file.property_id,
                    id: file.id
                }
                PropertyService.deletePhoto(data);
            }
        }

    }]);
