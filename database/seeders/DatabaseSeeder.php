<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TipoDocumentoFiscalSeeder::class,
            UserSeeder::class,
            EmpresaSeeder::class,
            PlanCuentasSeeder::class,
            EjercicioFiscalSeeder::class,
            TipoComprobanteSeeder::class,
        ]);
    }
}