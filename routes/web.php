<?php
//test
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CompraAgilController;

Route::get('detect-device', [FrontController::class, 'detuctDebice'])->name('detect-device');


Route::get('/api/{any}', function () {
    return view('welcome');
})->where('any', '.*');;



Route::get('/','seguridad\LoginController@index')->name('login');
Route::post('/','seguridad\LoginController@login')->name('login_post');
Route::get('/logout','seguridad\LoginController@logout')->name('logout');
//Route::get('/registrar','AdminController@registrar')->name('registrar');
Route::get('/graficos', 'ChartControllers\PulseChartController@index')->name('chart');
Route::post('/graficos', 'ChartControllers\PulseChartController@cargarC3')->name('cargarChart');

//reset passwords

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// consulta precios sin ruta
Route::get('/ConsultaPrecio','publico\PublicoController@ConsultaPrecio')->name('ConsultaPrecio');
Route::post('/ConsultaPrecioFiltro', 'publico\PublicoController@ConsultaPrecioFiltro')->name('ConsultaPrecioFiltro');

//Rutas autenticadas de sala
Route::prefix('Sala')->namespace('sala')->middleware('auth')->group(function(){
    Route::get('/Cambiodeprecios','SalaController@index')->name('cambiodeprecios');
    Route::post('/Cambiodeprecios','SalaController@filtrarcambioprecios')->name('filtrarcambioprecios');
    Route::get('/GiftCard','SalaController@indexGiftCard')->name('GiftCardVenta');
    Route::get('/GiftCardVoucher','SalaController@generarVoucher')->name('GiftCardVoucherIndex');
    Route::post('/GiftCardVoucher','SalaController@generarVoucher')->name('GiftCardVoucher');

    Route::get('/GiftCardCaja','SalaController@CargaTarjetasCaja')->name('CargaTarjetasCaja');
    Route::post('/GiftCardCaja','SalaController@CargarTarjetasCodigos')->name('postCargarCaja');
    Route::post('/VentasGiftcards','SalaController@VenderGiftcardSala')->name('venderGiftCardSala');

    Route::get('/OrdenesDeDiseño','SalaController@OrdenesDeDiseño')->name('OrdenesDeDiseño');
    Route::post('/GuardarOrdenesDeDiseño','SalaController@GuardarOrdenesDeDiseño')->name('GuardarOrdenesDeDiseño');

    Route::get('/ListarOrdenesDiseño','SalaController@ListarOrdenesDiseño')->name('ListarOrdenesDiseñoSala');
    Route::get('/ListarOrdenesDisenoDetalle/{idOrdenesDiseno}','SalaController@ListarOrdenesDisenoDetalle')->name('ListarOrdenesDisenoDetalleSala');

    Route::post('/GuardarConfigDiseno','SalaController@GuardarConfigDiseno')->name('GuardarConfigDiseno');

    /*  Mantenedor CRUD requerimientos de compra */
    Route::get('/RequerimientoCompra','SalaController@RequerimientoCompra')->name('RequerimientoCompra');
    Route::post('/AgregarRequerimientoCompra','SalaController@AgregarRequerimientoCompra')->name('AgregarRequerimientoCompra');
    Route::post('/DesactivarRequerimiento','SalaController@DesactivarRequerimiento')->name('DesactivarRequerimiento');
    Route::post('/EditarEstadoRequerimientoCompra','SalaController@EditarEstadoRequerimientoCompra')->name('EditarEstadoRequerimientoCompra');
    Route::put('/EditarRequerimientoCompra','SalaController@EditarRequerimientoCompra')->name('EditarRequerimientoCompra');
    Route::put('/EditarRequerimientoCompraMultiple','SalaController@EditarRequerimientoCompraMultiple')->name('EditarRequerimientoCompraMultiple');
    Route::put('/EditarRequerimientoCompraMultiplePrioridad','SalaController@EditarRequerimientoCompraMultiplePrioridad')->name('EditarRequerimientoCompraMultiplePrioridad');
    Route::get('/ResumenProducto/{codigo}','SalaController@ResumenProducto')->name('ResumenProducto');
    Route::get('/DetalleVale/{n_vale}','SalaController@DetalleVale')->name('DetalleVale');
    Route::post('/AgregarValeRequerimiento','SalaController@AgregarValeRequerimiento')->name('AgregarValeRequerimiento');
    Route::post('/BuscarRequerimientoFecha','SalaController@BuscarRequerimientoFecha')->name('BuscarRequerimientoFecha');
    Route::post('/BuscarProductosRequerimiento','SalaController@BuscarProductosRequerimiento')->name('BuscarProductosRequerimiento');

    /* fin */

    //cambio
    /*  Mantenedor CRUD Conteo Inventario Sala */
    Route::get('/ConteoInventarioSala', 'SalaController@ConteoInventarioSala')->name('ConteoInventarioSala');
    Route::post('/ConteoInventarioSala', 'SalaController@NuevoConteo')->name('NuevoConteoInventarioSala');
    Route::post('/ConteoInventarioDetalleSala', 'SalaController@ConteoDetalle')->name('ConteoInventarioDetalleSala');
    Route::post('/GuardarConteoInventarioDetalleSala', 'SalaController@GuardarConteoDetalle')->name('GuardarConteoDetalleSala');
    //Cargar descripcion segun codigo
    Route::get('/BuscarProducto/{codigo}','SalaController@BuscarProducto')->name('BuscarProducto');
    Route::get('/BuscarProducto_en_solicitud/{codigo}','SalaController@BuscarProducto_en_solicitud')->name('BuscarProducto_en_solicitud');
    Route::get('/BuscarProducto_en_pendiente/{codigo}', 'SalaController@BuscarProducto_en_pendiente')->name('BuscarProducto_en_pendiente');
    Route::get('/facturapendiente/{nfactura}', 'SalaController@facturapendiente')->name('facturapendiente');;
    Route::get('/Stockvalemas/{valemas}', 'SalaController@Stockvalemas')->name('Stockvalemas');
    Route::get('/Stockvalemenos/{valemenos}', 'SalaController@Stockvalemenos')->name('Stockvalemenos');
    // routes/web.php

    //
    Route::get('/ConsolidacionInventarioBodega', 'SalaController@ConsolidacionInventarioBodega')->name('ConsolidacionInventarioSala');
    Route::post('/CargarValeConteoSala', 'SalaController@CargarValeConteoSala')->name('CargarValeConteoSala');
    Route::post('/TerminarConteoSala', 'SalaController@TerminarConteoSala')->name('TerminarConteoSala');

    /* Modulo Creacion de precios oferta */
    Route::get('/Precios', 'SalaController@Precios')->name('Precios');
    Route::get('/PreciosL', 'SalaController@PreciosL')->name('PreciosL');

});


//rutas globales autenticadas
Route::prefix('api')->middleware('auth')->group(function(){

    Route::get('/', 'ApiController@LoadReact')->name('apiReact');
});

Route::prefix('Despacho')->namespace('Despacho')->middleware('auth')->group(function(){
    Route::get('/ProductosSegunGuia','DespachoController@ProductosSegunGuia')->name('ProductosSegunGuia');
    Route::post('/GuardarProductosSegunGuia','DespachoController@GuardarProductosSegunGuia')->name('GuardarProductosSegunGuia');
});

