<?php

namespace App\Services\Contabilidad;

use App\Models\Comprobante;
use App\Models\CuentaContable;
use App\Models\AsientoContable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardContableService
{
    /**
     * Get aggregate statistics for the dashboard.
     */
    public function getStats($empresaId)
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // 1. Ingresos y Gastos del Mes (desde Comprobantes aprobados)
        $ventas = Comprobante::where('empresa_id', $empresaId)
            ->where('estado', 'APROBADO')
            ->whereHas('tipoComprobante', function($q) {
                $q->where('naturaleza', 'INGRESO');
            })
            ->whereBetween('fecha_emision', [$inicioMes, $finMes])
            ->sum('total');

        $gastos = Comprobante::where('empresa_id', $empresaId)
            ->where('estado', 'APROBADO')
            ->whereHas('tipoComprobante', function($q) {
                $q->where('naturaleza', 'EGRESO');
            })
            ->whereBetween('fecha_emision', [$inicioMes, $finMes])
            ->sum('total');

        // 2. Saldos Críticos (desde el Libro Mayor / Plan de Cuentas)
        // Cuentas por Cobrar (1.1.02)
        $cuentasCobrar = $this->getAccountBalance('1.1.02', $empresaId);
        
        // Caja y Bancos (1.1.01)
        $cajaBancos = $this->getAccountBalance('1.1.01', $empresaId);

        // IVA por Pagar (2.1.02)
        $ivaPorPagar = $this->getAccountBalance('2.1.02', $empresaId);

        return [
            'periodo' => $inicioMes->format('F Y'),
            'kpis' => [
                'ventas_mes' => (float)$ventas,
                'gastos_mes' => (float)$gastos,
                'utilidad_operativa' => (float)($ventas - $gastos),
                'cuentas_por_cobrar' => (float)$cuentasCobrar,
                'caja_bancos' => (float)$cajaBancos,
                'impuestos_por_pagar' => (float)$ivaPorPagar,
            ]
        ];
    }

    /**
     * Get trends for Sales vs Expenses (Monthly).
     */
    public function getTrendData($empresaId, $months = 6)
    {
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $v = Comprobante::where('empresa_id', $empresaId)
                ->where('estado', 'APROBADO')
                ->whereHas('tipoComprobante', function($q) {
                    $q->where('naturaleza', 'INGRESO');
                })
                ->whereBetween('fecha_emision', [$start, $end])
                ->sum('total');

            $g = Comprobante::where('empresa_id', $empresaId)
                ->where('estado', 'APROBADO')
                ->whereHas('tipoComprobante', function($q) {
                    $q->where('naturaleza', 'EGRESO');
                })
                ->whereBetween('fecha_emision', [$start, $end])
                ->sum('total');

            $data[] = [
                'mes' => $date->format('M'),
                'ventas' => (float)$v,
                'gastos' => (float)$g
            ];
        }

        return $data;
    }

    /**
     * Helper to get the current balance of an account code.
     */
    private function getAccountBalance($codigoPadre, $empresaId)
    {
        // Determinamos la naturaleza por el primer dígito del código
        // 1: Activo, 5: Egreso -> Debe - Haber
        // 2: Pasivo, 3: Patrimonio, 4: Ingreso -> Haber - Debe
        $primerDigito = substr($codigoPadre, 0, 1);
        $esDeudora = in_array($primerDigito, ['1', '5']);

        return DB::table('detalles_asiento')
            ->join('asientos_contables', 'detalles_asiento.asiento_contable_id', '=', 'asientos_contables.id')
            ->join('cuentas_contables', 'detalles_asiento.cuenta_contable_id', '=', 'cuentas_contables.id')
            ->where('asientos_contables.empresa_id', $empresaId)
            ->where('asientos_contables.estado', 'APROBADO')
            ->where('cuentas_contables.codigo', 'like', $codigoPadre . '%')
            ->selectRaw($esDeudora ? 'SUM(debe) - SUM(haber) as balance' : 'SUM(haber) - SUM(debe) as balance')
            ->value('balance') ?? 0;
    }
}
