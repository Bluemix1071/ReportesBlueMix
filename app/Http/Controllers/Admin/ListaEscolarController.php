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
use App\categoria;
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

        $comunas=DB::select('select * from comunas');

        //dd($colegios);

        return view('admin.Cotizaciones.Colegios',compact('colegios','comunas'));


    }

    public function Cursos(Request $request){


        $cursos=DB::table('curso')->where('id_colegio', $request->get('id'))->get();


        $colegio=DB::table('colegio')

        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id',$request->get('id'))
        ->select('colegio.id','colegio.nombre as colegio','comunas.nombre as comuna')
        ->get()[0];
        //dd($colegio);
;


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

    public function AgregarColegio(Request $request){

        $elcurso = DB::table('colegio')->insert([
                [
                "nombre" => $request->get('nombrec'),
                "id_comuna" => $request->get('comunas'),
                ]
        ]);

        //dd($request);


        $colegios=DB::select("select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id");

        $comunas=DB::select('select * from comunas');

        return view('admin.Cotizaciones.Colegios',compact('colegios','comunas'));
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
            producto.ARMARCA as marca,
            sum(ListaEscolar_detalle.cantidad) as cantidad,
            bodeprod.bpsrea as stock_sala,
            Suma_Bodega.cantidad AS stock_bodega,
            (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
            precios.PCPVDET as preciou,ListaEscolar_detalle.comentario
            from ListaEscolar_detalle
            left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
            left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
            left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
            left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
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

    public function AgregarComentario(Request $request){
        //dd($request->get("id"));
        DB::table('ListaEscolar_detalle')
        ->where('ListaEscolar_detalle.id', $request->get("id"))

        ->update(
            [
                'ListaEscolar_detalle.comentario'=> $request->comentario]

            );
            //DB::table('Update ListaEscolar_detalle set ListaEscolar_detalle.comentario='.$request->get("comentario").'where ListaEscolar_detalle.id='.$request->get("id"));

            //return redirect()->route('listas')->with('success','Comentario Agregado Correctamente');

            $listas=DB::select('select
            ListaEscolar_detalle.id,
            ListaEscolar_detalle.comentario,
            ListaEscolar_detalle.id_curso,
            ListaEscolar_detalle.cod_articulo,
            producto.ARDESC as descripcion,
            producto.ARMARCA as marca,
            sum(ListaEscolar_detalle.cantidad) as cantidad,
            bodeprod.bpsrea as stock_sala,
            Suma_Bodega.cantidad AS stock_bodega,
            (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
            precios.PCPVDET as preciou
            from ListaEscolar_detalle
            left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
            left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
            left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
            left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
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

      //inicio Agregar Cotizacion
      public function CargarCotizacion(Request $request){


        $cotizacion = DB::select('select dcotiz.DZ_CODIART,dcotiz.DZ_CANT from dcotiz where dcotiz.DZ_NUMERO = '.$request->get('nro_cotiz').'');
        if(!empty($cotizacion)){
            foreach($cotizacion as $item){

                $nuevo = [
                              'id_curso' => $request->get('idcurso'),
                              'cod_articulo' => $item->DZ_CODIART,
                              'cantidad' => $item->DZ_CANT,
                ];
                //dd($nuevo);
                //error_log(print_r($nuevo, true));
                DB::table('ListaEscolar_detalle')->insert($nuevo);
            }
        }

        $listas=DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.comentario,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        Suma_Bodega.cantidad AS stock_bodega,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
        where ListaEscolar_detalle.id_curso='.$request->get("idcurso").' group by ListaEscolar_detalle.cod_articulo');


        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];
        //dd($colegio);


        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];

        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));

      }
      //fin agregar cotizacion


    public function eliminar(Request $request)
    {
        //dd($request);
        $update = DB::table('curso')
        ->where('id' ,$request->get('id'))
        ->delete();

        $update2 = DB::table('ListaEscolar_detalle')
        ->where('ListaEscolar_detalle.id_curso' , $request->get('id'))
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


    public function EliminarColegio(Request $request)
    {

        $update2 = DB::table('ListaEscolar_detalle','curso')
        ->join('curso','curso.id','=','ListaEscolar_detalle.id_curso')
        ->where('curso.id_colegio' , $request->get('id'))
        ->delete();

        $update3 = DB::table('curso')
        ->where('curso.id_colegio' , $request->get('id'))
        ->delete();

        $update = DB::table('colegio')
        ->where('id' ,$request->get('id'))
        ->delete();

        $colegios=DB::select("select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id");

        $comunas=DB::select('select * from comunas');

        return view('admin.Cotizaciones.Colegios',compact('colegios','comunas'));
    }


    public function eliminaritem(Request $request)
    {
        $update = DB::table('ListaEscolar_detalle')
        //->where('id' , $request->get('id'))
        ->where('cod_articulo' , $request->get('cod_articulo'))
        ->where('id_curso' , $request->get('idcurso'))
        ->take(5)
        ->delete();


        //$update=DB::select('Delete FROM ListaEscolar_detalle WHERE cod_articulo='.$request->get("cod_articulo").' and id_curso='.$request->get("idcurso").' limit 15');




        $listas=DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.comentario,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        Suma_Bodega.cantidad AS stock_bodega,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
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



    public function Listas(Request $request){
        //dd($request);

        $listas=DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.comentario,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        Suma_Bodega.cantidad AS stock_bodega,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
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
