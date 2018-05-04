<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::pattern('id', '[0-9]+');
Route::pattern('lang', '[a-z0-9]{2}');
Route::pattern('slug', '[a-zA-Z0-9-]+');

Route::post('payment/handle', function () {
    Log::info('Incoming request:', Input::all());
    echo '[accepted]';
});

Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('auth/login', 'Auth\LoginController@login');
Route::any('auth/logout', 'Auth\LoginController@logout');

Route::get('auth/register/{slug?}/{id?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('auth/register', 'Auth\RegisterController@register');

Route::get('confirm/guest/{slug}/{id}', 'Auth\LoginController@landlordConfirm')->name('confirmLandlord');

//SendConfirm(X, Type)

Route::get('sendConfirm/{id}/{slug}', 'Auth\LoginController@sendConfirm')->name('sendConfirm');

Route::get('register/deposit/{id}/{slug}', 'Auth\LoginController@deposit')->name('confirmDeposit');

Route::post('confirm/password/{id}/{slug}', 'Auth\RegisterController@depositRegister')->name('confirmPassword');

Route::get('testTenantManager', 'Auth\RegisterController@testTenantManager');

Route::get('delete/account/confirm/{id}', 'Auth\RegisterController@deleteAccountConfirm')->name('deleteAccountConfirm');

//Route::controllers([
//    'auth' => 'Auth\AuthController',
//    'password' => 'Auth\PasswordController',
//]);

Route::post('users/create', 'RegisterController@postCreate');
Route::post('users/forgot', 'Auth\RegisterController@postForgotPassword');

/**
 * methods used by 3rd parties
 */

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {
    Route::post('users/create', 'RegisterController@postApiCreate');
});

Route::post('jotform/webhook', 'Admin\JotformController@webhook');

