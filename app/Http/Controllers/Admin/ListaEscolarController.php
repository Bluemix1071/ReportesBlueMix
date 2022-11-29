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

        $cursos=DB::table('curso')->where('id_colegio', $request->get('id'))->get();

        /*$colegio=DB::select('select colegio.id,colegio.nombre as colegio,comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id=?',[$request->get("id")])[0];*/
        //dd($colegio);
        $colegio=DB::table('colegio')
        //->addSelect(['colegio.nombre as colegio', 'comunas.nombre as comuna']
        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id',$request->get('id'))
        ->select('colegio.id','colegio.nombre as colegio','comunas.nombre as comuna')
        ->get()[0];
        //dd($colegio);
        //$cursos=DB::select('select * from curso where id_colegio='.$request->get("idcolegio"))->get();
        //dd($cursos);


        return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    }

    public function AgregarCurso(Request $request){

        $elcurso = DB::table('curso')->insert([
                [
                "nombre_curso" => $request->get('nombre'),
                "letra" => $request->get('subcurso'),
                "id_colegio" => $request->get('id_colegio'),
                ]
        ]);

        $cursos=DB::table('curso')->where('id_colegio', $request->get('id_colegio'))->get();

        $colegio=DB::table('colegio')
        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id',$request->get('id_colegio'))
        ->select('colegio.id','colegio.nombre as colegio','comunas.nombre as comuna')
        ->get()[0];

        return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    }

    public function AgregarItem(Request $request){
        $inputs = request()->all();

        //dd($request);

        $lalista = DB::table('ListaEscolar_detalle')->insert([
                [
                "id_curso" => $request->get('idcurso'),
                "cod_articulo" => $request->get('codigo'),
                "cantidad" => $request->get('cantidad')
                ]
            ]);

            $listas=DB::select('select
            ListaEscolar_detalle.id,
            ListaEscolar_detalle.id_curso,
            ListaEscolar_detalle.cod_articulo,
            producto.ARDESC as descripcion,
            sum(ListaEscolar_detalle.cantidad) as cantidad,
            bodeprod.bpsrea as stock_sala,
            SUM(inventa.incant) AS stock_bodega,
            (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
            precios.PCPVDET as preciou
            from ListaEscolar_detalle
            left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
            left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
            left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
            left join inventa on ListaEscolar_detalle.cod_articulo = inventa.inarti
            where ListaEscolar_detalle.id_curso='.$request->get("idcurso").' group by ListaEscolar_detalle.cod_articulo');


            $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
            inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];
            //dd($colegio);


            //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
            $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];

            //dd($curso);

            //dd($request);
            return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }

    public function eliminar(Request $request)
    {
        //dd($request);
        $update = DB::table('curso')
        ->where('id' ,$request->get('id'))
        ->delete();

        $cursos=DB::table('curso')->where('id_colegio', $request->get('id_colegio'))->get();
        //dd($cursos);
        $colegio=DB::table('colegio')
        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id',$request->get('id_colegio'))
        ->select('colegio.id','colegio.nombre as colegio','comunas.nombre as comuna')
        ->get()[0];



        return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    }

    public function eliminaritem(Request $request)
    {
        $update = DB::table('ListaEscolar_detalle')
        //->where('id' , $request->get('id'))
        ->where('cod_articulo' , $request->get('cod_articulo'))
        ->where('id_curso' , $request->get('idcurso'))
        ->orderBy(DB::raw("RAND()"))
        ->take(5)
        ->delete();

        /*DB::table('users')
        ->whereIn('id', DB::table('users')
        ->orderBy(DB::raw("RAND()"))
        >take(5)->lists('id'))
        ->delete();*/


        $listas=DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        SUM(inventa.incant) AS stock_bodega,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join inventa on ListaEscolar_detalle.cod_articulo = inventa.inarti
        where ListaEscolar_detalle.id_curso='.$request->get("idcurso").' group by ListaEscolar_detalle.cod_articulo');


        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];
        //dd($colegio);


        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];


            //dd($curso);

            //dd($request);
            return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }

    /*public function ListaEscolarfiltro(Request $request){

        $comunas=DB::select("select nombre from comunas");
        //$comunas=DB::table('comunas')->get();

        return view('Admin.Cotizaciones.ListaEscolar',compact('comunas'));


      }*/

    public function Listas(Request $request){
        //dd($request);

        $listas=DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        SUM(inventa.incant) AS stock_bodega,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join inventa on ListaEscolar_detalle.cod_articulo = inventa.inarti
        where ListaEscolar_detalle.id_curso='.$request->get("idcurso").' group by ListaEscolar_detalle.cod_articulo');



        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("idcolegio").'')[0];
        //dd($colegio);


        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];
        //dd($curso);

        //dd($request);
        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }






}
