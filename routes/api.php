<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('iban-check', 'Auth\RegisterController@ibanCheck');
Route::post('postTenantDepositRelay', 'Auth\RegisterController@postTenantDepositRelay');
Route::post('postLandlordDepositRelay', 'Auth\RegisterController@postLandlordDepositRelay');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function () {
});
