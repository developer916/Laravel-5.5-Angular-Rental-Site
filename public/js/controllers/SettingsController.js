'use strict';

RentomatoApp.controller('SettingsController', [
    '$rootScope',
    '$scope',
    'SettingsService',
    'toaster',
    '$filter',
    'CurrencyService',
    'UserService'
    , function ($rootScope, $scope, SettingsService, toaster, $filter, CurrencyService, UserService) {
        $scope.formData = {};
        $scope.accountSettings = {};
        $scope.deletePassword = false;

        SettingsService.getAccountData().then(function (response) {
            response.files = [
                {
                    id: response.files.id,
                    file: response.files.file,
                    file_size: response.files.file_size
                }
            ]
            angular.extend($scope.formData, response);
        });


        $scope.setAvatar = function (avatar) {
            SettingsService.updateAvatar(avatar).then(function (response) {
                toaster.success($filter('translate')('Your avatar has been updated.'));
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };


        $scope.saveAvatar = function () {
            SettingsService.updateAvatar($scope.formData, true).then(function (response) {
                toaster.success($filter('translate')('Your avatar has been updated.'));
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };


        $scope.savePersonalInfo = function () {

            SettingsService.savePersonalInfo($scope.formData, true).then(function (response) {
                toaster.success($filter('translate')('Your personal information has been updated.'));
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };


        $scope.updatePassword = function () {
            console.log($scope.formData);
            SettingsService.updatePassword($scope.formData, true).then(function (response) {
                if (response.error) {
                    toaster.error(response.error);
                } else {
                    toaster.success($filter('translate')('Your password was updated.'));
                }
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };


        $scope.updateCurrency = function () {
            SettingsService.updateCurrency($scope.formData, true).then(function (response) {
                UserService.getAuthUser();
                toaster.success($filter('translate')('Your currency settings have been updated.'));
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };

        $scope.savePrivacy = function () {
            console.log($scope.accountSettings);
            SettingsService.updatePrivacy($scope.formData, true).then(function (response) {
                toaster.success($filter('translate')('Your privacy settings have been updated.'));
            }, function (err) {
                toaster.error($filter('translate')('An error occured, please try again later.'));
            });
        };

        $scope.deleteAccount = function (isValid) {
            $scope.deletePassword = false;
            if(isValid) {
                SettingsService.passwordCheck($scope.formData, true).then(function (response) {
                    if(response == 'success') {
                        var r = confirm("Are you sure? This can not be reverted and you will lose all your data, including tenants, properties, documents, settings, calculations, rent components, invoices.");
                        if( r == true){
                            SettingsService.deleteAccount($scope.formData, true).then(function (response) {
                               window.location.href = "auth/login";
                            });
                        }else {
                            return;
                        }
                    }else {
                        toaster.error($filter('translate')('Current password is incorrect.'));
                        $scope.deletePassword = true;
                        return;
                    }
                });
            }
        }
        $scope.removeFileFromUpload = function (file) {
            if (file && typeof file === 'object') {
                toaster.success($filter('translate')('Ok'));
                SettingsService.removeFileUpload().then(function (response) {
                    $scope.formData = response.original;
                    console.log($scope.formData);
                });
            }
        }


    }]);
