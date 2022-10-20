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

        $colegios=DB::select("select colegio.nombre as colegio, comunas.nombre as comuna from colegio
        inner join comunas on colegio.id_comuna = comunas.id");


        return view('Admin.Cotizaciones.Colegios',compact('colegios'));

    }


    /*public function ListaEscolarfiltro(Request $request){

        $comunas=DB::select("select nombre from comunas");
        //$comunas=DB::table('comunas')->get();

        return view('Admin.Cotizaciones.ListaEscolar',compact('comunas'));


      }*/

}
