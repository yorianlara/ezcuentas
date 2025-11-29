<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleComprobante extends Model
{
    use HasFactory;

    protected $table = 'detalles_comprobante';

    protected $fillable = [
        'comprobante_id',
        'producto_id',
        'cuenta_contable_id',
        'descripcion',
        'observaciones',
        'cantidad',
        'precio_unitario',
        'descuento_porcentaje',
        'descuento_monto',
        'subtotal',
        'total_impuestos',
        'total_retenciones',
        'total',
        'detalle_asiento_id',
        'afecta_inventario'
    ];

    protected $casts = [
        'cantidad' => 'decimal:4',
        'precio_unitario' => 'decimal:4',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_impuestos' => 'decimal:2',
        'total_retenciones' => 'decimal:2',
        'total' => 'decimal:2',
        'afecta_inventario' => 'boolean',
    ];

    // Relaciones
    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class);
    }

    public function detalleAsiento()
    {
        return $this->belongsTo(DetalleAsiento::class);
    }

    public function movimientosInventario()
    {
        return $this->hasMany(Inventario::class, 'detalle_comprobante_id');
    }

    // Métodos
    public function calcularTotales()
    {
        $subtotal = $this->cantidad * $this->precio_unitario;
        $descuento = $this->descuento_monto + ($subtotal * ($this->descuento_porcentaje / 100));
        
        $this->subtotal = $subtotal - $descuento;
        
        // Los impuestos se calcularían según la configuración
        // $this->total_impuestos = ...;
        // $this->total_retenciones = ...;
        
        $this->total = $this->subtotal + $this->total_impuestos - $this->total_retenciones;
        
        return $this;
    }

    public function obtenerMontoNeto()
    {
        return $this->subtotal;
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detalle) {
            $detalle->calcularTotales();
            
            // Si afecta inventario, validar que tenga producto
            if ($detalle->afecta_inventario && empty($detalle->producto_id)) {
                throw new \Exception('Los detalles que afectan inventario deben tener un producto asociado.');
            }
        });

        static::saved(function ($detalle) {
            // Actualizar totales del comprobante padre
            $detalle->comprobante->actualizarTotales();
        });

        static::deleted(function ($detalle) {
            // Actualizar totales del comprobante padre
            $detalle->comprobante->actualizarTotales();
        });
    }
}