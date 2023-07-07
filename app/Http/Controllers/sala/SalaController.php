<?php

namespace App\Http\Controllers\sala;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
use App\Mail\MailNotify;
use DB;
use Session;
use Mail;


class SalaController extends Controller
{
/*
    public function cambiodeprecios (){


        $porcentaje=DB::table('cambio_de_precios')
        ->get();

        return view('sala.cambiodeprecios',compact('porcentaje'));
      }
*/

      public function index(){
        return view('sala.cambiodeprecios');
      }



      public function filtrarcambioprecios (Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $porcentaje=DB::table('cambio_de_precios')
        ->whereBetween('FechaCambioPrecio', array($request->fecha1,$request->fecha2))
        ->get();



        return view('sala.cambiodeprecios',compact('porcentaje','fecha1','fecha2'));
      }


      public function indexGiftCard(){
        return view('sala.VoucherDatos');
      }


      public function generarVoucher(Request $request){
        if(empty($request->all())){
          //dd('nulo');
          // $cantGift=DB::table('CantidadGiftCard')
          // ->get();

          return view('sala.VoucherDatos');
        }
      //  dd('no nuñp');

       // dd($request->all());

       $idCobro=DB::table('nota_cobro')
       ->get();
       DB::table('nota_cobro')->increment('id_bueno');

      // dd($idCobro);



        $params_array=$request->all();
        unset( $params_array['_token'] );
        $date = Carbon::now();
        //dd( $date);
        //dd($date);
        $date = $date->format('d-m-Y');
       // dd($params_array,$date);

        return view('sala.ImprecionSala',compact('params_array','date','idCobro'));
      }





      public function CargaTarjetasCaja(){


        return view('sala.CargarTarjetas');

      }

      public function CargarTarjetasCodigos(Request $request){
        $tarjetasAcumuladas=[];
      //  dd($request->Acomulacion);

       if($request->Acomulacion==null){

        }else{
           $tarjetasAcumuladas= DB::table('tarjeta_gift_card')
                    ->whereIn('TARJ_CODIGO',$request->Acomulacion)
                    ->get();
        }

           $tarjetaEntrante=DB::table('tarjeta_gift_card')
                    ->where('TARJ_CODIGO',$request->Tarjeta)
                    ->where('TARJ_ESTADO','A')
                    ->get();

            $collection = Collection::make($vacio=[]);
       // dd($tarjetaEntrante->first(),$tarjetaEntrante);
           if(empty($tarjetaEntrante->first())){
            //dd('vacio',empty($tarjetaEntrante->first()));

            $collection = $collection->merge(Collection::make($tarjetasAcumuladas));
            Session::flash('error','No se ha encontrado la tarjeta');
            return view('sala.CargarTarjetas',compact('collection'));

           }else{


            $collection = $collection->merge(Collection::make($tarjetasAcumuladas));

            if(!($collection->contains('TARJ_CODIGO',$tarjetaEntrante[0]->TARJ_CODIGO))){
              //dd($collection->contains('TARJ_CODIGO',$tarjetaEntrante[0]->TARJ_CODIGO));
              $collection = $collection->merge(Collection::make($tarjetaEntrante));
            }

           // $collection = $collection->merge(Collection::make($tarjetaEntrante));

              //dd($collection->contains('TARJ_CODIGO',$tarjetaEntrante[0]->TARJ_CODIGO));
            //dd($collection);


           // dd($collection->contains('TARJ_CODIGO','000000000086')); if($collection->contains('TARJ_CODIGO',$tarjetaEntrante[0]->TARJ_CODIGO)){
            Session::flash('success','tarjeta encontrada');
            return view('sala.CargarTarjetas',compact('collection'));


           }






      }

