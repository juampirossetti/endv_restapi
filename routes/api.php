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