<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\MailNotify;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use Mail;
use App\mensajes;
use App\ipmac;
use App\cuponescolar;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




class ListaEscolarController extends Controller
{

    public function ListaEscolar(Request $request){

        $colegios=DB::select("select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id");

        return view('Admin.Cotizaciones.Colegios',compact('colegios'));

    }

    public function Cursos(Request $request){
        //dd($request->get("id"));
        //$colegio=DB::table("colegio")->where('id', $request->get("id"))->first();

        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id").'')[0];

        $cursos=DB::table('curso')->where('id_colegio', $request->get("id"))->get();

        return view('Admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    }

    public function AgregarCurso(Request $request){
        $inputs = request()->all();

       /*  $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get('id_colegio').'')[0]; */

        /* $cursos=DB::table('curso')->where('id_colegio', $request->get('id_colegio'))->get(); */

        $elcurso = DB::table('curso')->insert([
                [
                "nombre_curso" => request()->get('nombre'),
                "letra" => request()->get('subcurso'),
                "id_colegio" => request()->get('id_colegio'),
                ]
            ]);

            error_log(print_r(request()->all(), true));

            return response()->json(request()->all());
    }

    public function eliminar($id)
    {
        $update = DB::table('Curso')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('Curso')->with('success','Curso Eliminado!');
    }

    /*public function ListaEscolarfiltro(Request $request){

        $comunas=DB::select("select nombre from comunas");
        //$comunas=DB::table('comunas')->get();

        return view('Admin.Cotizaciones.ListaEscolar',compact('comunas'));


      }*/

    public function Listas(Request $request){

        $listas=DB::select('select ListaEscolar_detalle.cod_articulo,conveniomarco.descripcion,ListaEscolar_detalle.cantidad,conveniomarco.stock_sala,conveniomarco.stock_bodega,
        conveniomarco.precio_detalle from ListaEscolar_detalle left join conveniomarco on ListaEscolar_detalle.cod_articulo = conveniomarco.codigo');

        $colegiol=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id=2')[0];

       // $colegiol=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
       //   inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id").'')[0];



        return view('Admin.Cotizaciones.ListasEscolares', compact('listas','colegiol'));
    }

}
