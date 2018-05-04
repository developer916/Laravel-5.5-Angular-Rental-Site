<!DOCTYPE html>
<html lang="en" data-ng-app="RentomatoApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') web.rentling @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="rentling"/>
    @show @section('meta_author')
        <meta name="author" content="rentling"/>
    @show @section('meta_description')
        <meta name="description"
              content="web.rentling"/>
    @show

    @yield('styles')

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    {{--<link rel="shortcut icon" href="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only-SMALL.png" width="16" height="16">--}}
    <link rel="shortcut icon" href="/img/favicon.png">
</head>
<?php if(App::environment('production')) { ?>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-58654085-4', 'auto');
    ga('send', 'pageview');
</script>
<?php } ?>
<body ng-controller="AppController"
      class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo page-on-load"
      ng-class="{'page-sidebar-closed': settings.layout.pageSidebarClosed}"
      style="display:none;"
>

<!-- BEGIN PAGE SPINNER -->
<div ng-spinner-bar class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>

<div data-ng-include="'/tpl/header.html'" data-ng-controller="HeaderController"
     class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
</div>

<div class="clearfix"></div>

<div class="page-container" ng-hide="guest">

    <div data-ng-include="'/tpl/sidebar.html'" data-ng-controller="SidebarController" class="page-sidebar-wrapper"></div>

    <div class="page-content-wrapper">
        <div class="page-content">

            <div data-ng-include="'/tpl/page-head.html'" data-ng-controller="PageHeadController" class="page-head">
            </div>
            <div ui-view></div>
        </div>
    </div>
</div>
<div class="page-container" ng-show="guest">
    <div ui-view></div>
</div>

<div data-ng-include="'/tpl/footer.html'" data-ng-controller="FooterController" class="page-footer"></div>

<script src="{{ elixir('js/rt.js') }}"></script>
<script src="/js/app.js" type="text/javascript"></script>
<script src="/js/filters/filters.js?{{time()}}" type="text/javascript"></script>
<script src="/js/directives.js" type="text/javascript"></script>
<script src="/js/directives/property.js" type="text/javascript"></script>
<script src="/js/directives/tenant.js" type="text/javascript"></script>
<script src="/js/services/BaseService.js" type="text/javascript"></script>
<script src="/js/services/PropertyService.js?" type="text/javascript"></script>
<script src="/js/services/UserService.js" type="text/javascript"></script>
<script src="/js/services/GlobalService.js" type="text/javascript"></script>
<script src="/js/services/SettingsService.js" type="text/javascript"></script>
<script src="/js/services/TenantsService.js" type="text/javascript"></script>
<script src="/js/services/EmailsService.js" type="text/javascript"></script>
<script src="/js/services/I18NService.js" type="text/javascript"></script>
<script src="/js/services/InvoiceService.js" type="text/javascript"></script>
<script src="/js/services/MessageService.js" type="text/javascript"></script>
<script src="/js/services/PlanningService.js" type="text/javascript"></script>
<script src="/js/services/TagService.js" type="text/javascript"></script>
<script src="/js/services/DashboardService.js" type="text/javascript"></script>
<script src="/js/services/DepositRelayService.js" type="text/javascript"></script>
<script src="/js/services/PaymentPerTenantService.js" type="text/javascript"></script>
<script src="/js/services/ContractWorkbenchService.js" type="text/javascript"></script>
<script src="/js/services/SendRentIncreaseService.js" type="text/javascript"></script>
<script src="/js/services/DocumentService.js" type="text/javascript"></script>
<script src="/js/services/LisaService.js" type="text/javascript"></script>
<script src="/js/services/LandlordService.js" type="text/javascript"></script>
<script src="/js/services/NotificationService.js" type="text/javascript"></script>
<script src="/js/services/AssociationService.js" type="text/javascript"></script>
<script src="/js/services/ContractTemplateService.js" type="text/javascript"></script>

