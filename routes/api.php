<?php

use Illuminate\Http\Request;


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function ()
{
    Route::post('details', 'API\UserController@details');
    Route::get('logout', 'API\UserController@logout');
    Route::post('verify', 'API\UserController@verify');
});
