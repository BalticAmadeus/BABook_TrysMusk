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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('api')->group(function () {
    Route::get('events', 'EventsController@index');
    Route::get('events/{id}', 'EventsController@show');
    Route::post('events/{id}', 'EventsController@update');
    Route::put('events', 'EventsController@store');
    Route::delete('events/{id}', 'EventsController@delete');
});