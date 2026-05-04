<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;
use App\Exports\StockHistoricoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class StockHistoricoController extends Controller
{
    public function index()
    {
        return view('admin.StockHistorico.index');
    }


    public function exportExcel(Request $request)
    {
        $fecha = $request->get('fecha');
        $data = $this->calculateAllStock($fecha);
        return Excel::download(new StockHistoricoExport($data), "Stock_Historico_$fecha.xlsx");
    }

    public function exportPdf(Request $request)
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $fecha = $request->get('fecha');
        $productos = $this->calculateAllStock($fecha);

        $pdf = PDF::loadView('admin.StockHistorico.pdf', compact('productos', 'fecha'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("Stock_Historico_$fecha.pdf");
    }

    private function calculateAllStock($fecha)
    {
        $fechaCarbon = Carbon::parse($fecha);
        $hoy = Carbon::now();

        // Obtener stock actual de ambas salas
        $stockActual = DB::table('bodeprod')
            ->select('bpprod', 'bpsrea', 'bpsrea1')
            ->get()
            ->keyBy('bpprod');

        // Obtener stock actual de bodega (Matriz = 1, Sucursal = 2)
        $stockActualBodega = DB::table('inventa')
            ->select('inarti', 'inbode', DB::raw('SUM(incant) as cantidad'))
            ->groupBy('inarti', 'inbode')
            ->get()
            ->groupBy('inarti');

        // Ventas desde la fecha consultada hasta hoy
        // Separamos por CACOCA: 201 es Sucursal, el resto es Matriz
        $ventasDesc = DB::table('dcargos')
            ->join('cargos', function ($join) {
                $join->on('dcargos.DENMRO', '=', 'cargos.CANMRO')
                    ->on('dcargos.DETIPO', '=', 'cargos.CATIPO');
            })
            ->select(
                'dcargos.DECODI',
                'cargos.CACOCA',
                DB::raw('SUM(CASE WHEN cargos.CACOCA = "201" THEN dcargos.DECANT ELSE 0 END) as ventas_sucursal'),
                DB::raw('SUM(CASE WHEN cargos.CACOCA != "201" THEN dcargos.DECANT ELSE 0 END) as ventas_matriz')
            )
            ->whereBetween('dcargos.DEFECO', [$fecha, $hoy->format('Y-m-d')])
            ->groupBy('dcargos.DECODI', 'cargos.CACOCA')
            ->get()
            ->groupBy('DECODI');

        // Movimientos de bodega desde la fecha consultada hasta hoy
        // Casa Matriz: CMVBSAL/CMVBENT = 1
        // Sucursal: CMVBSAL/CMVBENT = 2 (Asumido segun patron)
        $movimientosDesc = DB::table('dmovim')
            ->join('cmovim', 'dmovim.DMVNGUI', '=', 'cmovim.CMVNGUI')
            ->select(
                'dmovim.DMVPROD',
                DB::raw('SUM(CASE WHEN cmovim.CMVBENT = "1" THEN dmovim.DMVCANT ELSE 0 END) as ingresos_matriz'),
                DB::raw('SUM(CASE WHEN cmovim.CMVBSAL = "1" THEN dmovim.DMVCANT ELSE 0 END) as egresos_matriz'),
                DB::raw('SUM(CASE WHEN cmovim.CMVBENT = "2" THEN dmovim.DMVCANT ELSE 0 END) as ingresos_sucursal'),
                DB::raw('SUM(CASE WHEN cmovim.CMVBSAL = "2" THEN dmovim.DMVCANT ELSE 0 END) as egresos_sucursal')
            )
            ->whereBetween('cmovim.CMVFECG', [$fecha, $hoy->format('Y-m-d')])
            ->groupBy('dmovim.DMVPROD')
            ->get()
            ->keyBy('DMVPROD');

        $productos = DB::table('producto')
            ->select('ARCODI as codigo', 'ARDESC as descripcion', 'ARMARCA as marca')
            ->get();

        foreach ($productos as $p) {
            $actual = $stockActual->get($p->codigo);
            $actualBod = $stockActualBodega->get($p->codigo);
            $v = $ventasDesc->get($p->codigo);
            $m = $movimientosDesc->get($p->codigo);

            // Sala Matriz
            $stockSalaMatriz = $actual ? (int) $actual->bpsrea : 0;
            $vMatriz = $v ? $v->sum('ventas_matriz') : 0;
            $p->stock_sala_matriz_historico = $stockSalaMatriz + $vMatriz;

            // Sala Sucursal
            $stockSalaSucursal = $actual ? (int) $actual->bpsrea1 : 0;
            $vSucursal = $v ? $v->sum('ventas_sucursal') : 0;
            $p->stock_sala_sucursal_historico = $stockSalaSucursal + $vSucursal;

            // Bodega Matriz (inbode = 1)
            $stockBodMatriz = 0;
            if ($actualBod) {
                $bod1 = $actualBod->where('inbode', '1')->first();
                $stockBodMatriz = $bod1 ? (int) $bod1->cantidad : 0;
            }
            $inMatriz = $m ? (int) $m->ingresos_matriz : 0;
            $outMatriz = $m ? (int) $m->egresos_matriz : 0;
            $p->stock_bodega_matriz_historico = $stockBodMatriz - $inMatriz + $outMatriz;

            // Bodega Sucursal (inbode = 2)
            $stockBodSucursal = 0;
            if ($actualBod) {
                $bod2 = $actualBod->where('inbode', '2')->first();
                $stockBodSucursal = $bod2 ? (int) $bod2->cantidad : 0;
            }
            $inSucursal = $m ? (int) $m->ingresos_sucursal : 0;
            $outSucursal = $m ? (int) $m->egresos_sucursal : 0;
            $p->stock_bodega_sucursal_historico = $stockBodSucursal - $inSucursal + $outSucursal;
        }

        return $productos;
    }

    public function getStockData(Request $request)
    {
        $fecha = $request->get('fecha');
        $productos = $this->calculateAllStock($fecha);

        return DataTables::of($productos)
            ->editColumn('stock_sala_matriz_historico', function ($row) {
                return (int) $row->stock_sala_matriz_historico;
            })
            ->editColumn('stock_bodega_matriz_historico', function ($row) {
                return (int) $row->stock_bodega_matriz_historico;
            })
            ->editColumn('stock_sala_sucursal_historico', function ($row) {
                return (int) $row->stock_sala_sucursal_historico;
            })
            ->editColumn('stock_bodega_sucursal_historico', function ($row) {
                return (int) $row->stock_bodega_sucursal_historico;
            })
            ->make(true);
    }
}
