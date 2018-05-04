RentomatoApp.filter('number', function () {
  return function (input) {
    return parseInt(input, 10);
  };
});

/**
 * return percentage based on input (how much) from totalValue
 */

RentomatoApp.filter('percentage', function ($filter) {
  return function (input, totalValue) {
    if (!input) input = 0;
    if (!totalValue) totalValue = 0;
    var returnVal = 0;
    returnVal = $filter('number')(Math.round((input * 100) / totalValue));
    if (returnVal) {
      return returnVal + '%';
    } else {
      return '--%';
    }
  }
});

/**
 * set default fallback value
 */

RentomatoApp.filter('default', function () {
  return function (input, value) {
    if (!isNaN(input) && input !== null && input !== undefined && (input !== '' || angular.isNumber(input))) {
      return input;
    }
    return value;
  }
});


RentomatoApp.filter('timeAgo', function () {
  return function (date) {
    return moment(date).fromNow(true);
  };
});


/**
 * format phone number
 */

RentomatoApp.filter('phone', function () {
  return function (phone) {
    if (!phone) {
      return '';
    }

    var value = phone.toString().trim();

    if (value.match(/[^0-9|\+]/)) {
      return phone;
    }

    var country, city, number;

    switch (value.length) {
      case 12:
        country = value.slice(0, 2);
        city = value.slice(2, 5);
        number = value.slice(5);
        break;

      default:
        return tel;
    }

    if (country == 1) {
      country = "";
    }

    number = number.slice(0, 3) + '-' + number.slice(3);

    return (country + " (" + city + ") " + number).trim();
  };
});

RentomatoApp.filter('trusted', ['$sce', function ($sce) {
  return $sce.trustAsResourceUrl;
}]);
