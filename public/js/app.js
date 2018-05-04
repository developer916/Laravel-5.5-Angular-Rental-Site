var RentomatoApp = angular.module("RentomatoApp", [
    "ui.router",
    "ngAnimate",
    "ui.bootstrap",
    "oc.lazyLoad",
    "ngSanitize",
    "pascalprecht.translate",
    "ngCookies",
    'toaster',
    'ngAutocomplete',
    //'localytics.directives',
    'ng-currency',
    'angular-loading-bar',
    'angularMoment',
    'ui.select',
    'ui-iconpicker',
    'datatables',
    'angular-img-cropper',
    'frapontillo.bootstrap-switch',
    'ui.tinymce'
]);

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
RentomatoApp.config(['$ocLazyLoadProvider', '$translateProvider', function ($ocLazyLoadProvider, $translateProvider) {
    $ocLazyLoadProvider.config({
        cssFilesInsertBefore: 'ng_load_plugins_before' // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
    });


    $translateProvider.useStaticFilesLoader({
        prefix: '/languages/',
        suffix: '.json'
    });

    // $translateProvider.useSanitizeValueStrategy('escape');
    $translateProvider.useSanitizeValueStrategy(null);

    $translateProvider.preferredLanguage('en');
    $translateProvider.useCookieStorage();
    $translateProvider.storageKey('lang');

}]);

//AngularJS v1.3.x workaround for old style controller declarition in HTML
RentomatoApp.config(['$controllerProvider', function ($controllerProvider) {
    // this option might be handy for migrating old apps, but please don't use it
    // in new ones!
    $controllerProvider.allowGlobals();
}]);

/* Setup global settings */
RentomatoApp.factory('settings', ['$rootScope', '$http', '$interval', '$timeout', function ($rootScope, $http, $interval) {
    var settings = {
        layout: {
            pageSidebarClosed: false, // sidebar state
            pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
        },
        layoutImgPath: RT.getAssetsPath() + 'admin/layout/img/',
        layoutCssPath: RT.getAssetsPath() + 'admin/layout/css/',
        menuLoading: true

    };
    $http.post('/menu').then(function (response) {
        settings.menu = response.data;
        settings.menuLoading = false;
    });

    $rootScope.settings = settings;

    return settings;
}]);

/* Setup App Main Controller */
RentomatoApp.controller('AppController', [
    '$scope',
    '$rootScope',
    '$translate',
    '$http',
    '$window',
    '$q',
    '$cookies',
    'UserService',
    'CurrencyService',
    'ContractService',
    'CountryService',
    function ($scope,
              $rootScope,
              $translate,
              $http,
              $window,
              $q,
              $cookies,
              UserService,
              CurrencyService,
              ContractService,
              CountryService) {
        $scope.$on('$viewContentLoaded', function () {
            RT.initComponents(); // init core components
            //Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive
        });
        //app available for all controllers
        $scope.app = {
            currencies: {},
            countries: [],
            contract_types: [],
            userServiceData: UserService.data
        };

        $scope.fetchingUserData = true;
        $scope.hasDemo = false;

        CurrencyService.getList().then(function (response) {
            $scope.app.currencies = response;
        });
        CountryService.getList().then(function (response) {
            $scope.app.countries = response;
        });
        ContractService.getContractTypes().then(function (response) {
            $scope.app.contract_types = response;            
        });

        ContractService.getFormFields(2); // get formFields for landlord type in contract template page
        ContractService.getFormFields(3); // get formFields for property type in contract template page

        UserService.getAuthUser().then(function (response) {
            $scope.name = response.user.name;
            if (response.user.profile != null && response.user.profile.avatar != null) {
                $scope.avatar = response.user.profile.avatar;
            }
            // console.log(response);
            $scope.hasDemo = response.user.has_demo;
            // console.log(response.roles);
            $scope.normal = response.normal;

            $scope.deposit = response.deposit;
            $scope.guest =  response.guest;

            $scope.role = response.roles;
            $scope.fetchingUserData = false;
            $scope.changeLoadingLanguage(response.lang);
        });


        /**
         * TODO::put this into a service
         */
        if ($cookies.get('lang')) {
            if ($cookies.get('lang') == '"nl"') {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/NL-flag.png';
                $scope.lang = 'Nederlands';
                $scope.langKey = 'nl';
                moment.locale('nl');
            } else {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/EN-flag.png';
                $scope.lang = 'English';
                $scope.langKey = 'en';
                moment.locale('en');
            }
        }
        $scope.changeLoadingLanguage = function (langKey){
            if (langKey == 'nl') {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/NL-flag.png';
                $scope.lang = 'Nederlands';
            } else {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/EN-flag.png';
                $scope.lang = 'English';
            }
            $scope.formData = {
                langKey : langKey
            };
            UserService.setLanguage($scope.formData).then(function (response) {
                $scope.langKey = langKey;
                moment.locale(langKey);
                $translate.use(langKey);
            });
        }

        $scope.changeLanguage = function (langKey) {
            if (langKey == 'nl') {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/NL-flag.png';
                $scope.lang = 'Nederlands';
            } else {
                $scope.langFlagUrl = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/EN-flag.png';
                $scope.lang = 'English';
            }
            $scope.formData = {
                langKey : langKey
            };
            UserService.setLanguage($scope.formData).then(function (response) {
                $scope.langKey = langKey;
                moment.locale(langKey);
                $translate.use(langKey);
                window.location.reload();
            });
        };


        /**
         * Handle demo data
         */

        $scope.removeDemoData = function () {
            UserService.disableDemoData().then(function (response) {
                $scope.hasDemo = false;
                $window.location.reload();
            });
        }

    }]);


