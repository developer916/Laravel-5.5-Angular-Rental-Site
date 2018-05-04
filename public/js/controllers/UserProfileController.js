'use strict';

RentomatoApp.controller('UserProfileController', ['$scope', 'UserService', function ($scope, UserService) {
    $scope.userData = {};
    if ($scope.userData) {
        RT.blockUI({
            target: '#userProfile',
            animate: true
        });
    }
    UserService.getAuthUserProfile().then(function (data) {
        $scope.userData = data;
        if(!angular.isObject(data.profile)){
            $scope.userData.profile = {};
        }
    }).finally(function () {
        RT.unblockUI("#userProfile");
    });

}]);
