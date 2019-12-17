<?php

namespace App\Http\Controllers\GiftCard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GiftCard;
use DB;
use Carbon\Carbon;
use Session;

class GiftCardController extends Controller
{
 

    public function index(){
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
        $cantGift=DB::table('CantidadGiftCard')
        ->get();
      
        return view('giftCard.index',compact('idBD','date','cantGift'));

    }

    
    public function generarGiftCard(Request $request){
        //dd($request->all());
       $params_array= $request->all();
      // dd($params_array);
      $cantGift=DB::table('CantidadGiftCard')
        ->get();

        $validate = \Validator::make($params_array,[
            // 'Desde' =>'required',
            // 'hasta' =>'required',
            'Monto' =>'required',
            'Cantidad'=>'required',
            // 'FechaVencimiento'=>'required',
        ]);
        

        if($validate->fails()){

            $errors = $validate->errors();
            Session::flash('error','Algo ha salido mal intentalo nuevamente');
           return view('giftCard.index',compact('errors','cantGift'));


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
           $cantidadIteracion= $params_array['Cantidad'];
           // dd( $cantidadIteracion);
           
           //dd($Ean13);
          // $cantidadIteracion= ;
            //$id= $params_array['hasta'];
           $date = Carbon::now();
           $date = $date->format('Y-m-d');
           $User= session()->get('nombre');
          
           try{

            DB::transaction(function () use ($date ,$User,$cantidadIteracion,$id,$params_array) {
              
               

                        for ($i = 1; $i <= $cantidadIteracion; $i++)  {
                            $Ean13= $this->ean13_check_digit($id);
                            
                            DB::table('tarjeta_gift_card')->insert([
                                'TARJ_ID' => $id,
                                'TARJ_CODIGO'=>$Ean13,
                                'TARJ_MONTO_INICIAL'=>$params_array['Monto'],
                                'TARJ_MONTO_ACTUAL'=>$params_array['Monto'],
                                'TARJ_FECHA_ACTIVACIÓN'=>$date,
                                // 'TARJ_FECHA_VENCIMIENTO' =>$params_array['FechaVencimiento'],
                                'TARJ_RUT_USUARIO'=>$User,
                                'TARJ_ESTADO'=>'A'
                                ]);
                                $id=$id+1;
                        }
                        
                         
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
         
                 return view('giftCard.index',compact('date','cantGift'));
     
            } catch (\Throwable $e) {
                 DB::rollBack();
                 $date = Carbon::now();
                 //dd($date);
                 $date->addMonth(6);
                 $date = $date->format('Y-m-d');
                 $cantGift=DB::table('CantidadGiftCard')
                 ->get();
                 Session::flash('error','Algo ha salido mal intentalo nuevamente');
                // dd($e,'2catch');
                 return view('giftCard.index',compact('date','cantGift'));
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
        Session::flash('success','Tarjetas Creadas con Exito!!!');
    
        return view('giftCard.index',compact('date','params_array','cantGift'));

    }

    public function CargarTablaCodigos($monto){
        //dd($monto);

        $giftCreadas=DB::table('tarjeta_gift_card')
       ->where('TARJ_MONTO_INICIAL',$monto)
       ->where('TARJ_ESTADO','A')
       ->get();

       $cantGift=DB::table('CantidadGiftCard')
       ->get();
      // dd($giftCreadas);

      return view('giftCard.index',compact('giftCreadas','cantGift'));
    }




    public function IndexVentasGiftCard (){

        
       $cantGift=DB::table('CantidadGiftCard')
       ->get();
        return view('giftCard.VentaGiftCards',compact('cantGift'));

    }

    public function CargarTablaCodigosVenta($monto){
        //dd($monto);

        $giftCreadas=DB::table('tarjeta_gift_card')
       ->where('TARJ_MONTO_INICIAL',$monto)
       ->where('TARJ_ESTADO','A')
       ->get();

       $cantGift=DB::table('CantidadGiftCard')
       ->get();
      // dd($giftCreadas);

      return view('giftCard.VentaGiftCards',compact('giftCreadas','cantGift'));
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
          


        $rut=$request->codigo;

        $consulta = DB::table('tarjeta_gift_card')
        ->where('TARJ_ESTADO', '=', 'V')
        ->where('TARJ_COMPRADOR_RUT' ,'=', $rut)
        ->get();

        return view('giftCard.BloqueoTargetas',compact('consulta'));
      }





      public function bloqueotrajeta (Request $request){


        
         $wea=$request->case;

         $conteo=count($request->case);
         $conteo = $conteo-1;


        for ($i = 0; $i <= $conteo; $i++){

        $bloqueoupdate = DB::table('tarjeta_gift_card')
        ->where('TARJ_CODIGO', $wea[$i])
        ->Update(['TARJ_MOTIVO_BLOQUEO' => $request->bloqueo,
                  'TARJ_ESTADO' => 'B'


        ]);
        

        }


        Session::flash('success','Bloqueo Realizado');

    
        return view('giftCard.BloqueoTargetas');

      }







      public function detalletarjeta($fk_cargos){


        $detalle = DB::table('dcargos')
        ->where('id_cargos','=',$fk_cargos)
        ->get();

        return view('giftCard.DetallecompraGiftcard',compact('detalle'));
          
        
      }








    public function imprimir($giftcard){
        dd($giftcard);
       // dd($request->all());
        // $oculto = $request->oculto;
        // dd($oculto);

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
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        return $digits . $check_digit;
    
    
    }


}
