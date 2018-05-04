'use strict';

RentomatoApp.controller('EmailsController', function ($rootScope, $scope, $http, $state, toaster, EmailsService, I18NService) {
  $scope.formData = {};


  EmailsService.getEmailEvents().then(function (response) {
    $scope.formData.events = response;
  });

  I18NService.getLanguages().then(function (response) {
    $scope.formData.languages = response;
  });

  $scope.deleteEmail = function (id) {
    console.log(id);
    EmailsService.deleteEmail(id).then(function (response) {
      console.log(response);
      $state.go($state.current, {}, {reload: true});
    });
  };

  $scope.submitForm = function () {
    EmailsService.saveEmail($scope.formData).then(function (response) {
      toaster.success(response.message);
    });
  }
});
