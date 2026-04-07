<?php

namespace Database\Seeders;

use App\Models\CuentaContable;
use App\Models\TipoCuenta;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class PlanCuentasSeeder extends Seeder
{
    public function run()
    {
        $empresa = Empresa::first();
        if (!$empresa) return;

        // 1. Tipos de Cuentas (Naturaleza)
        $tipos = [
            ['codigo' => 'ACT', 'nombre' => 'Activo', 'naturaleza' => 'D'],
            ['codigo' => 'PAS', 'nombre' => 'Pasivo', 'naturaleza' => 'C'],
            ['codigo' => 'PAT', 'nombre' => 'Patrimonio', 'naturaleza' => 'C'],
            ['codigo' => 'ING', 'nombre' => 'Ingresos', 'naturaleza' => 'C'],
            ['codigo' => 'GAS', 'nombre' => 'Gastos', 'naturaleza' => 'D'],
            ['codigo' => 'COS', 'nombre' => 'Costos', 'naturaleza' => 'D'],
        ];

        foreach ($tipos as $t) {
            TipoCuenta::updateOrCreate(
                ['empresa_id' => $empresa->id, 'codigo' => $t['codigo']],
                ['nombre' => $t['nombre'], 'naturaleza' => $t['naturaleza']]
            );
        }

        // 2. Plan de Cuentas (Simplified Hispanic Standard)
        $cuentas = [
            ['codigo' => '1', 'nombre' => 'ACTIVOS', 'tipo' => 'ACT', 'nivel' => 1],
            ['codigo' => '1.1', 'nombre' => 'ACTIVOS CORRIENTES', 'tipo' => 'ACT', 'nivel' => 2, 'padre' => '1'],
            ['codigo' => '1.1.01', 'nombre' => 'Caja y Bancos', 'tipo' => 'ACT', 'nivel' => 3, 'padre' => '1.1'],
            ['codigo' => '1.1.01.01', 'nombre' => 'Caja General', 'tipo' => 'ACT', 'nivel' => 4, 'padre' => '1.1.01', 'hoja' => true],
            ['codigo' => '1.1.01.02', 'nombre' => 'Bancos Locales', 'tipo' => 'ACT', 'nivel' => 4, 'padre' => '1.1.01', 'hoja' => true],
            ['codigo' => '1.1.02', 'nombre' => 'Cuentas por Cobrar Comerciales', 'tipo' => 'ACT', 'nivel' => 3, 'padre' => '1.1', 'hoja' => true],
            ['codigo' => '1.1.03', 'nombre' => 'IVA Crédito Fiscal', 'tipo' => 'ACT', 'nivel' => 3, 'padre' => '1.1', 'hoja' => true],
            
            ['codigo' => '2', 'nombre' => 'PASIVOS', 'tipo' => 'PAS', 'nivel' => 1],
            ['codigo' => '2.1', 'nombre' => 'PASIVOS CORRIENTES', 'tipo' => 'PAS', 'nivel' => 2, 'padre' => '2'],
            ['codigo' => '2.1.01', 'nombre' => 'Cuentas por Pagar Comerciales', 'tipo' => 'PAS', 'nivel' => 3, 'padre' => '2.1', 'hoja' => true],
            ['codigo' => '2.1.02', 'nombre' => 'IVA Débito Fiscal', 'tipo' => 'PAS', 'nivel' => 3, 'padre' => '2.1', 'hoja' => true],
            
            ['codigo' => '3', 'nombre' => 'PATRIMONIO', 'tipo' => 'PAT', 'nivel' => 1],
            ['codigo' => '3.1', 'nombre' => 'Capital Social', 'tipo' => 'PAT', 'nivel' => 2, 'padre' => '3', 'hoja' => true],
            
            ['codigo' => '4', 'nombre' => 'INGRESOS', 'tipo' => 'ING', 'nivel' => 1],
            ['codigo' => '4.1', 'nombre' => 'Ventas de Bienes y Servicios', 'tipo' => 'ING', 'nivel' => 2, 'padre' => '4', 'hoja' => true],
            
            ['codigo' => '5', 'nombre' => 'GASTOS', 'tipo' => 'GAS', 'nivel' => 1],
            ['codigo' => '5.1', 'nombre' => 'Gastos Administrativos', 'tipo' => 'GAS', 'nivel' => 2, 'padre' => '5', 'hoja' => true],
            ['codigo' => '5.1.01', 'nombre' => 'Sueldos y Salarios', 'tipo' => 'GAS', 'nivel' => 3, 'padre' => '5.1', 'hoja' => true],
        ];

        foreach ($cuentas as $c) {
            $tipo = TipoCuenta::where('codigo', $c['tipo'])->where('empresa_id', $empresa->id)->first();
            $padreId = null;
            if (isset($c['padre'])) {
                $padre = CuentaContable::where('codigo', $c['padre'])->where('empresa_id', $empresa->id)->first();
                $padreId = $padre->id;
            }

            CuentaContable::updateOrCreate(
                ['empresa_id' => $empresa->id, 'codigo' => $c['codigo']],
                [
                    'nombre' => $c['nombre'],
                    'tipo_cuenta_id' => $tipo->id,
                    'cuenta_padre_id' => $padreId,
                    'nivel' => $c['nivel'],
                    'es_cuenta_hoja' => $c['hoja'] ?? false,
                    'acepta_movimientos' => $c['hoja'] ?? false,
                    'activo' => true,
                    'fecha_saldo_inicial' => now()->startOfYear()
                ]
            );
        }
    }
}
