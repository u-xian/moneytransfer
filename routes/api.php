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
Route::post('login', 'AuthenticateController@login');
Route::post('suspendreactivate/{id}','AuthenticateController@suspendReactivate');
Route::post('resetpassword/{id}', 'AuthenticateController@resetPassword');

//
Route::resource('user', 'UsersController');
Route::get('checkuserstatus/{id}', 'UsersController@isActivated');
Route::get('activate/{id}', 'UsersController@activate');
Route::resource('customer', 'CustomerController');
Route::get('isCustomer/{id}', 'CustomerController@isCustomer');
Route::resource('currency', 'CurrenciesController');
Route::resource('country', 'CountriesController');
Route::resource('category', 'CategoriesController');
Route::resource('tag', 'TagsController');
Route::resource('blogpost', 'PostsController');
Route::resource('transaction', 'TransactionsController');
Route::get('archievepost', 'PostsController@archieve');
Route::resource('blogpostcomment', 'PostsCommentsController');
Route::post('pay', 'PaymentController@paying');
Route::post('paymobile', 'PaymentController@mobileTransfer');
Route::post('testpay', 'PaymentController@test');




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