/* Setup Layout Part - Header */
RentomatoApp.controller('HeaderController', ['$scope', '$http', '$q', '$window', 'NotificationService', 'MessageService', function ($scope, $http, $q, $window, NotificationService, MessageService) {
    $scope.$on('$includeContentLoaded', function () {
        Layout.initHeader(); // init header

        // Messages dropdown
        $scope.unread = 0;
        $scope.messages = [];
        MessageService.getMessages().then(function (response) {

            var msgStore = [];

            if(response.messages) {

                response.messages.forEach(function (message) {

                    // Check if the message has been read before
                    if (message.pivot.read == 0) {
                        if ($scope.messages.length < 5) $scope.messages.push(message);
                        $scope.unread += 1;
                    } else {
                        msgStore.push(message);
                    }
                });
            }



            if ($scope.messages.length < 5) {
                $scope.messages = $scope.messages.concat(msgStore.slice(0, Math.max(msgStore.length, 5 - $scope.messages.length)));
            }
        });

        // Notifications dropdown
        NotificationService.getNotifications().then(function (response) {
            $scope.unreadNotifications = response.count;
            $scope.notifications = response.notifications;
        });

    });
}]);

/* Setup Layout Part - Sidebar */
RentomatoApp.controller('SidebarController', function ($rootScope, $scope, $http, $window, $q, toaster, LisaService) {

    $scope.$on('$includeContentLoaded', function () {
        Layout.initSidebar(); // init sidebar
    });


    /** fix Lisa!!! **/
    $rootScope.$on('$locationChangeStart', function (event) {
        LisaService.getPageContent().then(function (response) {
            $rootScope.lisa = {};
            $rootScope.lisa = response;
            //$rootScope.pageVideo = $rootScope.trustAsHtml(response.lisa.video);
        });
    });

});

/* Setup Layout Part - Sidebar */
RentomatoApp.controller('PageHeadController', ['$scope', function ($scope) {
    $scope.$on('$includeContentLoaded', function () {
        //Demo.init(); // init theme panel
    });
}]);

/* Setup Layout Part - Footer */
RentomatoApp.controller('FooterController', ['$scope', function ($scope) {
    $scope.$on('$includeContentLoaded', function () {
        Layout.initFooter(); // init footer
    });
}]);

