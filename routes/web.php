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
        Route::get('users/data', 'UserController@users')->name('users.data');
    });
});
