<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function () {
    return View::make('hello');
});

Route::get('api/contacts', 'ContactsController@index');
Route::post('api/contacts', 'ContactsController@store');
Route::get('api/contacts/{id}', 'ContactsController@show');
Route::put('api/contacts/{id}', 'ContactsController@update');
Route::delete('api/contacts/{id}', 'ContactsController@destroy');
