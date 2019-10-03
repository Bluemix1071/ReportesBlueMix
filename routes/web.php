<?php



Route::get('/','seguridad\LoginController@index')->name('login');
Route::post('/','seguridad\LoginController@login')->name('login_post');
Route::get('/logout','seguridad\LoginController@logout')->name('logout');
Route::get('/registrar','AdminController@registrar')->name('registrar');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


//rutas globales autenticadas
Route::prefix('publicos')->middleware('auth')->group(function(){

    Route::get('/','InicioController@index')->name('Publico');


});

//rutas de registro
Route::prefix('auth')->middleware('auth','SuperAdmin')->group(function(){
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    
});


//rutas de administrador 
Route::prefix('admin')->namespace('Admin')->middleware('auth','SuperAdmin')->group(function(){

    Route::get('/','AdminController@index')->name('inicioAdmin');

    Route::get('/ListaUsuarios','EditarUserController@index')->name('ListarUser');
    Route::get('/ProductosNegativos','AdminController@ProductosNegativos')->name('ProductosNegativos');
    Route::post('/update', 'EditarUserController@update')->name('update');
    Route::get('/CuadroMando', 'AdminController@CuadroDeMAndo')->name('cuadroMando');
    Route::get('/ProductosPorMarca','AdminController@ProductosPorMarca')->name('ProductosPorMarca');



});


