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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['api']], function () {
    Route::post('auth/login', 'ApiController@login');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('user', 'ApiController@getAuthUser');
    });
});



Route::namespace('api')->group(function () {
    Route::get('events', 'EventsController@index');
    Route::get('events/{id}', 'EventsController@show');
    Route::put('events', 'EventsController@store');
    Route::post('events/{id}', 'EventsController@update');
    Route::delete('events/{id}', 'EventsController@delete');
});