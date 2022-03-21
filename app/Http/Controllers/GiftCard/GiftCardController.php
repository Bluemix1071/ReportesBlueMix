<?php

namespace App\Http\Controllers\GiftCard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GiftCard;
use DB;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Collection as Collection;

class GiftCardController extends Controller
{


    public function index(){ // carga los datos necesarios en la pantalla principal de laa activacion de giftcards
       // $ean = '5000';
       // dd( strlen($ean));
      //  $ena13 = $this->ean13_check_digit($ean);
        //dd($ena13);
        $idBD = DB::table('tarjeta_gift_card')->max('TARJ_ID');
        $idBD=$idBD+1;
        $date = Carbon::now();
        //dd($date);
        $date->addMonth(6);
        $date = $date->format('Y-m-d');
        //dd($date);

       // dd($cantGift);

        return view('giftCard.Index',compact('idBD','date'));

    }

    public function vistafolios($cant){
        $giftCreadas=DB::table('tarjeta_gift_card')
                ->orderBy('TARJ_ID', 'desc')
                ->take( $cant)
                ->get();

        return view ('giftCard.FoliosCreados',compact('giftCreadas'));
    }


    public function generarGiftCard(Request $request){ //metodo que se encarga de la cracion de Folios
      //  dd($request->all());
       $params_array= $request->all();
      // dd($params_array);


        $validate = \Validator::make($params_array,[
            // 'Desde' =>'required',
            // 'hasta' =>'required',
            'Monto' =>'required',
            'Cantidad'=>'required',
             'FechaVencimiento'=>'required',
        ]);


        if($validate->fails()){

            $errors = $validate->errors();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
           return view('giftCard.Index',compact('errors','cantGift'));


        }else{
                    setlocale(LC_ALL, 'es_CL', 'es', 'ES');
                    $fechaVenc=Carbon::createMidnightDate($params_array['FechaVencimiento'],'Chile/Continental');
                    //$fechaVenc = $fechaVenc->format('Y-m-d');
                    $diaActual=Carbon::now();
                    $diaActual = $diaActual->format('Y-m-d');
                    $diaActual=Carbon::createMidnightDate($diaActual);
                ///$diaActual->toDateString();

                 $diffDias=$diaActual->diffInDays($fechaVenc);
            if($diffDias<30){

                Session::flash('error','Los Folios no pueden tener una fecha de vencimiento inferior a 30 dias');
                //return view('giftCard.index',compact('params_array'));
                return redirect()->route('indexGiftCard');
                //$diffDias >=30 || $diffDias <60
             }elseif($diffDias<60){
                $this->CrearFolio($params_array);

          $giftCreadas=DB::table('tarjeta_gift_card')
                ->orderBy('TARJ_ID', 'desc')
                ->take( $params_array['Cantidad'])
                ->get();

                Session::flash('warning','Folios Creados, pero su fecha de vencimiento es '.' '.$diffDias.' '.' dias se sugiere que sea superior a 60 dias  ');

                //return view('giftCard.FoliosCreados',compact('params_array','giftCreadas'));
                return \Redirect::route('Vfolios',['cant'=>$params_array['Cantidad']]);

             }elseif($diffDias>60){

                $this->CrearFolio($params_array);

                $giftCreadas=DB::table('tarjeta_gift_card')
                ->orderBy('TARJ_ID', 'desc')
                ->take( $params_array['Cantidad'])
                ->get();

                Session::flash('success','Folios Creados con exito!!!');

                //return view('giftCard.FoliosCreados',compact('params_array','giftCreadas'));
                return \Redirect::route('Vfolios',['cant'=>$params_array['Cantidad']]);

             }

        }

    //    $giftCreadas=DB::table('tarjeta_gift_card')
    //    ->orderBy('TARJ_ID', 'desc')
    //    ->take( $params_array['Cantidad'])
    //    ->get();


    //    $cantGift=DB::table('CantidadFolios')
    //    ->get();
       //dd($cantGift);


        // $date = Carbon::now();

        // $date->addMonth(6);
        // $date = $date->format('Y-m-d');
        // Session::flash('success','Folios Creados con Exito!!!');

        // return view('giftCard.Index',compact('date','params_array','cantGift','giftCreadas'));
       //return redirect()->route('generarGiftCard',$giftCreadas);

    }




