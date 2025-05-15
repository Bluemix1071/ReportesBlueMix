<?php

namespace App\Http\Controllers\Sucursal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SucursalController extends Controller
{
    //
    public function ProductosSucursal(Request $request){
        //dd("llega aki");
        $productos = DB::table('bodeprod')
        ->leftJoin('producto', 'bodeprod.bpprod', '=', 'producto.ARCODI')
        ->leftJoin('suma_bodega', 'bodeprod.bpprod', '=', 'suma_bodega.inarti')
        ->select('bodeprod.*', 'producto.*', 'suma_bodega.*')
        ->get();

        //dd($productos);

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
            "autoriza" => "Diego Carrasco",
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
                DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta')
            )
            ->leftJoin('cargos', 'cargos.CANMRO', '=', 'dcargos.DENMRO')
            ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
            ->where('DEFECO', $fecha)
            ->where('CACOCA', '201')
            ->where('bpsrea1', '>', 0)
            ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1') // importante para evitar errores SQL
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
                DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta')
            )
            ->leftJoin('cargos', 'cargos.CANMRO', '=', 'dcargos.DENMRO')
            ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
            ->where('DEFECO', $fecha)
            ->where('CACOCA', '201')
            ->where('bpsrea1', '>', 0)
            ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1') // importante para evitar errores SQL
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
                DB::raw('(bodeprod.bpsrea1 - SUM(dcargos.DECANT)) as resta')
            )
            ->leftJoin('cargos', 'cargos.CANMRO', '=', 'dcargos.DENMRO')
            ->leftJoin('bodeprod', 'bodeprod.bpprod', '=', 'dcargos.DECODI')
            ->where('DEFECO', $fecha)
            ->where('CACOCA', '201')
            ->where('bpsrea1', '>', 0)
            ->groupBy('dcargos.DECODI', 'dcargos.Detalle', 'bodeprod.bpsrea1') // importante para evitar errores SQL
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
                "autoriza" => "Diego Carrasco",
                "solicita" => "Sucursal",
                "observacion" => "Egreso Mercaderia de Sucursal Isabel Riquelme del Dia"
            ]);
        }
        
        DB::table('detalle_devolucion')->insert([
            "folio" => 0,
            "t_doc" => "Egreso",
            "fecha" => $fecha,
            "estado" => "Egreso Mercaderia a Sucursal Isabel Riquelme",
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

        return view('Sucursal.IngresoMercaderia');
    }

    public function BuscarValeSucursal(Request $request){

        $n_vale = $request->get('n_vale');

        $message = "";

        $vale = DB::table('db_bluemix.vales')
            ->where('vanmro', $request->get('n_vale'))
            ->get();
        
        if(count($vale) === 0){
            $message = "Vale no Encontrado";
            return view('Sucursal.IngresoMercaderia', compact('message'));
        }
        
        if($vale[0]->vaesta == 1){
            $message = "Vale ya Cargado";
            return view('Sucursal.IngresoMercaderia', compact('message'));
        }

        $productos = DB::table('dvales')
        ->leftJoin('producto', 'dvales.vaarti', '=', 'producto.ARCODI')
        ->leftJoin('bodeprod', 'dvales.vaarti', '=', 'bodeprod.bpprod')
        ->where('vanmro', $n_vale)
        ->select('dvales.*', 'producto.*', 'bodeprod.*')
        ->get();
            //error_log(print_r("tiene algo", true));
        return view('Sucursal.IngresoMercaderia', compact('n_vale', 'productos'));

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
                "autoriza" => "Diego Carrasco",
                "solicita" => "Sucursal",
                "observacion" => "Ingreso Mercaderia a Sucursal Isabel Riquelme por Vale N°: $item->vanmro"
            ]);
        }

        DB::table('vales')
                ->where('vanmro', $request->get('n_vale'))
                ->update(['vaesta' => 1]);

        return redirect()->route('IngresoMercaderiaSucursal')->with('success','Vale Ingresado Correctamente');
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
                "autoriza" => "Diego Carrasco",
                "solicita" => "Sucursal",
                "observacion" => "Egreso Mercaderia de Sucursal Isabel Riquelme por Vale N°: $item->vanmro"
            ]);
        }

        DB::table('vales')
                ->where('vanmro', $request->get('n_vale'))
                ->update(['vaesta' => 1]);

        return redirect()->route('EgresosPorVales')->with('success','Vale Descontado Correctamente');
    }
}
