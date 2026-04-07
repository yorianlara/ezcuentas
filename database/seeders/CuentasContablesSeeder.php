<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuentasContablesSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $fechaSaldo = now();

        // Primero necesitamos crear algunos tipos de cuenta (asumiendo que ya tienes esta tabla)
        $tipoActivoId = DB::table('tipos_cuenta')->where('nombre', 'ACTIVO')->value('id');
        if (!$tipoActivoId) {
            $tipoActivoId = DB::table('tipos_cuenta')->insertGetId([
                'nombre' => 'ACTIVO',
                'descripcion' => 'Cuentas de Activo',
                'naturaleza' => 'deudora',
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        $cuentas = [
            // NIVEL 1 - CUENTA RAÍZ
            [
                'codigo' => '1',
                'nombre' => 'Activos',
                'nivel' => 1,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // NIVEL 2 - ACTIVOS CORRIENTES
            [
                'codigo' => '1.10',
                'nombre' => 'Activos Corrientes',
                'nivel' => 2,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // NIVEL 3 - EFECTIVO Y EQUIVALENTES
            [
                'codigo' => '1.10.100',
                'nombre' => 'Cheque, Efectivo y Equivalente',
                'nivel' => 3,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // NIVEL 4 - CUENTAS DE CAJA Y BANCOS
            [
                'codigo' => '1.10.100.1000',
                'nombre' => 'Cheques y efectivo',
                'nivel' => 4,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // NIVEL 5 - CUENTAS ESPECÍFICAS DE CAJA
            [
                'codigo' => '1.10.100.1000.10000',
                'nombre' => 'Cheques',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.100.1000.10001',
                'nombre' => 'Efectivo en Caja',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'es_efectivo' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // CUENTAS BANCARIAS
            [
                'codigo' => '1.10.100.1000.10002',
                'nombre' => 'Efectivo en Cuentas Bancarias',
                'nivel' => 5,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.100.1000.10002.00140',
                'nombre' => 'BBVA',
                'nivel' => 6,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'es_banco' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.100.1000.10002.00240',
                'nombre' => 'Citibank - VEB',
                'nivel' => 6,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'es_banco' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // CLIENTES Y CUENTAS POR COBRAR
            [
                'codigo' => '1.10.102',
                'nombre' => 'Clientes Ventas Comerciales',
                'nivel' => 3,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'es_tercero' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.102.10200',
                'nombre' => 'Clientes Ventas Local',
                'nivel' => 4,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'es_tercero' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // INVENTARIOS
            [
                'codigo' => '1.10.103',
                'nombre' => 'Inventarios',
                'nivel' => 3,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.103.1030',
                'nombre' => 'Materia prima y material de Empaque',
                'nivel' => 4,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.10.103.1030.10300',
                'nombre' => 'Materia Prima y consumibles',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // ACTIVOS NO CORRIENTES
            [
                'codigo' => '1.11',
                'nombre' => 'Total Activos no Corrientes',
                'nivel' => 2,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // PROPIEDAD, PLANTA Y EQUIPO
            [
                'codigo' => '1.11.111',
                'nombre' => 'Propiedad, Planta y Equipo',
                'nivel' => 3,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110',
                'nombre' => 'Prop. Planta y Eq. Neto',
                'nivel' => 4,
                'es_cuenta_hoja' => false,
                'acepta_movimientos' => false,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110.11100',
                'nombre' => 'Terrenos',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110.11101',
                'nombre' => 'Edificios',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110.11102',
                'nombre' => 'Planta y Maquinaria',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110.11104',
                'nombre' => 'Vehículos',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'codigo' => '1.11.111.1110.11105',
                'nombre' => 'Otros Activos Fijos y Equipos',
                'nivel' => 5,
                'es_cuenta_hoja' => true,
                'acepta_movimientos' => true,
                'tipo_cuenta_id' => $tipoActivoId,
                'fecha_saldo_inicial' => $fechaSaldo,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        // Insertar las cuentas
        foreach ($cuentas as $cuenta) {
            DB::table('cuentas_contables')->insert($cuenta);
        }

        // Ahora actualizamos las relaciones padre-hijo
        $this->actualizarRelacionesPadres();
    }

    private function actualizarRelacionesPadres()
    {
        $cuentas = DB::table('cuentas_contables')->get();
        
        foreach ($cuentas as $cuenta) {
            if ($cuenta->codigo === '1') {
                // Esta es la cuenta raíz, no tiene padre
                continue;
            }
            
            // Encontrar el código del padre (remover el último segmento)
            $segmentos = explode('.', $cuenta->codigo);
            array_pop($segmentos);
            $codigoPadre = implode('.', $segmentos);
            
            if (!empty($codigoPadre)) {
                $padre = DB::table('cuentas_contables')
                    ->where('codigo', $codigoPadre)
                    ->first();
                
                if ($padre) {
                    DB::table('cuentas_contables')
                        ->where('id', $cuenta->id)
                        ->update(['cuenta_padre_id' => $padre->id]);
                }
            }
        }
    }
}