Route::prefix('Sucursal')->namespace('Sucursal')->middleware('auth')->group(function(){
    Route::get('/ProductosSucursal','SucursalController@ProductosSucursal')->name('ProductosSucursal');
    Route::post('/GuardarCantidadSucursal','SucursalController@GuardarCantidadSucursal')->name('GuardarCantidadSucursal');
    Route::get('/EgresosPorVentas','SucursalController@EgresosPorVentas')->name('EgresosPorVentas');
    Route::post('/EgresosPorVentasDetalle','SucursalController@EgresosPorVentasDetalle')->name('EgresosPorVentasDetalle');
    Route::post('/CargarEgresosPorVentas','SucursalController@CargarEgresosPorVentas')->name('CargarEgresosPorVentas');
    Route::get('/IngresoMercaderia','SucursalController@IngresoMercaderia')->name('IngresoMercaderiaSucursal');
    Route::post('/BuscarValeSucursal','SucursalController@BuscarValeSucursal')->name('BuscarValeSucursal');
    Route::post('/CargarValeSucursal','SucursalController@CargarValeSucursal')->name('CargarValeSucursal');
    Route::post('/Convertirsolicitud','SucursalController@Convertirsolicitud')->name('Convertirsolicitud');
    Route::get('/listar-vales', 'SucursalController@listarRegistroVales')->name('listar.vales');
    Route::get('/EgresosPorVales','SucursalController@EgresosPorVales')->name('EgresosPorVales');
    Route::post('/BuscarValeSucursalEgreso','SucursalController@BuscarValeSucursalEgreso')->name('BuscarValeSucursalEgreso');
    Route::post('/CargarValeSucursalEgreso','SucursalController@CargarValeSucursalEgreso')->name('CargarValeSucursalEgreso');
});


Route::prefix('publicos')->middleware('auth')->group(function(){

    Route::get('/','InicioController@index')->name('Publico');
    Route::get('/ProductosFaltantesWebAPI','InicioController@ProductosFaltantesWebAPI')->name('ProductosFaltantesWebAPI');
    Route::get('/ProductosFaltantesAPI','InicioController@ProductosFaltantesAPI')->name('ProductosFaltantesAPI');
    Route::post('/mensaje','InicioController@store')->name('mensaje');
    Route::post('/ProductosNegativos','publico\PublicoController@filtarProductosNegativos')->name('filtrar');
    Route::get('/ProductosNegativos','publico\PublicoController@filtarProductosNegativos')->name('ProductosNegativos');
    Route::get('/ProductosNegativos2','publico\PublicoController@listarFiltrados')->name('filtro2');

    Route::get('/consultaPs','inicioController@consultaPs')->name('consultaPs');

    Route::get('/Informacion','publico\PublicoController@informacion')->name('informacion');
    Route::post('/updatemensaje', 'publico\PublicoController@updatemensaje')->name('updatemensaje');
    Route::get('/ConsultaSaldoenvio','publico\PublicoController@ConsultaSaldo')->name('ConsultaSaldo');
    Route::post('/ConsultaSaldoenvio', 'publico\PublicoController@ConsultaSaldoenvio')->name('ConsultaSaldoenvio');

    Route::get('/Estacionamiento','publico\PublicoController@Estacionamiento')->name('Estacionamiento');
    Route::post('/EstacionamientoFiltro','publico\PublicoController@EstacionamientoFiltro')->name('EstacionamientoFiltro');
    Route::post('/GenerarTicket','publico\PublicoController@GenerarTicket')->name('GenerarTicket');
    Route::post('/GenerarTicketSalida','publico\PublicoController@GenerarTicketSalida')->name('GenerarTicketSalida');
    Route::get('/ReimprimirTicketEntrada','publico\PublicoController@ReimprimirTicketEntrada')->name('ReimprimirTicketEntrada');
    Route::get('/ReimprimirTicketSalida','publico\PublicoController@ReimprimirTicketSalida')->name('ReimprimirTicketSalida');
    Route::post('/VerificarPatente', 'publico\PublicoController@VerificarPatente')->name('VerificarPatente');


    // Route::get('/ConsultaPrecio','publico\PublicoController@ConsultaPrecio')->name('ConsultaPrecio');
    // Route::post('/ConsultaPrecioFiltro', 'publico\PublicoController@ConsultaPrecioFiltro')->name('ConsultaPrecioFiltro');
//------------------------EXPORTACIONES------------------------------------//


Route::post('/excel','Admin\exports\ExportsController@exportExcelproductosnegativos')->name('excelProductosNegativos');
Route::post('/Excelcambioprecio','Admin\exports\ExportsController@exportexcelcambioprecios')->name('excelcambioprecios');
});

//rutas de registro
Route::prefix('auth')->middleware('auth','SuperAdmin')->group(function(){
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

});

Route::prefix('Informatica')->middleware('auth', 'SuperAdmin')->group(function(){

    //Informatica
    Route::get('/FirmaFacturas','Informatica\FirmaDocumentosController@FirmaFacturas')->name('FirmaFacturas');
    Route::get('/FirmaFacturasFiltro','Informatica\FirmaDocumentosController@FirmaFacturasFiltro')->name('FirmarFacturasFiltro');
    Route::get('/Receptores','Informatica\FirmaDocumentosController@Receptores')->name('Receptores');
    Route::get('/ReceptoresFiltro','Informatica\FirmaDocumentosController@ReceptoresFiltro')->name('ReceptoresFiltro');
    Route::get('/FirmaNC','Informatica\FirmaDocumentosController@FirmaNC')->name('FirmaNC');
    Route::get('/FirmaNCFiltro','Informatica\FirmaDocumentosController@FirmaNCFiltro')->name('FirmaNCFiltro');
    Route::get('/FirmaBoletas','Informatica\FirmaDocumentosController@FirmaBoletas')->name('FirmaBoletas');
    Route::get('/FirmaBoletasFiltro','Informatica\FirmaDocumentosController@FirmaBoletasFiltro')->name('FirmaBoletasFiltro');
    Route::get('/FirmaGuias','Informatica\FirmaDocumentosController@FirmaGuias')->name('FirmaGuias');
    Route::get('/FirmaGuiasFiltro','Informatica\FirmaDocumentosController@FirmaGuiasFiltro')->name('FirmaGuiasFiltro');

    Route::post('/FirmaFacturas','Informatica\FirmaDocumentosController@FirmarFacturasDia')->name('FirmarFacturasDia');
    Route::post('/FirmaFactura','Informatica\FirmaDocumentosController@FirmarFactura')->name('FirmarFactura');
    Route::get('/CreateFacturaJson','Informatica\FirmaDocumentosController@CreateFacturaJson')->name('CreateFacturaJson');

});



