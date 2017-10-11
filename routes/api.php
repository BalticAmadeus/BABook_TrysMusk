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
    Route::post('events', 'EventsController@store');
    Route::put('events/{id}', 'EventsController@update');
    Route::delete('events/{id}', 'EventsController@delete');

    //invites
//    Route::get('userevent/{eventId}', 'EventsController@index');
    //Route::get('userevent/{id}', 'EventsController@show');
    Route::post('userevent/{eventId}/{userId}', 'AttendanceController@store');
    Route::put('userevent/{attendaceId}/{status}', 'AttendanceController@update');
    //Route::delete('events/{id}', 'EventsController@delete');
});



