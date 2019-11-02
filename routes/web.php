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

use App\Providers\RouteServiceProvider;

Route::get('/','HomeController@index')->name('user.home.page');


/**
 * current affair routes
 */

 Route::get('admin','AdminController@index')->name('admin.current.affairs');

 Route::resource('categories', 'AdminCategoryController');