<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contabilidad\ReporteContabilidadService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class ReporteContableController extends Controller
{
    private ReporteContabilidadService $service;

    public function __construct(ReporteContabilidadService $service)
    {
        $this->service = $service;
    }

    /**
     * Preview or Download General Ledger (Libro Mayor).
     */
    public function libroMayor(Request $request)
    {
        $request->validate([
            'cuenta_id' => 'required|exists:cuentas_contables,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'formato' => 'nullable|in:html,pdf,json'
        ]);

        try {
            $data = $this->service->getLibroMayorData(
                $request->cuenta_id,
                $request->fecha_inicio,
                $request->fecha_fin
            );

            // Add empresa to data for the view
            $data['empresa'] = request()->attributes->get('empresa_actual');

            $formato = $request->get('formato', 'html');

            if ($formato === 'pdf') {
                $pdf = Pdf::loadView('contabilidad.reportes.libro_mayor', $data);
                return $pdf->download('libro_mayor_' . $data['cuenta']->codigo . '.pdf');
            }

            if ($formato === 'json') {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return view('contabilidad.reportes.libro_mayor', $data);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Preview or Download Trial Balance (Balance de Comprobación).
     */
    public function balanceComprobacion(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'formato' => 'nullable|in:html,pdf,json'
        ]);

        try {
            $data = $this->service->getBalanceComprobacionData(
                $request->fecha_inicio,
                $request->fecha_fin
            );

            // Add empresa to data for the view
            $data['empresa'] = request()->attributes->get('empresa_actual');

            $formato = $request->get('formato', 'html');

            if ($formato === 'pdf') {
                $pdf = Pdf::loadView('contabilidad.reportes.balance_comprobacion', $data);
                return $pdf->download('balance_comprobacion.pdf');
            }

            if ($formato === 'json') {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return view('contabilidad.reportes.balance_comprobacion', $data);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
