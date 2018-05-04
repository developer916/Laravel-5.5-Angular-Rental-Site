/**
 * Created by dmytro on 2/6/18.
 */
require('laravel-elixir-webpack');
var elixir = require('laravel-elixir');
var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');

var paths = {
    'assets': 'vendor',
    'build_css': 'assets/build/css',
    'build_js': 'assets/build/js',
    'js_public_path': '../public/js'
};

elixir(function (mix) {

    mix.styles([
        paths.assets + '/bootstrap/dist/css/bootstrap.min.css',
        paths.assets + '/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
        paths.assets + '/chosen/chosen.min.css',
        paths.assets + '/font-awesome/css/font-awesome.min.css',
        paths.assets + '/simple-line-icons/css/simple-line-icons.css',
        paths.assets + '/select2/dist/css/select2.min.css',
        paths.assets + '/ui-select/dist/select.min.css',
        paths.assets + '/datatables/media/css/jquery.dataTables.min.css',
        paths.assets + '/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.min.css',
        paths.assets + '/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        paths.assets + '/AngularJS-Toaster/toaster.min.css',
        paths.assets + '/dropzone/dist/min/basic.min.css',
        paths.assets + '/dropzone/dist/min/dropzone.min.css',
        paths.assets + '/angular-loading-bar/src/loading-bar.css',
        paths.assets + '/ui-iconpicker/dist/styles/ui-iconpicker.min.css',
        paths.build_css + '/components-md.css',
        paths.build_css + '/plugins-md.css',
        paths.build_css + '/layout.css',
        paths.build_css + '/themes/light.css',
        paths.build_css + '/custom.css'
    ], 'public/css/rt.css', 'resources/');


    mix.scripts([
        paths.assets + '/jquery-legacy/dist/jquery.min.js',
        paths.assets + '/jquery-ui/ui/minified/jquery-ui.min.js',
        paths.assets + '/bootstrap/dist/js/bootstrap.min.js',
        paths.assets + '/bootstrap-switch/dist/js/bootstrap-switch.min.js',
        paths.assets + '/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        paths.assets + '/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        paths.assets + '/chosen/chosen.jquery.min.js',
        paths.assets + '/jquery-slimscroll/jquery.slimscroll.min.js',
        paths.assets + '/blockUI/jquery.blockUI.js',
        paths.assets + '/select2/dist/js/select2.min.js',
        paths.assets + '/datatables/media/js/jquery.dataTables.min.js',
        paths.assets + '/datatables-tabletools/js/dataTables.tableTools.js',
        paths.assets + '/jquery-backstretch/jquery.backstretch.min.js',
        paths.assets + '/jquery-validation/dist/jquery.validate.min.js',
        paths.assets + '/jquery.cookie/jquery.cookie.js',
        paths.assets + '/moment/min/moment-with-locales.min.js',
        paths.assets + '/tinymce/tinymce.js',
        //paths.assets + '/morris.js/morris.min.js',
        paths.assets + '/dropzone/dist/dropzone.js',
        paths.build_js + '/rt.js',
        paths.build_js + '/layout.js',
        paths.build_js + '/pages/login-soft.js',
        //angular stuff
        paths.assets + '/angular/angular.min.js',
        paths.assets + '/angular-animate/angular-animate.min.js',
        paths.assets + '/angular-cookies/angular-cookies.min.js',
        paths.assets + '/angular-sanitize/angular-sanitize.min.js',
        paths.assets + '/angular-touch/angular-touch.min.js',
        paths.assets + '/angular-ui-router/release/angular-ui-router.min.js',
        paths.assets + '/oclazyload/dist/ocLazyLoad.min.js',
        paths.assets + '/angular-translate/angular-translate.min.js',
        paths.assets + '/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js',
        paths.assets + '/AngularJS-Toaster/toaster.min.js',
        paths.assets + '/ui-select/dist/select.min.js',
        paths.assets + '/angular-moment/angular-moment.min.js',
        paths.assets + '/ui-iconpicker/dist/scripts/ui-iconpicker.min.js',
        paths.assets + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
        paths.assets + '/ng-currency/dist/ng-currency.min.js',
        paths.assets + '/angular-loading-bar/src/loading-bar.js',
        paths.assets + '/angular-img-cropper/dist/angular-img-cropper.min.js',
        paths.assets + '/angular-bootstrap-switch/dist/angular-bootstrap-switch.min.js',
        paths.assets + '/angular-datatables/dist/angular-datatables.js',
        paths.assets + '/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js',
        paths.assets + '/angular-ui-tinymce/src/tinymce.js',
        paths.assets + '/angular-img-cropper/dist/angular-img-cropper.min.js',
    ], 'public/js/rt.js', 'resources/');


    mix.copy(paths.assets + '/font-awesome/fonts/**', 'public/fonts');
    mix.copy(paths.assets + '/simple-line-icons/fonts/**', 'public/build/fonts');


    mix.scripts([
        paths.js_public_path + '/controllers/ActivityController.js',
        paths.js_public_path + '/controllers/AuthController.js',
        paths.js_public_path + '/controllers/DashboardController.js',
        paths.js_public_path + '/controllers/DocumentsController.js',
        paths.js_public_path + '/controllers/EmailsController.js',
        paths.js_public_path + '/controllers/FinancesController.js',
        paths.js_public_path + '/controllers/I18NController.js',
        paths.js_public_path + '/controllers/InvoicesController.js',
        paths.js_public_path + '/controllers/ListDocumentsController.js',
        paths.js_public_path + '/controllers/MessagesController.js',
        paths.js_public_path + '/controllers/PaymentsController.js',
        paths.js_public_path + '/controllers/ProfileController.js',
        paths.js_public_path + '/controllers/SettingsController.js',
        paths.js_public_path + '/controllers/TenantsController.js',
        paths.js_public_path + '/controllers/UserProfileController.js',
        paths.js_public_path + '/controllers/DepositRelaysController.js',
    ], 'public/js/ctrl.js', 'resources/');


    mix.version([
        'css/rt.css',
        'js/rt.js',
        'js/ctrl.js'
    ]);

});