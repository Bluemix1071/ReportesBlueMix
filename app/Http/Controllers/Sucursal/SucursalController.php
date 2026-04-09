<?php

namespace App\Http\Controllers\Sucursal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Exports\SolicitudGuiaExport;
use Maatwebsite\Excel\Facades\Excel;

class SucursalController extends Controller
{
    //
    public function ProductosSucursal(Request $request){
        //dd("llega aki");
        $query = DB::table('bodeprod')
        ->leftJoin('producto', 'bodeprod.bpprod', '=', 'producto.ARCODI')
        ->leftJoin('suma_bodega', 'bodeprod.bpprod', '=', 'suma_bodega.inarti')
        ->select('bodeprod.*', 'producto.*', 'suma_bodega.*');

        if ($request->has('buscar') && $request->get('buscar') != "") {
            $search = $request->get('buscar');
            $query->where(function($q) use ($search) {
                $q->where('bodeprod.bpprod', 'like', "%{$search}%")
                  ->orWhere('producto.ARDESC', 'like', "%{$search}%")
                  ->orWhere('producto.ARMARCA', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'bodeprod.bpprod'); // Default sort
        $direction = $request->get('direction', 'desc');   // Default direction

        // Map sortable columns if needed, or use direct column names
        $allowedSorts = [
            'codigo' => 'bodeprod.bpprod',
            'detalle' => 'producto.ARDESC',
            'marca' => 'producto.ARMARCA',
            'stock_matriz' => 'bodeprod.bpsrea', // Assuming bpsrea is Matrix? Need to check view mapping. View says bpsrea
            'stock_sucursal' => 'bodeprod.bpsrea1',
            'stock_bodega' => 'suma_bodega.cantidad' // Fixed: cantidad is in suma_bodega
        ];

        // Ensure we are sorting by a valid column
        // If sorting by a direct DB column name passed from view, we might need to adjust or trust it.
        // For simplicity in view, we'll pass keys like 'codigo'.
        if (array_key_exists($sort, $allowedSorts)) {
            $query->orderBy($allowedSorts[$sort], $direction);
        } else {
             $query->orderBy('bodeprod.bpprod', 'desc');
        }

        $productos = $query->paginate($request->get('per_page', 50));
        
        // Append all request parameters to pagination links so sorting/search persists
        $productos->appends($request->all());

        return view('Sucursal.ProductosSucursal', compact('productos'));
    }

    public function GuardarCantidadSucursal(Request $request){

        $producto = DB::table('producto')->where('arcodi', $request->get('codigo'))->get()[0];

        $cantidad_anterior = DB::table('bodeprod')->where('bpprod', $request->get('codigo'))->get()[0];

        error_log(print_r($cantidad_anterior->bpsrea1, true));

        DB::table('solicitud_ajuste')->insert([
            "codprod" => $request->get('codigo'),
            "producto" => $producto->ARDESC,
            "fecha" => date('Y-m-d'),
            "stock_anterior" => $cantidad_anterior->bpsrea1,
            "nuevo_stock" => $request->get('cantidad'),
            "autoriza" => "Valentin Bello",
            "solicita" => "Sucursal",
            "observacion" => "Cambio de stock en Sucursal Isabel Riquelme"
        ]);

        DB::table('bodeprod')
        ->where('bpprod', $request->get('codigo'))
        ->update(['bpsrea1' => $request->get('cantidad')]);

        return response()->json(["status" => "ok"]);
    }

    public function EgresosPorVentas(Request $request){

        $fecha = date('Y-m-d');

        $productos = DB::table('dcargos')
                    ->select(
                        'dcargos.DECODI',
                        'dcargos.Detalle',
                        'bodeprod.bpsrea1',
                        DB::raw('SUM(dcargos.DECANT) as total'),
                        DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta'),
                        'dcargos.DETIPO'
                    )
                    ->leftJoin('cargos', function($join) {
                        $join->on('cargos.CANMRO', '=', 'dcargos.DENMRO')
                            ->whereColumn('cargos.CATIPO', 'dcargos.DETIPO');
                    })
                    ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
                    ->where('dcargos.DEFECO', $fecha)
                    ->where('cargos.CACOCA', '201')
                    ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1')
                    ->get();

        $egreso = DB::table('detalle_devolucion')->where('t_doc', 'Egreso')->where('fecha', $fecha)->get();

        return view('Sucursal.EgresosPorVentas', compact('productos', 'fecha', 'egreso'));
    }

    public function EgresosPorVentasDetalle(Request $request){

        $fecha = $request->get('fecha');

        $productos = DB::table('dcargos')
                    ->select(
                        'dcargos.DECODI',
                        'dcargos.Detalle',
                        'bodeprod.bpsrea1',
                        DB::raw('SUM(dcargos.DECANT) as total'),
                        DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta'),
                        'dcargos.DETIPO'
                    )
                    ->leftJoin('cargos', function($join) {
                        $join->on('cargos.CANMRO', '=', 'dcargos.DENMRO')
                            ->whereColumn('cargos.CATIPO', 'dcargos.DETIPO');
                    })
                    ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
                    ->where('dcargos.DEFECO', $fecha)
                    ->where('cargos.CACOCA', '201')
                    ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1')
                    ->get();

        $egreso = DB::table('detalle_devolucion')->where('t_doc', 'Egreso')->where('fecha', $fecha)->get();

        return view('Sucursal.EgresosPorVentas', compact('productos', 'fecha', 'egreso'));
    }

    public function CargarEgresosPorVentas(Request $request){
        $fecha = $request->get('fecha');

        $productos = DB::table('dcargos')
                    ->select(
                        'dcargos.DECODI',
                        'dcargos.Detalle',
                        'bodeprod.bpsrea1',
                        DB::raw('SUM(dcargos.DECANT) as total'),
                        DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta'),
                        'dcargos.DETIPO'
                    )
                    ->leftJoin('cargos', function($join) {
                        $join->on('cargos.CANMRO', '=', 'dcargos.DENMRO')
                            ->whereColumn('cargos.CATIPO', 'dcargos.DETIPO');
                    })
                    ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
                    ->where('dcargos.DEFECO', $fecha)
                    ->where('cargos.CACOCA', '201')
                    ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1')
                    ->get();

            if(count($productos) === 0){
                return redirect()->route('EgresosPorVentas')->with('danger','Dia Sin Ventas');
            }

        foreach($productos as $item){
            /* error_log(print_r($item->resta, true)); */

            DB::table('bodeprod')
                ->where('bpprod', $item->DECODI)
                ->update(['bpsrea1' => $item->resta]);

            DB::table('solicitud_ajuste')->insert([
                "codprod" => $item->DECODI,
                "producto" => $item->Detalle,
                "fecha" => date('Y-m-d'),
                "stock_anterior" => $item->bpsrea1,
                "nuevo_stock" => $item->resta,
                "autoriza" => "Valentin Bello",
                "solicita" => "Sucursal",
                "observacion" => "Egreso Mercaderia de Sucursal Isabel Riquelme del Dia"
            ]);
        }

        DB::table('detalle_devolucion')->insert([
            "folio" => 0,
            "t_doc" => "Egreso",
            "fecha" => $fecha,
            "estado" => "Egreso Mercaderia a Sucursal Isabel Riquelme"
            ]);

        $egreso = DB::table('detalle_devolucion')->where('t_doc', 'Egreso')->where('fecha', $fecha)->get();

        //return view('Sucursal.EgresosPorVentas', compact('productos', 'fecha', 'egreso'));
        return redirect()->route('EgresosPorVentas')->with('success','Mercaderia Descontada Correctamente');
    }

    public function IngresoMercaderia(Request $request){

        /* $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', '1381093')
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();

        dd($productos); */

        $registro = DB::table('registro_vales')
        ->get();

        return view('Sucursal.IngresoMercaderia', compact('registro'));
    }

    public function BuscarValeSucursal(Request $request){

        $n_vale = $request->get('n_vale');

        $message = "";

        $registro = DB::table('registro_vales')
        ->get();

        $vale = DB::table('db_bluemix.vales')
            ->where('vanmro', $request->get('n_vale'))
            ->get();

        if(count($vale) === 0){
            $message = "Vale no Encontrado";
            return view('Sucursal.IngresoMercaderia', compact('message', 'registro'));
        }

        if($vale[0]->vaesta == 1){
            $message = "Vale ya Cargado";
            return view('Sucursal.IngresoMercaderia', compact('message', 'registro'));
        }

        $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', $n_vale)
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();
            //error_log(print_r("tiene algo", true));
        return view('Sucursal.IngresoMercaderia', compact('n_vale', 'productos', 'registro'));

    }

    public function CargarValeSucursal(Request $request){
        //dd($request->get('n_vale'));

        $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', $request->get('n_vale'))
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();

        foreach($productos as $item){
            /* error_log(print_r($item->ARCODI, true));
            error_log(print_r($item->vacant+$item->bpsrea1, true)); */
            DB::table('bodeprod')
                ->where('bpprod', $item->ARCODI)
                ->update(['bpsrea1' => ($item->vacant + $item->bpsrea1)]);

            DB::table('solicitud_ajuste')->insert([
                "codprod" => $item->ARCODI,
                "producto" => $item->ARDESC,
                "fecha" => date('Y-m-d'),
                "stock_anterior" => $item->bpsrea1,
                "nuevo_stock" => ($item->vacant + $item->bpsrea1),
                "autoriza" => "Valentin Bello",
                "solicita" => "Sucursal",
                "observacion" => "Ingreso Mercaderia a Sucursal Isabel Riquelme por Vale N°: $item->vanmro"
            ]);
        }

        DB::table('vales')
                ->where('vanmro', $request->get('n_vale'))
                ->update(['vaesta' => 1]);

        return redirect()->route('IngresoMercaderiaSucursal')->with('success','Vale Ingresado Correctamente');
    }

    public function Convertirsolicitud(Request $request)
{
    $numeroBodega = $request->input('numeroBodega');
    $maxNumero = (DB::table('dvales')->max('vanmro') ?? 0) + 1;
    $horaActual = date('Hi');
    $ingreso = 0;
    $vendedor = 1;

    $Solicitud = DB::table('dsalida_bodega')
        ->where('id', $numeroBodega)
        ->where('tipo', 'S')
        ->get();

    if ($Solicitud->isEmpty()) {
        return redirect()->back()->with('error', 'Número de solicitud no encontrado');
    }

    DB::table('vales')->insert([
        'vanmro' => $maxNumero,
        'vafeco' => date('Y-m-d'),
        'vatime' => $horaActual,
        'vaesta' => $ingreso,
        'vendedor' => $vendedor,
    ]);

    foreach ($Solicitud as $item) {
        DB::table('dvales')->insert([
            'vanmro' => $maxNumero,
            'vaarti' => $item->articulo,
            'vacant' => $item->cantidad,
        ]);
    }


    DB::table('registro_vales')->insert([
        "Numerovale" => $maxNumero,
        "Numerosolicitudbodega" => $numeroBodega,
        "fecha" => date('Y-m-d'),
    ]);

    return redirect()->back()->with('success', 'Vale creado correctamente');
}

    public function EgresosPorVales(Request $request){
        return view('Sucursal.EgresosPorVales');
    }

    public function BuscarValeSucursalEgreso(Request $request){
        $n_vale = $request->get('n_vale');

        $message = "";

        $vale = DB::table('db_bluemix.vales')
            ->where('vanmro', $request->get('n_vale'))
            ->get();
        
        if(count($vale) === 0){
            $message = "Vale no Encontrado";
            return view('Sucursal.EgresosPorVales', compact('message'));
        }

        if($vale[0]->vaesta == 1){
            $message = "Vale ya Cargado";
            return view('Sucursal.EgresosPorVales', compact('message'));
        }

        $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', $n_vale)
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();

        return view('Sucursal.EgresosPorVales', compact('n_vale', 'productos'));
    }

    public function CargarValeSucursalEgreso(Request $request){
        //dd($request->get('n_vale'));

        $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', $request->get('n_vale'))
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();

        foreach($productos as $item){
            /* error_log(print_r($item->ARCODI, true));
            error_log(print_r($item->vacant+$item->bpsrea1, true)); */
            DB::table('bodeprod')
                ->where('bpprod', $item->ARCODI)
                ->update(['bpsrea1' => ($item->bpsrea1 - $item->vacant)]);

            DB::table('solicitud_ajuste')->insert([
                "codprod" => $item->ARCODI,
                "producto" => $item->ARDESC,
                "fecha" => date('Y-m-d'),
                "stock_anterior" => $item->bpsrea1,
                "nuevo_stock" => ($item->bpsrea1 - $item->vacant),
                "autoriza" => "Valentin Bello",
                "solicita" => "Sucursal",
                "observacion" => "".$request->get('motivo')." de Sucursal Isabel Riquelme por Vale N°: $item->vanmro"
            ]);
        }

        DB::table('vales')
                ->where('vanmro', $request->get('n_vale'))
                ->update(['vaesta' => 1]);

        return redirect()->route('EgresosPorVales')->with('success','Vale Descontado Correctamente');
    }

    public function VentasSucursal(Request $request){

        /* 'select DECODI, Detalle, ARMARCA,sum(DECANT), defeco, PCCOSTO, (avg(precio_real_con_iva)) from dcargos
left join cargos on dcargos.DENMRO = cargos.CANMRO and dcargos.DETIPO = cargos.CATIPO
left join precios on substring(dcargos.DECODI,1,5) = precios.PCCODI
left join producto on dcargos.DECODI = producto.ARCODI
where DEFECO between '2025-10-01' and '2025-10-31' and CACOCA = '201' group by DECODI, month(defeco);' */
        $ventas = DB::table('dcargos')
                ->select(
                    'dcargos.DECODI',
                    'dcargos.Detalle',
                    'producto.ARMARCA',
                    DB::raw('SUM(dcargos.DECANT) as total_decant'),
                    'dcargos.DEFECO',
                    'precios.PCCOSTO',
                    DB::raw('AVG(dcargos.precio_real_con_iva) as avg_precio')
                )
                ->leftJoin('cargos', function($join) {
                    $join->on('dcargos.DENMRO', '=', 'cargos.CANMRO')
                        ->on('dcargos.DETIPO', '=', 'cargos.CATIPO');
                })
                ->leftJoin('precios', DB::raw('SUBSTRING(dcargos.DECODI,1,5)'), '=', 'precios.PCCODI')
                ->leftJoin('producto', 'dcargos.DECODI', '=', 'producto.ARCODI')
                ->whereBetween('dcargos.DEFECO', [date('Y-m-d'), date('Y-m-d')])
                ->where('cargos.CACOCA', '201')
                ->groupBy('dcargos.DECODI', DB::raw('MONTH(dcargos.DEFECO)'))
                ->get();

        return view('Sucursal.VentasSucursal', compact('ventas'));
    }

    public function VentasSucursalFiltro(Request $request){

        $fechamin = $request->get('fechamin');
        $fechamax = $request->get('fechamax');

        $ventas = DB::table('dcargos')
                ->select(
                    'dcargos.DECODI',
                    'dcargos.Detalle',
                    'producto.ARMARCA',
                    DB::raw('SUM(dcargos.DECANT) as total_decant'),
                    'dcargos.DEFECO',
                    'precios.PCCOSTO',
                    DB::raw('AVG(dcargos.precio_real_con_iva) as avg_precio')
                )
                ->leftJoin('cargos', function($join) {
                    $join->on('dcargos.DENMRO', '=', 'cargos.CANMRO')
                        ->on('dcargos.DETIPO', '=', 'cargos.CATIPO');
                })
                ->leftJoin('precios', DB::raw('SUBSTRING(dcargos.DECODI,1,5)'), '=', 'precios.PCCODI')
                ->leftJoin('producto', 'dcargos.DECODI', '=', 'producto.ARCODI')
                ->whereBetween('dcargos.DEFECO', [$fechamin, $fechamax])
                ->where('cargos.CACOCA', '201')
                ->groupBy('dcargos.DECODI', DB::raw('MONTH(dcargos.DEFECO)'))
                ->get();

        return view('Sucursal.VentasSucursal', compact('ventas', 'fechamin', 'fechamax'));
    }

    /* Métodos para Solicitud de Guías */

    public function BuscarProductoSucursal($codigo) {
        $producto = DB::table('producto')
            ->where('ARCODI', $codigo)
            ->orWhere('ARCBAR', $codigo)
            ->get(['ARCODI', 'ARDESC', 'ARMARCA']);
        return response()->json($producto);
    }

    public function SolicitudGuiaIndex() {
        $tipo = session()->get('tipo_usuario');
        
        // Si es Bodega o Sala (Despachadores), priorizamos lo PENDIENTE (estado 0)
        if ($tipo == 'bodega' || $tipo == 'sala') {
            $solicitudes = DB::table('solicitud_guias')
                ->orderBy('estado', 'asc') // 0 (Pendiente) primero
                ->orderBy('fecha_solicitud', 'desc')
                ->get();
        } else {
            // Para Sucursal, orden cronológico descendente
            $solicitudes = DB::table('solicitud_guias')
                ->orderBy('id', 'desc')
                ->get();
        }
        
        $ultimo_folio = DB::table('solicitud_guias')->max('folio_dte');

        return view('Sucursal.SolicitudGuia.Index', compact('solicitudes', 'ultimo_folio'));
    }

    public function BuscarProductosFiltro(Request $request){

        $codigo = $request->get('codigo');
        $detalle = $request->get('detalle');
        $marca = $request->get('marca');
  
        $productos = DB::table('producto')
            ->where('ARCODI', 'like', '%'.$codigo.'%')
            ->where('ARDESC', 'like', '%'.$detalle.'%')
            ->where('ARMARCA', 'like', '%'.$marca.'%')
            ->limit(100)
            ->get(['ARCODI', 'ARDESC', 'ARMARCA']);
  
        return response()->json($productos);
    }

    public function SolicitudGuiaCrear(Request $request) {
        $usuario = session()->get('nombre');
        
        $id = DB::table('solicitud_guias')->insertGetId([
            'usuario' => $usuario,
            'fecha_solicitud' => date('Y-m-d H:i:s'),
            'estado' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        foreach ($request->productos as $prod) {
            DB::table('dsolicitud_guias')->insert([
                'id_solicitud' => $id,
                'articulo' => $prod['codigo'],
                'detalle' => $prod['detalle'],
                'marca' => $prod['marca'] ?? '',
                'cantidad' => $prod['cantidad'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Solicitud creada con éxito']);
    }

    public function SolicitudGuiaDetalle($id) {
        $cabecera = DB::table('solicitud_guias')->where('id', $id)->first();
        $detalles = DB::table('dsolicitud_guias')->where('id_solicitud', $id)->get();

        return response()->json(['cabecera' => $cabecera, 'detalles' => $detalles]);
    }

    public function SolicitudGuiaDespachar(Request $request) {
        $tipo = session()->get('tipo_usuario');
        
        // Seguridad: Solo perfiles de despacho pueden ejecutar esto
        if ($tipo != 'admin' && $tipo != 'adminGiftCard' && $tipo != 'bodega' && $tipo != 'sala') {
            return back()->with('error', 'No tiene permisos para procesar despachos.');
        }

        $id = $request->id;
        $folio = $request->folio;

        if (!$folio) {
            return back()->with('error', 'El número de folio es obligatorio.');
        }

        // 1. Validar Folio Único (SII Compliance)
        $existe_folio = DB::table('solicitud_guias')->where('folio_dte', $folio)->where('id', '!=', $id)->exists();
        if ($existe_folio) {
            return back()->with('error', 'Error: El Folio de Guía #' . $folio . ' ya fue utilizado en otra solicitud. Verifique el número legal.');
        }

        $cabecera = DB::table('solicitud_guias')->where('id', $id)->first();

        if (!$cabecera || $cabecera->estado != 0) {
            return back()->with('error', 'La solicitud no se encuentra en estado pendiente o no existe.');
        }

        $detalles = DB::table('dsolicitud_guias')->where('id_solicitud', $id)->get();
        $cantidades_ajustadas = $request->cantidades; // Array [id_detalle => cantidad]
        $hay_saldos = false;
        $nuevos_items_saldo = [];

        // 2. Validar Stock Suficiente basado en lo que realmente se enviará
        foreach ($detalles as $item) {
            $cant_enviar = isset($cantidades_ajustadas[$item->id]) ? $cantidades_ajustadas[$item->id] : $item->cantidad;
            
            // Validar que no se envíe MÁS de lo pedido originalmente
            if ($cant_enviar > $item->cantidad) {
                return back()->with('error', 'Error: No puede despachar más unidades de las solicitadas para el artículo: ' . $item->articulo);
            }

            $producto_stock = DB::table('bodeprod')->where('bpprod', $item->articulo)->first();
            if (!$producto_stock || $producto_stock->bpsrea < $cant_enviar) {
                return back()->with('error', 'Stock insuficiente en Matriz para el producto: ' . $item->articulo . '. Disponibles: ' . ($producto_stock->bpsrea ?? 0));
            }

            // Si se envía menos, preparamos el saldo
            if ($cant_enviar < $item->cantidad && $cant_enviar >= 0) {
                $hay_saldos = true;
                $nuevos_items_saldo[] = [
                    'articulo' => $item->articulo,
                    'detalle' => $item->detalle,
                    'marca' => $item->marca,
                    'cantidad' => $item->cantidad - $cant_enviar,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        // 2. Validar que no estemos despachando una guía VACIA
        $total_enviar = 0;
        foreach ($detalles as $item) {
            $total_enviar += isset($cantidades_ajustadas[$item->id]) ? $cantidades_ajustadas[$item->id] : $item->cantidad;
        }

        if ($total_enviar == 0) {
            // Si el total es 0, NO procesamos despacho oficial, solo guardamos nota y mantenemos pendiente
            DB::table('solicitud_guias')->where('id', $id)->update(['observacion_despacho' => $request->observacion]);
            return back()->with('info', 'No se puede emitir una guía por 0 artículos. Se ha guardado la nota explicativa y la solicitud sigue pendiente.');
        }

        DB::beginTransaction();
        try {
            // 3. Procesar el Despacho Actual y Generar Saldos si existen
            if ($hay_saldos && count($nuevos_items_saldo) > 0) {
                // Crear nueva cabecera para el saldo
                $id_saldo = DB::table('solicitud_guias')->insertGetId([
                    'usuario' => $cabecera->usuario,
                    'fecha_solicitud' => date('Y-m-d H:i:s'),
                    'estado' => 0, // Pendiente
                    'sucursal_destino' => $cabecera->sucursal_destino,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                foreach ($nuevos_items_saldo as $saldo_item) {
                    $saldo_item['id_solicitud'] = $id_saldo;
                    DB::table('dsolicitud_guias')->insert($saldo_item);
                }
            }

            // 4. Actualizar Detalle Actual y Descontar Stock
            foreach ($detalles as $item) {
                $cant_final = isset($cantidades_ajustadas[$item->id]) ? $cantidades_ajustadas[$item->id] : $item->cantidad;
                
                // Actualizar la cantidad en la solicitud actual para que coincida con la guía
                DB::table('dsolicitud_guias')
                    ->where('id', $item->id)
                    ->update(['cantidad' => $cant_final, 'cantidad_despachada' => $cant_final]);

                // Solo descontar si es mayor a 0
                if ($cant_final > 0) {
                    DB::table('bodeprod')
                        ->where('bpprod', $item->articulo)
                        ->decrement('bpsrea', $cant_final);
                }
            }

            // 5. Marcar como despachada la solicitud actual con nota de despacho
            DB::table('solicitud_guias')
                ->where('id', $id)
                ->update([
                    'folio_dte' => $folio,
                    'fecha_despacho' => date('Y-m-d H:i:s'),
                    'observacion_despacho' => $request->observacion,
                    'estado' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            DB::commit();
            
            $msg = 'Guía de Despacho procesada con éxito.';
            if ($hay_saldos) {
                $msg .= ' Se ha generado una nueva solicitud pendiente con los ítems restantes.';
            }
            
            return back()->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error crítico procesando el despacho: ' . $e->getMessage());
        }
    }

    public function SolicitudGuiaRecibir(Request $request) {
        $tipo = session()->get('tipo_usuario');

        // Seguridad: Solo sucursales (o admin) pueden recibir
        if ($tipo != 'admin' && $tipo != 'adminGiftCard' && $tipo != 'sucursal') {
            return back()->with('error', 'Solo el personal de la Sucursal puede confirmar la recepción.');
        }

        $id = $request->id;
        $cabecera = DB::table('solicitud_guias')->where('id', $id)->first();

        if (!$cabecera || $cabecera->estado != 1) {
            return back()->with('error', 'La solicitud no se encuentra en estado despachado o ya fue recibida.');
        }

        $detalles = DB::table('dsolicitud_guias')->where('id_solicitud', $id)->get();
        $sucursal_destino = $cabecera->sucursal_destino;

        $mapa_bodegas = [
            'Isabel Riquelme' => '234',
        ];

        $codigo_bodega = isset($mapa_bodegas[$sucursal_destino]) ? $mapa_bodegas[$sucursal_destino] : '2';

        DB::beginTransaction();
        try {
            foreach ($detalles as $item) {
                $existe = DB::table('bodeprod')
                    ->where('bpprod', $item->articulo)
                    ->where('bpbode', $codigo_bodega)
                    ->exists();

                if ($existe) {
                    DB::table('bodeprod')
                        ->where('bpprod', $item->articulo)
                        ->where('bpbode', $codigo_bodega)
                        ->increment('bpsrea', $item->cantidad);
                } else {
                    DB::table('bodeprod')->insert([
                        'bpbode' => $codigo_bodega,
                        'bpprod' => $item->articulo,
                        'bpsrea' => $item->cantidad,
                        'bpstin' => 0,
                        'bpsrea1' => 0
                    ]);
                }
            }

            DB::table('solicitud_guias')
                ->where('id', $id)
                ->update([
                    'fecha_recepcion' => date('Y-m-d H:i:s'),
                    'estado' => 2,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            DB::commit();
            return back()->with('success', 'Mercaderia recibida en Sucursal. El stock en COMBO (Bodega ' . $codigo_bodega . ') ha sido actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error critico sincronizando stock con COMBO: ' . $e->getMessage());
        }
    }

    public function SolicitudGuiaExport() {
        return Excel::download(new SolicitudGuiaExport, 'Movimientos_Sucursal_'.date('d-m-Y').'.xlsx');
    }

    public function SolicitudGuiaAnular(Request $request) {
        $tipo = session()->get('tipo_usuario');
        if ($tipo != 'admin' && $tipo != 'adminGiftCard' && $tipo != 'bodega' && $tipo != 'sala') {
            return back()->with('error', 'No tiene permisos para anular solicitudes.');
        }

        $id = $request->id;
        $motivo = $request->motivo;

        if (!$motivo) {
            return back()->with('error', 'Debe indicar un motivo para la anulación.');
        }

        DB::table('solicitud_guias')->where('id', $id)->update([
            'estado' => 4, // Anulada
            'observacion_despacho' => 'ANULADA: ' . $motivo,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'La solicitud ha sido anulada correctamente.');
    }

    public function SolicitudGuiaLive(Request $request) {
        $token_valid = "BlueMixLive7788"; // Token de seguridad sencillo
        
        if ($request->token !== $token_valid) {
            return response('Acceso denegado. Token inválido.', 403);
        }

        $datos = DB::table('solicitud_guias')
            ->join('dsolicitud_guias', 'solicitud_guias.id', '=', 'dsolicitud_guias.id_solicitud')
            ->select(
                'solicitud_guias.id as header_id', // Alias para evitar colisión
                'solicitud_guias.fecha_solicitud',
                'solicitud_guias.usuario',
                'solicitud_guias.folio_dte',
                'solicitud_guias.fecha_despacho',
                'solicitud_guias.fecha_recepcion',
                'solicitud_guias.estado',
                'dsolicitud_guias.articulo',
                'dsolicitud_guias.detalle',
                'dsolicitud_guias.marca',
                'dsolicitud_guias.cantidad'
            )
            ->orderBy('solicitud_guias.id', 'desc')
            ->get();
            
        return view('Sucursal.SolicitudGuia.Live', compact('datos'));
    }
}
 