    public function CrearFolio($params_array){
            $id=0;
            $idBD = DB::table('tarjeta_gift_card')->max('TARJ_ID');
            //dd($idBD);
            if(empty($idBD)){
            $id=1;
            }else{
            $id=$id+$idBD;
            $id=$id+1;
            }
            //dd($id);
            $cantidadIteracion= $params_array['Cantidad'];
            // dd( $cantidadIteracion);

            //dd($Ean13);
            // $cantidadIteracion= ;
            //$id= $params_array['hasta'];
            $date = Carbon::now();
            $date = $date->format('Y-m-d');
            // dd($date);
            $User= session()->get('nombre');
            $rem=1;
            try{

            DB::transaction(function () use ($date ,$User,$cantidadIteracion,$id,$params_array) {



            for ($i = 1; $i <= $cantidadIteracion; $i++)  {
            $Ean13= $this->ean13_check_digit($id);
            //dd($Ean13);
            $remplazo= substr($Ean13, -12);

            DB::table('tarjeta_gift_card')->insert([
                'TARJ_ID' => $id,
                'TARJ_CODIGO'=>$remplazo,
                'TARJ_MONTO_INICIAL'=>$params_array['Monto'],
                'TARJ_MONTO_ACTUAL'=>$params_array['Monto'],
                //'TARJ_FECHA_ACTIVACIÓN'=>$date,
                'TARJ_FECHA_VENCIMIENTO' =>$params_array['FechaVencimiento'],
                //'TARJ_RUT_USUARIO'=>$User,
                'TARJ_ESTADO'=>'C'
                ]);
                $id=$id+1;
            }


            }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno

            }catch(Exception $e){
            $cantGift=DB::table('CantidadFolios')
            ->get();
            // dd($e);
            $date = Carbon::now();
            //dd($date);
            $date->addMonth(6);
            $date = $date->format('Y-m-d');
            Session::flash('error','Algo ha salido mal intentalo nuevamente');

            return view('giftCard.Index',compact('date','cantGift'));

            } catch (\Throwable $e) {
            DB::rollBack();
            $date = Carbon::now();
            dd($e);
            $date->addMonth(6);
            $date = $date->format('Y-m-d');
            $cantGift=DB::table('CantidadFolios')
            ->get();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
            // dd($e,'2catch');
            return view('giftCard.Index',compact('date','cantGift'));
            }


    }

    public function CargarTablaCodigos($monto){ // carga los codigos para su posterior revicion o hacer giftcards preechas(activacion)
        //dd($monto);

        $giftCreadas=DB::table('tarjeta_gift_card')
       ->where('TARJ_MONTO_INICIAL',$monto)
       ->where('TARJ_ESTADO','C')
       ->get();

       $cantGift=DB::table('CantidadFolios')
       ->get();
      // dd($giftCreadas);

      return view('giftCard.Index',compact('giftCreadas','cantGift'));
    }




    public function IndexVentasGiftCard (){ // pantalla inicial de ventas carga solo el stock de giftcards


       $cantGift=DB::table('CantidadGiftCard')
       ->get();
     //  dd($cantGift);
        return view('giftCard.VentaSeleccion',compact('cantGift'));

    }

    public function CargarTablaCodigosVenta($monto){ //carga las giftcards seleccionadas en la tabla para posterios venta
        //dd($monto);

        $giftCreadas=DB::table('tarjeta_gift_card')
       ->where('TARJ_MONTO_INICIAL',$monto)
       ->where('TARJ_ESTADO','A')
       ->get();

       $cantGift=DB::table('CantidadGiftCard')
       ->get();
      // dd($giftCreadas);

      return view('giftCard.VentaSeleccion',compact('giftCreadas','cantGift'));
    }

    public function CargarVenta(Request $request){//  carga las giftcar seleccionadas en la pantalla para rellenar los datos de la venta
      // dd($request->all());
        $params_array = $request->all();
        //dd($params_array);
        unset( $params_array['_token']);
        if(empty($params_array)){
            Session::flash('info','ingrese nuevamente los datos');
            return redirect('Giftcard/VentasGiftCards');
        }
        $collection = Collection::make($vacio=[]);

        if($request->cantidad10 != null ){
            $cant=$request->cantidad10;
            // dd($cant);
             $gift10=DB::table('tarjeta_gift_card')
             ->where('TARJ_MONTO_INICIAL',10000)
             ->where('TARJ_ESTADO','A')
             ->take($cant)
             ->get();
            // dd($gift10);
            $collection = $collection->merge(Collection::make($gift10));

        }

        if($request->cantidad20 != null){
            $cant=$request->cantidad20;
           // dd($cant);
            $gift20=DB::table('tarjeta_gift_card')
            ->where('TARJ_MONTO_INICIAL',20000)
            ->where('TARJ_ESTADO','A')
            ->take($cant)
            ->get();
            //dd($gift20);
        $collection = $collection->merge(Collection::make($gift20));
        }
        //dd('fuera if');

        if($request->cantidad40 != null ){
            $cant=$request->cantidad40;
            // dd($cant);
             $gift40=DB::table('tarjeta_gift_card')
             ->where('TARJ_MONTO_INICIAL',40000)
             ->where('TARJ_ESTADO','A')
             ->take($cant)
             ->get();
             //dd($gift40);
             $collection = $collection->merge(Collection::make($gift40));
        }
        //dd($gift20,$gift40);

        if($request->cantidad60 != null){
            $cant=$request->cantidad60;
            // dd($cant);
             $gift60=DB::table('tarjeta_gift_card')
             ->where('TARJ_MONTO_INICIAL',60000)
             ->where('TARJ_ESTADO','A')
             ->take($cant)
             ->get();
            // dd($gift60);
            $collection = $collection->merge(Collection::make($gift60));
        }
        if($request->cantidad100 != null ){
            $cant=$request->cantidad100;
            // dd($cant);
             $gift100=DB::table('tarjeta_gift_card')
             ->where('TARJ_MONTO_INICIAL',100000)
             ->where('TARJ_ESTADO','A')
             ->take($cant)
             ->get();
            // dd($gift100);
            $collection = $collection->merge(Collection::make($gift100));

        }

       // dd($gift20,$gift40,$gift60,$gift100);
      // dd($collection);


        return view('giftCard.VentaGiftCard.VentaForm',compact('collection'));
    }



    public function VenderGiftcard(Request $request){  // captura los datos de la pantalla de asociacion de tarjetas con el cliente
        //dd($request->all(),'xd');                         // luego de eso deja las tarjetas vigentes para su posterior venta
       $params_array= $request->all();
        //dd($request->all());
        $validate = \Validator::make($params_array,[
            // 'Desde' =>'required',
            // 'hasta' =>'required',
            'nombreComprador' =>'required',
            'RutComprador'=>'required',
            // 'FechaVencimiento'=>'required',
        ]);


        if($validate->fails()){


            $errors = $validate->errors();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
           return view('giftCard.VentaEmpresa',compact('errors'));



        }else{

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

                try{
                DB::transaction(function () use ($TarjetasSeleccionadas,$Ncodigos,$date,$params_array,$cantidad,$User) {

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
                                    //'TARJ_FECHA_VENCIMIENTO' => $date,
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


                    }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno

                }catch(Exception $e){
                    DB::rollBack();

                    Session::flash('error','Algo ha salido mal intentalo nuevamente');
                   dd($e);
                    return view('giftCard.VentaSeleccion',compact('cantGift'));

                } catch (\Throwable $e) {
                    DB::rollBack();
                    dd($e);

                    Session::flash('error','Algo ha salido mal intentalo nuevamente');
                    // dd($e,'2catch');
                    return view('giftCard.VentaSeleccion');
                }

                // $cantGift=DB::table('CantidadGiftCard')
                // ->get();

                $idBD_vou = DB::table('tabla_voucher')->max('vou_folio');
                $dateVou = Carbon::now();
                $dateVou = $dateVou->format('d-m-Y');


                Session::flash('success','Tarjetas Vendidas con Exito!!!');
                return view('giftCard.Imprecion',compact('TarjetasSeleccionadas','dateVou','idBD_vou'));
        }

    }




    public function VentaEmpresaIndex(){


        return view('giftCard.VentaEmpresa');

    }

    public function VentaEmpresaFiltro(Request $request){

        //dd($request->all());
        $data[]=$request->Desde;
        $data[]=$request->Hasta;
        //dd($data,$data[0],$data[1]);

        $pruebaAct=DB::table('tarjeta_gift_card')
        ->whereBetween('TARJ_CODIGO', array($data))
        ->get();

        if(empty($pruebaAct->first())){
            Session::flash('info','No se han Encontrado tarjetas En el rango  ');
            return view('giftCard.VentaEmpresa');
        }

       // dd($pruebaAct);

        return view('giftCard.VentaEmpresa',compact('pruebaAct','data'));

    }

    public function ListarFiltroVentaEmpresa (Request $request){
        //dd('xdd');
           // dd($request->case);
           if(empty($request->case)){

            Session::flash('info','debe seleccionar minimo una tarjeta para vender');
            return view('giftCard.VentaEmpresa');

           }

            $collection=DB::table('tarjeta_gift_card')
            ->whereIn('TARJ_CODIGO',$request->case)
            ->get();


            return view('giftCard.VentaGiftCard.VentaForm',compact('collection'));

    }




    public function VentaEmpresa(Request $request){
        //dd($this->obtenerIDGiftcard());
        dd($request->all());
        $params_array = $request->all();
        //dd($params_array);
        unset( $params_array['_token']);
        if(empty($params_array)){
            Session::flash('info','ingrese nuevamente los datos');
            return redirect('Giftcard/VentaEmpresa');
        }

        $collection = Collection::make($vacio=[]);

        try{

            DB::beginTransaction();


            DB::commit();


        }catch(Exception $e){
            DB::rollBack();

        }catch (\Throwable $e) {

            DB::rollBack();

        }




        return view('giftCard.VentaEmpresa',compact('cantGift'));

    }



    public function Activacion2(){

        // $pruebaAct=DB::table('tarjeta_gift_card')
        // ->where('TARJ_ESTADO','C')
        // ->get();
        //dd($cantGift);
        return view ('giftCard.IngresoGiftCard');

    }
    public function Activacion3(){

        // $pruebaAct=DB::table('tarjeta_gift_card')
        // ->where('TARJ_ESTADO','C')
        // ->get();
        //dd($cantGift);
        return view ('giftCard.IngresoGiftCard');

    }

    public function Activacion3Redirect($desde,$hasta){
       // dd($desde,$hasta);

        $data[]=$desde;
        $data[]=$hasta;
        //dd($data,$data[0],$data[1]);

        $pruebaAct=DB::table('tarjeta_gift_card')
        ->whereBetween('TARJ_CODIGO', array($data))
        ->get();

        return view ('giftCard.IngresoGiftCard',compact('pruebaAct', 'data'));

    }

    public function ActivacionPost(Request $request){

     dd($request->all());
      //metodo que se encarga de la activacion de giftcards
            //dd($request->all());
           $params_array= $request->all();
          // dd($params_array);
          $cantGift=DB::table('CantidadGiftCard')
            ->get();

            $validate = \Validator::make($params_array,[
                // 'Desde' =>'required',
                // 'hasta' =>'required',
                //'Monto' =>'required',
                'Codigo'=>'required',
                 'FechaVencimiento'=>'required',
            ]);


            if($validate->fails()){

                $errors = $validate->errors();
                Session::flash('error','Algo ha salido mal intentalo nuevamente');
               return view('giftCard.IngresoGiftCard',compact('errors','cantGift'));


            }else{
                $id=0;
                $idBD = DB::table('tarjeta_gift_card')->max('TARJ_ID');
                //dd($idBD);
                if(empty($idBD)){
                    $id=1;
                }else{
                    $id=$id+$idBD;
                    $id=$id+1;
                }
                //dd($id);
              // $cantidadIteracion= $params_array['Cantidad'];
               // dd( $cantidadIteracion);

               //dd($Ean13);
              // $cantidadIteracion= ;
                //$id= $params_array['hasta'];
               $dateActual = Carbon::now();
               $dateActual = $dateActual->format('Y-m-d');

              // dd($date);
               $User= session()->get('nombre');
                $rem=1;
               try{

                DB::transaction(function () use ($dateActual ,$User,$id,$params_array) {



                           // for ($i = 1; $i <= $cantidadIteracion; $i++)  {
                              //  $Ean13= $this->ean13_check_digit($id);
                                //dd($Ean13);
                              // $remplazo= substr($Ean13, -12);

                              $updates = DB::table('tarjeta_gift_card')
                              ->where('TARJ_CODIGO', '=',$params_array['Codigo'])
                              ->where('TARJ_ESTADO','=','C')
                              ->update([
                                  'TARJ_FECHA_VENCIMIENTO' => $params_array['FechaVencimiento'],
                                  'TARJ_FECHA_ACTIVACIÓN'=>$dateActual,
                                  //'TARJ_COMPRADOR_NOMBRE' => $params_array['nombreComprador'],
                                  //'TARJ_COMPRADOR_RUT'=>$params_array['RutComprador'],
                                  'TARJ_ESTADO'=>'A',
                                  //'vou_folio_fk'=>$idVou
                              ]);

                              if($updates==0){

                                $cantGift=DB::table('XDDDDDDDDDDDDDDDD')
                                ->get();
                              }

                          /*
                                DB::table('tarjeta_gift_card')->insert([
                                    'TARJ_ID' => $id,
                                    'TARJ_CODIGO'=>$params_array['Codigo'],
                                    'TARJ_MONTO_INICIAL'=>$params_array['Monto'],
                                    'TARJ_MONTO_ACTUAL'=>$params_array['Monto'],
                                    'TARJ_FECHA_ACTIVACIÓN'=>$date,
                                     'TARJ_FECHA_VENCIMIENTO' =>$params_array['FechaVencimiento'],
                                    'TARJ_RUT_USUARIO'=>$User,
                                    'TARJ_ESTADO'=>'A'
                                    ]);
                                   // $id=$id+1;
                         //   }*/


                    }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno

                }catch(Exception $e){
                    $cantGift=DB::table('CantidadGiftCard')
                    ->get();
                    // dd($e);
                     $date = Carbon::now();
                     //dd($date);
                     $date->addMonth(6);
                     $date = $date->format('Y-m-d');
                     Session::flash('error','Algo ha salido mal intentalo nuevamente');

                     return view('giftCard.IngresoGiftCard',compact('cantGift'));//,compact('date','cantGift')

                } catch (\Throwable $e) {
                     DB::rollBack();
                     $date = Carbon::now();
                     //dd($e);
                     $date->addMonth(6);
                     $date = $date->format('Y-m-d');
                     $cantGift=DB::table('CantidadGiftCard')
                     ->get();
                     Session::flash('error','Algo ha salido mal intentalo nuevamente o la giftcard ya fue Activada');
                    // dd($e,'2catch');
                     return view('giftCard.IngresoGiftCard',compact('cantGift'));//,compact('date','cantGift')
                }

            }
            /*
           $giftCreadas=DB::table('tarjeta_gift_card')
           ->where('TARJ_COMPRADOR_RUT','=',$params_array['RutComprador'])
           ->orderBy('TARJ_ID', 'desc')
           ->take( $cantidadIteracion)
           ->get();*/


          $cantGift=DB::table('CantidadGiftCard')
           ->get();
           //dd($cantGift);




            $date = Carbon::now();

            $date->addMonth(6);
            $date = $date->format('Y-m-d');
            Session::flash('success','Tarjetas Activada con Exito!!!');

        return view('giftCard.IngresoGiftCard',compact('cantGift'));

    }


    public function FiltrarActivacion3( Request $request){

        //dd($request->all());
        $data[]=$request->Desde;
        $data[]=$request->Hasta;
        //dd($data,$data[0],$data[1]);

        $pruebaAct=DB::table('tarjeta_gift_card')
        ->whereBetween('TARJ_CODIGO', array($data))
        ->get();

        if(empty($pruebaAct->first())){
            Session::flash('info','No se han Encontrado tarjetas En el rango  ');
            return view('giftCard.IngresoGiftCard');
        }

       // dd($pruebaAct);

        return view('giftCard.IngresoGiftCard',compact('pruebaAct','data'));

    }

    public function ActivarRango(Request $request){
        //dd($request->all());
            $params_array= $request->all();

            $data[]=$request->Desde;
            $data[]=$request->Hasta;

            unset($params_array['_token']);
            unset($params_array['Desde']);
            unset($params_array['Hasta']);

            if(empty($params_array)){

                Session::flash('info','Debe seleccionar alguna tarjeta antes de activar ');
                return \Redirect::route('Activacion3.0');
            }
            $TarjetasSeleccionadas = DB::table('tarjeta_gift_card')
            ->whereIn('TARJ_CODIGO',$request->case )
            ->get();

            $pruebaAct=DB::table('tarjeta_gift_card')
            ->whereBetween('TARJ_CODIGO', array($data))
            ->get();

            $cantidad = count($TarjetasSeleccionadas);
            $seleccion = $request->case;
            $cantidad= $cantidad-1;
            $User= session()->get('nombre');
            $dateActual = Carbon::now();
            $dateActual = $dateActual->format('Y-m-d');
            //dd($TarjetasSeleccionadas,$cantidad);


            try{

            DB::transaction(function () use ($dateActual ,$User,$cantidad,$seleccion) {


            for ($i = 0; $i <= $cantidad; $i++){

                $bloqueoupdate = DB::table('tarjeta_gift_card')
                ->where('TARJ_CODIGO', $seleccion[$i])
                ->Update(['TARJ_ESTADO' => 'A',
                        'TARJ_RUT_USUARIO'=>$User,
                        'TARJ_FECHA_ACTIVACIÓN'=>$dateActual,
                ]);


                }
            }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno

        }catch(Exception $e){
            DB::rollBack();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
            dd($e);
            return view ('giftCard.IngresoGiftCard',compact('data'));//,compact('date','cantGift')

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Session::flash('error','Algo ha salido mal intentalo nuevamente o la giftcard ya fue Activada');

            return view ('giftCard.IngresoGiftCard',compact('data'));//,compact('date','cantGift')
        }



        Session::flash('success','Se Activaron las tarjetas correctamente');

        return \Redirect::route('ActivacionRedirect',['desde'=>$data[0],'hasta'=>$data[1]]);
        //return view ('giftCard.IngresoGiftCard',compact('pruebaAct','data'));
    }







    public function obtenerIDGiftcard (){
            $id=0;
            $idBD = DB::table('tarjeta_gift_card')->max('TARJ_ID');
            //dd($idBD);
            if(empty($idBD)){
                $id=1;
            }else{
                $id=$id+$idBD;
                $id=$id+1;
            }

            return $id;
    }


    public function vistaconsumotarjeta(){


        return view('giftCard.ConsumoTarjeta');


      }
      public function filtrarcambiotarjeta (Request $request){

        $codigo=$request->codigo;
        $consulta=DB::table('consumo_tarjeta')
        ->where('TARJ_CODIGO',$request->codigo)
        ->get();


        $consulta2=DB::table('tarjeta_gift_card')
        ->where('TARJ_CODIGO',$request->codigo)
        ->get();



        return view('giftCard.ConsumoTarjeta',compact('consulta','codigo','consulta2'));
      }



      public function BloqueoTarjetasIndex(){

        return view('giftCard.BloqueoTargetas');
    }





    public function filtrarbloqueo (Request $request){

        $estado[]='A';
        $estado[]='C';
        $estado[]='V';

        $rut=$request->codigo;

        $consulta = DB::table('tarjeta_gift_card')
        ->where('TARJ_COMPRADOR_RUT' ,'=', $rut)
        ->whereIn('TARJ_ESTADO',$estado)
        ->get();

        //hola

        return view('giftCard.BloqueoTargetas',compact('consulta'));
    }

    public function filtrarbloqueorango (Request $request){
        $estado[]='A';
        $estado[]='C';
        $estado[]='V';
        $desde=$request->desde;
        $hasta=$request->hasta;
        $consulta=DB::table('tarjeta_gift_card')
        ->whereBetween('TARJ_CODIGO', array($request->desde,$request->hasta))
        ->whereIn('TARJ_ESTADO',$estado)

        ->get();



        return view('giftCard.BloqueoTargetas',compact('consulta','desde','hasta'));
      }





      public function bloqueotrajeta (Request $request){


        // dd($request->all());

         $wea=$request->case;

         $conteo=count($request->case);
         $conteo = $conteo-1;


         $date = Carbon::now("Chile/Continental");

        for ($i = 0; $i <= $conteo; $i++){

        $bloqueoupdate = DB::table('tarjeta_gift_card')
        ->where('TARJ_CODIGO', $wea[$i])
        ->Update(['TARJ_MOTIVO_BLOQUEO' => $request->bloqueo,
                  'TARJ_ESTADO' => 'B',
                  'TARJ_FECHA_BLOQUEO' => $date,
                  'TARJ_USUARIO_BLOQUEO' => session()->get('nombre')


        ]);


        }


        Session::flash('success','Bloqueo Realizado');


        return view('giftCard.BloqueoTargetas');

      }







      public function detalletarjeta($fk_cargos){


        $detalle = DB::table('dcargos')
        ->join('cargos', 'CANMRO', '=', 'dcargos.DENMRO')
        ->where('CANMRO','=',$fk_cargos)
        ->get();

        return view('giftCard.DetallecompraGiftcard',compact('detalle'));


      }


    public function imprimir($giftcard){
        dd($giftcard);
       // dd($request->all());
        // $oculto = $request->oculto;
        // dd($oculto);

    }






















public function ListarGet(){
    return view('giftCard.VentaEmpresa');
}



     public  function ean13_check_digit($digits){
        //first change digits to a string so that we can access individual numbers
        //dd($digits);
        $digits =(string)$digits;
        $lengCadena= strlen($digits);
        $iteracion= 12-$lengCadena;
        $ceros='';
        for ($i =1 ; $i <= $iteracion; $i++) {
        $ceros .=''.'0';
        }
        //dd($ceros);

        $digits=$ceros.$digits;

        //dd($digits);
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        return $digits . $check_digit;


    }



    /* RESPALDO METODOS
    ------CARGA DE GIFTCARDS SELECIONADAS

    public function CargarVenta(Request $request){//  carga las giftcar seleccionadas en la pantalla para rellenar los datos de la venta
      dd($request->all());

        if(empty($request->all())){                  // caso contrario si se recarga devolvera  a la seleccion de giftcards
        //dd('nulo');
        $cantGift=DB::table('CantidadGiftCard')
        ->get();

        return view('giftCard.VentaSeleccion',compact('cantGift'));
      }

     // dd('no es nulo');
     // dd($request->tarjetas);
       //$collection = Collection::make($request->tarjetas);
       //dd($collection);

       $vender = DB::table('tarjeta_gift_card')
                    ->whereIn('TARJ_CODIGO',$request->tarjetas )
                    ->get();

                 // dd($request->tarjetas,$vender);

        return view('giftCard.VentaGiftCard.VentaForm',compact('vender'));
    }


    */

}
