<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use App\Exports\ProductospormarcaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\MailNotify;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use Mail;
use App\Modelos\OrdenDiseno;
use App\mensajes;
use App\ipmac;
use App\cuponescolar;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Modelos\InventarioTemporal;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ListaEscolarController extends Controller
{

public function ListaEscolar (Request $request){

$ARCODI = $request->arcodi;
$ARMARCA = $request->armarca;
$ARDESC = $request->ardesc;
$cantidad = $request->cantidad;

$marca = $request->marca;
$fecha1=$request->fecha1;
$fecha2=$request->fecha2;

$marcas=DB::table('listaescolar')->get();



$lista=DB::select('select producto.ARCODI,producto.ARMARCA,producto.ARDESC,listaescolar_detalle.cantidad
from ListaEscolar_detalle
inner join producto on ListaEscolar_detalle.cod_articulo=producto.ARCODI
inner join ListaEscolar on ListaEscolar_detalle.nro_lista=ListaEscolar.id
inner join curso on ListaEscolar.id_curso=curso.id
inner join colegio on ListaEscolar.id_colegio=colegio.id;', [$marca,$fecha1,$fecha2]);



return view('admin.ListaEscolar',compact('productos','marca','fecha1','fecha2','marcas'));


}
}
