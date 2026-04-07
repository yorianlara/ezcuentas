<?php

namespace App\Services\Contabilidad;

use App\Models\TipoImpuesto;
use App\Models\TasaImpuesto;
use Illuminate\Support\Facades\DB;

class TaxService
{
    /**
     * Calculate tax for an amount.
     */
    public function calculate($amount, $tasaId)
    {
        $tasa = TasaImpuesto::findOrFail($tasaId);
        $tipo = $tasa->tipoImpuesto;

        $montoImpuesto = 0;
        if ($tipo->tipo_calculo === 'PORCENTAJE') {
            $montoImpuesto = $amount * ($tasa->tasa / 100);
        } else {
            // Monto fijo
            $montoImpuesto = $tasa->tasa;
        }

        return round($montoImpuesto, 2);
    }

    /**
     * Get the accounting account associated with a tax type.
     */
    public function getTaxAccount($tipoImpuestoId, $empresaId)
    {
        $mapping = DB::table('cuenta_impuesto')
            ->join('cuentas_contables', 'cuenta_impuesto.cuenta_contable_id', '=', 'cuentas_contables.id')
            ->where('cuenta_impuesto.tipo_impuesto_id', $tipoImpuestoId)
            ->where('cuentas_contables.empresa_id', $empresaId)
            ->where('cuenta_impuesto.activo', true)
            ->select('cuentas_contables.id', 'cuentas_contables.codigo', 'cuentas_contables.nombre')
            ->first();

        return $mapping;
    }

    /**
     * Get all active taxes with their current rates.
     */
    public function getAvailableTaxes($empresaId)
    {
        return TipoImpuesto::with(['tasas' => function($q) {
            $q->where('activo', true);
        }])
        ->where('activo', true)
        ->get();
    }
}
