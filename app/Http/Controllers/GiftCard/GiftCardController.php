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
      
        return view('giftCard.index',compact('idBD','date'));

    }

    
    public function generarGiftCard(Request $request){
        //dd($request->all());
       $params_array= $request->all();
      // dd($params_array);

        $validate = \Validator::make($params_array,[
            'Cantidad' =>'required',
            'Monto' =>'required',
            'FechaVencimiento'=>'required',
            'NombreComprador'=>'required',
            'FechaVencimiento'=>'required',
            'RutComprador'=>'required',
        ]);
        

        if($validate->fails()){

            $errors = $validate->errors();

           return view('giftCard.index',compact('errors'));


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
           $date = Carbon::now();
           $date = $date->format('Y-m-d');
           $User= session()->get('nombre');
          
           try{

            DB::transaction(function () use ($date ,$User,$cantidadIteracion,$id,$params_array) {
              
               

                        for ($i = 1; $i <= $cantidadIteracion; $i++)  {
                            $Ean13= $this->ean13_check_digit($id);

                            $gift= new \GiftCard();
                            $gift->TARJ_ID=$id;
                            $gift->TARJ_CODIGO=$Ean13;
                            $gift->TARJ_MONTO_INICIAL=$params_array['Monto'];
                            $gift->TARJ_MONTO_ACTUAL=$params_array['Monto'];
                            $gift->TARJ_FECHA_ACTIVACIÓN=$date;
                            $gift->TARJ_FECHA_VENCIMIENTO=$params_array['FechaVencimiento'];
                            $gift->TARJ_COMPRADOR_NOMBRE=$params_array['NombreComprador'];
                            $gift->TARJ_COMPRADOR_RUT=$params_array['RutComprador'];
                            $gift->TARJ_RUT_USUARIO=$User;
                            $gift->TARJ_ESTADO='V';
                            $gift->save();
                           

                            /*
                            DB::table('tarjeta_gift_card')->insert([
                                'TARJ_ID' => $id,
                                'TARJ_CODIGO'=>$Ean13,
                                'TARJ_MONTO_INICIAL'=>$params_array['Monto'],
                                'TARJ_MONTO_ACTUAL'=>$params_array['Monto'],
                                'TARJ_FECHA_ACTIVACIÓN'=>$date,
                                'TARJ_FECHA_VENCIMIENTO' =>$params_array['FechaVencimiento'],
                                'TARJ_COMPRADOR_NOMBRE'=> $params_array['NombreComprador'],
                                'TARJ_COMPRADOR_RUT'=>$params_array['RutComprador'],
                                'TARJ_RUT_USUARIO'=>$User,
                                'TARJ_ESTADO'=>'V'
                                ]);
                                $id=$id+1;*/
                        }
                        
                         
                }); // acepta un numero que es la cantidad de veces q intenta hacer el procedimietno 

            }catch(Exception $e){

                // dd($e);
                 $date = Carbon::now();
                 //dd($date);
                 $date->addMonth(6);
                 $date = $date->format('Y-m-d');
                 Session::flash('error','Algo ha salido mal intentalo nuevamente');
         
                 return view('giftCard.index',compact('date'));
     
            } catch (\Throwable $e) {
                 DB::rollBack();
                 $date = Carbon::now();
                 //dd($date);
                 $date->addMonth(6);
                 $date = $date->format('Y-m-d');
                 Session::flash('error','Algo ha salido mal intentalo nuevamente');
                // dd($e,'2catch');
                 return view('giftCard.index',compact('date'));
            }

        }

       /* $UltimasTagjetas = GiftCard::latest()
            ->take(5)
            ->get();
            dd($UltimasTagjetas);*/
       // dd($gift);
        $date = Carbon::now();
       
        $date->addMonth(6);
        $date = $date->format('Y-m-d');
        Session::flash('success','Tarjetas Creadas con Exito!!!');
        
        
        //dd('cagasteXDD');
        return view('giftCard.index',compact('date'));
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
