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

Route::group(['middleware' => ['api']], function () {
    Route::post('auth/login', 'ApiController@login');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('user', 'ApiController@getAuthUser');
    });
});

Route::namespace('api')->group(function () {
    Route::get('events', 'EventsController@index');
    Route::get('events/{eventId}', 'EventsController@show');
    Route::post('events', 'EventsController@store');
    Route::put('events/{eventId}', 'EventsController@update');
    Route::delete('events/{eventId}', 'EventsController@delete');


    Route::get('userevent/{eventId}', 'AttendanceController@show');
    Route::get('userevent/invitable/{eventId}', 'AttendanceController@invitable');
    Route::post('userevent', 'AttendanceController@store');

    Route::get('comments/{eventId}', 'CommentsController@show');
    Route::post('comments/{eventId}', 'CommentsController@store');

    Route::get('groups', 'GroupsController@index');
});



