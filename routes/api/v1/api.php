<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

//User Routes

Route::post('login', 'Api\v1\LoginController@login');
//Route::post('register', 'Api\v1\LoginController@register');

Route::middleware('auth:api')->group( function () {
    Route::resource('inventory', 'Api\v1\inventory\InventoryController');
});

Route::prefix('/user')->group(function(){

	Route::middleware('auth:api')->get('/', 'Api\v1\user\UserController@index');
});