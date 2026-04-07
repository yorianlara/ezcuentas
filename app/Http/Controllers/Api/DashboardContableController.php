<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contabilidad\DashboardContableService;
use Illuminate\Http\Request;

class DashboardContableController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardContableService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get the financial statistics for the dashboard.
     */
    public function index(Request $request)
    {
        $empresaId = session('empresa_id') ?? 1;
        $stats = $this->dashboardService->getStats($empresaId);
        $trends = $this->dashboardService->getTrendData($empresaId);

        return response()->json([
            'success' => true,
            'data' => [
                'periodo' => $stats['periodo'],
                'kpis' => $stats['kpis'],
                'trends' => $trends
            ]
        ]);
    }
}
