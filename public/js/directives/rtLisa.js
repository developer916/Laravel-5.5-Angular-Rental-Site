RentomatoApp.directive('rtLisa', function ($filter, LisaService) {
  return {
    restrict: 'AE',
    templateUrl: '/views/lisa.html',
    scope: {
      pageUri: "="
    },
    controller: ['$scope', function ($scope) {

    }]
  }
});
