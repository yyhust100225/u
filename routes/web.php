<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Admin')->group(function(){
    Route::get('login/form', 'LoginController@showLoginForm')->name('login.form');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::middleware(['web.auth'])->group(function(){
        Route::get('/', 'HomeController@index');
        Route::get('home', 'HomeController@home')->name('home');
        Route::get('main', 'HomeController@main')->name('main');

        Route::get('users', 'UserController@list')->name('users.list');
        Route::get('users/data', 'UserController@data')->name('users.data');
        Route::get('users/create', 'UserController@create')->name('users.create');
        Route::post('users/store', 'UserController@store')->name('users.store');
        Route::get('users/edit/{id}', 'UserController@edit')->name('users.edit');
        Route::put('users/update', 'UserController@update')->name('users.update');
        Route::delete('users/delete', 'UserController@delete')->name('users.delete');
        Route::get('users/password', 'UserController@password')->name('users.password');
        Route::put('users/reset', 'UserController@reset')->name('users.reset');

        Route::get('roles', 'RoleController@list')->name('roles.list');
        Route::get('roles/data', 'RoleController@data')->name('roles.data');
        Route::get('roles/create', 'RoleController@create')->name('roles.create');
        Route::post('roles/store', 'RoleController@store')->name('roles.store');
        Route::get('roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
        Route::put('roles/update', 'RoleController@update')->name('roles.update');
        Route::delete('roles/delete', 'RoleController@delete')->name('roles.delete');

        Route::get('permissions', 'PermissionController@list')->name('permissions.list');
        Route::get('permissions/data', 'PermissionController@data')->name('permissions.data');
        Route::get('permissions/create', 'PermissionController@create')->name('permissions.create');
        Route::post('permissions/store', 'PermissionController@store')->name('permissions.store');
        Route::get('permissions/edit/{id}', 'PermissionController@edit')->name('permissions.edit');
        Route::put('permissions/update', 'PermissionController@update')->name('permissions.update');
        Route::delete('permissions/delete', 'PermissionController@delete')->name('permissions.delete');
    });
});
