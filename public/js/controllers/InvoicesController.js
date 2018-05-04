'use strict';

RentomatoApp.controller('InvoicesController', function ($rootScope, $scope, $stateParams, InvoiceService) {


  $scope.invoiceId = $stateParams.invoiceId;

  InvoiceService.getInvoice($scope.invoiceId).then(function(response) {
    $scope.invoice = response;
  });

});
