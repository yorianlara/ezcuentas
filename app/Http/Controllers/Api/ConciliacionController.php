<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contabilidad\ConciliacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConciliacionController extends Controller
{
    protected $conciliacionService;

    public function __construct(ConciliacionService $conciliacionService)
    {
        $this->conciliacionService = $conciliacionService;
    }

    /**
     * Import a bank statement.
     */
    public function importar(Request $request)
    {
        $request->validate([
            'cuenta_bancaria_id' => 'required|exists:cuentas_bancarias,id',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
            'saldo_inicial' => 'required|numeric',
            'saldo_final' => 'required|numeric',
            'movimientos' => 'required|array|min:1',
            'movimientos.*.fecha' => 'required|date',
            'movimientos.*.descripcion' => 'required|string',
            'movimientos.*.monto' => 'required|numeric'
        ]);

        $extractoId = $this->conciliacionService->registrarExtracto($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Extracto importado correctamente',
            'extracto_id' => $extractoId
        ]);
    }

    /**
     * Get suggestions for a statement.
     */
    public function sugerencias($id)
    {
        $sugerencias = $this->conciliacionService->sugerirConciliacion($id);

        return response()->json([
            'success' => true,
            'data' => $sugerencias
        ]);
    }

    /**
     * Match a movement with an accounting line.
     */
    public function conciliar(Request $request)
    {
        $request->validate([
            'movimiento_id' => 'required|exists:detalles_extracto,id',
            'detalle_asiento_id' => 'required|exists:detalles_asiento,id'
        ]);

        $this->conciliacionService->conciliar($request->movimiento_id, $request->detalle_asiento_id);

        return response()->json([
            'success' => true,
            'message' => 'Movimiento conciliado correctamente'
        ]);
    }

    /**
     * List bank accounts.
     */
    public function cuentasBancarias()
    {
        $empresaId = session('empresa_id') ?? 1;
        $cuentas = DB::table('cuentas_bancarias')
            ->where('empresa_id', $empresaId)
            ->where('activo', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cuentas
        ]);
    }
}
