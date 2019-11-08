<?php



Route::get('/','seguridad\LoginController@index')->name('login');
Route::post('/','seguridad\LoginController@login')->name('login_post');
Route::get('/logout','seguridad\LoginController@logout')->name('logout');
//Route::get('/registrar','AdminController@registrar')->name('registrar');
Route::get('/graficos', 'ChartControllers\PulseChartController@index')->name('chart');
Route::post('/graficos', 'ChartControllers\PulseChartController@cargarC3')->name('cargarChart');




//Rutas autenticadas de sala
Route::prefix('Ssla')->namespace('sala')->middleware('auth')->group(function(){
    Route::get('/Cambiodeprecios','SalaController@index')->name('cambiodeprecios');
    Route::post('/Cambiodeprecios','SalaController@filtrarcambioprecios')->name('filtrarcambioprecios');
});


//rutas globales autenticadas
Route::prefix('publicos')->middleware('auth')->group(function(){

    Route::get('/','InicioController@index')->name('Publico');
    Route::post('/ProductosNegativos','publico\PublicoController@filtarProductosNegativos')->name('filtrar');
    Route::get('/ProductosNegativos','publico\PublicoController@index')->name('ProductosNegativos');
    Route::get('/ProductosNegativos2','publico\PublicoController@listarFiltrados')->name('filtro2');
    Route::get('/Informacion','publico\PublicoController@informacion')->name('informacion');
  

//------------------------EXPORTACIONES----------------------------------//


Route::post('/excel','Admin\exports\ExportsController@exportExcelproductosnegativos')->name('excelProductosNegativos');
Route::post('/Excelcambioprecio','Admin\exports\ExportsController@exportexcelcambioprecios')->name('excelcambioprecios');
});

//rutas de registro
Route::prefix('auth')->middleware('auth','SuperAdmin')->group(function(){
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    
});


//rutas de administrador 
Route::prefix('admin')->namespace('Admin')->middleware('auth','SuperAdmin')->group(function(){


    //----------------------------------LISTADO DE DATOS-----------------//
    Route::get('/','AdminController@index')->name('inicioAdmin');
    Route::get('/ListaUsuarios','EditarUserController@index')->name('ListarUser');
    Route::post('/update', 'EditarUserController@update')->name('update');
    Route::get('/CuadroMando', 'AdminController@CuadroDeMando')->name('cuadroMando');
    Route::get('/ProductosPorMarca','AdminController@ProductosPorMarca')->name('ProductosPorMarca');
    Route::get('/Ordenesdecompra','AdminController@ordenesdecompra')->name('ordenesdecompra');
    Route::get('/Desviacion','AdminController@porcentajeDesviacion')->name('porcentaje');
    Route::get('/comprassegunprov','AdminController@comprassegunprov')->name('comprassegunprov');
    Route::get('/Productos','AdminController@Productos')->name('productos');


    //------------------------------FILTROS Y OTRAS COSAS XD----------------------------------------------//
    Route::post('/Desviacion','AdminController@filtrarDesviacion')->name('filtrarDesv');
    Route::post('/Productospormarca','AdminController@filtarProductospormarca')->name('filtrarpormarca');
    Route::post('/Productos','AdminController@FiltrarProductos')->name('filtrarProductos');



    //---------------------Exportaciones----------------------//
  
    Route::get('/pdf/{NroOrden}','exports\ExportsController@exportpdf')->name('pdf.orden');
    Route::get('/pdfprov/{NroOrden}','exports\ExportsController@exportpdfprov')->name('pdf.ordenprov');
    Route::post('/excelproductospormarca','exports\ExportsController@exportExcelproductospormarca')->name('excelproductopormarca');
    Route::post('/ExcelDesv','exports\ExportsController@exportExcelDesviacion')->name('excelDesviacion');




   




});


