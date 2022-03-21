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


}
