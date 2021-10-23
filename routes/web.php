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

Route::namespace('Home')->group(function(){
    // Route::get('/', 'HomeController');
    Route::get('/', 'DestinationController@index');

    Route::get('/blog', 'BlogController@index');
    Route::get('/contact', 'ContactController@index');
    Route::get('/destinations', 'DestinationController@index');
    Route::get('/destinations/{slug}', 'DestinationController@show');
});
