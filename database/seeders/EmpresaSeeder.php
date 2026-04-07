<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        Empresa::updateOrCreate(
            ['codigo' => 'DEMO01'],
            [
                'nombre' => 'EZCuentas Demo S.A.',
                'razon_social' => 'EZCuentas Accounting Services S.A.',
                'numero_documento' => 'J-12345678-9',
                'esquema' => 'demo_accounting',
                'direccion' => 'Calle Falsa 123',
                'email' => 'admin@ezcuentas.test',
                'telefono' => '+123456789',
                'activo' => true
            ]
        );
    }
}
