<?php

namespace App\Services\Inventario;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InventarioService
{
    /**
     * Process a stock movement and update average cost.
     */
    public function registrarMovimiento(array $data)
    {
        return DB::transaction(function () use ($data) {
            $producto = DB::table('productos')->where('id', $data['producto_id'])->lockForUpdate()->first();
            
            $stockAntes = $producto->stock_actual;
            $cantidad = (float) $data['cantidad'];
            $tipo = $data['tipo_movimiento'];
            
            // Determinar si suma o resta al stock
            $esEntrada = in_array($tipo, ['ENTRADA', 'AJUSTE_POSITIVO']);
            $stockDespues = $esEntrada ? ($stockAntes + $cantidad) : ($stockAntes - $cantidad);
            
            // Recalcular costo promedio solo en ENTRADAS
            $nuevoCostoPromedio = $producto->costo_promedio;
            if ($tipo === 'ENTRADA' && $stockDespues > 0) {
                $valorActual = $stockAntes * $producto->costo_promedio;
                $valorNuevaCompra = $cantidad * (float) ($data['costo_unitario'] ?? 0);
                $nuevoCostoPromedio = ($valorActual + $valorNuevaCompra) / $stockDespues;
            }

            // 1. Insertar Movimiento
            DB::table('movimientos_inventario')->insert([
                'empresa_id' => $producto->empresa_id,
                'producto_id' => $producto->id,
                'fecha' => $data['fecha'] ?? Carbon::now()->toDateString(),
                'tipo_movimiento' => $tipo,
                'descripcion' => $data['descripcion'],
                'cantidad' => $cantidad,
                'costo_unitario' => (float) ($data['costo_unitario'] ?? $producto->costo_promedio),
                'stock_antes' => $stockAntes,
                'stock_despues' => $stockDespues,
                'referencia_tipo' => $data['referencia_tipo'] ?? null,
                'referencia_id' => $data['referencia_id'] ?? null,
                'creado_por' => Auth::id() ?? 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Actualizar Producto
            DB::table('productos')->where('id', $producto->id)->update([
                'stock_actual' => $stockDespues,
                'costo_promedio' => round($nuevoCostoPromedio, 4),
                'updated_at' => now()
            ]);

            return true;
        });
    }

    /**
     * Get stock levels for all products in an enterprise.
     */
    public function getStockActual($empresaId)
    {
        return DB::table('productos')
            ->where('empresa_id', $empresaId)
            ->where('activo', true)
            ->where('es_servicio', false)
            ->get();
    }
}
