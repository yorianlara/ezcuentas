<?php

namespace Database\Seeders;

use App\Models\EjercicioFiscal;
use App\Models\PeriodoContable;
use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EjercicioFiscalSeeder extends Seeder
{
    public function run()
    {
        $empresa = Empresa::first();
        if (!$empresa) return;

        $anio = (int) date('Y');
        
        $ejercicio = EjercicioFiscal::updateOrCreate(
            ['empresa_id' => $empresa->id, 'anio' => $anio],
            [
                'nombre' => 'Ejercicio ' . $anio,
                'fecha_inicio' => Carbon::create($anio, 1, 1),
                'fecha_fin' => Carbon::create($anio, 12, 31),
                'activo' => true,
                'cerrado' => false
            ]
        );

        // Periodos Mensuales
        for ($mes = 1; $mes <= 12; $mes++) {
            $inicio = Carbon::create($anio, $mes, 1);
            $fin = $inicio->copy()->endOfMonth();
            
            $nombresMeses = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];

            PeriodoContable::updateOrCreate(
                ['empresa_id' => $empresa->id, 'ejercicio_fiscal_id' => $ejercicio->id, 'mes' => $mes],
                [
                    'nombre' => $nombresMeses[$mes],
                    'fecha_inicio' => $inicio,
                    'fecha_fin' => $fin,
                    'activo' => true,
                    'cerrado' => false
                ]
            );
        }
    }
}
