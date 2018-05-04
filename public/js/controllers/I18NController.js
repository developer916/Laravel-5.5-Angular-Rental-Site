'use strict';

RentomatoApp.controller('I18NController', function ($rootScope, $scope, toaster, I18NService, $filter) {

  $scope.translations = [];
  $scope.newItemFormData = {};
  $scope.updateItemsFormData = {};
  $scope.updateItemsFormData.label = [];
  $scope.updateItemsFormData.label_key = [];

  $scope.newItem = function () {
    I18NService.addItem($scope.newItemFormData).then(function (response) {
      I18NService.getTranslationsByLanguage(2).then(function (response) {
        $scope.translations = response;
      });
    });
  };

  $scope.updateItem = function (langId,itemIndex,itemId) {
    I18NService.updateItem($scope.translations[langId][itemIndex],itemId).then(function (response) {
      toaster.success($filter('translate')('Language Item Updated.'));
    });
  };

  $scope.publish = function (language_id) {
    I18NService.publish(language_id).then(function (response) {
      if (response.status == 1) {
        toaster.success($filter('translate')('Language Published - please refresh!'));
      }
    });
  };

  I18NService.getLanguages().then(function (response) {
    $scope.languages = response;
  });

  I18NService.getTranslations().then(function (response) {
    $scope.translations = response;
  });

  $scope.index = function () {
    var global = {};
    I18NService.index().then(function (indexResponse) {
      global.response = indexResponse;
      I18NService.getTranslations().then(function (translationsResponse) {
        $scope.translations = translationsResponse;
        if (global.response.status == 1 && global.response.msg) {
          toaster.success(global.response.msg);
        }
      });
    });
  };


});
