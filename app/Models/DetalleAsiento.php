<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleAsiento extends Model
{
    use HasFactory;

    protected $table = 'detalles_asiento';

    protected $fillable = [
        'asiento_contable_id',
        'cuenta_contable_id',
        'tercero_id',
        'debe',
        'haber',
        'tipo_cambio',
        'concepto',
        'referencia',
        'tipo_movimiento',
        'afecta_base_impuesto',
        'base_imponible'
    ];

    protected $casts = [
        'debe' => 'decimal:2',
        'haber' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
        'base_imponible' => 'decimal:2',
        'afecta_base_impuesto' => 'boolean',
    ];

    // Relaciones
    public function asientoContable()
    {
        return $this->belongsTo(AsientoContable::class);
    }

    public function cuentaContable()
    {
        return $this->belongsTo(CuentaContable::class);
    }

    public function tercero()
    {
        return $this->belongsTo(Tercero::class);
    }

    public function impuestos()
    {
        return $this->hasMany(ImpuestoDetalleAsiento::class, 'detalle_asiento_id');
    }

    // Scopes
    public function scopePorCuenta($query, $cuentaId)
    {
        return $query->where('cuenta_contable_id', $cuentaId);
    }

    public function scopePorTercero($query, $terceroId)
    {
        return $query->where('tercero_id', $terceroId);
    }

    public function scopeDebe($query)
    {
        return $query->where('debe', '>', 0);
    }

    public function scopeHaber($query)
    {
        return $query->where('haber', '>', 0);
    }

    // Métodos
    public function obtenerMonto()
    {
        return $this->debe > 0 ? $this->debe : $this->haber;
    }

    public function obtenerNaturaleza()
    {
        return $this->debe > 0 ? 'DEBITO' : 'CREDITO';
    }

    // Validaciones
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detalle) {
            // Validar que la cuenta acepte movimientos
            if (!$detalle->cuentaContable->acepta_movimientos) {
                throw new \Exception('La cuenta contable no acepta movimientos.');
            }

            // Validar que no tenga débito y crédito simultáneos
            if ($detalle->debe > 0 && $detalle->haber > 0) {
                throw new \Exception('Un detalle no puede tener débito y crédito simultáneos.');
            }

            // Validar que la fecha esté en período abierto
            if ($detalle->asientoContable->periodoContable->cerrado) {
                throw new \Exception('No se pueden modificar detalles en períodos cerrados.');
            }
        });
    }
}