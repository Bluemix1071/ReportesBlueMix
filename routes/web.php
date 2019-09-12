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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/','seguridad\LoginController@index')->name('login');
Route::post('/','seguridad\LoginController@login')->name('login_post');
Route::get('/logout','seguridad\LoginController@logout')->name('logout');
Route::get('/registrar','AdminController@registrar')->name('registrar');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function(){

    Route::get('/','AdminController@index');


});


