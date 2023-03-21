<?php

namespace App\Http\Controllers\Admin\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NotasCreditoProveedoresController extends Controller
{
    public function index(){

        /* $proveedores=DB::table('proveed')
        ->leftjoin('ciudades', 'proveed.PVCIUD', '=', 'ciudades.id')
        ->leftjoin('comunas', 'proveed.PVCOMU', '=', 'comunas.id')
        ->get(['PVRUTP as rut','PVNOMB as razon_social','PVDIRE as direccion','giro','ciudades.nombre as ciudad','comunas.nombre as comuna']); */
        $notas_credito = DB::table('nc_proveedor')->get();

        $fecha_hoy = date('Y-m-d');

        return view('admin.Compras.NotasCreditoProveedores', compact('notas_credito', 'fecha_hoy'));
    }

    public function insert(Request $request){

        $existe_factura = DB::table('compras')->where('folio', $request->get('folio_factura'))->first();

        $existe_nc = DB::table('nc_proveedor')
        ->where('rut', $request->get('rut_proveedor'))
        ->where('folio', $request->get('folio_nc'))->first();

        $nota_credito = ['rut' => $request->get('rut_proveedor'),
                    'razon_social' => strtoupper($request->get('razon_social')),
                    'folio' => $request->get('folio_nc'),
                    'folio_factura' => $request->get('folio_factura'),
                    'fecha_emision' => $request->get('fecha_emision_nc'),
                    'neto' => $request->get('neto_nc'),
                    'iva' => $request->get('iva_nc'),
                    'total' => $request->get('total_nc'),
                    'observacion' => $request->get('observacion_nc')
        ];

        if($existe_factura != null || $request->get('folio_factura') == null){
            if($existe_nc == null){
                DB::table('nc_proveedor')->insert($nota_credito);
                return redirect()->route('NotasCreditoProveedores')->with('success','Se ha Agregado la Nota Credito correctamente');
            }else{
                return redirect()->route('NotasCreditoProveedores')->with('warning','Nota Credito ya existe para este Proveedor');
            }
        }else{
            return redirect()->route('NotasCreditoProveedores')->with('warning','Folio de factura Inexistente');
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('nc_proveedor')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('NotasCreditoProveedores')->with('success','Nota Credito Eliminada');
    }

    public function xmlUpNC(Request $request){

        $url = $_FILES["myfile"]["tmp_name"];

        try{
            $xml = simplexml_load_file($url);
        }catch(\Throwable $th){
            return redirect()->route('ComprasProveedores')->with('warning','El Documento no corresponde a un archivo XML!');
        }

        $json = json_decode(json_encode($xml));
        //dd($json);

        if(empty($json->SetDTE)){
            return redirect()->route('ComprasProveedores')->with('warning','El Documento no corresponde al un formato DTE. No soportado!');
        }

        if($json->SetDTE->DTE->Documento->Encabezado->IdDoc->TipoDTE !== "61"){
            return redirect()->route('ComprasProveedores')->with('warning','El Documento no corresponde al un formato DTE de Nota de Credito. No soportado!');
        }

        $encabezado = $json->SetDTE->DTE->Documento->Encabezado;

        $detalle = $json->SetDTE->DTE->Documento->Detalle;

        if(!empty($json->SetDTE->DTE->Documento->Referencia)){
            $referencia = $json->SetDTE->DTE->Documento->Referencia;
        }

        $observacion = "";
        $folio_factura = "";

        if(!is_array($referencia)){
            if(!empty($referencia->RazonRef)){
                $observacion = $referencia->RazonRef;
            }
            $folio_factura = $referencia->FolioRef;
        }else{
            foreach($referencia as $item){
                if($item->TpoDocRef == "33"){
                    if(empty($item->RazonRef)){
                        $observacion = null;
                    }else{
                        $observacion = $item->RazonRef;
                    }
                    $folio_factura = $item->FolioRef;
                }
            }
        }

        if(!empty($encabezado->Totales->MntExe)){
            $encabezado->Totales->MntNeto = $encabezado->Totales->MntTotal;
            $encabezado->Totales->IVA = 0;
        }else{
            $encabezado->Totales->MntExe = null;
        }



        $existe = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->Folio);

        $nc = ['folio' => $encabezado->IdDoc->Folio,
                    'fecha_emision' => $encabezado->IdDoc->FchEmis,
                    'rut' => strtoupper($encabezado->Emisor->RUTEmisor),
                    'razon_social' => strtoupper($encabezado->Emisor->RznSoc),
                    'neto' => $encabezado->Totales->MntNeto,
                    'iva' => $encabezado->Totales->IVA,
                    'total' => $encabezado->Totales->MntTotal,
                    'folio_factura' => ltrim($folio_factura, "0"),
                    'observacion' => strtoupper($observacion)
            ];

            $nc += [ 'xml' => $request->file('myfile')->store('dte') ];

        if($existe == null){

            DB::table('nc_proveedor')->insert($nc);

            return redirect()->route('NotasCreditoProveedores')->with('success','Se ha Agregado el Documento correctamente');
        }else{
            return redirect()->route('NotasCreditoProveedores')->with('warning','Documento ya existe para este Proveedor');
        }
    }

    public function buscaDte($rut, $folio){

        $nc = DB::table('nc_proveedor')
        ->where('rut', $rut)
        ->where('folio', $folio)->first();

        return $nc;
    }
}

