<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::get('/user', 'Api\UserController@getAuthUser');
Route::post('logout', 'Api\UserController@logout');

Route::group(['middleware' => ['jwt.verify']], function(){

 Route::post('transfer', 'Api\PaymentController@transferReceipt');
 Route::get('history', 'Api\PaymentController@customerHistory');
 
});