/* Setup Rounting For All Pages */
RentomatoApp.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    // Redirect any unmatched url
    $urlRouterProvider.otherwise("/dashboard");

    $stateProvider

    // Dashboard
    .state('dashboard', {
        url: "/dashboard",
        templateUrl: "/views/dashboard.html?" + Math.random(),
        data: {pageTitle: 'Dashboard', pageSubTitle: 'statistics & reports'},
        controller: "DashboardController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/DashboardController.js'
                    ]
                });
            }]
        }
    })


    .state('invoice-view', {
        url: "/invoice/view/:invoiceId",
        templateUrl: "/views/invoices/view.html",
        controller: "InvoicesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/InvoicesController.js'
                    ]
                }]);
            }]
        }
    })

    .state('deposit-relays', {
        url: "/deposit-relays",
        templateUrl: "/views/deposits/index.html",
        controller: "DepositRelaysController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/dt-i18n.js'
                    ]
                });
            }]
        }
    })
    .state('payment-per-tenant', {
        url: "/payment-per-tenant",
        templateUrl: "/views/payments/payment_per_tenant.html",
        controller: "PaymentPerTenantController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/dt-i18n.js'
                    ]
                });
            }]
        }
    })

    .state('send-rent-increase', {
        url: "/send-rent-increase",
        templateUrl: "/views/rent/send-rent-increase.html",
        controller: "SendRentIncreaseController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/dt-i18n.js'
                    ]
                });
            }]
        }
    })

    .state('contract-workbench', {
        url: "/contract-workbench",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
        // resolve: {
        //     deps: ['$ocLazyLoad', function ($ocLazyLoad) {
        //         return $ocLazyLoad.load({
        //             name: 'RentomatoApp',
        //             insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
        //             files: [
        //                 '/js/scripts/datatable.js',
        //                 '/js/scripts/table-ajax.js',
        //                 '/js/dt-i18n.js'
        //             ]
        //         });
        //     }]
        // }
    })

    .state('contract-workbench.early-cancellation-fees', {
        url: "^/contract-workbench/early-cancellation-fees",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
    })

    .state('contract-workbench.rent-components', {
        url: "^/contract-workbench/rent-components",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
    })

    .state('contract-workbench.points-calculation', {
        url: "^/contract-workbench/points-calculation",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
    })

    .state('contract-workbench.contract-wb-explanation', {
        url: "^/contract-workbench/contract-wb-explanation",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
    })

   .state('contract-workbench.rental-law', {
        url: "^/contract-workbench/rental-law",
        templateUrl: "/views/contract/contract-workbench.html",
        controller: "ContractWorkbenchController"
    })

    .state('properties', {
        url: "/properties",
        templateUrl: "/views/properties/index.html",
        controller: "PropertiesListController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/dt-i18n.js'
                    ]
                });
            }]
        }
    })

    .state('property-view', {
        url: "/properties/view/{id:int}",
        params: {
            id: null
        },
        templateUrl: "/views/properties/property_view.html",
        controller: "PropertiesController as propertyCtrl",
    })

    .state('property-view.overview', {
        url: "^/properties/view/overview/:id",
        templateUrl: "/views/properties/overview.html",
        controller: "PropertyOverviewController as propertyOverviewCtrl",
    })

    .state('property-view.info', {
        url: "^/properties/view/info/:id",
        templateUrl: "/views/properties/property_basic.html",
        controller: "PropertyBasicsController as propertyBasicsCtrl",
    })

    .state('property-view.documents', {
        url: "^/properties/view/documents/:id",
        templateUrl: "/views/properties/documents.html",
        controller: "PropertyDocumentsController as propertyDocumentsCtrl",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    .state('property-view.documents-edit', {
        url: "^/properties/view/documents/:id/:documentId",
        templateUrl: "/views/properties/documents_create_edit.html",
        controller: "PropertyDocumentsController as propertyDocumentsCtrl",
    })

    .state('property-view.transactions', {
        url: "^/properties/view/transactions/:id",
        templateUrl: "/views/properties/transactions.html",
        controller: "PropertyTransactionsController as propertyTransactionsCtrl",
    })

    .state('property-view.user-transactions', {
        url: "^/properties/view/tenant-transactions/:id/:ptid",
        templateUrl: "/views/properties/user_transactions.html",
        controller: "PropertyUserTransactionsController as propertyUserTransactionsCtrl",
    })  

    .state('property-view.settings', {
        url: "^/properties/view/settings/:id",
        templateUrl: "/views/properties/settings.html",
        controller: "PropertySettingsController as propertySettingsCtrl",
    })

    .state('property-view.tenants', {
        url: "^/properties/view/tenants/:id",
        templateUrl: "/views/properties/tenants.html",
        controller: "PropertyTenantsController as propertyTenantsCtrl",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    // Service Cost Account
    .state('property-view.scaccounts', {
        url: "^/properties/view/scaccounts/:id",
        templateUrl: "/views/properties/service_cost_accounts.html",
        controller: "PropertyServiceCostAccountsController as propertyScaccountsCtrl",
    })

    .state('property-view.scaccounts-create', {
        url: "^/properties/view/scaccounts/:id/:scaccountId",
        templateUrl: "/views/properties/service_cost_accounts_create.html",
        controller: "PropertyServiceCostAccountsController as propertyScaccountsCtrl",
    })

    //end  Service Cost Account

    .state('documents', {
        url: "/documents",
        templateUrl: "/views/documents/index.html",
        controller: "ListDocumentsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/ListDocumentsController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })


    .state('document-new', {
        url: "/document/new",
        templateUrl: "/views/documents/create.html",
        controller: "DocumentsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/DocumentsController.js'
                    ]
                }]);
            }]
        }
    })

    .state('document-edit', {
        url: "/documents/edit/:id",
        templateUrl: "/views/documents/create.html",
        controller: "DocumentsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/DocumentsController.js'
                    ]
                }]);
            }]
        }
    })


    .state('finances', {
        url: "/finances",
        templateUrl: "/views/finances/index.html",
        controller: "FinancesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/FinancesController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    .state('activity', {
        url: "/activity",
        templateUrl: "/views/activity/index.html",
        data: {pageTitle: 'Activity', pageSubTitle: 'see whats happening'},
        controller: "ActivityController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/ActivityController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    .state('invoices', {
        url: "/invoices",
        templateUrl: "/views/invoices/index.html",
        data: {pageTitle: 'Invoices', pageSubTitle: 'overview of your invoices'},
        controller: "InvoicesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/InvoicesController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    .state('invoices-tenant', {
        url: "/invoices/tenant/:tenantId",
        templateUrl: "/views/invoices/tenant.html",
        controller: "InvoicesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/InvoicesController.js'
                    ]
                }]);
            }]
        }
    })

    .state('payments-tenant', {
        url: "/payments/tenant/:tenantId",
        templateUrl: "/views/payments/tenant.html",
        controller: "PaymentsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/PaymentsController.js'
                    ]
                }]);
            }]
        }
    })


    .state('payments', {
        url: "/payments",
        templateUrl: "/views/payments/index.html",
        controller: "PaymentsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/PaymentsController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })


    .state('settings', {
        url: "/settings",
        templateUrl: "/views/settings.html",
        controller: "SettingsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/SettingsController.js'
                    ]
                }]);
            }]
        }
    })


    .state('translations', {
        url: "/translations",
        templateUrl: "/views/translations/index.html",
        controller: "I18NController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/I18NController.js'
                    ]
                }]);
            }]
        }
    })

    .state('emails', {
        url: "/emails",
        templateUrl: "/views/emails/index.html",
        controller: "EmailsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/EmailsController.js'
                    ]
                }]);
            }]
        }
    })

    .state('new-email', {
        url: "/emails/create",
        templateUrl: "/views/emails/create_edit.html",
        controller: "EmailsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/EmailsController.js'
                    ]
                }]);
            }]
        }
    })


    // -- Messages -----------------------------------------
    .state('messages', {
        url: "/messages",
        templateUrl: "/views/messages/index.html",
        data: {pageTitle: 'My Messages', pageSubTitle: 'overview of your messages'},
        controller: "MessagesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }]);
            }]
        }
    })
    .state('messages.compose', { // State when writing a message
        url: "/compose",
        templateUrl: "/views/messages/compose.html?ng=" + Math.random(),
        data: {pageTitle: 'Compose a message', pageSubTitle: ''},
        controller: "MessagesController", // Is this necessary or inherited?
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }]);
            }]
        }
    })
    .state('messages.composing', { // State when replying to a single user
        url: "/compose/reply/{id:[0-9]+}",
        templateUrl: "/views/messages/compose.html?ng=" + Math.random(),
        data: {pageTitle: 'Reply to a message', pageSubTitle: ''},
        controller: "MessagesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }])
            }]
        }
    })
    .state('messages.composingType', { // TODO Possibly redundant State when writing another kind of reply
        url: "/compose/reply/{id}/{type}",
        templateUrl: "/views/messages/compose.html?ng=" + Math.random(),
        data: {pageTitle: 'Reply to a message', pageSubTitle: ''},
        controller: "MessagesController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }])
            }]
        }
    })
    .state('messages.composeTo', { // State when writing a message to specific object
        url: "/compose/{type}/{id}",
        templateUrl: "/views/messages/compose.html?ng=" + Math.random(),
        data: {pageTitle: 'Compose a message', pageSubTitle: ''},
        controller: "MessagesController", // Is this necessary or inherited?
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }]);
            }]
        }
    })
    .state('messages.view', {
        url: "/view/{id}",
        templateUrl: "/views/messages/message.html?x=" + Math.random(),
        data: {pageTitle: 'View the message', pageSubTitle: ''},
        controller: "MessagesController", // Is this necessary or inherited?
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/MessagesController.js'
                    ]
                }]);
            }]
        }
    })
    // -- End messages -----------------------------------------

    // -- Planning ---------------------------------------------
    .state('planning', {
      url: '/planning',
      templateUrl: "/views/planning/index.html",
      controller: "PlanningController",
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'RentomatoApp',
            files: [
                '/js/controllers/PlanningController.js'
            ]
          }]);
        }]
      }
    })
    .state('planning.create', {
      url: '/task/create',
      templateUrl: "/views/planning/create-task.html",
      controller: "PlanningTaskController",
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'RentomatoApp',
            files: [
                '/js/controllers/PlanningTaskController.js'
            ]
          }]);
        }]
      }
    })
    // -- End planning -----------------------------------------

    // Tenants States

    .state('tenants', {
        url: "/tenants",
        templateUrl: "/views/tenants/index.html",
        controller: "TenantsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/controllers/TenantsController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    .state('new-tenant', {
        url: "/tenants/new",
        templateUrl: "/views/tenants/create.html",
        controller: "TenantsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/TenantsController.js'
                    ]
                }]);
            }]
        }
    })

    .state('tenant-view', {
        url: "/tenant/view/:id",
        templateUrl: "/views/tenants/view.html",
        controller: "TenantsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/TenantsController.js'
                    ]
                }]);
            }]
        }
    })

    .state('tenant-edit', {
        url: "/tenant/edit/:id",
        templateUrl: "/views/tenants/edit_tenant.html",
        controller: "TenantsController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/controllers/TenantsController.js'
                    ]
                }]);
            }]
        }
    })

    // -- Association setting ---------------------------------------------
    .state('association', {
        url: "/contract/association",
        templateUrl: "/views/association/index.html",
        controller: "AssociationController as associationCtrl",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [
                        '/js/scripts/datatable.js',
                        '/js/scripts/table-ajax.js',
                        '/js/controllers/AssociationController.js',
                        '/js/dt-i18n.js'
                    ]
                }]);
            }]
        }
    })

    // -- End Association setting  ---------------------------------------------

    // -- Property template management ---------------------------------------------
    .state('contract-template', {
        url: "/contract/template",
        templateUrl: "/views/contract-template/index.html",
        controller: "ContractTemplateController as ContractTemplateCtrl",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load([{
                    name: 'RentomatoApp',
                    files: [                        
                        '/js/controllers/ContractTemplateController.js'                        
                    ]
                }]);
            }]
        }
    })

    // -- End Property template management  ---------------------------------------------


    // User Profile
    .state("profile", {
        url: "/profile",
        templateUrl: "views/profile/main.html",
        controller: "UserProfileController",
        resolve: {
            deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                return $ocLazyLoad.load({
                    name: 'RentomatoApp',
                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                    files: [
                        'js/controllers/UserProfileController.js'
                    ]
                });
            }]
        }
    })
}]);

/* Init global settings and run the app */
RentomatoApp.run(["$rootScope", "settings", "$state", "$window", function ($rootScope, settings, $state, $window) {
    $('body').show();
    $rootScope.$state = $state; // state to be accessed from view

}]);
