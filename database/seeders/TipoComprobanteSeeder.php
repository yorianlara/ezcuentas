<?php

namespace Database\Seeders;

use App\Models\TipoComprobante;
use App\Models\Empresa;
use App\Models\CuentaContable;
use Illuminate\Database\Seeder;

class TipoComprobanteSeeder extends Seeder
{
    public function run()
    {
        $empresa = Empresa::first();
        if (!$empresa) return;

        $cuentas = CuentaContable::where('empresa_id', $empresa->id)->get()->keyBy('codigo');

        $tipos = [
            [
                'codigo' => 'FAV',
                'nombre' => 'Factura de Venta',
                'abreviatura' => 'FAV',
                'naturaleza' => 'INGRESO',
                'configuracion' => [
                    'cuenta_defecto_id' => $cuentas['1.1.02']?->id, // Cartera
                    'cuenta_contrapartida_id' => $cuentas['4.1']?->id, // Ingresos
                    'prefijo' => 'FAV'
                ]
            ],
            [
                'codigo' => 'FAC',
                'nombre' => 'Factura de Compra',
                'abreviatura' => 'FAC',
                'naturaleza' => 'EGRESO',
                'configuracion' => [
                    'cuenta_defecto_id' => $cuentas['2.1.01']?->id, // Pasivo
                    'cuenta_contrapartida_id' => $cuentas['5.1']?->id, // Gastos
                    'prefijo' => 'FAC'
                ]
            ],
            [
                'codigo' => 'RCI',
                'nombre' => 'Recibo de Caja (Ingreso)',
                'abreviatura' => 'RCI',
                'naturaleza' => 'INGRESO',
                'afecta_caja' => true,
                'configuracion' => [
                    'cuenta_defecto_id' => $cuentas['1.1.01.01']?->id, // Caja
                    'cuenta_contrapartida_id' => $cuentas['1.1.02']?->id, // Cartera
                    'prefijo' => 'RCI'
                ]
            ],
            [
                'codigo' => 'CEG',
                'nombre' => 'Comprobante de Egreso',
                'abreviatura' => 'CEG',
                'naturaleza' => 'EGRESO',
                'afecta_banco' => true,
                'configuracion' => [
                    'cuenta_defecto_id' => $cuentas['1.1.01.02']?->id, // Bancos
                    'cuenta_contrapartida_id' => $cuentas['2.1.01']?->id, // Pasivo
                    'prefijo' => 'CEG'
                ]
            ],
        ];

        foreach ($tipos as $t) {
            TipoComprobante::updateOrCreate(
                ['codigo' => $t['codigo']],
                [
                    'nombre' => $t['nombre'],
                    'abreviatura' => $t['abreviatura'],
                    'naturaleza' => $t['naturaleza'],
                    'afecta_caja' => $t['afecta_caja'] ?? false,
                    'afecta_banco' => $t['afecta_banco'] ?? false,
                    'requiere_tercero' => true,
                    'configuracion' => $t['configuracion'],
                    'activo' => true
                ]
            );
        }
    }
}