Route::group(['middleware' => 'acl', 'protect_alias' => 'menu', 'namespace' => 'Admin'], function () {
    # Menu
    Route::post('menu', 'MenuController@postMenu');

    # Users
    Route::post('user', 'NgCheckController@postUser');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {

    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

    # API for invitations
    Route::post('existTenants', 'InvitationController@existTenants');
    Route::post('postNewUserWizard', 'InvitationController@postNewUserWizard');

    # Guest Dashboard
    Route::get('guest', 'GuestController@index');

    # Admin Dashboard
    Route::get('dashboard', 'DashboardController@index');
    Route::get('new-user-wizard','DashboardController@newUserWizard');
    Route::get('new-user-wizard-video','DashboardController@newUserWizardVideo');
    Route::get('dashboard/get/deposit', 'DashboardController@getDepositRelay');
    Route::get('dashboard/widgets/stats', 'DashboardController@getDashboardStats');
    Route::get('dashboard/widgets/stats/total', 'DashboardController@getDashboardTotal');
    Route::get('dashboard/widgets/stats/thismonthsrent', 'DashboardController@getDashboardRent');
    Route::get('dashboard/widgets/stats/latest', 'DashboardController@getDashboardLatest');
    Route::any('dashboard/widgets/stats/monthoverview', 'DashboardController@getDashboardMonthOverview');
    Route::get('dashboard/widgets/stats/tenantstatus', 'DashboardController@getDashboardTenantStatus');

    # Create and invite landlord
    Route::post('landlord/create', 'LandlordController@postCreate');

    # Password api calls
    Route::post('users/password/change', 'UserPasswordController@postChange');
    Route::post('users/password/reset', 'UserPasswordController@postReset');

    # Language
    Route::get('language', 'LanguageController@index');
    Route::get('language/create', 'LanguageController@getCreate');
    Route::post('language/create', 'LanguageController@postCreate');
    Route::get('language/{id}/edit', 'LanguageController@getEdit');
    Route::post('language/{id}/edit', 'LanguageController@postEdit');
    Route::get('language/{id}/delete', 'LanguageController@getDelete');
    Route::post('language/{id}/delete', 'LanguageController@postDelete');
    Route::get('language/data', 'LanguageController@data');
    Route::get('language/reorder', 'LanguageController@getReorder');

    # Activity
    Route::get('activity', 'ActivityController@index');

    # Invoices
    Route::get('invoices', 'InvoiceController@getInvoices');
    Route::get('invoice/{id}', 'InvoiceController@getInvoice');
    Route::get('invoice/update', 'InvoiceController@getInvoiceUpdate');
    Route::delete('invoice/{id}', 'InvoiceController@deleteInvoice');

    Route::post('invoice/update', 'InvoiceController@postInvoiceUpdate');

    // -- end invoices

    # Payments
    Route::get('payments', 'PaymentController@getPayments');
    Route::get('payment/{id}', 'PaymentController@getPayment');
    Route::get('payment/result', 'PaymentController@getPaymentResult');
    Route::get('payment/update', 'PaymentController@getPaymentUpdate');
    Route::get('payment/delete/{id}', 'PaymentController@getPaymentDelete');

    Route::get('paymentPerTenant/tenants', 'PaymentPerTenantController@getTenants');
    Route::get('paymentPerTenant/getTenantPayment/{id}', 'PaymentPerTenantController@getTenantPayment');
    Route::post('paymentPerTenant/importFileUpload', 'PaymentPerTenantController@importFileUpload');
    Route::post('paymentPerTenant/deregFileUpload', 'PaymentPerTenantController@deregFileUpload');

    Route::post('payment/update', 'PaymentController@postPaymentUpdate');

    // -- end payments

    # Association setting    
    Route::get('association/properties/{id}', 'AssociationController@getPropertiesWithCountry');    
    Route::post('association/create', 'AssociationController@postCreate');        
    // -- end Association setting

    # Contract Template management    
    Route::get('contracts/types', 'ContractTemplateController@getTypes');
    Route::get('contracts/getFormFields/{typeId}', 'ContractTemplateController@getFormFields');        
    Route::get('contracts/getTemplate/{typeId}/{countryId}/{propertyId?}', 'ContractTemplateController@getTemplate');    
    Route::post('contracts/saveTemplate', 'ContractTemplateController@postSaveTemplate');        
    // -- end Contract Template management
    
    

    # Documents
    Route::post('document/create', 'DocumentController@postCreate');
    Route::post('document/search', 'DocumentController@postSearchDocuments');

    Route::get('documents', 'DocumentController@getDocuments');
    Route::get('document/{id}', 'DocumentController@getDocument');
    //        Route::delete('document/{id}', 'DocumentController@deleteDocument');
    Route::get('document/delete/{id}', 'DocumentController@getDelete');
    Route::get('documents/delete/{id}', 'DocumentController@getDeleteDocument');
    Route::post('documents/update', 'DocumentController@postUpdate');
    Route::post('documents/upload', 'DocumentController@postUpload');
    Route::post('document/new', 'DocumentController@postCreate');
    // -- end tenants

    # Emails
    Route::get('emails/', 'EmailController@getEmails');
    Route::get('emails/events', 'EmailController@getEmailEvents');
    Route::get('emails/delete/{id}', 'EmailController@getDeleteEmail');

    Route::post('emails/save', 'EmailController@postSaveEmail');
    // -- end emails

    # Messages
    Route::get      ('messages', 'MessagesController@getMessages');
    Route::post     ('messages/send', 'MessagesController@postSendMessage');
    Route::put      ('messages', 'MessagesController@putMessage');
    Route::delete   ('messages/delete/{id}', 'MessagesController@deleteMessage');
    Route::post     ('messages/mark-as-read/{id}', 'MessagesController@postMarkAsRead');
    Route::get      ('messages/getReplyDetails/{id}/{type}', 'MessagesController@getReplyDetails');
    # Messages - tags
    Route::get      ('messages/tags', 'TagsController@getTags');
    Route::post     ('messages/tags', 'MessagesController@postTags');

    # Tags
    Route::delete   ('tags/{id}', 'TagsController@delete');
    Route::post     ('tags', 'TagsController@postTag');
    Route::patch    ('tags', 'TagsController@patchTag');

    # Settings
    Route::get('settings', 'SettingsController@index');
    Route::post('settings/save', 'SettingsController@postSaveAccountSettings');
    Route::post('settings/save', 'SettingsController@postSaveAccountSettings');
    Route::post('settings/save/password', 'SettingsController@postSavePassword');

    # Deposit Relays
    Route::get('depositRelays', 'DepositRelaysController@index');
    Route::get('depositRelays/tenant', 'DepositRelaysController@index');
    Route::get('depositRelays/getRelays','DepositRelaysController@getRelays');
    Route::post('depositRelay/getChangeableData', 'DepositRelaysController@getChangeableData');
    Route::post('depositRelay/cancel', 'DepositRelaysController@setCancelDepositRelay');
    Route::post('depositRelays/saveRelay', 'DepositRelaysController@saveDepositRelay');

    # Rent Increase Module
    Route::any('sendRentIncrease/getList', 'SendRentIncreaseController@getList');
    Route::post('sendRentIncrease/postCreate','SendRentIncreaseController@postCreate');

    # Contract workbench
    Route::get('contractWorkbench/getRentComponents', 'ContractWorkbenchController@getRentComponents');
    Route::get('contractWorkbench/getPropertyUnits/{id}', 'ContractWorkbenchController@getPropertyUnits');
    Route::post('contractWorkbench/postCreateRentComponent', 'ContractWorkbenchController@postCreateRentComponent');
    Route::get('contractWorkbench/deleteRentComponent/{id}', 'ContractWorkbenchController@deleteRentComponent');

    # Tenants
    Route::post('tenant/create', 'TenantController@postCreate');
    Route::post('tenant/create_single_tenant', 'TenantController@postCreateSingleTenant');
    Route::post('tenants/search', 'TenantController@postSearchTenants');
    Route::post('tenant/update', 'TenantController@postUpdateTenant');
    Route::get('tenants', 'TenantController@getTenantsGrid');
    Route::get('tenant/{id}', 'TenantController@getTenant');
    Route::get('tenant/assigned/{id}', 'TenantController@getTenantAssigned');
    Route::get('tenants/delete/{id}', 'TenantController@getDeleteTenant');
    Route::get('tenants/test', 'TenantController@test');
    // -- end tenants

    # status update methods
    Route::put('status/demo', 'UserController@putUpdateDemo');

    # Reports
    Route::get('reports', 'ReportsController@index');

    # Lisa (Help)
    Route::post('lisa', 'LisaController@postIndex');

    # Notifications
    Route::get('notifications', 'NotificationController@getNotifications');

    # Settings
    Route::get('settings', 'SettingsController@index');
    Route::get('settings/get', 'SettingsController@getSettings');
    Route::post('settings/save/personal', 'SettingsController@postSavePersonalInfo');
    Route::post('settings/save/avatar', 'SettingsController@postSaveAvatar');
    Route::post('settings/save/privacy', 'SettingsController@postSavePrivacy');
    Route::post('settings/save/currency', 'SettingsController@postSaveCurrency');
    Route::post('settings/upload/avatar', 'SettingsController@postUploadAvatar');
    Route::post('settings/delete/account', 'SettingsController@postDeleteAccount');
    Route::post('settings/password/check', 'SettingsController@postPasswordCheck');
    Route::get('settings/removeFileUpload', 'SettingsController@getRemoveFileUpload');

    # Properties
    Route::get('properties', 'PropertyController@getProperties');
    Route::get('properties/view/{id}', 'PropertyController@getProperty');
    Route::get('properties/overview/{id}', 'PropertyController@getPropertyOverview');
    Route::get('properties/edit/{id}', 'PropertyController@getEdit');
    Route::get('properties/documents/{id}', 'PropertyController@getDocuments');
    Route::get('properties/amenities', 'PropertyController@getAmenities');
    Route::get('properties/currencies', 'PropertyController@getCurrencies');
    Route::get('properties/countries', 'PropertyController@getCountries');
    Route::get('properties/basic/{any?}', 'PropertyController@getBasic');
    Route::get('properties/identity/{id}', 'PropertyController@getIdentity');
    Route::get('properties/units/{id}', 'PropertyController@getUnits');
    Route::get('properties/transaction-categories', 'PropertyController@getTransactionCategories');
    Route::get('properties/transaction-recurrings', 'PropertyController@getTransactionRecurrings');
    Route::get('properties/transaction-types', 'PropertyController@getTransactionTypes');
    Route::get('properties/transactions/{id}', 'PropertyController@getTransactions');
    Route::get('properties/transactions-count/{id}', 'PropertyController@getCountTransactions');
    Route::get('properties/tenants/{id}', 'PropertyTenantController@getTenants');
    Route::get('properties/tenants-transactions/{id}', 'PropertyTenantController@getUserTransactions');
    Route::get('property-tenants/tenant/{id}', 'PropertyTenantController@getTenant');
    Route::get('properties/delete/{id}', 'PropertyController@getDeleteProperty');
    Route::get('properties/property-types', 'PropertyController@getPropertyTypes');
    //post
    Route::post('properties/{propertyId}/tenant/{tenantId}', 'PropertyTenantController@postUpdatePropertyTenant');
    Route::post('properties/create-update-user-transaction', 'PropertyTenantController@postCreateUpdateUserTransaction');
    Route::get('properties/delete-user-transaction/{id}', 'PropertyTenantController@getDeleteUserTransaction');
    Route::get('properties/delete-transactions/{id}', 'PropertyController@getDeleteTransactions');
    Route::post('properties/create', 'PropertyController@postCreate');
    Route::post('properties/edit', 'PropertyController@postEdit');
    Route::post('properties/update', 'PropertyController@postUpdate');
    //Route::delete('properties/delete/{id}', 'PropertyController@deleteProperty');
    Route::post('properties/photos/upload', 'PropertyController@postUploadPhotos');
    Route::post('properties/documents/upload', 'PropertyController@postUploadDocuments');
    Route::post('properties/update_media', 'PropertyController@postUpdateMedia');
    Route::get('properties/delete_photo/{propertyId}/{id}', 'PropertyController@getDeletePhoto');
    Route::post('properties/create-update-tenant', 'PropertyTenantController@postCreateUpdate');
    Route::get('properties/delete_property_tenant/{id}', 'PropertyTenantController@postDelete');
    Route::post('properties/search_by_name', 'PropertyTenantController@postSearchByname');
    Route::post('properties/update_property_financial', 'PropertyController@postUpdateFinancial');
    Route::post('properties/transaction', 'PropertyController@postTransaction');
    Route::post('property-tenants/create', 'PropertyTenantController@postCreate');

    Route::get('properties/scaccounts/{id}', 'PropertyController@getScacounts');
    Route::get('properties/cost-types/{basetype}', 'PropertyController@getCostTypes');
    Route::post('properties/create-scaccount/', 'PropertyController@postCreateScacount');
    // Route::post('properties/scaccount/upload', 'PropertyController@postScaccountUpload');
    Route::get('properties/delete-scaccount/{id}', 'PropertyController@getDeleteScaccount');
    // -- end properties

    #Landlord
    Route::get('landlord/tenants-list', 'LandlordController@getTenantsList');

    # Users
    Route::get('user/visible-users/', 'UserController@getVisibleUsers');
    Route::get('user/recipients', 'UserController@getRecipients');
    Route::get('user/update/first/login', 'UserController@getSetFirstLogin');
    Route::get('user/get/first/login', 'UserController@getCheckFirstLogin');
    Route::get('user/get/tags', 'UserController@getTags');

    # Tasks
    Route::get('tasks', 'TasksController@index');

    # Translations
    Route::get('translations', 'LanguageController@getTranslations');// -- end translations
    Route::get('translations/languages', 'LanguageController@getTranslationLanguages');// -- end translations

    Route::post('translations/add', 'LanguageController@postNewItem');
    Route::post('translations/update/{id}', 'LanguageController@postUpdateItem');
    Route::post('translations/publish', 'LanguageController@postPublish');
    Route::post('translations/index', 'LanguageController@postIndexFiles');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {

    Route::get('users/', 'UserController@index');
    //Route::get('users/create', 'UserController@getCreate');
    Route::get('users/auth-user-profile', 'UserController@getAuthUserProfile');
    Route::get('users/auth-user-data', 'UserController@getAuthUserData');
    Route::get('users/auth-user-properties', 'UserController@getAuthUserProperties');
    Route::get('users/auth-user-properties-with-units', 'UserController@getAuthUserPropertiesWithUnits');
    Route::get('users/{id}/edit', 'UserController@getEdit');
    Route::post('users/{id}/edit', 'UserController@postEdit');
    Route::get('users/{id}/delete', 'UserController@getDelete');
    Route::post('users/{id}/delete', 'UserController@postDelete');
    Route::post('users/setLanguages', 'UserController@postSetLanguages');
    Route::get('users/data', 'UserController@data');
});

Route::group(['namespace' => 'Admin'], function () {
    # Menu
    Route::post('menu', 'MenuController@postMenu');
    Route::get('menu', 'MenuController@getMenu');

    # Users
    Route::post('user', 'NgCheckController@postUser');
    Route::get('user', 'NgCheckController@getUser');

    # Language
    Route::get('locale/{lang}', 'NgCheckController@getSetLocale');
});
