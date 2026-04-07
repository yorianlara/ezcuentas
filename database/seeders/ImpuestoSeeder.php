<?php

namespace Database\Seeders;

use App\Models\TipoImpuesto;
use App\Models\TasaImpuesto;
use App\Models\CuentaContable;
use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImpuestoSeeder extends Seeder
{
    public function run()
    {
        $empresa = Empresa::first();
        if (!$empresa) return;

        $cuentas = CuentaContable::where('empresa_id', $empresa->id)->get()->keyBy('codigo');

        // 1. Tipos de Impuesto
        $tipos = [
            [
                'codigo' => 'IVA_VENTAS_16',
                'nombre' => 'IVA Ventas (16%)',
                'naturaleza' => 'DEBITO',
                'tipo_calculo' => 'PORCENTAJE',
                'tasa' => 16.00,
                'cuenta_id' => $cuentas['2.1.02']?->id
            ],
            [
                'codigo' => 'IVA_VENTAS_0',
                'nombre' => 'IVA Ventas (Exento)',
                'naturaleza' => 'DEBITO',
                'tipo_calculo' => 'PORCENTAJE',
                'tasa' => 0.00,
                'cuenta_id' => $cuentas['2.1.02']?->id
            ],
            [
                'codigo' => 'IVA_COMPRAS_16',
                'nombre' => 'IVA Compras (16%)',
                'naturaleza' => 'CREDITO',
                'tipo_calculo' => 'PORCENTAJE',
                'tasa' => 16.00,
                'cuenta_id' => $cuentas['1.1.03']?->id
            ],
        ];

        foreach ($tipos as $t) {
            $tipo = TipoImpuesto::updateOrCreate(
                ['codigo' => $t['codigo']],
                [
                    'nombre' => $t['nombre'],
                    'naturaleza' => $t['naturaleza'],
                    'tipo_calculo' => $t['tipo_calculo'],
                    'activo' => true
                ]
            );

            // Bincular con la cuenta contable
            if ($t['cuenta_id']) {
                DB::table('cuenta_impuesto')->updateOrInsert(
                    ['tipo_impuesto_id' => $tipo->id, 'cuenta_contable_id' => $t['cuenta_id']],
                    ['activo' => true, 'updated_at' => now(), 'created_at' => now()]
                );
            }

            // Crear tasa por defecto
            TasaImpuesto::updateOrCreate(
                ['tipo_impuesto_id' => $tipo->id, 'tasa' => $t['tasa']],
                ['fecha_vigencia_inicio' => '2020-01-01', 'activo' => true]
            );
        }
    }
}
