<?php

//use Illuminate\Routing\Route;



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
Route::match(['get', 'post'],'/ConsultaPrecioFiltro', 'publico\PublicoController@ConsultaPrecioFiltro')->name('ConsultaPrecioFiltro');

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


    //cambio


});


//rutas globales autenticadas
Route::prefix('api')->middleware('auth')->group(function(){

    Route::get('/', 'ApiController@LoadReact')->name('apiReact');
});



Route::prefix('publicos')->middleware('auth')->group(function(){

    Route::get('/','InicioController@index')->name('Publico');
    Route::post('/mensaje','InicioController@store')->name('mensaje');
    Route::post('/ProductosNegativos','publico\PublicoController@filtarProductosNegativos')->name('filtrar');
    Route::get('/ProductosNegativos','publico\PublicoController@filtarProductosNegativos')->name('ProductosNegativos');
    Route::get('/ProductosNegativos2','publico\PublicoController@listarFiltrados')->name('filtro2');
    Route::get('/Informacion','publico\PublicoController@informacion')->name('informacion');
    Route::post('/updatemensaje', 'publico\PublicoController@updatemensaje')->name('updatemensaje');
    Route::get('/ConsultaSaldoenvio','publico\PublicoController@ConsultaSaldo')->name('ConsultaSaldo');
    Route::post('/ConsultaSaldoenvio', 'publico\PublicoController@ConsultaSaldoenvio')->name('ConsultaSaldoenvio');

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

    Route::post('/ComprasProveedores','Compras\ComprasProveedoresController@insert')->name('AgregarCompras');

    Route::get('/ListarComprasProveedores','Compras\ComprasProveedoresController@list')->name('ListarCompras');
    Route::post('/EditarCompraProveedores','Compras\ComprasProveedoresController@editar')->name('EditarCompra');
    Route::put('/EditarCompraProveedores','Compras\ComprasProveedoresController@update')->name('UpdateCompra');

    // fin
    /*  Mantenedor CRUD Notas Credito Proveedores */
    Route::get('/NotasCreditoProveedores','Compras\NotasCreditoProveedoresController@index')->name('NotasCreditoProveedores');
    Route::post('/NotasCreditoProveedores','Compras\NotasCreditoProveedoresController@insert')->name('AgregarNC');
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
    Route::post('/filtrarconsultafacturaboleta','AdminController@filtrarconsultafacturaboleta')->name('filtrarconsultafacturaboleta');

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

    Route::get('/MantencionClientes','AdminController@MantencionClientes')->name('MantencionClientes');
    Route::post('/MantencionClientesFiltro','AdminController@MantencionClientesFiltro')->name('MantencionClientesFiltro');
    Route::put('/MantencionClientesUpdate','AdminController@MantencionClientesUpdate')->name('MantencionClientesUpdate');

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
    Route::post('/UpdateContrato','AdminController@UpdateContrato')->name('UpdateContrato');

    Route::get('/MantenedorProducto','AdminController@MantenedorProducto')->name('MantenedorProducto');
    Route::post('/MantenedorProductoFiltro','AdminController@MantenedorProductoFiltro')->name('MantenedorProductoFiltro');

    Route::get('/ProductosFaltantes','AdminController@ProductosFaltantes')->name('ProductosFaltantes');

    Route::get('/ResumenDeVenta','AdminController@ResumenDeVenta')->name('ResumenDeVenta');
    Route::post('/ResumenDeVentaFiltro','AdminController@ResumenDeVentaFiltro')->name('ResumenDeVentaFiltro');

    Route::get('/VentasPorVendedor','AdminController@VentasPorVendedor')->name('VentasPorVendedor');
    Route::post('/VentasPorVendedorFiltro','AdminController@VentasPorVendedorFiltro')->name('VentasPorVendedorFiltro');


    //------------------------------FILTROS Y OTRAS COSAS XD-----------------------------------------------//
    Route::post('/Desviacion','AdminController@filtrarDesviacion')->name('filtrarDesv');
    Route::post('/Productospormarca','AdminController@filtarProductospormarca')->name('filtrarpormarca');
    Route::post('/Productos','AdminController@FiltrarProductos')->name('filtrarProductos');
    Route::post('VentasProdutos','AdminController@VentaProductosPorFechas')->name('ventaProdFiltro');

    Route::post('/CostoHistoricoProducto','CostoHistoricoPorProductoController@filtro')->name('CostoHistoricoProductoFiltro');

    Route::post('/VentasPorHora','AdminController@DocumentosPorHora')->name('ComprasPorHora');
    Route::post('ComprasProdutos','AdminController@CompraProductosPorFechas')->name('compraProdFiltro');
    Route::post('/ComprasPorHora','AdminController@DocumentosPorHora')->name('ComprasPorHora');
    Route::post('/Proyeccion','AdminController@ProyeccionDeCompras')->name('proyeccionFiltro');




    //---------------------Exportaciones----------------------------------------------//

    Route::get('/pdf/{NroOrden}','exports\ExportsController@exportpdf')->name('pdf.orden');
    Route::get('/ExcelOC/{NroOrden}','exports\ExportsController@exportExelOrdenDeCompra')->name('ordenExcel');
    Route::get('/pdfprov/{NroOrden}','exports\ExportsController@exportpdfprov')->name('pdf.ordenprov');
    Route::post('/excelproductospormarca','exports\ExportsController@exportExcelproductospormarca')->name('excelproductopormarca');
    Route::post('/ExcelDesv','exports\ExportsController@exportExcelDesviacion')->name('excelDesviacion');

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




