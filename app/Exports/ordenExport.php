<?php

namespace App\Exports;

use App\orden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use DB;


class ordenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct( $variable)
    {
        $this->search = $variable;
    
    }
    

    public function view(): View
    {
        //dd( $this->search,'XD');
        return view('exports.OrdenDeCompraExcel', [
            'ordendecompra' => DB::table('ordenesdecompra')
            ->where('numero_de_orden_de_compra','=',$this->search)
            ->get(),
            'ordendecompradetalle'=> DB::table('ordenesdecomprapdf')
            ->where('NroOC','=',$this->search)
            ->get()
        ]);

    }

 












}
