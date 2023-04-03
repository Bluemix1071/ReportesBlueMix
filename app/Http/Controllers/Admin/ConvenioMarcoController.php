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

class ConvenioMarcoController extends Controller
{
    public function ListarConvenio(Request $request){

        $convenio=DB::select("select
        convenio_marco.cod_articulo,
        convenio_marco.id_conveniomarco,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        convenio_marco.cantidad,
        bodeprod.bpsrea as stock_sala,
        if(isnull(Suma_Bodega.cantidad),0,suma_bodega.cantidad) AS stock_bodega,
        convenio_marco.neto,
        convenio_marco.precio_venta,
        convenio_marco.margen
        from convenio_marco
        left join precios on SUBSTRING(convenio_marco.cod_articulo,1,5)  = precios.PCCODI
        left join producto on convenio_marco.cod_articulo = producto.ARCODI
        left join bodeprod on convenio_marco.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on convenio_marco.cod_articulo = Suma_Bodega.inarti
        group by convenio_marco.cod_articulo");

        // dd($convenio);
        return view('admin.Cotizaciones.ConvenioMarco',compact('convenio'));


    }

    public function AgregarProducto(Request $request){
        $inputs = request()->all();

        $iconvenio = DB::table('convenio_marco')->insert([
                [
                "cod_articulo" => $request->get('codigo'),
                "cantidad" => $request->get('cantidad'),
                "neto" => ('1000'),
                "precio_venta" => $request->get('precioventa'),
                "margen" => $request->get('mergen'),
                "id_conveniomarco" => $request->get('idconvenio')
                ]
            ]);
            dd($request);

            $convenio=DB::select("select
            convenio_marco.cod_articulo,
            convenio_marco.id_conveniomarco,
            producto.ARDESC as descripcion,
            producto.ARMARCA as marca,
            convenio_marco.cantidad,
            bodeprod.bpsrea as stock_sala,
            if(isnull(Suma_Bodega.cantidad),0,suma_bodega.cantidad) AS stock_bodega,
            convenio_marco.neto,
            convenio_marco.precio_venta,
            convenio_marco.margen
            from convenio_marco
            left join precios on SUBSTRING(convenio_marco.cod_articulo,1,5)  = precios.PCCODI
            left join producto on convenio_marco.cod_articulo = producto.ARCODI
            left join bodeprod on convenio_marco.cod_articulo = bodeprod.bpprod
            left join Suma_Bodega on convenio_marco.cod_articulo = Suma_Bodega.inarti
            group by convenio_marco.cod_articulo");

            return view('admin.Cotizaciones.ConvenioMarco',compact('convenio'));
    }
}
