<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class CompraAgilController extends Controller
{
    //

    public function ListarCompraAgil(Request $request){

        // $lcompra = DB::table('compragil')->orderby('id','DESC')->get();
        $lcompra = DB::table('compragil')
        ->select('compragil.*', 'tablas.taglos as vender')
        ->leftJoin('tablas', 'compragil.vendedor', '=', 'tablas.tarefe')
        ->where('tablas.tacodi', '=', 24)
        ->orderBy('compragil.id', 'desc')
        ->get();

        // $user = DB::table('users')->where('name', 'John')->first();

        $clientes = DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        ->whereNotNull('regiones.nombre')
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC', 'CLRUTD', 'DEPARTAMENTO', 'CLRSOC', 'TAGLOS AS CIUDAD', 'regiones.nombre AS REGION']);


        return view('admin.Cotizaciones.ComprasAgils',compact('lcompra','clientes'));


    }

    public function CompraAgilDetalle(Request $request){

        // dd($request);

        $compragild=DB::select('select
        compragil_detalle.id,
        compragil_detalle.cod_articulo,
        compragil_detalle.id_compragil,
        compragil_detalle.margen,
        compragil_detalle.valor_margen,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        compragil_detalle.cantidad,
        if(isnull(bodeprod.bpsrea),0,bodeprod.bpsrea) AS stock_sala,
        if(isnull(Suma_Bodega.cantidad),0,Suma_Bodega.cantidad) AS stock_bodega,
        (sum(compragil_detalle.cantidad) * compragil_detalle.valor_margen) as precio_detalle,
        (precios.PCCOSTO)/1.19 as preciou
        from compragil_detalle
        left join precios on SUBSTRING(compragil_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on compragil_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on compragil_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on compragil_detalle.cod_articulo = Suma_Bodega.inarti
        where compragil_detalle.id_compragil= '.$request->get("id"). ' group by compragil_detalle.cod_articulo order by compragil_detalle.id desc');
        // dd($compragild);

        return view('admin.Cotizaciones.Compragil',compact('compragild'),['id' =>$request->get("id")]);
        // return view('nombre.vista', ['id' => $id]);
    }

    public function exportagilpdf($id){


        $compragilpdf=DB::select('select
		tablas.taglos as vendedor,
		compragil.rut,
        compragil.id_compra,
        compragil.razon_social,
        compragil.fecha_i,
        compragil_detalle.id,
        compragil_detalle.cod_articulo,
        compragil_detalle.id_compragil,
        compragil_detalle.margen,
        compragil_detalle.valor_margen,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        compragil_detalle.cantidad,
        if(isnull(bodeprod.bpsrea),0,bodeprod.bpsrea) AS stock_sala,
        if(isnull(Suma_Bodega.cantidad),0,Suma_Bodega.cantidad) AS stock_bodega,
        (compragil_detalle.cantidad * compragil_detalle.valor_margen) as precio_detalle,
        (precios.PCCOSTO)/1.19 as preciou
        from compragil_detalle
        left join precios on SUBSTRING(compragil_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on compragil_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on compragil_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on compragil_detalle.cod_articulo = Suma_Bodega.inarti
        left join compragil on compragil_detalle.id_compragil = compragil.id
        left join tablas on compragil.vendedor = tablas.tarefe
        where compragil_detalle.id_compragil='.$id.' and tablas.TACODI=24 group by compragil_detalle.cod_articulo order by compragil_detalle.id desc');
        // dd($compragilpdf);
        $clientepdf=DB::select('select cliente.CLRSOC as r_social,cliente.CLDIRF as direccion,compragil.rut,vv_tablas8.giro as giro,compragil.observacion,
        cliente.CLFONO as fono,compragil.id_compra,compragil.ciudad,tablas.taglos as vendedor,curdate() as fecha,curtime() as hora
        from compragil
        left join cliente on SUBSTRING(compragil.rut, 1, LENGTH(compragil.rut) - 2) = cliente.CLRUTC
        left join tablas on compragil.vendedor = tablas.tarefe
        left join vv_tablas8 on cliente.CLGIRO = vv_tablas8.tarefe
        where compragil.id='.$id.' and compragil.depto = cliente.DEPARTAMENTO and tablas.tacodi=24');

        // dd($clientepdf);

        $pdf =PDF::loadView('exports.compra_agil', compact('compragilpdf','clientepdf'));

        return $pdf->stream('Orden De Compra.pdf');
      }

    public function AgregarItemc(Request $request){
        $inputs = request()->all();

        // dd($request);

        $codigo = $request->input('codigo');
        $cantidadingresada = $request->input('cantidad');
        $idcompra = $request->get('id');
        $margen = $request->get('margen');
        $label_pmargen = $request->get('label_pmargen');
        // dd($idcompra);


        $codigof = DB::table('compragil_detalle')
        ->where('cod_articulo', $codigo)
        ->where('id_compragil', $idcompra)
        ->first();



        if ($codigof) {

            // $cantidad = $codigof->cantidad+$cantidadingresada;

            // DB::table('compragil_detalle')
            // ->where('compragil_detalle.cod_articulo', $request->get("codigo"))
            // ->update(
            //     [
            //         'compragil_detalle.cantidad'=> $cantidad]

            //     );
                return back()->with('error','El producto ya existe');
        } else {


            $iitemc = DB::table('compragil_detalle')->insert([
                [
                    "cod_articulo" => $request->get('codigo'),
                    "cantidad" => $request->get('cantidad'),
                    "id_compragil" => $idcompra,
                    "margen" => $margen,
                    "valor_margen"=> $label_pmargen,
                    ]
                    ]);


                // return redirect()->route('CompraAgilDetalle')->with('success','Producto Agregado Correctamente');
                return back()->with('success','Producto Agregado Correctamente');
        }

        // dd($request);
        // }
    }

    public function AgregarCompraAgil(Request $request){

        $date = Carbon::now();
        $date2 = $date->format('Y-m-d');
        $validacomprainser = $request->get('idcompra');
        $validacompra = DB::table('compragil')->where('id_compra', $validacomprainser)->exists();

        if($validacompra == true){
            return back()->with('error','Compra Agil Ya Existe!');
        }else {
        if($request->get("rsocial")==""){
            return back()->with('error','Razón Social No Ingresada!');
        }else {
        if($request->get("ciudad")==""){
            return back()->with('error','Ciudad No Ingresada!');
        }
        else{
        if($request->get("region")==""){
            return back()->with('error','Region No Ingresada!');
        }
        else{
        if($request->get("depto")==""){
            return back()->with('error','Departamento No Ingresado!');
        }
        else{
        if($request->get("adjudicada")==""){
            return back()->with('error','Seleccionar Adjudicación!');
        }else{
        $icompra = DB::table('compragil')->insert([
            [
                "id_compra" => $request->get('idcompra'),
                "rut" => $request->get('rut_auto'),
                "razon_social" => $request->get('rsocial'),
                "ciudad" => $request->get('ciudad'),
                "adjudicada" => $request->get("adjudicada"),
                "depto" => $request->get('depto'),
                "region" => $request->get('region'),
                "oc" => $request->get('oc'),
                "fecha_i" => $date2,
                "observacion" => $request->get('observacion'),
                "vendedor" => $request->get('codvende'),
                ]
            ]);


        return redirect()->route('ListarCompraAgil')->with('success','Compra Agregada Correctamente');
        }
        }
        }
        }
        }
        }
    }



    // Inicio Agregar Cotización
    public function AgregarCotizacion(Request $request){
        $idcompra = $request->get('id');

        //
        // Primera consulta
        $consulta1 = DB::select('select dcotiz.DZ_CODIART from dcotiz where dcotiz.DZ_NUMERO = '.$request->get('nro_cotiz').'');


        // Segunda consulta
         $consulta2 = DB::select('select cod_articulo from compragil_detalle where id_compragil='.$idcompra);

        // Variable para indicar si se encontró el resultado
        $encontrado = false;

        foreach ($consulta1 as $dato1) {
            foreach ($consulta2 as $dato2) {
                if ($dato2->cod_articulo == $dato1->DZ_CODIART) {
                    $encontrado = true;
                break 2; // Sale de ambos bucles cuando se encuentra una coincidencia
                }
            }
        }

        if ($encontrado) {
            return back()->with('error','Uno o Mas Productos Ya Existen!');
        } else {
            $cotizacion = DB::select('select dcotiz.DZ_CODIART,dcotiz.DZ_CANT,round(precios.PCCOSTO/1.19) as DZ_PRECIO
            from dcotiz
            left join precios on SUBSTRING(dcotiz.DZ_CODIART,1,5)  = precios.PCCODI
            where dcotiz.DZ_NUMERO = '.$request->get('nro_cotiz').'');

            if(!empty($cotizacion)){
                foreach($cotizacion as $item){

                    $cantidad = $item->DZ_CANT;
                    $neto = $item->DZ_PRECIO; // Asegúrate de reemplazar esto con la lógica real para obtener el valor neto
                    // Calcula el margen utilizando la fórmula que proporcionaste
                    $margenFactor = $request->margen / 100;
                    // dd($margenFactor+1);
                        $precioConMargen = ($cantidad * $neto) * (1 + $margenFactor);
                        $valorcmargen = $precioConMargen/$cantidad;
                        // dd($valorcmargen*43);
                    $nuevo = [
                        'id_compragil' => $idcompra,
                        'cod_articulo' => $item->DZ_CODIART,
                        'cantidad' => $item->DZ_CANT,
                        'margen' => $request->margen,
                        'valor_margen' => round($valorcmargen),
                        //  $('#label_pmargen').val(((cantidad * neto) * (1 + margenFactor)).toFixed(2));
                    ];


                    //error_log(print_r($nuevo, true));
                    DB::table('compragil_detalle')->insert($nuevo);
                }
            }

            // return redirect()->route('CompraAgilDetalle')->with('success','Cotización Agregada Correctamente');
            return back()->with('success','Cotización Agregada Correctamente');
        }

        //

        $cotizacion = DB::select('select dcotiz.DZ_CODIART,dcotiz.DZ_CANT from dcotiz where dcotiz.DZ_NUMERO = '.$request->get('nro_cotiz').'');
        if(!empty($cotizacion)){
            foreach($cotizacion as $item){

                $nuevo = [
                    'id_compragil' => $idcompra,
                    'cod_articulo' => $item->DZ_CODIART,
                    'cantidad' => $item->DZ_CANT,
                ];


                //error_log(print_r($nuevo, true));
                DB::table('compragil_detalle')->insert($nuevo);
            }
        }

        // return redirect()->route('CompraAgilDetalle')->with('success','Cotización Agregada Correctamente');
        return back()->with('success','Cotización Agregada Correctamente');

      }
    // Fin Agregar Cotización


    public function EditarItem(Request $request){


        // dd($request);
              DB::table('compragil_detalle')
              ->where('compragil_detalle.id', $request->get("id"))
              ->update(
                [
                    'cantidad'=> $request->cantidad,]

                );

                // return redirect()->route('ListarConvenio')->with('success','Producto Editado Correctamente');
                return back()->with('success','Producto Editado Correctamente');
          }

public function EditarCompra(Request $request){
    $datet = Carbon::now();

    // dd($request);
    DB::table('compragil')
    ->where('compragil.id', $request->get("id"))
    ->update(
        [
            'oc'=> $request->oc,
            'observacion'=>$request->observacion,
            'fecha_t'=>$datet]
        );

        // return redirect()->route('ListarConvenio')->with('success','Producto Editado Correctamente');
        return back()->with('success','Compra Editada Correctamente');
}



    public function Eliminaritemc(Request $request)
    {
        // dd($request);
        $update = DB::table('compragil_detalle')
        ->where('compragil_detalle.id' , $request->get('id'))
        ->take(5)
        ->delete();

        // return redirect()->route('CompraAgilDetalle')->with('success','Producto Eliminado Correctamente')->with('compragil_detalle.id', $request->get('id'));
        return back()->with('success','Producto Eliminado Correctamente');
    }

    public function EliminarCompra(Request $request)
    {
        // dd($request);
        $update = DB::table('compragil')
        ->where('compragil.id' , $request->get('id'))
        ->take(5)
        ->delete();

        $update2 = DB::table('compragil_detalle')
        ->where('compragil_detalle.id_compragil' , $request->get('id'))
        ->take(5)
        ->delete();

        // return redirect()->route('CompraAgilDetalle')->with('success','Producto Eliminado Correctamente')->with('compragil_detalle.id', $request->get('id'));
        return back()->with('success','Compra Eliminada Correctamente');
    }

    public function index()
    {
        $compras_agiles=DB::table('compra_agil')->orderBy('fecha','desc')->get();

        $adjudicatorios=DB::table('compra_agil')->where('adjudicatorio', '!=', '')->groupBy('adjudicatorio')->get('adjudicatorio');

        $clientes=DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        /* ->where('CLRUTC', 69140900)
        ->where('CLRUTD', 7)
        ->where('DEPARTAMENTO', 1) */
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC','CLRUTD','DEPARTAMENTO','CLRSOC','TAGLOS AS CIUDAD','regiones.nombre AS REGION']);

        $regiones=DB::table('regiones')->get();

        //dd($clientes);

        return view('admin.CompraAgil' ,compact('compras_agiles', 'adjudicatorios', 'clientes', 'regiones'));
    }

    public function create(Request $request)
    {
        //dd($request->estado);

        if($request->fechahora == "" || $request->fechahora == null){
            $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                    'razon_social' => strtoupper($request->razon_social),
                    'rut' => strtoupper($request->rut),
                    'depto' => $request->depto,
                    'ciudad' => strtoupper($request->ciudad),
                    'region' => strtoupper($request->region),
                    'neto' => $request->neto,
                    'id_cot' => $request->id_cot,
                    'margen' => $request->margen,
                    'dias' => $request->dias,
                    'adjudicada' => $request->adjudicada,
                    'oc' => strtoupper($request->oc),
                    'adjudicatorio' => strtoupper($request->adjudicatorio),
                    'factura' => $request->factura,
                    'total' => $request->total,
                    'bara' => $request->bara,
                    'observacion' => strtoupper($request->observacion),
                    'estado' => $request->estado
        ];
        }else{
            $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                        'razon_social' => strtoupper($request->razon_social),
                        'rut' => strtoupper($request->rut),
                        'depto' => $request->depto,
                        'ciudad' => strtoupper($request->ciudad),
                        'region' => strtoupper($request->region),
                        'neto' => $request->neto,
                        'fecha' => $request->fechahora,
                        'id_cot' => $request->id_cot,
                        'margen' => $request->margen,
                        'dias' => $request->dias,
                        'adjudicada' => $request->adjudicada,
                        'oc' => strtoupper($request->oc),
                        'adjudicatorio' => strtoupper($request->adjudicatorio),
                        'factura' => $request->factura,
                        'total' => $request->total,
                        'bara' => $request->bara,
                        'observacion' => strtoupper($request->observacion),
                        'estado' => $request->estado
            ];
        }


        //dd($nueva_compra);

        DB::table('compra_agil')->insert($nueva_compra);

        return redirect()->route('CompraAgil')->with('success','Se ha Agregado la Compra Ágil correctamente');

    }

    public function destroy($id)
    {
        $update = DB::table('compra_agil')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('CompraAgil')->with('success','Compra Ágil Eliminada');
    }

    public function update(Request $request)
    {
        //dd($request->request);

        $compra = DB::table('compra_agil')->where('id', $request->get('id'))->first();

        //dd($compra->estado);

        if($compra != null){

            if($request->estado != null){
                $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                'razon_social' => strtoupper($request->razon_social),
                'rut' => strtoupper($request->rut),
                'depto' => $request->depto,
                'ciudad' => strtoupper($request->ciudad),
                'region' => strtoupper($request->region),
                'neto' => $request->neto,
                'fecha' => $request->fechahoraupdate,
                'id_cot' => $request->id_cot,
                'margen' => $request->margen,
                'dias' => $request->dias,
                'adjudicada' => $request->adjudicada,
                'oc' => strtoupper($request->oc),
                'adjudicatorio' => strtoupper($request->adjudicatorio),
                'factura' => $request->factura,
                'total' => $request->total,
                'bara' => $request->bara,
                'observacion' => strtoupper($request->observacion),
                'estado' => $request->estado,
                ];
                //dd($nueva_compra);
            }else{
                $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                'razon_social' => strtoupper($request->razon_social),
                'rut' => strtoupper($request->rut),
                'depto' => $request->depto,
                'ciudad' => strtoupper($request->ciudad),
                'region' => strtoupper($request->region),
                'neto' => $request->neto,
                'fecha' => $request->fechahoraupdate,
                'id_cot' => $request->id_cot,
                'margen' => $request->margen,
                'dias' => $request->dias,
                'adjudicada' => $request->adjudicada,
                'oc' => strtoupper($request->oc),
                'adjudicatorio' => strtoupper($request->adjudicatorio),
                'factura' => $request->factura,
                'total' => $request->total,
                'bara' => $request->bara,
                'observacion' => strtoupper($request->observacion),
                'estado' => $compra->estado,
                ];
                //dd($nueva_compra);
            }


            DB::table('compra_agil')->where('id', $request->get('id'))->update($nueva_compra);

            return redirect()->route('CompraAgil')->with('success','Compra Ágil Editada Correctamente');

        }else{
            return redirect()->route('CompraAgil')->with('error','Compra Ágil no encontrada');
        }
        return null;
    }

    public function fechaFiltro(Request $request){

        $adjudicatorios=DB::table('compra_agil')->where('adjudicatorio', '!=', '')->groupBy('adjudicatorio')->get('adjudicatorio');

        $clientes=DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        /* ->where('CLRUTC', 69140900)
        ->where('CLRUTD', 7)
        ->where('DEPARTAMENTO', 1) */
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC','CLRUTD','DEPARTAMENTO','CLRSOC','TAGLOS AS CIUDAD','regiones.nombre AS REGION']);

        $fecha1=$request->fecha1;

        if($fecha1 == null){
            return redirect()->route('CompraAgil');
        }else{
            $fecha = date("m-Y", strtotime($fecha1));

            /* $fecha2=$request->fecha2; */
            $compras_agiles = DB::table('compra_agil')->where('fecha', 'LIKE', "%$fecha%")->get();

            //return view('admin.CompraAgil',compact('diseno'));
            return view('admin.CompraAgil',compact('compras_agiles', 'adjudicatorios', 'clientes'));
        }


    }

}
