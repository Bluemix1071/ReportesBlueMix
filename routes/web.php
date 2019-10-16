<?php



Route::get('/','seguridad\LoginController@index')->name('login');
Route::post('/','seguridad\LoginController@login')->name('login_post');
Route::get('/logout','seguridad\LoginController@logout')->name('logout');
//Route::get('/registrar','AdminController@registrar')->name('registrar');
Route::get('/graficos', 'ChartControllers\PulseChartController@index')->name('chart');
Route::post('/graficos', 'ChartControllers\PulseChartController@cargarC3')->name('cargarChart');


//Route::get('/home', 'HomeController@index')->name('home');


//rutas globales autenticadas
Route::prefix('publicos')->middleware('auth')->group(function(){

    Route::get('/','InicioController@index')->name('Publico');
    Route::get('/ProductosNegativos','publico\PublicoController@ProductosNegativos')->name('ProductosNegativos');


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
    
    Route::post('/update', 'EditarUserController@update')->name('update');
    Route::get('/CuadroMando', 'AdminController@CuadroDeMando')->name('cuadroMando');
    Route::get('/ProductosPorMarca','AdminController@ProductosPorMarca')->name('ProductosPorMarca');
    Route::get('/Ordenesdecompra','AdminController@ordenesdecompra')->name('ordenesdecompra');
    Route::post('/excel','AdminController@exportExcelproductosnegativos')->name('excel');
    Route::get('/pdf/{numero_de_orden_de_compra}','AdminController@exportpdf')->name('pdf.orden');
    Route::get('/excelproductospormarca','AdminController@exportExcelproductospormarca')->name('excelproductopormarca');
    Route::get('/Desviacion','AdminController@porcentajeDesviacion')->name('desviacion');



});