Route::prefix('admin')->namespace('Admin')->group(function(){

});
//rutas de administrador
Route::prefix('admin')->namespace('Admin')->middleware('auth','SuperAdmin')->group(function(){


    //----------------------------------LISTADO DE DATOS------------------//
    Route::get('/','AdminController@index')->name('inicioAdmin');
    Route::get('/ListaUsuarios','EditarUserController@index')->name('ListarUser');
    Route::post('/update', 'EditarUserController@update')->name('update');
    /*  Mantenedor CRUD Usuarios de COMBO */
    Route::get('/ListaUsuariosCOMBO','EditarUserCOMBOController@index')->name('ListarUserCombo');
    Route::post('/ListaUsuariosCOMBO','EditarUserCOMBOController@create')->name('AgregarUserCombo');
    Route::put('/ListaUsuariosCOMBO','EditarUserCOMBOController@update')->name('EditarUserCombo');
    // fin
    /*  Mantenedor CRUD Compra Agil */
    Route::get('/CompraAgil','CompraAgilController@index')->name('CompraAgil');
    Route::post('/CompraAgil','CompraAgilController@create')->name('AgregarCompraAgil');
    Route::delete('/CompraAgil/{id}','CompraAgilController@destroy')->name('BorrarCompraAgil');
    Route::put('/CompraAgil','CompraAgilController@update')->name('EditarCompraAgil');
    Route::post('/FiltroCompraAgil','CompraAgilController@fechaFiltro')->name('FiltarCompraAgil');
    Route::post('/XmlTest','CompraAgilController@xmlTest')->name('XmlTest');
    // fin
    /*  Mantenedor CRUD Cotizaciones */
    Route::get('/Cotizaciones/{id}','CotizacionesController@index')->name('Cotizaciones');
    // fin
    /*  Mantenedor CRUD Compras a proveedores */
    Route::get('/ComprasProveedores','Compras\ComprasProveedoresController@index')->name('ComprasProveedores');
    Route::post('/XmlUp','Compras\ComprasProveedoresController@xmlUp')->name('XmlUp');
    Route::post('/DescargaXml', 'Compras\ComprasProveedoresController@descargaXml')->name('DescargaXml');
    Route::post('/ComprasProveedores','Compras\ComprasProveedoresController@insert')->name('AgregarCompras');
    Route::get('/ListarComprasProveedores','Compras\ComprasProveedoresController@list')->name('ListarCompras');
    Route::get('/ListarComprasProveedoresFecha','Compras\ComprasProveedoresController@listFecha')->name('ListarComprasFecha');
    Route::post('/EditarCompraProveedoresNew','Compras\ComprasProveedoresController@editar')->name('EditarCompraNew');
    Route::put('/EditarCompraProveedores','Compras\ComprasProveedoresController@update')->name('UpdateCompra');
    Route::post('/DINCompraProveedores','Compras\ComprasProveedoresController@insertDIN')->name('AgregarDIN');

    /*  Mantenedor CRUD Ingreso */
    Route::get('/Ingresos', 'Bodega\IngresosController@index')->name('ListarIngresos');
    Route::post('/IngresoDetalle', 'Bodega\IngresosController@detalle')->name('IngresoDetalle');
    Route::post('/EditarDetalle', 'Bodega\IngresosController@editardetalle')->name('EditarDetalle');

    /*  Mantenedor CRUD Conteo Inventario Bodega */
    Route::get('/ConteoInventarioBodega', 'Bodega\ConteoInventarioBodegaController@index')->name('ConteoInventarioBodega');
    Route::post('/ConteoInventarioBodega', 'Bodega\ConteoInventarioBodegaController@NuevoConteo')->name('NuevoConteoInventarioBodega');
    Route::post('/ConteoInventarioDetalleBodega', 'Bodega\ConteoInventarioBodegaController@ConteoDetalle')->name('ConteoInventarioDetalleBodega');
    Route::post('/GuardarConteoInventarioDetalleBodega', 'Bodega\ConteoInventarioBodegaController@GuardarConteoDetalle')->name('GuardarConteoDetalleBodega');
    Route::get('/BuscarProducto/{codigo}','Bodega\ConteoInventarioBodegaController@BuscarProducto')->name('BuscarProducto');
    Route::get('/ConsolidacionInventarioBodega', 'Bodega\ConteoInventarioBodegaController@ConsolidacionInventarioBodega')->name('ConsolidacionInventarioBodega');
    Route::post('/ActualizarInventarioSala', 'Bodega\ConteoInventarioBodegaController@ActualizarInventarioSala')->name('ActualizarInventarioSala');
    Route::post('/CargarValeConteoBodega', 'Bodega\ConteoInventarioBodegaController@CargarValeConteoBodega')->name('CargarValeConteoBodega');
    Route::post('/TerminarConteoBodega', 'Bodega\ConteoInventarioBodegaController@TerminarConteoBodega')->name('TerminarConteoBodega');

    /* Modulo Productos pendientes*/
    Route::get('/ListarProductosPendientes', 'Bodega\ProductosPendientesController@ListarProductosPendientes')->name('ListarProductosPendientes');
    Route::post('/AgregarItemp','Bodega\ProductosPendientesController@AgregarItemp')->name('AgregarItemp');
    Route::post('/AgregarItempf','Bodega\ProductosPendientesController@AgregarItempf')->name('AgregarItempf');
    Route::put('/EditarProd','Bodega\ProductosPendientesController@EditarProd')->name('EditarProd');
    Route::post('/Eliminaritemp','Bodega\ProductosPendientesController@Eliminaritemp')->name('Eliminaritemp');
    Route::put('/AgregarObservacion','Bodega\ProductosPendientesController@AgregarObservacion')->name('AgregarObservacion');
    Route::put('/cambiaritem','Bodega\ProductosPendientesController@cambiaritem')->name('cambiaritem');
    Route::get('/detalleitem/{codigo}', 'Bodega\ProductosPendientesController@detalleitem')->name("detalleitem");
    Route::post('/EnviarProductosMultiple','Bodega\ProductosPendientesController@EnviarProductosMultiple')->name('EnviarProductosMultiple');


    /*  Mantenedor Clientes Credito */
    Route::get('/MantencionClientesCredito', 'MantencionClientesCreditoController@index')->name('MantencionClientesCredito');
    Route::post('/MantencionClientesCreditoDetalle', 'MantencionClientesCreditoController@DetalleCliente')->name('MantencionClientesCreditoDetalle');
    Route::get('/buscacliente', 'MantencionClientesCreditoController@buscacliente')->name('buscacliente');

    Route::post('/buscacliente', 'MantencionClientesCreditoController@buscacliente')->name('buscacliente');

    Route::get('/ConsultaDocumentos','Compras\ConsultaDocumentosController@index')->name('ConsultaDocumentos');
    Route::post('/ConsultaDocumentosFiltro','Compras\ConsultaDocumentosController@ConsultaDocumentosFiltro')->name('ConsultaDocumentosFiltro');

    Route::get('/LibroDeComprasDiario','Compras\ConsultaDocumentosController@LibroDeComprasDiarioindex')->name('LibroDeComprasDiario');
    Route::post('/LibroDeComprasDiarioFiltro','Compras\ConsultaDocumentosController@LibroDeComprasDiarioFiltro')->name('LibroDeComprasDiarioFiltro');

    Route::get('/EstadoFacturas','Compras\ConsultaDocumentosController@EstadoFacturas')->name('EstadoFacturas');
    Route::post('/EstadoFacturasFiltro','Compras\ConsultaDocumentosController@EstadoFacturasFiltro')->name('EstadoFacturasFiltro');
    Route::post('/EstadoFacturasAbono','Compras\ConsultaDocumentosController@EstadoFacturasAbono')->name('EstadoFacturasAbono');
    Route::post('/EstadoFacturasAbonoMasivo', 'Compras\ConsultaDocumentosController@AbonoMasivo')->name('AbonoMasivo');

    Route::get('/VerificacionDocumentos','Compras\ConsultaDocumentosController@VerificacionDocumentos')->name('VerificacionDocumentos');
    Route::post('/VerificacionDocumentosAutorizar','Compras\ConsultaDocumentosController@VerificacionDocumentosAutorizar')->name('VerificacionDocumentosAutorizar');
    Route::post('/VerificacionDocumentosAutorizarTodo','Compras\ConsultaDocumentosController@VerificacionDocumentosAutorizarTodo')->name('VerificacionDocumentosAutorizarTodo');

    // fin
    //Productos Perecibles
    Route::get('/ProductosExpiracion', 'Productos\ProductosPereciblesController@ProductosExpiracion')->name('ProductosExpiracion');
    Route::post('/guardarproductoperecible', 'Productos\ProductosPereciblesController@guardarproductoperecible')->name('guardarproductoperecible');
    Route::put('/editarproductoperecible', 'Productos\ProductosPereciblesController@editarproductoperecible')->name('editarproductoperecible');
    Route::delete('/borrarproductoperecible', 'Productos\ProductosPereciblesController@borrarproductoperecible')->name('borrarproductoperecible');
    Route::get('/BuscarRacks/{codigo}','Productos\ProductosPereciblesController@BuscarRacks')->name('BuscarRacks');
    Route::get('/EditarRack/{id}','Productos\ProductosPereciblesController@EditarRack')->name('EditarRack');
    //Fin
    // Mercaderia Bodega
    Route::get('/Mercaderialistadabodega', 'Mercaderiabodega\MercaderiabodegaController@Mercaderialistadabodega')->name('Mercaderialistadabodega');

    /*  Mantenedor CRUD Notas Credito Proveedores */
    Route::get('/NotasCreditoProveedores','Compras\NotasCreditoProveedoresController@index')->name('NotasCreditoProveedores');
    Route::post('/NotasCreditoProveedores','Compras\NotasCreditoProveedoresController@insert')->name('AgregarNC');
    Route::post('/XmlUpNC','Compras\NotasCreditoProveedoresController@xmlUpNC')->name('XmlUpNC');
    Route::delete('/NotasCreditoProveedores/{id}','Compras\NotasCreditoProveedoresController@destroy')->name('BorrarNC');
    // fin
    Route::get('/CuadroMando', 'AdminController@CuadroDeMando')->name('cuadroMando');
    Route::get('/ProductosPorMarca','AdminController@ProductosPorMarca')->name('ProductosPorMarca');
    Route::post('/ProductosPorMarca/fetch','AdminController@fetch')->name('ProductosPorMarca.fetch');
    Route::post('/ProductosPorMarcafiltrar','AdminController@ProductosPorMarcafiltrar')->name('ProductosPorMarcafiltrar');
    Route::get('/Ordenesdecompra','AdminController@ordenesdecompra')->name('ordenesdecompra');
    Route::get('/Desviacion','AdminController@porcentajeDesviacion')->name('porcentaje');
    Route::get('/comprassegunprov','AdminController@comprassegunprov')->name('comprassegunprov');
    Route::get('/Productos','AdminController@Productos')->name('productos');
    Route::get('VentasProdutos','AdminController@IndexVentaProductos')->name('ventaProd');
    Route::get('/VentasPorHora','AdminController@DocumentosPorHoraIndex')->name('ComprasPorHoraIndex');
    Route::get('compraProdutos','AdminController@IndexCompraProductos')->name('compraProd');
    Route::get('/ComprasPorHora','AdminController@DocumentosPorHoraIndex')->name('ComprasPorHoraIndex');
    Route::get('/Proyeccion','AdminController@ProyeccionIndex')->name('proyeccion');
    Route::get('/areaproveedor','AdminController@areaproveedor')->name('areaproveedor');
    Route::get('/areaproveedorfamilia','AdminController@areaproveedorfamilia')->name('areaproveedorfamilia');

    Route::get('/consultafacturaboleta','AdminController@consultafacturaboleta')->name('consultafacturaboleta');
    Route::get('/ArqueoC','AdminController@ArqueoC')->name('ArqueoC');

    Route::post('/filtrarconsultafacturaboleta','AdminController@filtrarconsultafacturaboleta')->name('filtrarconsultafacturaboleta');
    Route::post('/filtrarArqueoC','AdminController@filtrarArqueoC')->name('filtrarArqueoC');/**>AQUI ARQUEO */

    Route::get('/CostoHistoricoPorProducto','CostoHistoricoPorProductoController@index')->name('CostoHistoricoPorProducto');

    Route::get('controlipmac','AdminController@controlipmac')->name('controlipmac');
    Route::post('/actualizaripmac', 'AdminController@actualizaripmac')->name('actualizaripmac');
    Route::get('agregaripmac','AdminController@agregaripmac')->name('agregaripmac');
    Route::post('/agregaripmac','AdminController@insertaripmac')->name('agregaripmac');
    Route::get('cuponesescolares','AdminController@cuponesescolares')->name('cuponesescolares');
    Route::post('/actualizarcupon', 'AdminController@actualizarcupon')->name('actualizarcupon');
    Route::get('/costos','AdminController@costos')->name('costos');
    Route::post('/costosfiltro','AdminController@costosfiltro')->name('costosfiltro');
    Route::get('/costosdetalle','AdminController@costosdetalle')->name('costosdetalle');
    Route::post('/costosdetallefiltro','AdminController@costosdetallefiltro')->name('costosdetallefiltro');
    Route::get('/stocktiemporeal','AdminController@stocktiemporeal')->name('stocktiemporeal');
    Route::get('/ListarOrdenesDiseño','AdminController@ListarOrdenesDiseño')->name('ListarOrdenesDiseño');
    Route::get('/ListarOrdenesDisenoDetalle/{idOrdenesDiseno}','AdminController@ListarOrdenesDisenoDetalle')->name('ListarOrdenesDisenoDetalle');
    Route::post('/ListarOrdenesDisenoDetalleedit', 'AdminController@ListarOrdenesDisenoDetalleedit')->name('ListarOrdenesDisenoDetalleedit');
    Route::post('/ListarOrdenesDisenoDetalleedittermino', 'AdminController@ListarOrdenesDisenoDetalleedittermino')->name('ListarOrdenesDisenoDetalleedittermino');
    Route::get('/descargaordendiseno/{id}', 'AdminController@descargaordendiseno')->name('descargaordendiseno');
    Route::post('/desactivarordendiseno', 'AdminController@desactivarordendiseno')->name('desactivarordendiseno');

    Route::get('/MantencionClientes','AdminController@MantencionClientes')->name('MantencionClientes');
    Route::post('/MantencionClientesFiltro','AdminController@MantencionClientesFiltro')->name('MantencionClientesFiltro');
    Route::put('/MantencionClientesUpdate','AdminController@MantencionClientesUpdate')->name('MantencionClientesUpdate');
    Route::put('/AbonarDetalleCliente', 'MantencionClientesCreditoController@AbonarDetalleCliente')->name('AbonarDetalleCliente');
    Route::get('/MantencionClientesCredito', 'MantencionClientesCreditoController@index')->name('MantencionClientesCredito');
    Route::post('/MantencionClientesCreditoDetalle', 'MantencionClientesCreditoController@DetalleCliente')->name('MantencionClientesCreditoDetalle');
    Route::get('/buscacliente', 'MantencionClientesCreditoController@buscacliente')->name('buscacliente');
    Route::post('/guardar-registro', [MantencionClientesCreditoController::class, 'GuardarRegistro'])->name('guardar.registro');

    Route::get('/ventasCategoria','AdminController@ventasCategoria')->name('ventasCategoria');
    Route::post('/ventasCategoriaFiltro','AdminController@ventasCategoriaFiltro')->name('ventasCategoriaFiltro');

    Route::get('/ListadoProductosContrato','AdminController@ListadoProductosContrato')->name('ListadoProductosContrato');
    Route::post('/ListadoProductosContratoFiltro','AdminController@ListadoProductosContratoFiltro')->name('ListadoProductosContratoFiltro');

    Route::get('/MantenedorContrato','AdminController@MantenedorContrato')->name('MantenedorContrato');
    Route::post('/MantenedorContratoFiltro','AdminController@MantenedorContratoFiltro')->name('MantenedorContratoFiltro');
    Route::post('/updateproductocontrato','AdminController@updateproductocontrato')->name('updateproductocontrato');
    Route::post('/deleteproductocontrato','AdminController@deleteproductocontrato')->name('deleteproductocontrato');
    Route::post('/MantenedorContratoAgregarProducto','AdminController@MantenedorContratoAgregarProducto')->name('MantenedorContratoAgregarProducto');
    Route::get('/MantenedorContratoAgregar','AdminController@MantenedorContratoAgregar')->name('MantenedorContratoAgregar');
    Route::post('/MantenedorContratoAgregarContrato','AdminController@MantenedorContratoAgregarContrato')->name('MantenedorContratoAgregarContrato');
    Route::get('/ListadoContratos','AdminController@ListadoContratos')->name('ListadoContratos');
    Route::put('/EditarPrecio','AdminController@EditarPrecio')->name('EditarPrecio');
    Route::post('/UpdateContrato','AdminController@UpdateContrato')->name('UpdateContrato');
    Route::get('/EstadisticaContrato','Contratos\EstadisticaContratoController@EstadisticaContrato')->name('EstadisticaContrato');
    Route::post('/EstadisticaContrato','Contratos\EstadisticaContratoController@EstadisticaContratoDetalle')->name('EstadisticaContratoDetalle');
    Route::get('/VentaProdXContrato/{codigo},{fecha_in},{fecha_ter}','Contratos\EstadisticaContratoController@VentaProdXContrato')->name('VentaProdXContrato');
    Route::post('/EstadisticaEntidad','Contratos\EstadisticaContratoController@EstadisticaEntidadDetalle')->name('EstadisticaEntidadDetalle');
    Route::post('/EstadisticaEntidadFecha','Contratos\EstadisticaContratoController@EstadisticaEntidadDetalleFecha')->name('EstadisticaEntidadDetalleFecha');
    Route::post('/EstadisticaContratoFecha','Contratos\EstadisticaContratoController@EstadisticaContratoFecha')->name('EstadisticaContratoFecha');
    Route::get('/ResumenProducto/{codigo_producto}','AdminController@ResumenProducto')->name('ResumenProducto');
    Route::get('/SincronizacionProductos','Contratos\EstadisticaContratoController@SincronizacionProductos')->name('SincronizacionProductos');
    Route::post('/SincronizacionProductosExcel','Contratos\EstadisticaContratoController@SincronizacionProductosExcel')->name('SincronizacionProductosExcel');
    Route::get('/descargaPlantillaSincProductos', 'exports\MyController@descargaPlantillaSincProductos')->name('descargaPlantillaSincProductos');
    Route::get('/StockCategorias', 'Contratos\StockCategoriasController@StockCategorias')->name('StockCategorias');
    Route::get('/DetalleCategoria/{id}', 'Contratos\StockCategoriasController@DetalleCategoria')->name('DetalleCategoria');

    Route::get('/MercadoPublico','Contratos\MercadoPublicoController@MercadoPublico')->name('MercadoPublico');
    Route::post('/MercadoPublicoDia','Contratos\MercadoPublicoController@MercadoPublicoDia')->name('MercadoPublicoDia');
    Route::get('/Adjuntos/{oc}','Contratos\MercadoPublicoController@Adjuntos')->name('Adjuntos');

    Route::get('/MantenedorProducto','AdminController@MantenedorProducto')->name('MantenedorProducto');
    Route::post('/MantenedorProductoFiltro','AdminController@MantenedorProductoFiltro')->name('MantenedorProductoFiltro');

    Route::get('/ProductosFaltantes','AdminController@ProductosFaltantes')->name('ProductosFaltantes');
    Route::get('/ProductosFaltantesWeb','AdminController@ProductosFaltantesWeb')->name('ProductosFaltantesWeb');/*AQUI!!*/
    //crud de ventas por colegio
    Route::get('/VentasPorColegio','VentasPorColegioController@VentasPorColegio')->name('VentasPorColegio');
    Route::post('/VentasPorColegioDetalle','VentasPorColegioController@VentasPorColegioDetalle')->name('VentasPorColegioDetalle');

    //modulo rutas
    Route::get('/Rutas','Contratos\RutasController@Rutas')->name('Rutas');
    Route::post('/Rutas','Contratos\RutasController@AgregarRutas')->name('AgregarRutas');
    Route::post('/RutaDetalle','Contratos\RutasController@RutaDetalle')->name('RutaDetalle');
    //Ruta para mostrar los productos no subidos en "Index"

    Route::get('/BuscarDoc','buscardocController@BuscarDoc')->name('BuscarDoc');
    Route::get('/buscardocumento','buscardocController@buscardocumento')->name('buscardocumento');
    Route::get('/Docencontrados','buscardocController@Docencontrados')->name('Docencontrados');
    // Editar Folio Boleta Tarjeta Credito
    Route::get('/verboleta','EditarBoletaController@verboleta')->name('verboleta');
    Route::put('/editardetalleboleta','EditarBoletaController@editardetalleboleta')->name('editardetalleboleta');
    Route::get('/UltimaBoleta/{caja}','EditarBoletaController@UltimaBoleta')->name('UltimaBoleta');


    /* Cotizaciones */
    Route::get('/ListaEscolar','ListaEscolarController@ListaEscolar')->name('ListaEscolar');
    Route::post('/ListaEscolar','ListaEscolarController@ListaEscolar')->name('ListaEscolar');
    Route::get('/colegios-temporada-2022', 'ListaEscolarController@colegiosTemporada2022')->name('colegios.temporada2022');
    Route::get('/colegios-temporada-2023', 'ListaEscolarController@colegiosTemporada2023')->name('colegios.temporada2023');


    Route::get('/ListarConvenio','ConvenioMarcoController@ListarConvenio')->name('ListarConvenio');
    Route::get('/ListarCompraAgil','CompraAgilController@ListarCompraAgil')->name('ListarCompraAgil');
    Route::post('/AgregarProducto','ConvenioMarcoController@AgregarProducto')->name('AgregarProducto');

    Route::post('/Cursos','ListaEscolarController@Cursos')->name('Cursos');
    Route::get('/Cursos','ListaEscolarController@Cursos')->name('Cursos');
    Route::post('/AgregarCurso','ListaEscolarController@AgregarCurso')->name('AgregarCurso');
    Route::post('/AgregarColegio','ListaEscolarController@AgregarColegio')->name('AgregarColegio');

    Route::post('/EliminarCurso','ListaEscolarController@eliminar')->name('EliminarCurso');
    Route::put('/EliminarColegio','ListaEscolarController@EliminarColegio')->name('EliminarColegio');

    Route::get('/CotizacionProveedores','Cotizaciones\CotizacionProveedorController@ListarCotizacionProveedores')->name('ListarCotizacionProveedores');
    Route::post('/CotizacionProveedores','Cotizaciones\CotizacionProveedorController@PasarACotizacionProveedores')->name('PasarACotizacionProveedores');
    Route::post('/CargarCatalogoProveedor','Cotizaciones\CotizacionProveedorController@CargarCatalogoProveedor')->name('CargarCatalogoProveedor');
    Route::post('/importCotizProveedor', 'exports\MyController@importCotizProveedores')->name('importCotizProveedores');
    Route::get('/descargaPlantillaCotizProveedores', 'exports\MyController@descargaPlantillaCotizProveedores')->name('descargaPlantillaCotizProveedores');
    Route::get('/ProvMarcaCat','Cotizaciones\CotizacionProveedorController@ProvMarcaCat')->name('ProvMarcaCat');
    Route::put('/EditarMultipleCatalogoProveedor','Cotizaciones\CotizacionProveedorController@EditarMultipleCatalogoProveedor')->name('EditarMultipleCatalogoProveedor');
    Route::put('/EditarMultipleCotizadoProveedor','Cotizaciones\CotizacionProveedorController@EditarMultipleCotizadoProveedor')->name('EditarMultipleCotizadoProveedor');
    Route::post('/EliminarMultipleCatalogoProveedor','Cotizaciones\CotizacionProveedorController@EliminarMultipleCatalogoProveedor')->name('EliminarMultipleCatalogoProveedor');
    Route::post('/SinStockMultipleCatalogoProveedor','Cotizaciones\CotizacionProveedorController@SinStockMultipleCatalogoProveedor')->name('SinStockMultipleCatalogoProveedor');
    Route::post('/DescontinuadoMultipleCatalogoProveedor','Cotizaciones\CotizacionProveedorController@DescontinuadoMultipleCatalogoProveedor')->name('DescontinuadoMultipleCatalogoProveedor');

    Route::post('/Eliminaritem','ListaEscolarController@eliminaritem')->name('EliminarItem');

    Route::post('/AgregarItem','ListaEscolarController@AgregarItem')->name('AgregarItem');
    //Route::delete('/EliminarItem/{id}','ListaEscolarController@eliminaritem')->name('EliminarItem');
    Route::get('/Listas','ListaEscolarController@Listas')->name('listas');
    Route::post('/Listas','ListaEscolarController@Listas')->name('listas');
    Route::get('/Reportes','ListaEscolarController@Reportes')->name('reportes');
    Route::get('/Reportes2022','ListaEscolarController@Reportes2022')->name('reportes2022');
    Route::get('/Reportes2023','ListaEscolarController@Reportes2023')->name('reportes2023');

    Route::put('/EditarProducto','ConvenioMarcoController@EditarProducto')->name('EditarProducto');
    Route::put('/editarcantidadp','ListaEscolarController@editarcantidadp')->name('editarcantidadp');

    Route::post('/CargarCotizacion', 'ListaEscolarController@CargarCotizacion')->name('CargarCotizacion');
    Route::post('/CargarCotizacion', 'ConvenioMarcoController@CargarCotizacion')->name('CargarCotizacion');
    Route::post('/EliminarProd','ConvenioMarcoController@eliminarprod')->name('EliminarProd');

    //Route::get('/colegios','ListaEscolarController@colegios')->name('colegios');
    //Route::post('/AgregarComentario','ListaEscolarController@AgregarComentario')->name('AgregarComentario');
    Route::get('/AgregarComentario','ListaEscolarController@AgregarComentario')->name('AgregarComentario');
    Route::put('/AgregarComentario','ListaEscolarController@AgregarComentario')->name('AgregarComentario');
    Route::post('/CargarCotizacion', 'ListaEscolarController@CargarCotizacion')->name('CargarCotizacion');

    Route::get('/ColegiosXCodigo/{codigo}','ListaEscolarController@ColegiosXCodigo')->name('ColegiosXCodigo');
    /* */

    ////////////////////////////////////////////// Compra Agil ////////////////////////////////////////////////
    Route::post('/AgregarCompraAgil','CompraAgilController@AgregarCompraAgil')->name('AgregarCompraAgil');
    Route::post('/AgregarItemc','CompraAgilController@AgregarItemc')->name('AgregarItemc');
    Route::post('/AgregarCotizacion', 'CompraAgilController@AgregarCotizacion')->name('AgregarCotizacion');
    Route::put('/EditarItem','CompraAgilController@EditarItem')->name('EditarItem');
    Route::put('/EditarCompra','CompraAgilController@EditarCompra')->name('EditarCompra');
    Route::post('/Eliminaritemc','CompraAgilController@Eliminaritemc')->name('Eliminaritemc');
    Route::post('/EliminarCompra','CompraAgilController@EliminarCompra')->name('EliminarCompra');
    Route::post('/CompraAgilDetalle','CompraAgilController@CompraAgilDetalle')->name('CompraAgilDetalle');
    Route::get('/CompraAgilDetalle','CompraAgilController@CompraAgilDetalle')->name('CompraAgilDetalle');
    Route::post('/envio_combo','CompraAgilController@envio_combo')->name('envio_combo');
    Route::get('/buscarClientes', 'CompraAgilController@buscarClientes')->name('buscarClientes');


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/ResumenDeVenta','AdminController@ResumenDeVenta')->name('ResumenDeVenta');//
    Route::post('/ResumenDeVentaFiltro','AdminController@ResumenDeVentaFiltro')->name('ResumenDeVentaFiltro');

    Route::get('/AvanceAnualMensual','AdminController@AvanceAnualMensual')->name('AvanceAnualMensual');
    Route::post('/AvanceAnualMensualFiltro','AdminController@AvanceAnualMensualFiltro')->name('AvanceAnualMensualFiltro');
    Route::post('/AvanceAnualMensualExcel','AdminController@AvanceAnualMensualExcel')->name('AvanceAnualMensualExcel');

    Route::get('/VentasPorVendedor','AdminController@VentasPorVendedor')->name('VentasPorVendedor');
    Route::post('/VentasPorVendedorFiltro','AdminController@VentasPorVendedorFiltro')->name('VentasPorVendedorFiltro');

    Route::get('/InformeExistencia','AdminController@InformeExistencia')->name('InformeExistencia');
    Route::post('/InformeExistenciaFiltro','AdminController@InformeExistenciaFiltro')->name('InformeExistenciaFiltro');

    Route::get('/VentaProductosPorDia','AdminController@VentaProductosPorDia')->name('VentaProductosPorDia');
    Route::post('/VentaProductosPorDiaFiltro','AdminController@VentaProductosPorDiaFiltro')->name('VentaProductosPorDiaFiltro');

    Route::get('/ControlDeFolios', 'AdminController@ControlDeFolios')->name('ControlDeFolios');
    Route::post('/ControlDeFolios', 'AdminController@EditarFolios')->name('EditarFolios');
    Route::post('/ControlDeFoliosBoletas', 'AdminController@EditarFoliosBoletas')->name('EditarFoliosBoletas');
    Route::post('/ControlDeFoliosGuias', 'AdminController@EditarFoliosGuias')->name('EditarFoliosGuias');

    Route::get('/InformeUtilidades','AdminController@InformeUtilidades')->name('InformeUtilidades');
    Route::post('/InformeUtilidadesFiltro','AdminController@InformeUtilidadesFiltro')->name('InformeUtilidadesFiltro');

    Route::get('/VentasPorRut','AdminController@VentasPorRut')->name('VentasPorRut');
    Route::post('/VentasPorRutFiltro','AdminController@VentasPorRutFiltro')->name('VentasPorRutFiltro');


    //------------------------------FILTROS Y OTRAS COSAS XD-----------------------------------------------//
    Route::post('/Desviacion','AdminController@filtrarDesviacion')->name('filtrarDesv');
    Route::post('/Productospormarca','AdminController@filtarProductospormarca')->name('filtrarpormarca');/*Referencia Aqui*/
    Route::post('/Productos','AdminController@FiltrarProductos')->name('filtrarProductos');
    Route::post('VentasProdutos','AdminController@VentaProductosPorFechas')->name('ventaProdFiltro');

    Route::post('/CostoHistoricoProducto','CostoHistoricoPorProductoController@filtro')->name('CostoHistoricoProductoFiltro');

    Route::post('/VentasPorHora','AdminController@DocumentosPorHora')->name('ComprasPorHora');
    Route::post('ComprasProdutos','AdminController@CompraProductosPorFechas')->name('compraProdFiltro');
    Route::post('/ComprasPorHora','AdminController@DocumentosPorHora')->name('ComprasPorHora');
    Route::post('/Proyeccion','AdminController@ProyeccionDeCompras')->name('proyeccionFiltro');

    /*  Mantenedor CRUD rectificacion inventario sala */
    Route::get('/RectificacionNotasCredito','Rectificacion\RectificacionInventarioSalaController@RectificacionNotasCredito')->name('RectificacionNotasCredito');
    Route::post('/RectificacionNotasCredito','Rectificacion\RectificacionInventarioSalaController@DevolverNotasCredito')->name('DevolverNotasCredito');
    Route::get('/RectificacionCotizacionesSalida','Rectificacion\RectificacionInventarioSalaController@RectificacionCotizacionesSalida')->name('RectificacionCotizacionesSalida');
    Route::post('/RectificacionCotizacionesSalida','Rectificacion\RectificacionInventarioSalaController@DevolverCotizacionSalida')->name('RectificacionCotizacionesSalida');
    Route::post('/RectificacionCotizacionesSalidaDetalle','Rectificacion\RectificacionInventarioSalaController@DevolverCotizacionSalidaDetalle')->name('RectificacionCotizacionesSalidaDetalle');
    Route::get('/RectificacionCotizacionesEntrada','Rectificacion\RectificacionInventarioSalaController@RectificacionCotizacionesEntrada')->name('RectificacionCotizacionesEntrada');
    Route::post('/RectificacionCotizacionesEntrada','Rectificacion\RectificacionInventarioSalaController@DevolverCotizacionEntrada')->name('RectificacionCotizacionesEntrada');
    Route::post('/RectificacionCotizacionesEntradaDetalle','Rectificacion\RectificacionInventarioSalaController@DevolverCotizacionEntradaDetalle')->name('RectificacionCotizacionesEntradaDetalle');
    Route::get('/RectificacionGuia','Rectificacion\RectificacionInventarioSalaController@RectificacionGuia')->name('RectificacionGuia');
    Route::post('/RectificacionGuia','Rectificacion\RectificacionInventarioSalaController@DevolverGuia')->name('DevolverGuia');
    Route::post('/RectificacionGuiaSegunDocumento','Rectificacion\RectificacionInventarioSalaController@DevolverGuiaSegunDocumento')->name('DevolverGuiaSegunDocumento');
    Route::post('/RectificacionGuiaDetalle','Rectificacion\RectificacionInventarioSalaController@DevolverGuiaDetalle')->name('RectificacionGuiaDetalle');
    Route::get('/RectificacionFactura','Rectificacion\RectificacionInventarioSalaController@RectificacionFactura')->name('RectificacionFactura');
    Route::get('/DetalleFactura','Rectificacion\RectificacionInventarioSalaController@DetalleFactura')->name('DetalleFactura');
    Route::post('/editfirma','Rectificacion\RectificacionInventarioSalaController@editfirma')->name('editfirma');
    Route::post('/editartotal','Rectificacion\RectificacionInventarioSalaController@editartotal')->name('editartotal');
    Route::post('/editfirmaNC','Rectificacion\RectificacionInventarioSalaController@editfirmaNC')->name('editfirmaNC');
    Route::post('/quitarREF','Rectificacion\RectificacionInventarioSalaController@quitarREF')->name('quitarREF');
    Route::get('/activarcodigo','Rectificacion\RectificacionInventarioSalaController@activarcodigo')->name('activarcodigo');
    Route::post('/guardarcodigo','Rectificacion\RectificacionInventarioSalaController@guardarcodigo')->name('guardarcodigo');
    Route::get('/RectificacionNotaCredito','Rectificacion\RectificacionInventarioSalaController@RectificacionNotaCredito')->name('RectificacionNotaCredito');
    Route::get('/DetalleNotacredito','Rectificacion\RectificacionInventarioSalaController@DetalleNotacredito')->name('DetalleNotacredito');
    Route::post('/Buscarproducto', 'Rectificacion\RectificacionInventarioSalaController@Buscarproducto')->name('Buscarproducto');
    Route::get('/RectificacionInsumoMerma','Rectificacion\RectificacionInventarioSalaController@RectificacionInsumoMerma')->name('RectificacionInsumoMerma');
    Route::post('/RectificacionInsumoMerma','Rectificacion\RectificacionInventarioSalaController@GuardarRectificacionInsumoMerma')->name('GuardarRectificacionInsumoMerma');
    Route::get('/StockSala','Rectificacion\RectificacionInventarioSalaController@StockSala')->name('StockSala');
    Route::post('/NStockSala','Rectificacion\RectificacionInventarioSalaController@NStockSala')->name('NStockSala');
    Route::get('/SumarVale','Rectificacion\RectificacionInventarioSalaController@SumarVale')->name('SumarVale');
    Route::get('/RestarVale','Rectificacion\RectificacionInventarioSalaController@RestarVale')->name('RestarVale');
    Route::get('/buscar-stock', 'TuControlador@BuscarStock')->name('buscar.stock');
    Route::post('/RectificacionInsumoMermaCargarVale','Rectificacion\RectificacionInventarioSalaController@CargarValeInsimoMerma')->name('CargarValeInsimoMerma');
    /* fin */

    /*  Mantenedor CRUD rectificacion inventario bodega */
    Route::get('/StockBodega', 'Rectificacion\RectificacionInventarioBodegaController@HistorialRectificacionBodega')->name('HistorialRectificacionBodega');
    Route::post('/StockBodega', 'Rectificacion\RectificacionInventarioBodegaController@BuscarHistorialProducto')->name('BuscarHistorialProducto');
    Route::post('/GuardarStockBodega', 'Rectificacion\RectificacionInventarioBodegaController@GuardarStockBodega')->name('GuardarStockBodega');
    Route::post('/AgregarRack', 'Rectificacion\RectificacionInventarioBodegaController@AgregarRack')->name('AgregarRack');
    /* fin */

    // MODULO DE MOVIMIENTO DE PRODUCTO
    Route::get('/MovimientoProducto', 'Productos\MovimientoProductoController@MovimientoProducto')->name('MovimientoProducto');
    Route::get('/MovimientoProductoFiltro', 'Productos\MovimientoProductoController@MovimientoProductoFiltro')->name('MovimientoProductoFiltro');

    // Modulos de Stock critico
    Route::get('/StockDesaparecido','StockCritico\StockCriticoController@StockDesaparecido')->name('StockDesaparecido');
    Route::get('/StockNecesario','StockCritico\StockCriticoController@StockNecesario')->name('StockNecesario');
    Route::get('/StockGuardado','StockCritico\StockCriticoController@StockGuardado')->name('StockGuardado');
    Route::get('/Proveedores','ProductosProveedor\ProductosProveedorController@ProductosProveedor')->name('ProductosProveedor');
    Route::get('/Detalles_proveedor/{id}','ProductosProveedor\ProductosProveedorController@Detalles_Proveedor')->name('Detalles_proveedor');
    Route::get('/obtenerProducto/{codigoProducto}','ProductosProveedor\ProductosProveedorController@obtenerProducto')->name('obtenerProducto');
    Route::post('/agregar-producto','ProductosProveedor\ProductosProveedorController@agregarProducto')->name('agregarProducto');
    Route::post('/eliminar-producto/{id}','ProductosProveedor\ProductosProveedorController@eliminarProducto')->name('eliminarProducto');
    Route::post('actualizarCantidadProducto/{id}','ProductosProveedor\ProductosProveedorController@actualizarCantidadProducto')->name('actualizarCantidadProducto');

    //---------------------Exportaciones----------------------------------------------//

    Route::get('/pdf/{NroOrden?}','exports\ExportsController@exportpdf')->name('pdf.orden');
    Route::get('/pdfDocProv/{folio},{rut}','exports\ExportsController@exportpdfDocProv')->name('pdf.docProv');
    Route::get('/pdfDocProvNc/{folio},{rut}','exports\ExportsController@exportpdfDocProvNc')->name('pdf.docProvNc');
    Route::get('/ExcelOC/{NroOrden?}','exports\ExportsController@exportExelOrdenDeCompra')->name('ordenExcel');
    Route::get('/pdfprov/{NroOrden?}','exports\ExportsController@exportpdfprov')->name('pdf.ordenprov');
    Route::post('/excelproductospormarca','exports\ExportsController@exportExcelproductospormarca')->name('excelproductopormarca');
    Route::post('/ExcelDesv','exports\ExportsController@exportExcelDesviacion')->name('excelDesviacion');
    Route::get('/pdf/{NroOrden?}','exports\ExportsController@exportpdf')->name('pdf.orden');//CompraAgiles
    Route::get('/exportagilpdf/{id}','CompraAgilController@exportagilpdf')->name('exportagilpdf');
    //---------------------Exportaciones ----------------------//

    Route::get('/export', 'exports\MyController@export')->name('export');
    Route::get('/importarordendecompra', 'exports\MyController@importExportView')->name('cargaroc');
    Route::post('/import', 'exports\MyController@import')->name('import');
    Route::post('/importdetalle', 'exports\MyController@importdetalle')->name('importdetalle');
    Route::get('/descargadetalle', 'exports\MyController@descargadetalle')->name('descargadetalle');
    Route::get('/descargaencabezado', 'exports\MyController@descargaEncabezado')->name('descargaencabezado');


    //----------------------- Rutas de Roles y permisos ----------------------------//


    Route::get('/Roles','LaravelPermission\RolesController@index')->name('Roles');
    Route::get('/ShowRoles','LaravelPermission\RolesController@ShowRoles')->name('ShowRoles');
    Route::post('/AddRol','LaravelPermission\RolesController@AddRol')->name('AddRol');
    Route::get('/ShowPermisos/{id}','LaravelPermission\RolesController@ShowPermisos')->name('ShowPermisos');
    Route::post('/AddPermisoRol','LaravelPermission\RolesController@AddPermisoRol')->name('AddPermisoRol');
    Route::get('/ShowUsers','LaravelPermission\RolesController@ShowUsers')->name('ShowUsers');
    Route::get('/ShowRolesUser/{id}','LaravelPermission\RolesController@ShowRolesUser')->name('ShowRolesUser');
    Route::post('/AddRolPermiso','LaravelPermission\RolesController@AddRolUser')->name('');

    // inventario

    Route::get('/movimientoinventario','AdminController@movimientoinventario')->name('movimientoinventario');
    Route::post('/movimientoinventario','AdminController@filtrarmovimientoinventario')->name('filtrarmovimientoinventario');
    Route::post('/ajustemovimientoinventario','AdminController@ajustemovimientoinventario')->name('ajustemovimientoinventario');


    // api jumpseller

    Route::get('/jumpsellerEmpresas','Jumpseller\BluemixEmpresas\SincronizacionProductosController@index')->name('index.jumpsellerEmpresas');
    Route::get('/SincronizarProductos','Jumpseller\BluemixEmpresas\SincronizacionProductosController@sincronizarProductos')->name('sincronizar');
    Route::get('/ActualizarProducto','Jumpseller\BluemixEmpresas\SincronizacionProductosController@actualizarProducto')->name('updateProducto');
    Route::get('/CarritoDeCompras','Jumpseller\BluemixEmpresas\GenerarCarritoController@index')->name('CreacionCarrito.index');
    Route::get('/CarritoDeComprasSearch','Jumpseller\BluemixEmpresas\GenerarCarritoController@BuscarCotizacion')->name('GenerarCarrito.search');
    Route::post('/CrearCarrito','Jumpseller\BluemixEmpresas\GenerarCarritoController@CrearCarrito')->name('GenerarCarrito.store');

    Route::get('/jumpsellerWeb','Jumpseller\BluemixWeb\SincronizacionProductosWebController@index')->name('index.jumpsellerWeb');

    Route::get('/SincronizarProductosWeb','Jumpseller\BluemixWeb\SincronizacionProductosWebController@sincronizarProductos')->name('sincronizarWeb');
    Route::get('/ActualizarProductoWeb','Jumpseller\BluemixWeb\SincronizacionProductosWebController@actualizarProductoWeb')->name('updateProductoWeb');

    Route::get('/actualizacionProductosWeb','Jumpseller\BluemixWeb\ActualizacionProductosWebController@index')->name('index.ActualizacionProductos');

    //Anulacion de documentos
    Route::get('/Anulacion-De-Documentos','AnulacionDocumentosController@index')->name('AnulacionDocs');
    Route::post('/AnularDocs','AnulacionDocumentosController@store')->name('AnulacionDocs.store');

    //Gastos Diseño
    Route::get('/GastosInternosDiseño','GastosDiseno@GastosInternosDiseño')->name('GastosInternosDiseño');
    Route::post('/GastosInternosDiseñoFiltro','GastosDiseno@GastosInternosDiseñoFiltro')->name('GastosInternosDiseñoFiltro');

    Route::get('/ReporteGastosInternosDiseño','GastosDiseno@ReporteGastosInternosDiseño')->name('ReporteGastosInternosDiseño');
    Route::post('/ReporteGastosInternosDiseñoFiltro','GastosDiseno@ReporteGastosInternosDiseñoFiltro')->name('ReporteGastosInternosDiseñoFiltro');

    Route::get('/VentasPorArea','VentasPorAreaController@index')->name('VentasPorArea');
    Route::post('/VentasPorAreaFiltro','VentasPorAreaController@VentasPorAreaFiltro')->name('VentasPorAreaFiltro');

    //Listado precios proveedores
    Route::get('/PreciosProveedores','Contratos\PreciosProveedoresController@PreciosProveedores')->name('PreciosProveedores');
    Route::post('/GuardarPreciosProveedores','Contratos\PreciosProveedoresController@GuardarPreciosProveedores')->name('GuardarPreciosProveedores');
    Route::get('/DescargarAdjunto/{id}','Contratos\PreciosProveedoresController@DescargarAdjunto')->name('DescargarAdjunto');
    Route::post('/EditarPreciosProveedores','Contratos\PreciosProveedoresController@EditarPreciosProveedores')->name('EditarPreciosProveedores');

});




