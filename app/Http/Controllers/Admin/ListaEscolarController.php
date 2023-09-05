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
use App\Models\Colegio;
use Illuminate\Validation\Rule;


class ListaEscolarController extends Controller
{

    public function ListaEscolar(Request $request){

        $colegios=DB::select("select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.temporada='2023-2024'");


        $comunas=DB::select('select * from comunas');

        $reporte=DB::select("
        select curso.id id_curso,curso.nombre_curso,curso.letra,colegio.id id_colegio,colegio.nombre nombre_colegio,comunas.nombre nombre_comuna from curso
        left join colegio on curso.id_colegio = colegio.id
        left join comunas on colegio.id_comuna = comunas.id
        where colegio.temporada='2023-2024'");

        return view('admin.Cotizaciones.Colegios',compact('colegios','comunas','reporte'));


    }



    public function colegiosTemporada2022()
    {
        $colegios=DB::select("select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.temporada='2022-2023'");

        $comunas=DB::select('select * from comunas');

        $reporte=DB::select("
        select curso.id id_curso,curso.nombre_curso,curso.letra,colegio.id id_colegio,colegio.nombre nombre_colegio,comunas.nombre nombre_comuna from curso
        left join colegio on curso.id_colegio = colegio.id
        left join comunas on colegio.id_comuna = comunas.id
        where colegio.temporada='2022-2023'");


        return view('admin.Cotizaciones.Colegios',compact('colegios','comunas','reporte'));
    }


    public function Reporte(Request $request){

        $reporte=DB::select("
        select ListaEscolar_detalle.cod_articulo,
        producto.ARDESC,producto.ARMARCA,ListaEscolar_detalle.cantidad,curso.nombre_curso,curso.letra,
        colegio.nombre colegio,comunas.nombre comuna
        from ListaEscolar_detalle
        left join curso on ListaEscolar_detalle.id_curso = curso.id
        left join colegio on curso.id_colegio = colegio.id
        left join comunas on colegio.id_comuna = comunas.id
        left join producto on ListaEscolar_detalle.cod_articulo=producto.ARCODI");


        return view('admin.Cotizaciones.Colegios',compact('reporte'));


    }

    public function Cursos(Request $request){


        $cursos=DB::table('curso')->where('id_colegio', $request->get('id'))->get();


        $colegio=DB::table('colegio')

        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id',$request->get('id'))
        ->select('colegio.id','colegio.nombre as colegio','comunas.nombre as comuna')
        ->get()[0];

;


        return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    }

    // public function AgregarCurso(Request $request){

    //     $elcurso = DB::table('curso')->insert([
    //         [
    //             "nombre_curso" => $request->get('nombre'),
    //             "letra" => $request->get('subcurso'),
    //             "id_colegio" => $request->get('id_colegio'),
    //         ]
    //     ]);

    //     $cursos = DB::table('curso')->where('id_colegio', $request->get('id_colegio'))->get();

    //     $colegio = DB::table('colegio')
    //         ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
    //         ->where('colegio.id', $request->get('id_colegio'))
    //         ->select('colegio.id', 'colegio.nombre as colegio', 'comunas.nombre as comuna')
    //         ->get()[0];

    //     $request->session()->flash('success', 'Curso agregado correctamente');
    //     return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
    // }
    //
    public function AgregarCurso(Request $request)
{
    $nombreCurso = $request->get('nombre');
    $letraCurso = $request->get('subcurso');
    $idColegio = $request->get('id_colegio');

    // Verificar si el curso ya existe en el colegio
    $cursoExistente = DB::table('curso')
        ->where('nombre_curso', $nombreCurso)
        ->where('letra', $letraCurso)
        ->where('id_colegio', $idColegio)
        ->exists();

    if ($cursoExistente) {
        $request->session()->flash('error', 'El curso ya existe en este colegio.');
    } else {
        // Agregar el curso si no existe
        DB::table('curso')->insert([
            "nombre_curso" => $nombreCurso,
            "letra" => $letraCurso,
            "id_colegio" => $idColegio,
        ]);

        $request->session()->flash('success', 'Curso agregado correctamente.');
    }

    $cursos = DB::table('curso')->where('id_colegio', $idColegio)->get();

    $colegio = DB::table('colegio')
        ->leftjoin('comunas', 'colegio.id_comuna', '=', 'comunas.id')
        ->where('colegio.id', $idColegio)
        ->select('colegio.id', 'colegio.nombre as colegio', 'comunas.nombre as comuna')
        ->first();

    return view('admin.Cotizaciones.Cursos', compact('colegio', 'cursos'));
}
    //
    public function AgregarColegio(Request $request){

        $validatedData = $request->validate([
            'nombrec' => ['required','string','max:40',
                Rule::unique('colegio', 'nombre')->where(function ($query) use ($request) {
                    return $query->where('id_comuna', $request->comunas)
                        ->where('temporada', '2023-2024');
                }),
            ],
            'comunas' => 'required|integer',
        ], [
            'nombrec.unique' => 'El colegio ya existe en esta comuna y temporada',
        ]);

        // Insertar un nuevo colegio en la base de datos
        $elcurso = DB::table('colegio')->insert([
            [
                "nombre" => $validatedData['nombrec'],
                "id_comuna" => $validatedData['comunas'],
                "temporada" => "2023-2024",
            ]
        ]);

        return redirect()->route('ListaEscolar')->with('success', 'El colegio se agregó correctamente.');
    }


    public function AgregarItem(Request $request){
        $inputs = request()->all();

        $idCurso = $request->get('idcurso');
        $cod_articulo = $request->get('codigo');
        $cantidad = $request->get('cantidad');

        $productoExistente = DB::table('ListaEscolar_detalle')
        ->where('id_curso', $idCurso)
        ->where('cod_articulo', $cod_articulo)
        ->exists();

        if ($productoExistente) {
            $request->session()->flash('error', 'El producto ya existe en este curso.');
        } else {
            // Agregar el producto si no existe
            DB::table('ListaEscolar_detalle')->insert([
                         [
                         "id_curso" => $idCurso,
                         "cod_articulo" => $cod_articulo,
                         "cantidad" => $cantidad
                         ]
                     ]);

            $request->session()->flash('success', 'Curso agregado correctamente.');
        }

        // $lalista = DB::table('ListaEscolar_detalle')->insert([
        //         [
        //         "id_curso" => $request->get('idcurso'),
        //         "cod_articulo" => $request->get('codigo'),
        //         "cantidad" => $request->get('cantidad')
        //         ]
        //     ]);

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


            $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
            inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];



            //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
            $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];

            // $request->session()->flash('success', 'Producto agregado correctamente');
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


            $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
            inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];



            //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
            $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];


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


        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];



        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];
        $request->session()->flash('success', 'Cotización cargada correctamente');
        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));

      }
      //fin agregar cotizacion


    public function eliminar(Request $request)
    {


        $update = DB::table('curso')
        ->where('id' ,$request->get('id'))
        ->delete();

        $update2 = DB::table('ListaEscolar_detalle')
        ->where('ListaEscolar_detalle.id_curso' , $request->get('id'))
        ->delete();


        $cursos=DB::table('curso')->where('id_colegio', $request->get('id_colegio'))->get();

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

        return redirect()->route('ListaEscolar')->with('success', 'El colegio se elimino correctamente.');
    }


    public function eliminaritem(Request $request)
    {
        $update = DB::table('ListaEscolar_detalle')

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


        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];


        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];


        $request->session()->flash('success', 'Producto Eliminado correctamente');
        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }



    public function Listas(Request $request){


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



        $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
        inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("idcolegio").'')[0];



        //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
        $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];

        return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));
    }

    public function Reportes(Request $request){

        $critico=DB::select("select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.id_curso,
        colegio.id as id_colegio,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        Suma_Bodega.cantidad AS stock_bodega
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
        left join curso on ListaEscolar_detalle.id_curso = curso.id
        left join colegio on curso.id_colegio = colegio.id
        where Suma_Bodega.cantidad <= 50 or isnull(Suma_Bodega.cantidad) and ListaEscolar_detalle.cod_articulo != 2516800 and colegio.temporada='2023-2024'
        group by ListaEscolar_detalle.cod_articulo");
        // dd($critico[0]);

        /* $criticod=DB::select("select ListaEscolar_detalle.id,ListaEscolar_detalle.id_curso,ListaEscolar_detalle.cod_articulo,ListaEscolar_detalle.cantidad,curso.id as curso_id,curso.nombre_curso as nombre_curso,curso.letra as subcurso, curso.id_colegio as cursoid_colegio
        ,colegio.id as id_colegio,colegio.nombre as nombre_colegio,colegio.id_comuna as id_comuna ,comunas.nombre as nombre_comuna from ListaEscolar_detalle
        left join curso on ListaEscolar_detalle.id_curso = curso.id
        left join colegio on curso.id_colegio = colegio.id
        left join comunas on colegio.id_comuna = comunas.id
        where ListaEscolar_detalle.cod_articulo != 2516800"); */

        return view('admin.Cotizaciones.ReportesListas', compact('critico'));

    }

    public function Reportes2022(Request $request){

        $critico=DB::select("select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.id_curso,
        colegio.id as id_colegio,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        Suma_Bodega.cantidad AS stock_bodega
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
        left join curso on ListaEscolar_detalle.id_curso = curso.id
        left join colegio on curso.id_colegio = colegio.id
        where Suma_Bodega.cantidad <= 50 or isnull(Suma_Bodega.cantidad) and ListaEscolar_detalle.cod_articulo != 2516800 and colegio.temporada='2022-2023'
        group by ListaEscolar_detalle.cod_articulo");

        return view('admin.Cotizaciones.ReportesListas', compact('critico'));

    }


    public function ColegiosXCodigo($codigo){

        $colegios = DB::select('select ListaEscolar_detalle.id,ListaEscolar_detalle.id_curso,ListaEscolar_detalle.cod_articulo,ListaEscolar_detalle.cantidad,curso.id as curso_id,curso.nombre_curso as nombre_curso,curso.letra as subcurso, curso.id_colegio as cursoid_colegio
        ,colegio.id as id_colegio,colegio.nombre as nombre_colegio,colegio.id_comuna as id_comuna ,comunas.nombre as nombre_comuna from ListaEscolar_detalle
        left join curso on ListaEscolar_detalle.id_curso = curso.id
        left join colegio on curso.id_colegio = colegio.id
        left join comunas on colegio.id_comuna = comunas.id
        where ListaEscolar_detalle.cod_articulo != 2516800 and ListaEscolar_detalle.cod_articulo = "'.$codigo.'"');

        return response()->json($colegios);
    }

    public function editarcantidadp(Request $request){

        DB::table('ListaEscolar_detalle')
        ->where('ListaEscolar_detalle.id', $request->get("id"))
        ->update(
          [
              'cantidad'=> $request->cantidad,
            ]

          );

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


          $colegio=DB::select('select colegio.id, colegio.nombre as colegio, comunas.nombre as comuna,colegio.temporada as temporada from colegio
          inner join comunas on colegio.id_comuna = comunas.id where colegio.id='.$request->get("id_colegio").'')[0];



          //$curso=DB::select('select curso.id,curso.nombre_curso as nombre, curso.letra,curso.id_colegio from curso where id='.$request->get("idcurso").'')[0];
          $curso=DB::table('curso')->where('id', $request->get("idcurso"))->get()[0];

          $request->session()->flash('success', 'Cantidad actualizada exitosamente');
          return view('admin.Cotizaciones.ListasEscolares', compact('listas','colegio','curso'));

        //   return redirect()->route('listas')->with('success','Producto Editado Correctamente');
    }

}
