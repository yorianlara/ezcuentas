<?php

namespace App\Services;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;

class EsquemaService
{
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function crearEsquemaEmpresa(Empresa $empresa): bool
    {
        try {
            DB::beginTransaction();
            
            $esquema = $this->sanitizeEsquemaName($empresa->esquema);
            
            // 1. Crear el esquema
            DB::statement("CREATE SCHEMA IF NOT EXISTS {$esquema}");
            
            // 2. Ejecutar migraciones en el nuevo esquema
            $this->ejecutarMigracionesEnEsquema($esquema);
            
            // 3. Insertar datos básicos
            $this->insertarDatosBasicos($empresa);
            
            DB::commit();
            
            Log::info("Esquema creado exitosamente: {$esquema}");
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error creando esquema {$empresa->esquema}: " . $e->getMessage());
            throw $e;
        }
    }

    private function ejecutarMigracionesEnEsquema(string $esquema): void
    {
        // Guardar el esquema original
        $esquemaOriginal = config('database.connections.pgsql.search_path', 'public');
        
        try {
            // Cambiar temporalmente al nuevo esquema
            config(['database.connections.pgsql.search_path' => $esquema]);
            DB::purge('pgsql');
            DB::reconnect('pgsql');
            
            // Ejecutar migraciones específicas para contabilidad
            Artisan::call('migrate', [
                '--path' => 'database/migrations/contabilidad',
                '--force' => true,
            ]);
            
            Log::info("Migraciones ejecutadas en esquema: {$esquema}");
            
        } finally {
            // Restaurar el esquema original
            config(['database.connections.pgsql.search_path' => $esquemaOriginal]);
            DB::purge('pgsql');
            DB::reconnect('pgsql');
        }
    }

    private function insertarDatosBasicos(Empresa $empresa): void
    {
        $esquemaOriginal = config('database.connections.pgsql.search_path', 'public');
        
        try {
            // Cambiar al esquema de la empresa
            config(['database.connections.pgsql.search_path' => $empresa->esquema]);
            DB::purge('pgsql');
            DB::reconnect('pgsql');
            
            // Insertar plan de cuentas básico
            $this->insertarPlanCuentasBasico();
            
            // Insertar centros de costo básicos
            $this->insertarCentrosCostoBasicos();
            
        } finally {
            // Restaurar esquema original
            config(['database.connections.pgsql.search_path' => $esquemaOriginal]);
            DB::purge('pgsql');
            DB::reconnect('pgsql');
        }
    }

    private function insertarPlanCuentasBasico(): void
    {
        $cuentas = [
            // Nivel 1
            ['codigo' => '1', 'nombre' => 'ACTIVO', 'tipo' => 'activo', 'nivel' => 1, 'acepta_movimiento' => false],
            ['codigo' => '2', 'nombre' => 'PASIVO', 'tipo' => 'pasivo', 'nivel' => 1, 'acepta_movimiento' => false],
            ['codigo' => '3', 'nombre' => 'PATRIMONIO', 'tipo' => 'patrimonio', 'nivel' => 1, 'acepta_movimiento' => false],
            ['codigo' => '4', 'nombre' => 'INGRESOS', 'tipo' => 'ingreso', 'nivel' => 1, 'acepta_movimiento' => false],
            ['codigo' => '5', 'nombre' => 'GASTOS', 'tipo' => 'gasto', 'nivel' => 1, 'acepta_movimiento' => false],
            
            // Nivel 2 - Activo
            ['codigo' => '1.1', 'nombre' => 'ACTIVO CORRIENTE', 'tipo' => 'activo', 'nivel' => 2, 'acepta_movimiento' => false],
            ['codigo' => '1.2', 'nombre' => 'ACTIVO NO CORRIENTE', 'tipo' => 'activo', 'nivel' => 2, 'acepta_movimiento' => false],
            
            // Nivel 3 - Caja y Bancos
            ['codigo' => '1.1.1', 'nombre' => 'CAJA', 'tipo' => 'activo', 'nivel' => 3, 'acepta_movimiento' => true],
            ['codigo' => '1.1.2', 'nombre' => 'BANCOS', 'tipo' => 'activo', 'nivel' => 3, 'acepta_movimiento' => true],
        ];

        foreach ($cuentas as $cuenta) {
            DB::table('plan_cuentas')->insert($cuenta);
        }
    }

    private function insertarCentrosCostoBasicos(): void
    {
        $centros = [
            ['codigo' => 'ADM', 'nombre' => 'ADMINISTRACIÓN', 'descripcion' => 'Centro de costo administrativo'],
            ['codigo' => 'VENT', 'nombre' => 'VENTAS', 'descripcion' => 'Centro de costo de ventas'],
            ['codigo' => 'PROD', 'nombre' => 'PRODUCCIÓN', 'descripcion' => 'Centro de costo de producción'],
        ];

        foreach ($centros as $centro) {
            DB::table('centros_costo')->insert($centro);
        }
    }

    private function sanitizeEsquemaName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
    }

    public function eliminarEsquemaEmpresa(Empresa $empresa): bool
    {
        try {
            DB::statement("DROP SCHEMA IF EXISTS {$empresa->esquema} CASCADE");
            Log::info("Esquema eliminado: {$empresa->esquema}");
            return true;
        } catch (\Exception $e) {
            Log::error("Error eliminando esquema {$empresa->esquema}: " . $e->getMessage());
            return false;
        }
    }
}