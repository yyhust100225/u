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

        Route::get('departments', 'DepartmentController@list')->name('departments.list');
        Route::get('departments/data', 'DepartmentController@data')->name('departments.data');
        Route::get('departments/create', 'DepartmentController@create')->name('departments.create');
        Route::post('departments/store', 'DepartmentController@store')->name('departments.store');
        Route::get('departments/edit/{id}', 'DepartmentController@edit')->name('departments.edit');
        Route::put('departments/update', 'DepartmentController@update')->name('departments.update');
        Route::delete('departments/delete', 'DepartmentController@delete')->name('departments.delete');

        Route::get('books', 'BookController@list')->name('books.list');
        Route::get('books/data', 'BookController@data')->name('books.data');
        Route::get('books/create', 'BookController@create')->name('books.create');
        Route::post('books/store', 'BookController@store')->name('books.store');
        Route::get('books/edit/{id}', 'BookController@edit')->name('books.edit');
        Route::put('books/update', 'BookController@update')->name('books.update');
        Route::delete('books/delete', 'BookController@delete')->name('books.delete');
        Route::get('books/increase/{id}', 'BookController@increase')->name('books.increase');
        Route::put('books/supplement', 'BookController@supplement')->name('books.supplement');
        Route::get('books/decrease/{id}', 'BookController@decrease')->name('books.decrease');
        Route::put('books/consume', 'BookController@consume')->name('books.consume');

        Route::get('materiels', 'MaterielController@list')->name('materiels.list');
        Route::get('materiels/data', 'MaterielController@data')->name('materiels.data');
        Route::get('materiels/create', 'MaterielController@create')->name('materiels.create');
        Route::post('materiels/store', 'MaterielController@store')->name('materiels.store');
        Route::get('materiels/edit/{id}', 'MaterielController@edit')->name('materiels.edit');
        Route::put('materiels/update', 'MaterielController@update')->name('materiels.update');
        Route::delete('materiels/delete', 'MaterielController@delete')->name('materiels.delete');
        Route::get('materiels/increase/{id}', 'MaterielController@increase')->name('materiels.increase');
        Route::put('materiels/supplement', 'MaterielController@supplement')->name('materiels.supplement');
        Route::get('materiels/decrease/{id}', 'MaterielController@decrease')->name('materiels.decrease');
        Route::put('materiels/consume', 'MaterielController@consume')->name('materiels.consume');

        Route::get('printers', 'PrinterController@list')->name('printers.list');
        Route::get('printers/data', 'PrinterController@data')->name('printers.data');
        Route::get('printers/create', 'PrinterController@create')->name('printers.create');
        Route::post('printers/store', 'PrinterController@store')->name('printers.store');
        Route::get('printers/edit/{id}', 'PrinterController@edit')->name('printers.edit');
        Route::put('printers/update', 'PrinterController@update')->name('printers.update');
        Route::delete('printers/delete', 'PrinterController@delete')->name('printers.delete');

        Route::get('printed_matters', 'PrintedMatterController@list')->name('printed_matters.list');
        Route::get('printed_matters/data', 'PrintedMatterController@data')->name('printed_matters.data');
        Route::get('printed_matters/create', 'PrintedMatterController@create')->name('printed_matters.create');
        Route::post('printed_matters/store', 'PrintedMatterController@store')->name('printed_matters.store');
        Route::get('printed_matters/edit/{id}', 'PrintedMatterController@edit')->name('printed_matters.edit');
        Route::put('printed_matters/update', 'PrintedMatterController@update')->name('printed_matters.update');
        Route::delete('printed_matters/delete', 'PrintedMatterController@delete')->name('printed_matters.delete');
    });
});
