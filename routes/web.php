<?php

use Illuminate\Support\Facades\Route;

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

//The Following all get view from javascript
Route::get('/', function () {return view('app');});
Route::get('/login', function () {return view('app');});
Route::get('/dashboard', function () {return view('app');});
Route::get('/dashboard/{section}', function () {return view('app');})->where('section','.*');
Route::get('/cp', function () {return view('app');});
Route::get('/search', function () {return view('app');});
Route::get('/isbn/{isbn}', function () {return view('app');});
Route::get('/search', function () {return view('app');});
Route::get('/search/{string}', function () {return view('app');});
Route::get('/search/{string}/{category}', function () {return view('app');});
Route::get('/admin/cms', function () {return view('app');});
Route::get('/cms', function () {return view('app');});

Route::get('/cart/{cartId}', function () {return view('app');});
Route::get('/invoice/{invoiceId}', function () {return view('app');});

Route::get('/download-all-marcs', '\App\Http\Controllers\IndexController@marc');

Route::get('/static/{file}', "\App\Http\Controllers\IndexController@file")->where('file','.*');
Route::get('/files/{file}', '\App\Http\Controllers\IndexController@files');
Route::get('/files', '\App\Http\Controllers\IndexController@filesIndex');
Route::get('/logs', '\App\Http\Controllers\IndexController@logs');

Route::get('/success/{remoteid}', '\App\Http\Controllers\IndexController@success');
Route::get('/setup', '\App\Http\Controllers\SetupController@index');
Route::post('/setup/terminal', '\App\Http\Controllers\SetupController@terminal');
Route::get('/setup/optimize', '\App\Http\Controllers\SetupController@optimize');
Route::get('/setup/migrate', '\App\Http\Controllers\SetupController@migrate');
Route::get('/setup/rollback', '\App\Http\Controllers\SetupController@rollback');
Route::get('/setup/seed', '\App\Http\Controllers\SetupController@seed');
Route::get('/setup/reset', '\App\Http\Controllers\SetupController@reset');
Route::get('/setup/fresh', '\App\Http\Controllers\SetupController@fresh');
Route::get('/update-from-github', '\App\Http\Controllers\SetupController@pull');
Route::get('/setup/table/{action}/{table}', '\App\Http\Controllers\SetupController@tableAction');

Route::get('/img/{template}/{path}', '\App\Http\Controllers\ImagesController@images')->where('path','.*');

/*
Route::get('/admin/application', '\App\Http\Controllers\ApplicationController@index');
Route::post('/admin/application', '\App\Http\Controllers\ApplicationController@command');
Route::get('/admin/tests/{id}', '\App\Http\Controllers\ApplicationController@tests');
Route::post('/admin/application/env', '\App\Http\Controllers\ApplicationController@postUpdateEnv');
Route::post('/admin/application/error', '\App\Http\Controllers\ApplicationController@postUpdateError');
*/