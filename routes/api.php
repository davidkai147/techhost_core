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

Route::get('/unauthenticated', 'HomeController@unauthenticated')->name('unauthenticated');

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'AuthController@before_login')->name('login');
    Route::post('login', 'AuthController@login');

    Route::middleware('jwt.auth')->group(function () {
        Route::get('refresh', 'AuthController@refresh');
        Route::get('user', 'AuthController@user');
        Route::get('logout', 'AuthController@logout');
    });
});

// For main
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::namespace('API')->group(function () {
        Route::resource('categories', 'CategoryController');
    });
});

// For super admin
Route::group(['prefix' => 'sa', 'middleware' => ['jwt.auth', 'role.sa']], function () {
    Route::namespace('API')->group(function () {

    });
});
