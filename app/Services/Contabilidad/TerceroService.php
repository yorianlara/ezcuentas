<?php

namespace App\Services\Contabilidad;

use App\Models\Tercero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TerceroService
{
    /**
     * Create a new entity (Tercero).
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Generar código si no se proporciona
            if (empty($data['codigo'])) {
                $data['codigo'] = $this->generateUniqueCode($data['tipo']);
            }

            return Tercero::create($data);
        });
    }

    /**
     * Update an entity (Tercero).
     */
    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tercero = Tercero::findOrFail($id);
            $tercero->update($data);
            return $tercero;
        });
    }

    /**
     * Delete an entity (Soft delete).
     */
    public function delete($id)
    {
        $tercero = Tercero::findOrFail($id);
        
        // Verificar si tiene movimientos antes de eliminar (opcional, pero buena práctica)
        if ($tercero->detallesAsiento()->exists()) {
            throw new \Exception('No se puede eliminar un tercero que ya tiene movimientos contables.');
        }

        return $tercero->delete();
    }

    /**
     * Generate a unique code for the entity.
     */
    private function generateUniqueCode($tipo)
    {
        $prefijo = match($tipo) {
            'CLIENTE' => 'CLI-',
            'PROVEEDOR' => 'PRO-',
            'EMPLEADO' => 'EMP-',
            default => 'TER-',
        };

        $count = Tercero::where('tipo', $tipo)->count() + 1;
        $codigo = $prefijo . str_pad($count, 6, '0', STR_PAD_LEFT);

        // Asegurar unicidad total en caso de huecos
        while (Tercero::where('codigo', $codigo)->exists()) {
            $count++;
            $codigo = $prefijo . str_pad($count, 6, '0', STR_PAD_LEFT);
        }

        return $codigo;
    }

    /**
     * Get the balance of an entity.
     */
    public function getSaldo($id, $fecha = null)
    {
        $tercero = Tercero::findOrFail($id);
        return $tercero->obtenerSaldo($fecha);
    }
}
