<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductosEnTransito;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors']], function () {

//---------------------------Mercaderia en trancito----------------------------------\\
Route::post('/getProductos','ProductosEnTransito\ProductosEnTransitoController@Buscar');
Route::post('/GenerarProductosEnTrancito','ProductosEnTransito\ProductosEnTransitoController@GenerarProductoEnTrancito');

Route::get('/GetCaja/{id}','ProductosEnTransito\ProductosEnTransitoController@GetCaja');
Route::put('/UpdateCaja/{id}','ProductosEnTransito\ProductosEnTransitoController@UpdateCaja');

Route::get('/ReIngresarMercaderia/{id}','ProductosEnTransito\ProductosEnTransitoController@ReIngresarMercaderia');

Route::get('/GetProductoTransito','ProductosEnTransito\ProductosEnTransitoController@GetProductoTransito');
Route::get('/GetListadoCajas','ProductosEnTransito\ProductosEnTransitoController@GetListadoCajas');


//-------------------------------Session en React ----------------------------------------\\
Route::get('/getSession','ApiController@GetSession');


//---------------------------------Colegios y coupones -------------------------------- */

Route::get('/GetColegios','colegios\ColegiosController@getColegios');
Route::post('/GenerarCupon','Cupones\CuponesController@GenerarCupon');



// Auth users
Route::post('/Login','Api\AuthController@Login');

Route::get('/Permisos/{id}','Api\AuthController@getPermission');

Route::get('/User','Api\AuthController@User');

Route::get('/Test','Api\AuthController@Test');

// validar los productos faltantes de una cotizacion jumpseller

Route::get('/ProductosFaltantes/{id}','Admin\Jumpseller\BluemixEmpresas\GenerarCarritoController@VerProductosFaltantes');

//endpoints productos
Route::get('/getProducto/{codigo}','Api\ProductosController@getProducto')->name('getProducto');

//enpoints conteos sala
Route::get('/getConteosSala','Api\ConteosController@getConteosSala')->name('getConteosSala');
Route::get('/getConteoSala/{id}','Api\ConteosController@getConteoSala')->name('getConteoSala');
Route::get('/getHeadConteoSala/{id}','Api\ConteosController@getHeadConteoSala')->name('getHeadConteoSala');
Route::post('/nuevoConteo','Api\ConteosController@nuevoConteo')->name('nuevoConteo');
//endpoints utility
Route::delete('/deleteItem/{id}','Api\ConteosController@deleteItem')->name('deleteItem');
Route::put('/updateCantItem/{id}','Api\ConteosController@updateCantItem')->name('updateCantItem');
Route::get('/buscarProducto/{codigo}','Api\ConteosController@buscarProducto')->name('buscarProducto');
Route::post('/agregarProducto/{id_conteo}','Api\ConteosController@agregarProducto')->name('agregarProducto');
Route::put('/terminarConteo/{id}','Api\ConteosController@terminarConteo')->name('terminarConteo');
Route::post('/cargarVale/{id_conteo}','Api\ConteosController@cargarVale')->name('cargarVale');
//endpoints conteo bodega
Route::get('/getConteosBodega','Api\ConteosController@getConteosBodega')->name('getConteosBodega');
Route::get('/getConteoBodega/{id}','Api\ConteosController@getConteoBodega')->name('getConteoBodega');
Route::get('/getHeadConteoBodega/{id}','Api\ConteosController@getHeadConteoBodega')->name('getHeadConteoBodega');
Route::post('/nuevoConteoBodega','Api\ConteosController@nuevoConteoBodega')->name('nuevoConteoBodega');
Route::get('/getRacks','Api\ConteosController@getRacks')->name('getRacks');






/*
Route::get('ProductosNegativos',function(){
//   return datatables(DB::table('productos_negativos'))->toJson();
//
});*/

});
