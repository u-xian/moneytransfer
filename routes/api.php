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
Route::post('login', 'UserController@login');
Route::post('suspendreactivate/{id}','AuthenticateController@suspendReactivate');
Route::post('resetpassword/{id}', 'AuthenticateController@resetPassword');

Route::resource('user', 'UsersController');
Route::resource('customer', 'CustomerController');
Route::resource('currency', 'CurrenciesController');
Route::resource('country', 'CountriesController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
