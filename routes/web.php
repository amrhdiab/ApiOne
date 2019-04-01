<?php

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

//Home - Front
Route::get('/', 'PagesController@index');
Route::get('/readme', 'PagesController@readme')->name('readme');

//Admin Routes
Route::group(['prefix' => 'admin'], function ()
{
    //Auth Routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');

    /////////////////////////////> Users CRUD </////////////////////////////

    //Users Fetch data
    Route::get('users/data','UsersController@fetchData')->name('users.fetch');
    //Users Fetch Single data
    Route::get('users/single-item','UsersController@fetch_single')->name('users.fetch.single');
    //Users View data
    Route::get('users/view','UsersController@view')->name('users.view');
    //Users Remove Single
    Route::delete('users/delete-item','UsersController@removeData')->name('users.remove');
    //Users Bulk Remove
    Route::delete('users/delete-bulk','UsersController@removeBulk')->name('users.remove.bulk');
    //Resource route (Store & Index)
    Route::resource('users','UsersController');
});