      public function VenderGiftcardSala(Request $request){  // captura los datos de la pantalla de asociacion de tarjetas con el cliente
       //dd($request->all());                         // luego de eso deja las tarjetas vigentes para su posterior venta
       $params_array= $request->all();
        //dd($request->all());
        $validate = \Validator::make($params_array,[
            // 'Desde' =>'required',
            // 'hasta' =>'required',
            'nombreComprador' =>'required',
            'RutComprador'=>'required',
            'Pago'=>'required',
        ]);

          $monto=0;


          if (isset($request->Pago)){

              foreach ($request->Pago as $key ) {

                        $monto+=$key;
                }

          }

       // dd($data);

        if($monto ==$request->Total && isset($request->Pago)){

          $pago=$request->Pago;
          $FormaPago=$request->FormaPago;

        }else{
          $collection= DB::table('tarjeta_gift_card')
          ->whereIn('TARJ_CODIGO',$request->Codigos)
          ->get();

          Session::flash('warning','el total de la venta no es igual a lo ingresado o el pago no ha sido ingresado');
          return view('sala.CargarTarjetas',compact('collection'));
        }


        if($validate->fails()){

            $cantGift=DB::table('CantidadGiftCard')
            ->get();
            $errors = $validate->errors();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
           return view('sala.CargarTarjetas');



        }else{

          $textoPago='';
          for ($i=0; $i <count($FormaPago) ; $i++) {

            if($FormaPago[$i]==0){

              $textoPago .=''.'Efectivo';

            }elseif($FormaPago[$i]==1){

              $textoPago .='/'.'Credito';

            }elseif($FormaPago[$i]==2){
              $textoPago .='/'.'Debito';


            }

          }
          //dd($textoPago,$FormaPago,count($FormaPago));

            $TarjetasSeleccionadas = DB::table('tarjeta_gift_card')
                    ->whereIn('TARJ_CODIGO',$request->Codigos )
                    ->get();
            $cantidad = count($TarjetasSeleccionadas);
            //dd($cantidad);
                $Ncodigos=$request->Codigos;
              //  dd($Ncodigos);
                $date = Carbon::now();

                $date->addMonth(6);
                $date = $date->format('Y-m-d');
                $User= session()->get('nombre');

                $FormasDePago= $request->FormaPago;
                $ValorPAgo=   $request->Pago;


                try{
                DB::transaction(function () use ($TarjetasSeleccionadas,$Ncodigos,$date,$params_array,$cantidad,$User, $FormaPago, $pago) {

                    $idVou=0;
                    $idBD_vou = DB::table('tabla_voucher')->max('vou_folio');
                    //dd($idBD);
                    if(empty($idBD_vou)){
                        $idVou=1;
                        //dd($idVou);
                    }else{
                        $idVou=$idVou+$idBD_vou;
                        $idVou=$idVou+1;
                       // dd($idVou);
                    }
                    $dateVou = Carbon::now();
                    $dateVou = $dateVou->format('Y-m-d');
                    DB::table('tabla_voucher')->insert([
                        'vou_folio' => $idVou,
                        'vou_fecha'=>$dateVou,
                        'vou_nombre_vendedor'=>$User,
                        ]);

                    $j=0;
                        for ($i = 1; $i <= $cantidad; $i++)  {

                            $updates = DB::table('tarjeta_gift_card')
                                ->where('TARJ_CODIGO', '=',$Ncodigos[$j])
                                ->where('TARJ_ESTADO','=','A')
                                ->update([
                                  //  'TARJ_FECHA_VENCIMIENTO' => $date,
                                    'TARJ_COMPRADOR_NOMBRE' => $params_array['nombreComprador'],
                                    'TARJ_COMPRADOR_RUT'=>$params_array['RutComprador'],
                                    'TARJ_ESTADO'=>'V',
                                    'vou_folio_fk'=>$idVou
                                ]);
                                $j=$j+1;
                        }
                            $jj=0;

                        for ($i=0; $i  <$cantidad ; $i++) {

                            DB::table('tabla_voucher_detalle')->insert([
                                'vou_folio' => $idVou,
                                'tarj_codigo'=>$Ncodigos[$jj],
                                ]);
                                $jj=$jj+1;
                        }

                        for ($i=0; $i <count($FormaPago) ; $i++) {


                          if($FormaPago[$i]==0){

                            DB::table('voucher_pago')->insert([
                              'id_voucher_fk'=> $idVou,
                              'id_forma_pago_fk'=>1 ,
                              'monto'=>$pago[$i],
                              ]);

                          }elseif($FormaPago[$i]==1){

                            DB::table('voucher_pago')->insert([
                              'id_voucher_fk'=> $idVou,
                              'id_forma_pago_fk'=>2 ,
                              'monto'=>$pago[$i],
                              ]);

                          }elseif($FormaPago[$i]==2){

                            DB::table('voucher_pago')->insert([
                              'id_voucher_fk'=> $idVou,
                              'id_forma_pago_fk'=>3 ,
                              'monto'=>$pago[$i],
                              ]);

                          }


                        }


                    }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno

                }catch(Exception $e){
                    DB::rollBack();
                    // $cantGift=DB::table('CantidadGiftCard')
                    // ->get();

                    Session::flash('error','Algo ha salido mal intentalo nuevamente');
                    dd($e);
                    return view('sala.CargarTarjetas');

                } catch (\Throwable $e) {
                    DB::rollBack();
                    dd($e);
                    // $cantGift=DB::table('CantidadGiftCard')
                    // ->get();
                    Session::flash('error','Algo ha salido mal intentalo nuevamente');
                    // dd($e,'2catch');
                    return view('sala.CargarTarjetas');
                }
                // $cantGift=DB::table('CantidadGiftCard')
                // ->get();

                $idBD_vou = DB::table('tabla_voucher')->max('vou_folio');
                $dateVou = Carbon::now();
                $dateVou = $dateVou->format('d-m-Y');


                Session::flash('success','Tarjetas Vendidas con Exito!!!');
                return view('sala.ImprecionOk',compact('TarjetasSeleccionadas','dateVou','idBD_vou','textoPago'));
        }

    }


    public function OrdenesDeDiseño(){

        $vendedores = DB::select('SELECT vendedor FROM db_bluemix.ordenesdiseño where vendedor is not NULL and vendedor != "Null" group by vendedor');

        return view('sala.OrdenesDeDiseño', compact('vendedores'));

      }

      public function GuardarOrdenesDeDiseño(Request $request){

        // dd($request->all());
        $date = Carbon::now("Chile/Continental");
        // $date = $date->format('Y-m-d');

        // $date = Carbon::now("Chile/Continental");

            // dd($date);



        if ($request->file('archivo') == null) {
            DB::table('ordenesdiseño')->insert([
                [
                    "nombre" => $request->nombre,
                    "telefono" => $request->telefono,
                    "correo" => $request->correo,
                    "trabajo" => $request->trabajo,
                    "comentario" => $request->comentario,
                    "vendedor" => $request->vendedor,
                    "tipo_documento" => $request->opciones,
                    "documento" => $request->numerodocumento,
                    "fecha_solicitud" => $date,
                    "fecha_entrega" => $request->fechaentrega,
                    ]
                ]);

                $data = array(
                    'nombre' => $request->nombre,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'trabajo' => $request->trabajo,
                    'comentario' => $request->comentario,
                    'fechaentrega' => $request->fechaentrega,
                );

                Mail::send('emails.correo', $data, function ($message) use($request) {
                    $message->from('bluemix.informatica@gmail.com', 'Bluemix SPA.');
                    $message->to($request->correo)->subject('Trabajo ' . $request->trabajo . ' Libreria Bluemix');

                });

                 return redirect()->route('OrdenesDeDiseño')->with('success','Orden De Trabajo Registrada');


        } else{
            DB::table('ordenesdiseño')->insert([
                [
                    "nombre" => $request->nombre,
                    "telefono" => $request->telefono,
                    "correo" => $request->correo,
                    "trabajo" => $request->trabajo,
                    "comentario" => $request->comentario,
                    "archivo" => $request->file('archivo')->store('archivos'),
                    "vendedor" => $request->vendedor,
                    "tipo_documento" => $request->opciones,
                    "documento" => $request->numerodocumento,
                    "fecha_solicitud" => $date,
                    "fecha_entrega" => $request->fechaentrega,
                    ]
                ]);

                $data = array(
                    'nombre' => $request->nombre,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'trabajo' => $request->trabajo,
                    'comentario' => $request->comentario,
                    'fechaentrega' => $request->fechaentrega,
                );

                Mail::send('emails.correo', $data, function ($message) use($request) {
                    $message->from('bluemix.informatica@gmail.com', 'Bluemix SPA.');
                    $message->to($request->correo)->subject('Trabajo ' . $request->trabajo . ' Libreria Bluemix');

                });

                 return redirect()->route('OrdenesDeDiseño')->with('success','Orden De Trabajo Registrada');



        }




        if ($request->correo == null) {

            return redirect()->route('OrdenesDeDiseño')->with('success','Orden De Trabajo Registrada');
        }






    }

    public function ListarOrdenesDiseño(Request $request){

      $ordenes=DB::table('ordenesdiseño')
      ->orderBy('idOrdenesDiseño', 'desc')
      ->get();



      return view('admin.ListarOrdenesDiseño',compact('ordenes'));
  }

    public function ListarOrdenesDisenoDetalle($idOrdenesDiseño){

        $ordenesdiseño=DB::table('ordenesdiseño')
        ->where('idOrdenesDiseño', $idOrdenesDiseño)
        ->get();

        $path = storage_path('app/'.$ordenesdiseño[0]->archivo);
        $data = file_get_contents($path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $base64 = base64_encode($data);

        $img = 'data:image/' . $type . ';base64,' . $base64;

        //  dd($ordenesdiseño);

        return view('admin.ListarOrdenesDiseñoDetalle',compact('ordenesdiseño', 'img'));
    }

    public function RequerimientoCompra(Request $request){

      //$requerimiento_compra = DB::table('requerimiento_compra')->get();

      $requerimiento_compra = DB::select('SELECT requerimiento_compra.*, if(isnull(Suma_Bodega.cantidad), 0, Suma_Bodega.cantidad) as stock_bodega FROM db_bluemix.requerimiento_compra
      left join Suma_Bodega on requerimiento_compra.codigo = Suma_Bodega.inarti');

      $estados = [ ["estado" => "INGRESADO"],  ["estado" => "ENVÍO OC"], ["estado" => "BODEGA"],["estado" => "DESACTIVADO"]];

      //$productos = DB::table('producto')->get(['ARCODI', 'ARDESC', 'ARMARCA']);

      $productos = DB::table('conveniomarco')->get(['codigo', 'descripcion', 'marca']);

      $fecha1 = date("Y-m-d",strtotime(date("Y-m-d")."- 1 month"));

      //dd($depto[5]['depto']);

      return view('sala.RequerimientoCompra', compact('requerimiento_compra', 'estados', 'productos', 'fecha1'));
    }

    public function AgregarRequerimientoCompra(Request $request){

      /* $fecha_ingreso = DB::select('select cmovim.* from dmovim
      left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI where DMVPROD = "'.strtoupper($request->codigo).'" order by CMVFECG desc limit 1'); */

      //dd(empty($fecha_ingreso));
      DB::table('requerimiento_compra')->insert([
        [
            "codigo" => strtoupper($request->codigo),
            "descripcion" => strtoupper($request->descripcion),
            "marca" => strtoupper($request->marca),
            "cantidad" => $request->cantidad,
            "depto" => $request->depto,
            "estado" => $request->estado,
            "oc" => $request->oc,
            "observacion" => $request->observacion,
            "observacion_interna" => $request->observacion_interna
        ]
      ]);

      /* if(!empty($fecha_ingreso)){
        if($fecha_ingreso[0]->CMVFECG <= "2021-11-01"){
          DB::table('requerimiento_compra')->insert([
            [
                "codigo" => strtoupper($request->codigo),
                "descripcion" => strtoupper($request->descripcion),
                "marca" => strtoupper($request->marca),
                "cantidad" => $request->cantidad,
                "depto" => $request->depto,
                "estado" => $request->estado,
                "oc" => $request->oc,
                "observacion" => $request->observacion,
                "observacion_interna" => $request->observacion_interna
            ]
          ]);
          return redirect()->route('RequerimientoCompra')->with('error','El requerimiento de Compra no se agregó ya que el producto tiene ingresos de mercadería de antes de 01-11-2021');
        }else{
        }
      }else{
        DB::table('requerimiento_compra')->insert([
          [
              "codigo" => strtoupper($request->codigo),
              "descripcion" => strtoupper($request->descripcion),
              "marca" => strtoupper($request->marca),
              "cantidad" => $request->cantidad,
              "depto" => $request->depto,
              "estado" => $request->estado,
              "oc" => $request->oc,
              "observacion" => $request->observacion,
              "observacion_interna" => $request->observacion_interna
          ]
        ]);
      } */

      return redirect()->route('RequerimientoCompra')->with('success','Requerimiento de Compra Agregado');
    }

    public function DesactivarRequerimiento(Request $request){

      //$requerimiento_compra = DB::table('requerimiento_compra')->get();
      //dd($request->idrequerimiento);
      DB::table('requerimiento_compra')
      ->where('id' , $request->idrequerimiento)
      ->update(['estado' => "DESACTIVADO"]);

      return redirect()->route('RequerimientoCompra')->with('success','Requerimiento Desactivado');
    }

    public function EditarEstadoRequerimientoCompra(Request $request){

      //$requerimiento_compra = DB::table('requerimiento_compra')->get();
      DB::table('requerimiento_compra')
      ->where('id' , $request->idrequerimiento)
      ->update(['estado' => $request->estadorequerimiento]);

      return redirect()->route('RequerimientoCompra')->with('success','Estado Cambiado');
    }

    public function EditarRequerimientoCompra(Request $request){

      $estado = "";

      $now = DB::select('select now() as hoy')[0]->hoy;

      $requerimiento = DB::table('requerimiento_compra')->where('id' , $request->id)->get()[0];

      DB::table('requerimiento_compra')
      ->where('id' , $request->id)
      ->update(
        ['codigo' => $request->codigo,
          'descripcion' => $request->descripcion,
          'marca' => $request->marca,
          'cantidad' => $request->cantidad,
          'depto' => $request->departamento,
          'estado' => $request->estado,
          'oc' => $request->oc,
          'observacion' => $request->observacion,
          'observacion_interna' => $request->observacion_interna]
      );

      if($requerimiento->estado != $request->estado){

      switch ($request->estado) {
        case "INGRESADO":
            $estado = "fecha";
            break;
        case "ENVÍO OC":
            $estado = "fecha_enviooc";
            break;
        case "BODEGA":
            $estado = "fecha_bodega";
            break;
        case "RECHAZADO":
            $estado = "fecha_rechazado";
            break;
        case "DESACTIVADO":
            $estado = "fecha_desactivado";
            break;
      }

        DB::table('requerimiento_compra')
        ->where('id' , $request->id)
        ->update(
          [$estado => $now]
        );

      }

      return redirect()->route('RequerimientoCompra')->with('success','Requerimiento Editado Correctamente');

    }

    public function EditarRequerimientoCompraMultiple(Request $request){

      $estado = "";

      $now = DB::select('select now() as hoy')[0]->hoy;

      switch ($request->estado_multiple) {
        case "INGRESADO":
            $estado = "fecha";
          break;
        case "ENVÍO OC":
            $estado = "fecha_enviooc";
            break;
        case "BODEGA":
            $estado = "fecha_bodega";
            break;
        case "RECHAZADO":
            $estado = "fecha_rechazado";
            break;
        case "DESACTIVADO":
            $estado = "fecha_desactivado";
            break;
      }

      if(is_null($request->case)){
        return redirect()->route('RequerimientoCompra')->with('warning','No seleccionó Requerimientos para Editar');
      }else{
        foreach($request->case as $item){

          DB::table('requerimiento_compra')
            ->where('id' , $item)
            ->update(
            [ 'estado' => $request->estado_multiple,
              'oc' => $request->oc_multiple,
              'observacion_interna' => $request->observacion_interna_multiple,
              $estado => $now]
          );

        }
        return redirect()->route('RequerimientoCompra')->with('success','Requerimientos Editados Correctamente');
      }
    }

    public function EditarRequerimientoCompraMultiplePrioridad(Request $request){

      if(is_null($request->case)){
        return redirect()->route('RequerimientoCompra')->with('warning','No seleccionó Requerimientos para Priorizar');
      }else{
        foreach($request->case as $item){

          DB::table('requerimiento_compra')
            ->where('id' , $item)
            ->update(
            ['prioridad' => 1]
          );

        }
        return redirect()->route('RequerimientoCompra')->with('success','Requerimientos Priorizados Correctamente');
      }
    }

    public function ConteoInventarioSala(){
      $conteo_inventario = DB::table('conteo_inventario')->where('ubicacion', 'Sala')->orderBy('fecha', 'desc')->get();

      $modulos = [['modulo' => 'ARTE 1'], ['modulo' => 'ARTE 2'], ['modulo' => 'ARTE 3'], ['modulo' => 'ARTE 4'], ['modulo' => 'ARTE 5'], ['modulo' => 'ARTE 6'], ['modulo' => 'ARTE 7'], ['modulo' => 'ARTE 8'], ['modulo' => 'ARTE 9'], ['modulo' => 'ASEO'], ['modulo' => 'BLISTERIA'], ['modulo' => 'CABECERA 1'], ['modulo' => 'CABECERA 2'], ['modulo' => 'CABECERA 3'], ['modulo' => 'CABECERA 4'], ['modulo' => 'CABECERA 5'], ['modulo' => 'CABECERA 6'],
      ['modulo' => 'CABECERA 7'], ['modulo' => 'CABECERA 8'], ['modulo' => 'CORDONEDRIA 1'] , ['modulo' => 'CORDONEDRIA 2'], ['modulo' => 'CORDONEDRIA 3'], ['modulo' => 'CORDONEDRIA 4'], ['modulo' => 'CORDONEDRIA 5'], ['modulo' => 'CORDONEDRIA 6'], ['modulo' => 'CORDONEDRIA 7'],['modulo' => 'CORDONEDRIA 8'], ['modulo' => 'CORDONEDRIA 9'], ['modulo' => 'DESPACHO'], ['modulo' => 'DISEÑO 1'], ['modulo' => 'DISEÑO 2'], ['modulo' => 'GONDOLA 1 (ESCOLARES)'], ['modulo' => 'GONDOLA 2 (ARCHIVADORES)'], ['modulo' => 'GONDOLA 3 (CARPETAS)'],
      ['modulo' => 'GONDOLA 4 (LANAS)'], ['modulo' => 'GONDOLA 4 A(LANAS)'], ['modulo' => 'GONDOLA 5 (CUADERNOS)'], ['modulo' => 'GONDOLA 6 (REGLAS)'], ['modulo' => 'GONDOLA 7 (JUGUETES)'], ['modulo' => 'GONDOLA 8 (DIDACTICOS)'], ['modulo' => 'HILOS DE BORDAR'], ['modulo' => 'LIBROS'], ['modulo' => 'LIBROS 2'], ['modulo' => 'LIBROS 3'], ['modulo' => 'LIBROS 4'], ['modulo' => 'LIBROS 5'], ['modulo' => 'MERMA'], ['modulo' => 'PAPELERIA 1'], ['modulo' => 'PAPELERIA 2'], ['modulo' => 'PAPELERIA 3 (METALES)'], ['modulo' => 'PAPELERIA 4 (GOMA EVA)'],
      ['modulo' => 'PAPELERIA 5 (FOTOGRAFICO)'], ['modulo' => 'PAPELERIA 6 (CINTAS)'], ['modulo' => 'PAPELERIA 7'],['modulo' => 'PAPELERIA 8'], ['modulo' => 'PAPELERIA 9'], ['modulo' => 'PAPELERIA MESON 1'], ['modulo' => 'PAPELERIA MESON 2'], ['modulo' => 'REGALERÍA'], ['modulo' => 'SERVICIOS 1 Y ADETEC'], ['modulo' => 'SERVICIOS CENTRAL'], ['modulo' => 'SERVICIOS CENTRAL 2'], ['modulo' => 'SERVICIOS CENTRAL 3'], ['modulo' => 'SERVICIOS CENTRAL 4'], ['modulo' => 'VENTA ASISTIDA 1'], ['modulo' => 'VENTA ASISTIDA 2'], ['modulo' => 'VENTA ASISTIDA 3'], ['modulo' => 'VENTA ASISTIDA 4'], ['modulo' => 'VENTA ASISTIDA 5'],['modulo' => 'VENTA ASISTIDA 6'],['modulo' => 'VENTA ASISTIDA 7'],['modulo' => 'VENTA ASISTIDA 8'], ['modulo' => 'ZIÑA']];

      return view('sala.ConteoInventarioSala', compact('conteo_inventario', 'modulos'));

    }

    public function NuevoConteo(Request $request){

      $nuevo = ['ubicacion' => $request->ubicacion,
          'modulo' => $request->modulo,
          'encargado' => $request->encargado,
          'estado' => "Ingresado"
      ];

      DB::table('conteo_inventario')->insert($nuevo);

      return redirect()->route('ConteoInventarioSala')->with('success','Agregado Correctamente');
    }

    public function ConteoDetalle(Request $request){

      $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', '=', $request->id)->orderBy('posicion', 'asc')->get();

      $conteo = DB::table('conteo_inventario')->where('id', $request->id)->get()[0];

      $id_conteo = $request->id;

      return view('sala.ConteoInventarioSalaDetalle', compact('detalles', 'id_conteo', 'conteo'));
    }

    public function BuscarProducto($codigo){

      //error_log(print_r($codigo, true));

      $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();

      return response()->json($producto);
    }

    public function GuardarConteoDetalle(Request $request){
      //stristr($email, 'e');
      $id_conteo = $request->get('id_conteo');

      DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->delete();

      $i = 1;

      $groups = array();

      foreach ($request->request as $item) {
          $key = $item['codigo'];
          if (!array_key_exists($key, $groups)) {
              $groups[$key] = array(
                  'posicion' => $i++,
                  'codigo' => $item['codigo'],
                  'detalle' => $item['detalle'],
                  'marca' => $item['marca'],
                  'costo' => 0,
                  'precio' => 0,
                  'cantidad' => $item['cantidad'],
                  'estado' => 'exeptuado',
                  'id_conteo_inventario' => $id_conteo
              );
          } else {
              $groups[$key]['cantidad'] = $groups[$key]['cantidad'] + $item['cantidad'];
          }

      }

      foreach($groups as $item){
          //error_log(print_r($item, true));
          DB::table('conteo_inventario_detalle')->insert($item);
      }

      $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', '=', $id_conteo)->orderBy('posicion', 'asc')->get();

      $conteo = DB::table('conteo_inventario')->where('id', $id_conteo)->get()[0];

      return view('sala.ConteoInventarioSalaDetalle', compact('detalles', 'id_conteo', 'conteo'));
    }

    public function CargarValeConteoSala(Request $request){

      $conteo = DB::table('conteo_inventario')->where('id', $request->get('id_conteo'))->get()[0];
      $contador = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $request->get('id_conteo'))->get()->count();
      $contador = $contador+1;
      //dd(DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $request->get('id_conteo'))->get());

      //dd($request->get('nro_vale'));

      $vale = DB::select('select dvales.vaarti, producto.ARDESC, producto.ARMARCA, dvales.vacant from dvales left join producto on dvales.vaarti = producto.ARCODI where vanmro = '.$request->get('nro_vale').'');
      if(!empty($vale)){
          foreach($vale as $item){

              $nuevo = ['posicion' => $contador++,
                            'codigo' => $item->vaarti,
                            'detalle' => $item->ARDESC,
                            'marca' => $item->ARMARCA,
                            'costo' => 0,
                            'precio' => 0,
                            'cantidad' => $item->vacant,
                            'estado' => 'exeptuado',
                            'id_conteo_inventario' => $request->get('id_conteo')
              ];
              //error_log(print_r($nuevo, true));
              DB::table('conteo_inventario_detalle')->insert($nuevo);
          }
      }

      $id_conteo = $request->get('id_conteo');

      $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', '=', $id_conteo)->orderBy('posicion', 'asc')->get();

      return view('sala.ConteoInventarioSalaDetalle', compact('detalles', 'id_conteo', 'conteo'));

    }

  public function TerminarConteoSala(Request $request){
      DB::table('conteo_inventario')
          ->where('id' , $request->get('id_conteo'))
          ->update(
          [ 'estado' => "Terminado"]
        );

      return redirect()->route('ConteoInventarioSala')->with('success','Conteo Terminado');
  }

  public function ResumenProducto($codigo){

    //error_log(print_r($codigo, true));
    $producto = DB::select('SELECT arcodi, arcbar, ARCOPV,ardesc, ARDVTA, armarca, defeco, if(isnull(cantidad), 0, cantidad) as cantidad, bpsrea, (
      select CMVFECG from dmovim
      left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI where DMVPROD = "'.$codigo.'" order by CMVFECG desc limit 1
    ) as ult_ingreso,
    (select DMVCANT from dmovim
      left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI where DMVPROD = "'.$codigo.'" order by CMVFECG desc limit 1) as ult_cant,
      (select date(fecha) from requerimiento_compra where codigo = "'.$codigo.'" order by fecha desc limit 1) as ult_requerimiento
	FROM producto
    left join dcargos on ARCODI = dcargos.DECODI
    left join Suma_Bodega on ARCODI = Suma_Bodega.inarti
    left join bodeprod on ARCODI = bodeprod.bpprod
    where ARCODI = "'.$codigo.'" order by DEFECO desc limit 1')[0];

    $ingresos = DB::select('select DMVPROD, proveed.PVNOMB, DMVCANT, DMVUNID, CMVFECG, PrecioCosto from dmovim
    left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI
    left join dcargos on dmovim.DMVPROD = dcargos.DECODI
    left join proveed on cmovim.CMVCPRV = proveed.PVRUTP
    where CMVFECG >= "2020-01-01" and DMVPROD = "'.$codigo.'" and DEFECO >= "2020-01-01" group by CMVFECG');

    $costos = DB::select('select DEFECO, PrecioCosto, DEPREC from dcargos where DECODI = "'.$codigo.'" and DETIPO != 3 and DEFECO >= "2020-01-01" AND PrecioCosto != 100 group by PrecioCosto order by DEFECO asc');

    return response()->json([$producto,$ingresos,$costos]);
  }

  public function DetalleVale($n_vale){

    $vale = DB::select('select vaarti, ARDESC, ARMARCA, dvales.vacant from dvales
    left join producto on dvales.vaarti = producto.ARCODI
    where vanmro = '.$n_vale.' group by vaarti');

    return response()->json($vale);
  }

  public function AgregarValeRequerimiento(Request $request){

    $vale = DB::select("select vaarti, ARDESC, ARMARCA, vacant, if(isnull(cantidad), 0, cantidad) as cantidad, bpsrea from dvales
    left join producto on dvales.vaarti = producto.ARCODI
    left join Suma_Bodega on dvales.vaarti = Suma_Bodega.inarti
    left join bodeprod on dvales.vaarti = bodeprod.bpprod
    where vanmro = '.$request->n_vale.'");

    if(count($vale) == 0){
      return redirect()->route('RequerimientoCompra')->with('warning','El vale ingresado no existe');
    }

    if(is_null($request->vale)){
      return redirect()->route('RequerimientoCompra')->with('warning','No seleccionó ningún producto para Ingresar');
    }


    foreach($vale as $item){
      foreach($request->vale as $item2){
        if($item->vaarti == $item2){
          DB::table('requerimiento_compra')->insert([
            [
                "codigo" => strtoupper($item->vaarti),
                "descripcion" => strtoupper($item->ARDESC),
                "marca" => strtoupper($item->ARMARCA),
                "cantidad" => $item->vacant,
                "depto" => $request->depto,
                "estado" => "INGRESADO",
                "observacion" => $request->observacion
            ]
          ]);
        }
      }
    }

    /* foreach ($vale as $item) {
      //error_log(print_r($request->depto, true));
      DB::table('requerimiento_compra')->insert([
        [
            "codigo" => strtoupper($item->vaarti),
            "descripcion" => strtoupper($item->ARDESC),
            "marca" => strtoupper($item->ARMARCA),
            "cantidad" => $item->vacant,
            "depto" => $request->depto,
            "estado" => "INGRESADO",
            "observacion" => $request->observacion
        ]
      ]);
    } */

    return redirect()->route('RequerimientoCompra')->with('success','Vale de Requerimientos Ingresados Correctamente');

  }

  public function Precios(Request $request) {

    return view('sala.Precios');
  }

  public function PreciosL(Request $request) {

    return view('sala.PreciosL');
  }
}
