<?php

namespace App\Services\Contabilidad;

use App\Models\AsientoContable;
use App\Models\CuentaContable;
use App\Models\DetalleAsiento;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteContabilidadService
{
    /**
     * Get General Ledger (Libro Mayor) data for a specific account and range.
     */
    public function getLibroMayorData(int $cuentaId, string $fechaInicio, string $fechaFin)
    {
        $cuenta = CuentaContable::findOrFail($cuentaId);

        // Calculate Opening Balance before the start date
        $saldoAnterior = $this->calcularSaldoAFrecha($cuenta, $fechaInicio);

        // Get movements within the range
        $movimientos = DetalleAsiento::where('cuenta_contable_id', $cuentaId)
            ->whereHas('asientoContable', function ($query) use ($fechaInicio, $fechaFin) {
                $query->where('estado', 'APROBADO')
                    ->whereBetween('fecha_asiento', [$fechaInicio, $fechaFin]);
            })
            ->with(['asientoContable' => function($q) {
                $q->select('id', 'numero_asiento', 'fecha_asiento', 'concepto');
            }])
            ->get()
            ->sortBy('asientoContable.fecha_asiento');

        // Build running balance
        $runningBalance = $saldoAnterior;
        $reporte = $movimientos->map(function ($movimiento) use (&$runningBalance) {
            $runningBalance += (float) ($movimiento->debe - $movimiento->haber);
            /** @var \Carbon\Carbon $fechaAsiento */
            $fechaAsiento = $movimiento->asientoContable->fecha_asiento;
            return [
                'fecha' => $fechaAsiento->format('d/m/Y'),
                'numero' => $movimiento->asientoContable->numero_asiento,
                'concepto' => $movimiento->concepto ?: $movimiento->asientoContable->concepto,
                'debe' => $movimiento->debe,
                'haber' => $movimiento->haber,
                'saldo' => $runningBalance,
            ];
        });

        return [
            'cuenta' => $cuenta,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'saldo_inicial' => $saldoAnterior,
            'movimientos' => $reporte,
            'total_debe' => $movimientos->sum('debe'),
            'total_haber' => $movimientos->sum('haber'),
            'saldo_final' => $runningBalance,
        ];
    }

    /**
     * Get Trial Balance (Balance de Comprobación) data.
     */
    public function getBalanceComprobacionData(string $fechaInicio, string $fechaFin)
    {
        // 1. Get movements aggregated by account
        $movimientos = DB::table('detalles_asiento')
            ->join('asientos_contables', 'detalles_asiento.asiento_contable_id', '=', 'asientos_contables.id')
            ->where('asientos_contables.estado', 'APROBADO')
            ->whereBetween('asientos_contables.fecha_asiento', [$fechaInicio, $fechaFin])
            ->where('detalles_asiento.empresa_id', session('empresa_id'))
            ->select(
                'cuenta_contable_id',
                DB::raw('SUM(debe) as total_debe'),
                DB::raw('SUM(haber) as total_haber')
            )
            ->groupBy('cuenta_contable_id')
            ->get()
            ->keyBy('cuenta_contable_id');

        // 2. Get all accounts ordered by level DESC to allow bottom-up aggregation
        $cuentas = CuentaContable::orderBy('nivel', 'desc')
            ->orderBy('codigo', 'asc')
            ->get();

        $balance = [];
        $totalesPorCuenta = [];

        foreach ($cuentas as $cuenta) {
            $mov = $movimientos->get($cuenta->id);
            
            // Initial data for current account
            $debeMes = (float)($mov->total_debe ?? 0);
            $haberMes = (float)($mov->total_haber ?? 0);
            $saldoInicial = $this->calcularSaldoAFrecha($cuenta, $fechaInicio);

            // Store in a temporary map for aggregation
            if (!isset($totalesPorCuenta[$cuenta->id])) {
                $totalesPorCuenta[$cuenta->id] = [
                    'debe' => 0,
                    'haber' => 0,
                    'saldo_inicial' => 0
                ];
            }

            $totalesPorCuenta[$cuenta->id]['debe'] += $debeMes;
            $totalesPorCuenta[$cuenta->id]['haber'] += $haberMes;
            $totalesPorCuenta[$cuenta->id]['saldo_inicial'] += $saldoInicial;

            // Aggregation to parent if exists
            if ($cuenta->cuenta_padre_id) {
                if (!isset($totalesPorCuenta[$cuenta->cuenta_padre_id])) {
                    $totalesPorCuenta[$cuenta->cuenta_padre_id] = [
                        'debe' => 0,
                        'haber' => 0,
                        'saldo_inicial' => 0
                    ];
                }
                $totalesPorCuenta[$cuenta->cuenta_padre_id]['debe'] += $totalesPorCuenta[$cuenta->id]['debe'];
                $totalesPorCuenta[$cuenta->cuenta_padre_id]['haber'] += $totalesPorCuenta[$cuenta->id]['haber'];
                $totalesPorCuenta[$cuenta->cuenta_padre_id]['saldo_inicial'] += $totalesPorCuenta[$cuenta->id]['saldo_inicial'];
            }
        }

        // 3. Format final list (re-ordering by code ASC)
        $resultado = [];
        foreach ($cuentas->sortBy('codigo') as $cuenta) {
            $t = $totalesPorCuenta[$cuenta->id];
            $saldoFinal = $t['saldo_inicial'] + $t['debe'] - $t['haber'];
            
            $resultado[] = [
                'id' => $cuenta->id,
                'codigo' => $cuenta->codigo,
                'nombre' => $cuenta->nombre,
                'nivel' => $cuenta->nivel,
                'es_hoja' => $cuenta->es_cuenta_hoja,
                'saldo_inicial' => $t['saldo_inicial'],
                'debe' => $t['debe'],
                'haber' => $t['haber'],
                'saldo_final' => $saldoFinal,
            ];
        }

        return [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'cuentas' => $resultado,
            'totales_generales' => [
                'debe' => collect($resultado)->where('nivel', 1)->sum('debe'),
                'haber' => collect($resultado)->where('nivel', 1)->sum('haber'),
            ]
        ];
    }

    /**
     * Helper to calculate balance at a specific point in time.
     */
    private function calcularSaldoAFrecha(CuentaContable $cuenta, string $fecha): float
    {
        // 1. Initial Balance from account definition
        $saldo = (float) $cuenta->saldo_inicial;

        // 2. Sum movements between the account's initial date and the requested date (exclusive)
        $movimientosAnteriores = DB::table('detalles_asiento')
            ->join('asientos_contables', 'detalles_asiento.asiento_contable_id', '=', 'asientos_contables.id')
            ->where('asientos_contables.estado', 'APROBADO')
            ->where('detalles_asiento.cuenta_contable_id', $cuenta->id)
            ->where('asientos_contables.fecha_asiento', '>=', $cuenta->fecha_saldo_inicial)
            ->where('asientos_contables.fecha_asiento', '<', $fecha)
            ->where('detalles_asiento.empresa_id', session('empresa_id'))
            ->selectRaw('SUM(debe) as total_debe, SUM(haber) as total_haber')
            ->first();

        $saldo += ($movimientosAnteriores->total_debe ?? 0) - ($movimientosAnteriores->total_haber ?? 0);

        return $saldo;
    }
}
