RentomatoApp.factory('InvoiceService', function ($http, BaseService) {
  var InvoiceService = {
    getInvoice: function (id) {
      var request = $http({
        url: '/invoice/'+id,
        method: 'GET'
      });
      return BaseService.apiCall(request);
    }
  };

  return InvoiceService;
});
