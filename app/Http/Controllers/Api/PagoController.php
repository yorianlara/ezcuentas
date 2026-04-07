<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contabilidad\PagoService;
use App\Models\Comprobante;

class PagoController extends Controller
{
    protected $pagoService;

    public function __construct(PagoService $pagoService)
    {
        $this->pagoService = $pagoService;
    }

    /**
     * Get all pending debts (Provider).
     */
    public function deudas(Request $request)
    {
        $empresaId = session('empresa_id') ?? 1;
        $deudas = $this->pagoService->getDeudasPendientes($empresaId);

        return response()->json([
            'success' => true,
            'data' => $deudas
        ]);
    }

    /**
     * Record a new payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'comprobante_id' => 'required|exists:comprobantes,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'metodo_pago' => 'required|string',
            'cuenta_banco_caja_id' => 'required|exists:cuentas_contables,id',
            'referencia' => 'nullable|string|max:100'
        ]);

        try {
            $pagoId = $this->pagoService->registrarPago($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado correctamente',
                'pago_id' => $pagoId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get history for a voucher.
     */
    public function historial($comprobanteId)
    {
        $pagos = \DB::table('pagos_comprobante')
            ->where('comprobante_id', $comprobanteId)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pagos
        ]);
    }
}
