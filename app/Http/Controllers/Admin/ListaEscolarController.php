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
        return view('admin.Cotizaciones.Colegios',compact('colegios'));

    }

    public function Cursos(Request $request){
        //dd($request->get("id"));
        //$colegio=DB::table("colegio")->where('id', $request->get("id"))->first();

        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id").'')[0];

        $cursos=DB::table('curso')->where('id_colegio', $request->get("id"))->get();
        //dd($cursos)


        return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
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
        $update = DB::table('curso')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('Cursos')->with('success','Curso Eliminado!');
    }

    /*public function ListaEscolarfiltro(Request $request){

        $comunas=DB::select("select nombre from comunas");
        //$comunas=DB::table('comunas')->get();

        return view('Admin.Cotizaciones.ListaEscolar',compact('comunas'));


      }*/

    public function Listas(Request $request){
        //dd($request);

        $listas=DB::select('select ListaEscolar_detalle.id,ListaEscolar_detalle.id_curso,ListaEscolar_detalle.cod_articulo,conveniomarco.descripcion,ListaEscolar_detalle.cantidad,
        conveniomarco.stock_sala,conveniomarco.stock_bodega,
        (ListaEscolar_detalle.cantidad * conveniomarco.precio_detalle) as precio_detalle from ListaEscolar_detalle
        left join conveniomarco on ListaEscolar_detalle.cod_articulo = conveniomarco.codigo where ListaEscolar_detalle.id_curso='.$request->get("idcurso"));
        //dd($listas);


        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("idcolegio").'')[0];
        //dd($colegio);


        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];
        //dd($curso);

        //dd($request);
        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }

    public function eliminaritem($id)
    {
        $update = DB::table('ListaEscolar_detalle')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('ListaEscolar_detalle')->with('success','Item Eliminado!');
    }

    public function AgregarItem(Request $request){
        $inputs = request()->all();

        $lalista = DB::table('ListaEscolar_detalle')->insert([
                [
                "id_curso" => request()->get('id_curso'),
                "cod_articulo" => request()->get('codigo'),
                "cantidad" => request()->get('cantidad')
                ]
            ]);

            error_log(print_r(request()->all(), true));

            return response()->json(request()->all());
    }

}
