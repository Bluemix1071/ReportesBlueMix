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



Route::post('/getProductos','ProductosEnTransito\ProductosEnTransitoController@Buscar');
Route::post('/GenerarProductosEnTrancito','ProductosEnTransito\ProductosEnTransitoController@GenerarProductoEnTrancito');
Route::get('/GetCaja/{id}','ProductosEnTransito\ProductosEnTransitoController@GetCaja');
Route::put('/UpdateCaja/{id}','ProductosEnTransito\ProductosEnTransitoController@UpdateCaja');

/*
Route::get('ProductosNegativos',function(){
//   return datatables(DB::table('productos_negativos'))->toJson();
//
});*/
