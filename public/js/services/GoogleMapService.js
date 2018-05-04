RentomatoApp.factory('GoogleMapService', function () {
    var geocoder = new google.maps.Geocoder();
    // google.maps.configure({
    //     'key' : 'AIzaSyCnNMcqu4f6RbbSUm1Ri1MIP_8VLbZ_1mM'
    // });
    var create = function (id, zoom, center) {
        return new google.maps.Map(document.getElementById(id), {
            zoom: zoom,
            center: center
        });
    }
    var geocode = function (map, address, controller) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                controller.setGoogleMapResultComponents(results[0]);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                //alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    var getComponent = function (result) {
        var comp = {};
        for (var i = 0; i < result.address_components.length; i++) {
            var ac = result.address_components[i];
            comp[ac.types[0]] = ac.long_name;
        }
        return comp;
    }
    return {
        create: create,
        geocode: geocode,
        getComponent: getComponent,
    }
});