<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReIngresarStockEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnulacionDocumentosRequest;
use App\Modelos\Cargos;
use App\Modelos\Dcargos;
use App\Modelos\Dte_hex;
use App\Modelos\MetodosDePago\CuentaCliente_xCobrar;
use App\Modelos\PagoEfectivo;
use App\Modelos\ProductosEnTrancito\Bodeprod;
use App\Modelos\TarjetaCredito;
use Faker\Test\Provider\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

class AnulacionDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.AnulacionDeDocumentos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnulacionDocumentosRequest $request)
    {
        $pago_efectivo=[];
        $pago_transferencia=[];
        $pago_tarjeta =[];
        $x_cobrar =[];

        $cargos = Cargos::where('canmro', $request->folio)
            ->where('catipo', $request->tipo_documento)
            ->where('cavalo', $request->valor_documento)
            ->where('cafeco', $request->fecha)
            ->first();
       // dd($cargos);

        if (is_null($cargos)) {
            return back()->with("flash", "Documento no encontrado!!")->withInput();
        }

        $dcargos = DB::table('dcargos')
            ->where('denmro', $cargos->CANMRO)
            ->where('detipo', $request->tipo_documento)
            ->where('defeco', $request->fecha)
            ->get();
        //dd($dcargos);


        switch ($request->pago) {
            case 'efectivo':
                $pago_efectivo = PagoEfectivo::where('nro_doc', $cargos->CANMRO)
                    ->where('fecha', $request->fecha)
                    ->where('monto', $request->valor_documento)
                    ->first();

                if (is_null($pago_efectivo)) {
                    return back()->with("flash", "el Documento " . $cargos->CANMRO . " no fue pagado en efectivo")->withInput();
                }

                break;
            case 'tarjeta':
                $pago_tarjeta = TarjetaCredito::where('nro_doc', $cargos->CANMRO)
                    ->where('fecha', $request->fecha)
                    ->where('monto', $request->valor_documento)
                    ->first();

                if (is_null($pago_tarjeta)) {
                    return back()->with("flash", "el Documento " . $cargos->CANMRO . " no fue pagado con tarjeta")->withInput();
                }
                break;
            case 'transferencia':
                $pago_transferencia = DB::table('pago_transferencia')->where('nro_doc', $cargos->CANMRO)
                    ->where('fecha', $request->fecha)
                    ->where('monto', $request->valor_documento)
                    ->first();

                if (is_null($pago_transferencia)) {
                    return back()->with("flash", "el Documento " . $cargos->CANMRO . " no fue pagado con transferencia")->withInput();
                }
                break;
            case 'cobrar':
                $x_cobrar = CuentaCliente_xCobrar::where('CCPDOCUMEN', $cargos->CANMRO)
                    ->where('CCPFECHAHO', $request->fecha)
                    ->where('CCPRUTCLIE', substr($request->rut, 0, -2))
                    ->first();

                if (is_null($x_cobrar)) {
                    return back()->with("flash", "el Documento " . $cargos->CANMRO . " no fue pagado por cobrar o el rut" . $request->rut . "no esta registrado en el DTE")->withInput();
                }
                break;
            case null:

                    return back()->with("flash", "Selecione un metodo de pago ")->withInput();

                break;

            default:
                return back()->with("flash", "Todo lo que podia salir mal, salio mal:C comuniquese con el administrador")->withInput();
                break;
        }


        try {

            for ($i = 0; $i < sizeof($dcargos); $i++) {

                //dd($dcargos[$i]->DECODI, $dcargos[$i]->DECANT);

                $sala = Bodeprod::where('bpprod', $dcargos[$i]->DECODI)->first();

                if (is_null($sala)) {
                } else {
                    $sala->bpsrea = $sala->bpsrea + $dcargos[$i]->DECANT;
                    $sala->save();
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            return back()->with("flash", "problemas con el re ingreso de mercaderia")->withInput();
        }

        //dd($pago_efectivo, $pago_tarjeta, $x_cobrar, !empty($pago_efectivo), !empty($pago_tarjeta), !empty($x_cobrar));
        $dte_hex = Dte_hex::where('folio',$cargos->CANMRO)->where('fecha',$request->fecha)->delete();


        $dcargos = DB::table('dcargos')
            ->where('denmro', $cargos->CANMRO)
            ->where('detipo', $request->tipo_documento)
            ->where('defeco', $request->fecha)
            ->delete();

        $cargos->delete();

        if (!empty($pago_efectivo)) {
            $pago_efectivo->delete();
        }elseif (!empty($pago_transferencia)){
            $pago_transferencia = DB::table('pago_transferencia')->where('id', $pago_transferencia->id)->delete();
        }elseif (!empty($pago_tarjeta)) {
            $pago_tarjeta->delete();
        } elseif (!empty($x_cobrar)) {
            $x_cobrar->delete();
        }




        return  redirect()->route('AnulacionDocs')->with('success','Se ha eliminado el documento');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
