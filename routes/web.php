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

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('auth/login', 'Auth\LoginController@showLoginForm');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout');


/* CLIENT SIDE START */

Route::get('/', 'IndexController@index');
Route::get('/dashboard', 'IndexController@index');
Route::get('/cp', 'IndexController@index');

Route::get('/search', 'IndexController@search');
Route::get('/isbn/{isbn}', 'IndexController@isbn');

Route::get('/search', 'IndexController@search');
Route::get('/search/{string}', 'IndexController@search');
Route::get('/search/{string}/{category}', 'IndexController@search');
Route::get('/admin/cms', 'IndexController@indexBlank');
Route::get('/cms', 'IndexController@indexBlank');

//Route::get('/dashboard', 'DashboardController@index');
//Route::get('/dashboard/profile', 'DashboardController@index');
//Route::get('/dashboard/settings', 'DashboardController@index');

Route::get('/cart', 'IndexController@index');
Route::get('/cart/{transo}', 'IndexController@index');
Route::get('/cart/review/{transno}', 'IndexController@index');
Route::post('/cart/add-to/{isbn}/{quantity}', 'IndexController@index');

/* CLIENT SIDE END */


Route::get('/logs', 'IndexController@logs');

Route::get('/success/{remoteid}', 'IndexController@success');
Route::get('/setup', 'SetupController@index');
Route::post('/setup/terminal', 'SetupController@terminal');
Route::get('/setup/optimize', 'SetupController@optimize');
Route::get('/setup/migrate', 'SetupController@migrate');
Route::get('/setup/rollback', 'SetupController@rollback');
Route::get('/setup/seed', 'SetupController@seed');
Route::get('/setup/reset', 'SetupController@reset');
Route::get('/setup/fresh', 'SetupController@fresh');
Route::get('/update-from-github', 'SetupController@pull');
Route::get('/setup/table/{action}/{table}', 'SetupController@tableAction');

//Route::post('/search', 'IndexController@postSearch');
Route::post('/dashboard/update/{prop}', 'DashboardController@updateProp');

Route::get('/dashboard/my-titles', 'DashboardController@myTitles');
Route::get('/dashboard/orders/standing-orders', 'DashboardController@standingOrders');
Route::get('/dashboard/orders/history', 'DashboardController@allHead');
Route::get('/dashboard/orders/archived-history', 'DashboardController@ancientHead');
Route::get('/dashboard/orders/bro', 'DashboardController@broHead');
Route::get('/dashboard/orders/back-ordered', 'DashboardController@backHead');

Route::get('/dashboard/orders/standing-orders/{transactionumber}', 'DashboardController@standingOrder');
Route::get('/dashboard/orders/history/{transactionumber}', 'DashboardController@allDetail');
Route::get('/dashboard/orders/bro/{transactionumber}', 'DashboardController@broDetail');
Route::get('/dashboard/orders/archived-history/{transactionumber}', 'DashboardController@ancientDetail');
Route::get('/dashboard/orders/back-ordered/{transactionumber}', 'DashboardController@backOrder');
Route::get('/dashboard/orders/processing/{remoteaddr}', 'DashboardController@processing');

Route::post('/cart/add-to', 'CartController@postAddToCart');
Route::post('/cart/update', 'CartController@postUpdateCart');
Route::post('/cart/use-cart', 'CartController@useCart');
Route::post('/cart/create-new-cart', 'CartController@postCreateCart');

Route::get('/admin/application', 'ApplicationController@index');
Route::post('/admin/application', 'ApplicationController@command');
Route::get('/admin/tests/{id}', 'ApplicationController@tests');
Route::post('/admin/application/env', 'ApplicationController@postUpdateEnv');
Route::post('/admin/application/error', 'ApplicationController@postUpdateError');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/db', 'AdminController@index');
Route::post('/admin/db', 'AdminController@command');
Route::post('/admin/db/search', 'AdminController@search');
Route::get('/admin/order/{transno}', 'AdminController@invoice');
Route::get('/admin/{dbf}', 'AdminController@viewDBF');
Route::get('/admin/vendors/{key}', 'AdminController@vendor');
Route::get('/admin/{dbf}/search/{search}', 'AdminController@viewDBF');


Route::get('/admin/ask/{table}/{search?}', 'AdminController@ask')->where('search','.*');

Route::get('/img/{template}/{path}', 'ImagesController@images')->where('path','.*');

Route::get('/static/{file}', "IndexController@file")->where('file','.*');

Route::get('/test','IndexController@test');
Route::get('/test-manual','IndexController@manual');
Route::post('/test-manual','IndexController@manual');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/files/{file}', 'IndexController@files');
Route::get('/files', 'IndexController@filesIndex');