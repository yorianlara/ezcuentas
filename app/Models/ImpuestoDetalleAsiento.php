<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImpuestoDetalleAsiento extends Model
{
    use HasFactory;

    protected $table = 'impuestos_detalle_asiento';

    protected $fillable = [
        'detalle_asiento_id',
        'tipo_impuesto_id',
        'tasa_impuesto_id',
        'base_imponible',
        'tasa_aplicada',
        'monto_impuesto',
        'monto_retencion',
        'naturaleza',
        'es_retencion',
        'cuenta_impuesto_id',
        'cuenta_retencion_id',
        'concepto'
    ];

    protected $casts = [
        'base_imponible' => 'decimal:2',
        'tasa_aplicada' => 'decimal:4',
        'monto_impuesto' => 'decimal:2',
        'monto_retencion' => 'decimal:2',
        'es_retencion' => 'boolean',
    ];

    // Relaciones
    public function detalleAsiento()
    {
        return $this->belongsTo(DetalleAsiento::class);
    }

    public function tipoImpuesto()
    {
        return $this->belongsTo(TipoImpuesto::class);
    }

    public function tasaImpuesto()
    {
        return $this->belongsTo(TasaImpuesto::class);
    }

    public function cuentaImpuesto()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_impuesto_id');
    }

    public function cuentaRetencion()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_retencion_id');
    }

    // Métodos
    public function calcularImpuesto()
    {
        $this->monto_impuesto = $this->base_imponible * ($this->tasa_aplicada / 100);
        
        if ($this->es_retencion) {
            $this->monto_retencion = $this->monto_impuesto;
            $this->monto_impuesto = 0;
        }
        
        return $this;
    }

    public function obtenerMontoNeto()
    {
        if ($this->es_retencion) {
            return $this->base_imponible - $this->monto_retencion;
        }
        
        return $this->base_imponible + $this->monto_impuesto;
    }
}