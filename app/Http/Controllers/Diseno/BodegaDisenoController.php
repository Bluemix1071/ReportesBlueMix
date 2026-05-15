<?php

namespace App\Http\Controllers\Diseno;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BodegaDisenoController extends Controller
{
    private $bodega_diseno = '110';

    public function index()
    {
        return view('Diseno.bodega_diseno');
    }

    public function getProductos(Request $request)
    {
        $productos = DB::table('producto as p')
            ->leftJoin('bodeprod as b', function($join) {
                $join->on('p.ARCODI', '=', 'b.bpprod')
                     ->where('b.bpbode', '=', $this->bodega_diseno);
            })
            ->where('p.ARGRPO2', '=', 12)
            ->select([
                'p.ARCODI as codigo',
                'p.ARDESC as descripcion',
                'p.ARMARCA as marca',
                DB::raw('IFNULL(b.bpsrea, 0) as stock')
            ]);

        return DataTables::of($productos)
            ->addColumn('acciones', function($producto) {
                return '
                    <button class="btn btn-sm btn-success btn-movimiento" data-codigo="'.$producto->codigo.'" data-tipo="INGRESO" title="Registrar Ingreso"><i class="fas fa-arrow-down"></i> Ingresar</button>
                    <button class="btn btn-sm btn-danger btn-movimiento" data-codigo="'.$producto->codigo.'" data-tipo="EGRESO" title="Registrar Egreso"><i class="fas fa-arrow-up"></i> Retirar</button>
                ';
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function registrarMovimiento(Request $request)
    {
        $codigo = $request->get('codigo');
        $tipo = $request->get('tipo'); // INGRESO or EGRESO
        $cantidad = $request->get('cantidad');
        $motivo = $request->get('motivo');
        $referencia = $request->get('referencia');

        if ($cantidad <= 0) {
            return response()->json(['success' => false, 'message' => 'La cantidad debe ser mayor a cero'], 400);
        }

        DB::beginTransaction();
        try {
            $existe = DB::table('bodeprod')
                ->where('bpprod', $codigo)
                ->where('bpbode', $this->bodega_diseno)
                ->first();

            $cantidad_anterior = $existe ? $existe->bpsrea : 0;

            if ($tipo == 'INGRESO') {
                $nueva_cantidad = $cantidad_anterior + $cantidad;
            } else {
                $nueva_cantidad = $cantidad_anterior - $cantidad;
            }

            if ($existe) {
                DB::table('bodeprod')
                    ->where('bpprod', $codigo)
                    ->where('bpbode', $this->bodega_diseno)
                    ->update(['bpsrea' => $nueva_cantidad]);
            } else {
                DB::table('bodeprod')->insert([
                    'bpbode' => $this->bodega_diseno,
                    'bpprod' => $codigo,
                    'bpsrea' => $nueva_cantidad,
                    'bpstin' => 0,
                    'bpsrea1' => 0
                ]);
            }

            DB::table('log_bodega_diseno')->insert([
                'codigo_producto' => $codigo,
                'tipo_movimiento' => $tipo,
                'cantidad' => $cantidad,
                'motivo' => $motivo,
                'referencia' => $referencia,
                'id_usuario' => session()->get('id_usuario') ?? 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'nuevo_stock' => $nueva_cantidad,
                'message' => 'Movimiento registrado correctamente (' . $tipo . ')'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar movimiento: ' . $e->getMessage()
            ], 500);
        }
    }
}
