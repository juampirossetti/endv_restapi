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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('jwt.auth')->group(function () {
/* User Model API Routes */
    Route::get('user', 'UserController@index');
    Route::get('user/{user}', 'UserController@show');
    Route::post('user', 'UserController@create');
    Route::put('user/{user}', 'UserController@update');
    Route::delete('user/{user}', 'UserController@delete');

/* Dogday Event Model API Routes */
    Route::get('dogday', 'DogdayController@index');
    Route::get('dogday/{dogday}', 'DogdayController@show');
    Route::post('dogday', 'DogdayController@create');
    Route::put('dogday/{dogday}', 'DogdayController@update');
    Route::delete('dogday/{dogday}', 'DogdayController@delete');

/* GreenFriday Event Model API Routes */
    Route::get('greenfriday', 'GreenFridayController@index');
    Route::get('greenfriday/{greenFriday}', 'GreenFridayController@show');
    Route::post('greenfriday', 'GreenFridayController@create');
    Route::put('greenfriday/{greenFriday}', 'GreenFridayController@update');
    Route::delete('greenfriday/{greenFriday}', 'GreenFridayController@delete');
});

Route::post('authenticate', 'AuthenticateController@authenticate');                 