<!-- cosinus -->
<script src="/js/services/GoogleMapService.js?" type="text/javascript"></script>
<script src="/js/services/CountryService.js?{{time()}}" type="text/javascript"></script>
<script src="/js/directives/ngAutocomplete.js?{{time()}}" type="text/javascript"></script>
<script src="/js/services/UtilService.js?{{time()}}" type="text/javascript"></script>
<script src="/js/services/CurrencyService.js?{{time()}}" type="text/javascript"></script>
<script src="/js/services/ContractService.js" type="text/javascript"></script>
<!--  -->
<script src="/js/controllers/DashboardController.js" type="text/javascript"></script>
<script src="/js/controllers/InvoicesController.js" type="text/javascript"></script>
<script src="/js/controllers/PaymentsController.js" type="text/javascript"></script>
<script src="/js/controllers/ProfileController.js" type="text/javascript"></script>
<script src="/js/controllers/SettingsController.js" type="text/javascript"></script>
<script src="/js/controllers/TenantsController.js" type="text/javascript"></script>
<script src="/js/controllers/EmailsController.js" type="text/javascript"></script>
<script src="/js/controllers/ActivityController.js" type="text/javascript"></script>
<script src="/js/controllers/SettingsController.js" type="text/javascript"></script>
<script src="/js/controllers/DocumentsController.js" type="text/javascript"></script>
<script src="/js/controllers/ListDocumentsController.js" type="text/javascript"></script>
<script src="/js/controllers/FinancesController.js" type="text/javascript"></script>
<script src="/js/controllers/I18NController.js" type="text/javascript"></script>
<script src="/js/controllers/MessagesController.js" type="text/javascript"></script>
<script src="/js/controllers/PlanningController.js" type="text/javascript"></script>
<script src="/js/controllers/PlanningTaskController.js" type="text/javascript"></script>
<script src="/js/controllers/UserProfileController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertiesListController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertiesController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyBasicsController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyOverviewController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyTransactionsController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyDocumentsController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyTenantsController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertySettingsController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyUserTransactionsController.js" type="text/javascript"></script>
<script src="/js/controllers/AssociationController.js" type="text/javascript"></script>
<script src="/js/controllers/ContractTemplateController.js" type="text/javascript"></script>
<script src="/js/controllers/Properties/PropertyServiceCostAccountsController.js" type="text/javascript"></script>
<script src="/js/controllers/DepositRelaysController.js" type="text/javascript"></script>
<script src="/js/controllers/PaymentPerTenantController.js" type="text/javascript"></script>
<script src="/js/controllers/ContractWorkbenchController.js" type="text/javascript"></script>
<script src="/js/controllers/SendRentIncreaseController.js" type="text/javascript"></script>

<!-- END APP LEVEL ANGULARJS SCRIPTS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{--<script src="//cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>--}}
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="//code.highcharts.com/modules/data.js"></script>
<script src="//code.highcharts.com/modules/drilldown.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&sensor=true&language=en-US&key=AIzaSyCnNMcqu4f6RbbSUm1Ri1MIP_8VLbZ_1mM"></script>
<script>
    jQuery(document).ready(function () {
        $.fn.dataTableExt.sErrMode = 'throw';
        RT.init();
        Layout.init();
        @if(!Request::segment(1))
            Index.init(); // init index page
        @endif

        $('.dataTables_scrollBody thead tr').addClass('hidden');
        $('.dataTables_scrollHeadInner').removeAttr('style');

    });
</script>
{{--<div style="font-size:14px;position: absolute;background:green;color:#fff;width:33%;right:0px;bottom:0;padding:15px;">--}}
    <?php

//    $environment = App::environment();
//    if ($environment == 'local' && $environment != 'production' && $_SERVER['SERVER_NAME'] != 'app.rentomato.com') {
//        $stringfromfile = file(base_path() . '/.git/HEAD', FILE_USE_INCLUDE_PATH);
//        $firstLine      = $stringfromfile[0];
//        $explodedstring = explode("/", $firstLine, 3);
//        $branchname     = $explodedstring[2];
//        print '<pre>';
//        print_r('Branch: ' . $branchname);
//        print '</pre>';
//
//        echo shell_exec("git log -1 --pretty=format:'%h - %s (%ci)' --abbrev-commit");
//    }

    ?>
{{--</div>--}}
</body>
</html>

