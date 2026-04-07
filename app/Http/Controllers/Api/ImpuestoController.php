<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contabilidad\TaxService;
use Illuminate\Http\Request;

class ImpuestoController extends Controller
{
    protected $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    /**
     * List all available taxes for the enterprise.
     */
    public function index(Request $request)
    {
        $empresaId = session('empresa_id') ?? 1;
        $taxes = $this->taxService->getAvailableTaxes($empresaId);

        return response()->json([
            'success' => true,
            'data' => $taxes
        ]);
    }

    /**
     * Calculate tax for a specific rate and amount.
     */
    public function calcular(Request $request)
    {
        $request->validate([
            'tasa_id' => 'required|exists:tasas_impuesto,id',
            'monto' => 'required|numeric'
        ]);

        $montoTotal = $this->taxService->calculate($request->monto, $request->tasa_id);

        return response()->json([
            'success' => true,
            'monto_impuesto' => $montoTotal
        ]);
    }
}