Route::prefix('Giftcard')->namespace('GiftCard')->middleware('auth','GiftCard')->group(function(){

    Route::get('/Folios','GiftCardController@index')->name('indexGiftCard');
    Route::get('/Folios2/{cant}','GiftCardController@vistafolios')->name('Vfolios');
    Route::post('/Folios2','GiftCardController@generarGiftCard')->name('generarGiftCard');

    Route::get('/imprimir/{giftCreadas}','GiftCardController@imprimir')->name('imprimir');
    Route::get('/Load/{Monto}','GiftCardController@CargarTablaCodigos')->name('cargarCodigos');
    Route::get('/VentasGiftCards','GiftCardController@IndexVentasGiftCard')->name('indexVentas');
    Route::get('/LoadVenta/{Monto}','GiftCardController@CargarTablaCodigosVenta')->name('cargarCodigosVenta');
    Route::get('/Venta','GiftCardController@CargarVenta')->name('ventaGiftCard');

    Route::get('/Activacion2.0','GiftCardController@Activacion2')->name('Activacion2.0');




    Route::get('/VentaEmpresa','GiftCardController@VentaEmpresaIndex')->name('VentaEmpresa');
    Route::post('/VentaEmpresa','GiftCardController@VentaEmpresaFiltro')->name('FiltroVentaEmpresa');
    Route::get('/ListarVenta','GiftCardController@ListarGet');
    Route::post('/ListarVenta','GiftCardController@ListarFiltroVentaEmpresa')->name('ListaVentaEmpresa');
    Route::post('/VentasGiftcards','GiftCardController@VenderGiftcard')->name('venderGiftCard');


    Route::post('/Venta','GiftCardController@CargarVenta')->name('ventaGiftCard');
    Route::post('/BloqueoGiftCards','GiftCardController@BloqueoTarjetas')->name('BloqueoConfirmacion');


    Route::get('/Activacion3.0','GiftCardController@Activacion3')->name('Activacion3.0');

    //prueba ruta redirect para las giftcard activadas
    Route::get('/Activacion3.0/{desde}/{hasta}','GiftCardController@Activacion3Redirect')->name('ActivacionRedirect');

    Route::post('/Activacion3.0','GiftCardController@FiltrarActivacion3')->name('filtroActivacion3');
    Route::post('/Activacion2.0','GiftCardController@ActivacionPost')->name('Activacion2Post');
    Route::post('/Activar3','GiftCardController@ActivarRango')->name('ActivarRango');


    //gifcard

    Route::get('/ConsumoTarjeta','GiftCardController@vistaconsumotarjeta')->name('consumotarj');
    Route::post('/ConsumoTarjeta','GiftCardController@filtrarcambiotarjeta')->name('filtrartarjeta');
    Route::get('/BloqueoGiftCards','GiftCardController@BloqueoTarjetasIndex')->name('Bloqueo');
    Route::post('/BloqueoGiftCards','GiftCardController@filtrarbloqueo')->name('filtrartarjetabloqueo');
    Route::post('/BloqueoGiftCardsrango','GiftCardController@filtrarbloqueorango')->name('filtrartarjetabloqueorango');
    Route::post('/BloqueoGif','GiftCardController@bloqueotrajeta')->name('bloqueartarjetacard');
    Route::get('/detalle/{fk_cargos}','GiftCardController@detalletarjeta')->name('detalletarjeta');

});




