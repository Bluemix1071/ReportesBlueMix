<?php

namespace App\Http\Controllers\Admin\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComprasProveedoresController extends Controller
{
    public function index(){

        $proveedores=DB::table('proveed')
        ->leftjoin('ciudades', 'proveed.PVCIUD', '=', 'ciudades.id')
        ->leftjoin('comunas', 'proveed.PVCOMU', '=', 'comunas.id')
        ->get(['PVRUTP as rut','PVNOMB as razon_social','PVDIRE as direccion','giro','ciudades.nombre as ciudad','comunas.nombre as comuna']);

        //dd($proveedores);
        $comunas = DB::table('comunas')->groupBy('nombre')->get();

        $ciudades = DB::table('ciudades')->groupBy('nombre')->get();

        return view('admin.Compras.ComprasProveedores', compact('proveedores', 'ciudades', 'comunas'));
    }

    public function xmlUp(Request $request){

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
        if(is_array($json->SetDTE->DTE)){
            $agregados = 0;
            foreach($json->SetDTE->DTE as $array_json){
                if($array_json->Documento->Encabezado->IdDoc->TipoDTE !== "33" && $array_json->Documento->Encabezado->IdDoc->TipoDTE !== "34"){
                    return redirect()->route('ComprasProveedores')->with('warning','El Documento no corresponde al un formato DTE de Factura. No soportado!');
                }
                
                $encabezado = $array_json->Documento->Encabezado;
                
                $detalle = $array_json->Documento->Detalle;
                
                if(empty($encabezado->IdDoc->FmaPago)){
                    $encabezado->IdDoc->FmaPago = 1;
                }
                if(empty($encabezado->IdDoc->FchVenc) && $encabezado->IdDoc->FmaPago == "2"){
                    $fecha = strtotime('+1 month', strtotime($encabezado->IdDoc->FchEmis));
                    $encabezado->IdDoc->FchVenc = date('Y-m-d', $fecha);
                }
                if(!empty($array_json->Documento->Referencia)){
                    $referencia = $array_json->Documento->Referencia;
                }
                if(empty($encabezado->IdDoc->FchVenc)){
                    $encabezado->IdDoc->FchVenc = null;
                }
                if(empty($encabezado->IdDoc->FchVenc) && $encabezado->IdDoc->FmaPago == "1"){
                    $encabezado->IdDoc->FchVenc = $encabezado->IdDoc->FchEmis;
                }
                if(empty($encabezado->Emisor->CiudadOrigen) || is_object($encabezado->Emisor->CiudadOrigen)){
                    $encabezado->Emisor->CiudadOrigen = null;
                }
                /* if(empty($encabezado->IdDoc->FmaPago)){
                    $encabezado->IdDoc->FmaPago = 2;
                } */
                if(!empty($encabezado->Totales->MntExe)){
                    $encabezado->Totales->MntNeto = $encabezado->Totales->MntTotal;
                    $encabezado->Totales->IVA = 0;
                }else{
                    $encabezado->Totales->MntExe = null;
                }
                
                $i = 0;
                $o = 0;
        
                $compra = ['folio' => $encabezado->IdDoc->Folio,
                            'fecha_emision' => $encabezado->IdDoc->FchEmis,
                            'fecha_venc' => $encabezado->IdDoc->FchVenc,
                            'tipo_dte' => $encabezado->IdDoc->TipoDTE,
                            'tpo_pago' =>  $encabezado->IdDoc->FmaPago,
                            'rut' => strtoupper($encabezado->Emisor->RUTEmisor),
                            'razon_social' => strtoupper($encabezado->Emisor->RznSoc),
                            'giro' => strtoupper($encabezado->Emisor->GiroEmis),
                            'direccion' => strtoupper($encabezado->Emisor->DirOrigen),
                            'comuna' => strtoupper($encabezado->Emisor->CmnaOrigen),
                            'ciudad' => strtoupper($encabezado->Emisor->CiudadOrigen),
                            'neto' => $encabezado->Totales->MntNeto,
                            'mnto_exento' => $encabezado->Totales->MntExe,
                            'iva' => $encabezado->Totales->IVA,
                            'total' => $encabezado->Totales->MntTotal
                    ];
        
                    /* if($request->hasFile('myfile')){
                        $file = $request->file('myfile')->store('dte');
                        $name = time().$file->getClientOriginalName();
                        $file->move(public_path().'/dte/',$name);
                        $compra += [ 'xml' => $request->file('myfile')->store('dte'); ];
                    } */
        
                $existe = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);
                
                if($existe == null){
                    $compra += [ 'xml' => $request->file('myfile')->store('dte') ];
                    DB::table('compras')->insert($compra);
                    $ultima_compra = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);
        
                    if(!empty($detalle)){
                        if(is_array($detalle)){
                            foreach($detalle as $item){
                                $codigo = "";
                                if(!empty($item->CdgItem)){
                                    if(is_array($item->CdgItem)){
                                        $codigo = $item->CdgItem[0]->VlrCodigo;
                                    }else{
                                        $codigo = $item->CdgItem->VlrCodigo;
                                    }
                                }
                                if(empty($item->UnmdItem)){
                                    $item->UnmdItem = 'C/U';
                                }
                                if(empty($item->QtyItem)){
                                    $item->QtyItem = 1;
                                }
                                if(empty($item->PrcItem)){
                                    $item->PrcItem = $item->MontoItem;
                                }
                                    
                                $detalles = ['codigo' => $codigo,
                                                'nombre' => $item->NmbItem,
                                                'descripcion' => $item->NmbItem,
                                                'cantidad' => $item->QtyItem,
                                                'tpo_uni' => $item->UnmdItem,
                                                'precio' => $item->PrcItem,
                                                'total_neto' => $item->MontoItem,
                                                'id_compras' => $ultima_compra->id
                                ];
                                //error_log(print_r($referencias, true));
                                DB::table('compras_detalles')->insert($detalles);
                            }
                        }else{
                            $codigo = "";
                            if(!empty($item->CdgItem)){
                                if(is_array($detalle->CdgItem)){
                                    $codigo = $detalle->CdgItem[0]->VlrCodigo;
                                }else{
                                    $codigo = $detalle->CdgItem->VlrCodigo;
                                }
                            }
                            if(empty($detalle->UnmdItem)) {
                                $detalle->UnmdItem = 'C/U';
                            }
                            if(empty($detalle->QtyItem)){
                                $detalle->QtyItem = 1;
                            }
                            if(empty($detalle->PrcItem)){
                                $detalle->PrcItem = $detalle->MontoItem;
                            }
        
                            $detalles = ['codigo' => $codigo,
                                            'nombre' => $detalle->NmbItem,
                                            'descripcion' => $detalle->NmbItem,
                                            'cantidad' => $detalle->QtyItem,
                                            'tpo_uni' => $detalle->UnmdItem,
                                            'precio' => $detalle->PrcItem,
                                            'total_neto' => $detalle->MontoItem,
                                            'id_compras' => $ultima_compra->id
                            ];
                                
                            DB::table('compras_detalles')->insert($detalles);
                        }
                    }
        
                    if(!empty($referencia)){
                        if(is_array($referencia)){
                            foreach($referencia as $item){
                                $i++;
                                $referencias = ['n_linea' => $i,
                                                'tpo_doc_ref' => $item->TpoDocRef,
                                                'folio' => $item->FolioRef,
                                                'fecha_ref' => $item->FchRef,
                                                'id_compra' => $ultima_compra->id
                                ];
                                //error_log(print_r($referencias, true));
                                DB::table('referencias')->insert($referencias);
                            }
                        }else{
                            $referencias = ['n_linea' => 1,
                                            'tpo_doc_ref' => $referencia->TpoDocRef,
                                            'folio' => $referencia->FolioRef,
                                            'fecha_ref' => $referencia->FchRef,
                                            'id_compra' => $ultima_compra->id
                            ];
                                
                            DB::table('referencias')->insert($referencias);
                        }
                    }
                    error_log(print_r("Se ha Agregado el Documento correctamente", true));
                    $agregados++;
                    //return redirect()->route('ComprasProveedores')->with('success','Se ha Agregado el Documento correctamente');
                }else{
                    error_log(print_r("Documento ya existe para este Proveedor", true));
                    //return redirect()->route('ComprasProveedores')->with('warning','Documento ya existe para este Proveedor');
                }
            }
            //--------------------------------------------------------------------------------------------------------------------------------
            return redirect()->route('ComprasProveedores')->with('success','El Documento es un agrupado de DTEs. Agregados '.$agregados.' de '.count($json->SetDTE->DTE).'.');
        }else{

        if($json->SetDTE->DTE->Documento->Encabezado->IdDoc->TipoDTE !== "33" && $json->SetDTE->DTE->Documento->Encabezado->IdDoc->TipoDTE !== "34"){
            return redirect()->route('ComprasProveedores')->with('warning','El Documento no corresponde al un formato DTE de Factura. No soportado!');
        }
        
        $encabezado = $json->SetDTE->DTE->Documento->Encabezado;
        
        $detalle = $json->SetDTE->DTE->Documento->Detalle;
        
        if(empty($encabezado->IdDoc->FmaPago)){
            $encabezado->IdDoc->FmaPago = 1;
        }
        if(empty($encabezado->IdDoc->FchVenc) && $encabezado->IdDoc->FmaPago == "2"){
            $fecha = strtotime('+1 month', strtotime($encabezado->IdDoc->FchEmis));
            $encabezado->IdDoc->FchVenc = date('Y-m-d', $fecha);
        }
        if(!empty($json->SetDTE->DTE->Documento->Referencia)){
            $referencia = $json->SetDTE->DTE->Documento->Referencia;
        }
        if(empty($encabezado->IdDoc->FchVenc)){
            $encabezado->IdDoc->FchVenc = null;
        }
        if(empty($encabezado->IdDoc->FchVenc) && $encabezado->IdDoc->FmaPago == "1"){
            $encabezado->IdDoc->FchVenc = $encabezado->IdDoc->FchEmis;
        }
        if(empty($encabezado->Emisor->CiudadOrigen) || is_object($encabezado->Emisor->CiudadOrigen)){
            $encabezado->Emisor->CiudadOrigen = null;
        }
        /* if(empty($encabezado->IdDoc->FmaPago)){
            $encabezado->IdDoc->FmaPago = 2;
        } */
        if(!empty($encabezado->Totales->MntExe)){
            $encabezado->Totales->MntNeto = $encabezado->Totales->MntTotal;
            $encabezado->Totales->IVA = 0;
        }else{
            $encabezado->Totales->MntExe = null;
        }
        
        $i = 0;
        $o = 0;

        $compra = ['folio' => $encabezado->IdDoc->Folio,
                    'fecha_emision' => $encabezado->IdDoc->FchEmis,
                    'fecha_venc' => $encabezado->IdDoc->FchVenc,
                    'tipo_dte' => $encabezado->IdDoc->TipoDTE,
                    'tpo_pago' =>  $encabezado->IdDoc->FmaPago,
                    'rut' => strtoupper($encabezado->Emisor->RUTEmisor),
                    'razon_social' => strtoupper($encabezado->Emisor->RznSoc),
                    'giro' => strtoupper($encabezado->Emisor->GiroEmis),
                    'direccion' => strtoupper($encabezado->Emisor->DirOrigen),
                    'comuna' => strtoupper($encabezado->Emisor->CmnaOrigen),
                    'ciudad' => strtoupper($encabezado->Emisor->CiudadOrigen),
                    'neto' => $encabezado->Totales->MntNeto,
                    'mnto_exento' => $encabezado->Totales->MntExe,
                    'iva' => $encabezado->Totales->IVA,
                    'total' => $encabezado->Totales->MntTotal
            ];

            /* if($request->hasFile('myfile')){
                $file = $request->file('myfile')->store('dte');
                $name = time().$file->getClientOriginalName();
                $file->move(public_path().'/dte/',$name);
                $compra += [ 'xml' => $request->file('myfile')->store('dte'); ];
            } */

        $existe = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);
        
        if($existe == null){
            $compra += [ 'xml' => $request->file('myfile')->store('dte') ];
            DB::table('compras')->insert($compra);
            $ultima_compra = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);

            if(!empty($detalle)){
                if(is_array($detalle)){
                    foreach($detalle as $item){
                        $codigo = "";
                        if(!empty($item->CdgItem)){
                            if(is_array($item->CdgItem)){
                                $codigo = $item->CdgItem[0]->VlrCodigo;
                            }else{
                                $codigo = $item->CdgItem->VlrCodigo;
                            }
                        }
                        if(empty($item->UnmdItem)){
                            $item->UnmdItem = 'C/U';
                        }
                        if(empty($item->QtyItem)){
                            $item->QtyItem = 1;
                        }
                        if(empty($item->PrcItem)){
                            $item->PrcItem = $item->MontoItem;
                        }
                            
                        $detalles = ['codigo' => $codigo,
                                        'nombre' => $item->NmbItem,
                                        'descripcion' => $item->NmbItem,
                                        'cantidad' => $item->QtyItem,
                                        'tpo_uni' => $item->UnmdItem,
                                        'precio' => $item->PrcItem,
                                        'total_neto' => $item->MontoItem,
                                        'id_compras' => $ultima_compra->id
                        ];
                        //error_log(print_r($referencias, true));
                        DB::table('compras_detalles')->insert($detalles);
                    }
                }else{
                    $codigo = "";
                    if(!empty($item->CdgItem)){
                        if(is_array($detalle->CdgItem)){
                            $codigo = $detalle->CdgItem[0]->VlrCodigo;
                        }else{
                            $codigo = $detalle->CdgItem->VlrCodigo;
                        }
                    }
                    if(empty($detalle->UnmdItem)) {
                        $detalle->UnmdItem = 'C/U';
                    }
                    if(empty($detalle->QtyItem)){
                        $detalle->QtyItem = 1;
                    }
                    if(empty($detalle->PrcItem)){
                        $detalle->PrcItem = $detalle->MontoItem;
                    }

                    $detalles = ['codigo' => $codigo,
                                    'nombre' => $detalle->NmbItem,
                                    'descripcion' => $detalle->NmbItem,
                                    'cantidad' => $detalle->QtyItem,
                                    'tpo_uni' => $detalle->UnmdItem,
                                    'precio' => $detalle->PrcItem,
                                    'total_neto' => $detalle->MontoItem,
                                    'id_compras' => $ultima_compra->id
                    ];
                        
                    DB::table('compras_detalles')->insert($detalles);
                }
            }

            if(!empty($referencia)){
                if(is_array($referencia)){
                    foreach($referencia as $item){
                        $i++;
                        $referencias = ['n_linea' => $i,
                                        'tpo_doc_ref' => $item->TpoDocRef,
                                        'folio' => $item->FolioRef,
                                        'fecha_ref' => $item->FchRef,
                                        'id_compra' => $ultima_compra->id
                        ];
                        //error_log(print_r($referencias, true));
                        DB::table('referencias')->insert($referencias);
                    }
                }else{
                    $referencias = ['n_linea' => 1,
                                    'tpo_doc_ref' => $referencia->TpoDocRef,
                                    'folio' => $referencia->FolioRef,
                                    'fecha_ref' => $referencia->FchRef,
                                    'id_compra' => $ultima_compra->id
                    ];
                        
                    DB::table('referencias')->insert($referencias);
                }
            }
            return redirect()->route('ComprasProveedores')->with('success','Se ha Agregado el Documento correctamente');
        }else{
            return redirect()->route('ComprasProveedores')->with('warning','Documento ya existe para este Proveedor');
        }
    }
        //printf("</br>".$json);
        /* printf("</br>".$xml->Documento->Encabezado->Emisor->RznSoc);

         foreach($xml->Documento->Detalle as $item){
            printf("</br>".$item->NmbItem);
            printf("</br>".$item->MontoItem);
         } */
    }

    public function insert(Request $request){
        $body = $request->request;
        $o = 0;
        $referencia = [];
        $detalle = [];

        $compra = ['folio' => $body->get('folio'),
                    'fecha_emision' => $body->get('fecha_emision'),
                    'fecha_venc' => $body->get('fecha_vencimiento'),
                    'tipo_dte' => 33,
                    'tpo_pago' =>  $body->get('tipo_documento'),
                    'rut' => strtoupper($body->get('rut')),
                    'razon_social' => strtoupper($body->get('razon_social')),
                    'giro' => strtoupper($body->get('giro')),
                    'direccion' => strtoupper($body->get('direccion')),
                    'comuna' => strtoupper($body->get('comuna')),
                    'ciudad' => strtoupper($body->get('ciudad')),
                    'neto' => $body->get('neto'),
                    'iva' => $body->get('iva'),
                    'total' => $body->get('total')
            ];

            $existe = $this->buscaDte($body->get('rut'), 33, $body->get('folio'));
    
            if($existe == null){
                DB::table('compras')->insert($compra);
                $ultima_compra = $this->buscaDte($body->get('rut'), 33, $body->get('folio'));
                if(!empty($body->get('referencias'))){
                    $referencias = $body->get('referencias');
                    foreach($referencias as $item){
                            $o++;
                            $referencia = ['n_linea' => $o,
                                        'tpo_doc_ref' => $item[0],
                                        'folio' => $item[1],
                                        'fecha_ref' => $item[2],
                                        'id_compra' => $ultima_compra->id
                            ];
                            //error_log(print_r($referencia, true));
                            DB::table('referencias')->insert($referencia);
                    }
                }
                if(!empty($body->get('detalles'))){
                    $detalles = $body->get('detalles');
                    foreach($detalles as $item){
                            $detalle = ['codigo' => $item[0],
                                    'nombre' => $item[1],
                                    'descripcion' => $item[1],
                                    'cantidad' => $item[2],
                                    'tpo_uni' => $item[3],
                                    'precio' => $item[4],
                                    'total_neto' => $item[5],
                                    'id_compras' => $ultima_compra->id
                            ];
                            //error_log(print_r($referencia, true));
                            DB::table('compras_detalles')->insert($detalle);
                    }
                }
                return redirect()->route('ComprasProveedores')->with('success','Se ha Agregado el Documento correctamente');
            }else{
                return redirect()->route('ComprasProveedores')->with('warning','Documento ya existe para este Proveedor');
            }
    }

    public function buscaDte($rut, $tipo, $folio){
        
        $ultima_compra = DB::table('compras')
        ->where('rut', $rut)
        ->where('tipo_dte', $tipo)
        ->where('folio', $folio)->first();

        return $ultima_compra;
    }

    public function list(){

        $max = date('Y-m-d');

        $min = date("Y-m-d",strtotime($max."- 1 month"));

        $compras =DB::table('compras')->where('estado_verificacion', 2)->whereBetween('fecha_emision', [$min, $max])->get();

        return view('admin.Compras.ListarComprasProveedores', compact('compras', 'max', 'min'));
    }

    public function listFecha(Request $request){

        $max = $request->get('max');

        $min = $request->get('min');

        $compras =DB::table('compras')->where('estado_verificacion', 2)->whereBetween('fecha_emision', [$min, $max])->get();

        return view('admin.Compras.ListarComprasProveedores', compact('compras', 'max', 'min'));
    }

    public function editar(Request $request){

        if($request->get('id') == null){
            $compra = DB::table('compras')->where('rut', 'like', $request->get('rut').'%')->where('folio', $request->get('folio'))->get()->first();
        }else{
            $compra = DB::table('compras')->where('id', $request->get('id'))->get()->first();
        }

        if($compra != null){
            //dd($compra->id);
            $detalles = DB::table('compras_detalles')->where('id_compras', $compra->id)->get();
    
            $referencias = DB::table('referencias')->where('id_compra', $compra->id)->get();
    
            $proveedores=DB::table('proveed')
            ->leftjoin('ciudades', 'proveed.PVCIUD', '=', 'ciudades.id')
            ->leftjoin('comunas', 'proveed.PVCOMU', '=', 'comunas.id')
            ->get(['PVRUTP as rut','PVNOMB as razon_social','PVDIRE as direccion','giro','ciudades.nombre as ciudad','comunas.nombre as comuna']);
    
            return view('admin.Compras.EditarCompraProveedores', compact('proveedores', 'compra', 'referencias', 'detalles'));
        }else{
            return redirect()->route('ListarIngresos')->with('warning','Documento no existe para este Proveedor');
        }
    }

    public function update(Request $request){
        $body = $request->request;
        $i = 0;
        $o = 0;
        //$referencias = [];

        $compra = ['folio' => $body->get('folio'),
                    'fecha_emision' => $body->get('fecha_emision'),
                    'fecha_venc' => $body->get('fecha_vencimiento'),
                    'tipo_dte' => 33,
                    'tpo_pago' =>  $body->get('tipo_documento'),
                    'rut' => strtoupper($body->get('rut')),
                    'razon_social' => strtoupper($body->get('razon_social')),
                    'giro' => strtoupper($body->get('giro')),
                    'direccion' => strtoupper($body->get('direccion')),
                    'comuna' => strtoupper($body->get('comuna')),
                    'ciudad' => strtoupper($body->get('ciudad')),
                    'neto' => $body->get('neto'),
                    'iva' => $body->get('iva'),
                    'total' => $body->get('total')
            ];

        DB::table('compras')->where('id', $request->get('id'))->update($compra);
        $ultima_compra = $this->buscaDte($body->get('rut'), 33, $body->get('folio'));
        DB::table('referencias')->where('id_compra', $ultima_compra->id)->delete();
        if(count($body) > 16){
            foreach($body as $item){
                $i++;
                if($i > 16){
                    $o++;
                    //error_log(print_r($item, true));
                    $referencias = ['n_linea' => $o,
                                    'tpo_doc_ref' => $item[0],
                                    'folio' => $item[1],
                                    'fecha_ref' => $item[2],
                                    'id_compra' => $ultima_compra->id
                    ];
                    //error_log(print_r($referencias, true));
                    DB::table('referencias')->insert($referencias);
                }
            }
        }
        return redirect()->route('ListarCompras')->with('success','Se ha Editado el Documento correctamente');
    }

    public function descargaXml(Request $request){
        //dd($request->get('ruta'));
        return response()->download(storage_path("app/" .$request->get('ruta')), ($request->get('folio').'_'.$request->get('rut').'.xml'));
    }

    public function insertDIN(Request $request){
        $din = ['folio' => $request->get('folio_din'),
                    'fecha_emision' => $request->get('fecha_emision_din'),
                    'fecha_venc' => $request->get('fecha_emision_din'),
                    'tipo_dte' => 914,
                    'tpo_pago' =>  1,
                    'rut' => strtoupper($request->get('rut_din')),
                    'razon_social' => strtoupper($request->get('razon_social_din')),
                    'giro' => "",
                    'direccion' => "",
                    'comuna' => "",
                    'ciudad' => "",
                    'mnto_exento' => $request->get('exento_din'),
                    'iva' => $request->get('iva_din'),
                    'total' => $request->get('total_din'),
                    'xml' => null,
                    'estado_verificacion' => 2
            ];

            $existe_din = $this->buscaDte($request->get('rut_din'), 914, $request->get('folio_din'));

            if($existe_din != null){
                return redirect()->route('ComprasProveedores')->with('warning','Documento ya existe para este Proveedor');
            }else{
                DB::table('compras')->insert($din);
    
                return redirect()->route('ComprasProveedores')->with('success','Se ha Agregado el Documento correctamente');
            }


           /*  $compra = ['folio' => $request->get('folio_din'),
                    'fecha_emision' => $request->get('fecha_emision_din'),
                    'fecha_venc' => $request->get('fecha_emision_din'),
                    'tipo_dte' => 914,
                    'tpo_pago' =>  1,
                    'rut' => strtoupper($request->get('rut_din')),
                    'razon_social' => strtoupper($request->get('razon_social_din')),
                    'giro' => "ADM. PUBLICA Y DEFENSA",
                    'direccion' => "TEATINOS 28",
                    'comuna' => "SANTIAGO",
                    'ciudad' => "SANTIAGO",
                    'neto' => $request->get('exento_din'),
                    'iva' => $request->get('iva_din'),
                    'total' => $request->get('total_din')
            ]; */
    }

    
}
