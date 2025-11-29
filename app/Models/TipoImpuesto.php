<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoImpuesto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_impuesto';

    protected $fillable = [
        'codigo',
        'nombre',
        'naturaleza',
        'tipo_calculo',
        'descripcion',
        'activo',
        'configuracion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    // Relaciones
    public function tasas()
    {
        return $this->hasMany(TasaImpuesto::class, 'tipo_impuesto_id');
    }

    public function cuentasContables()
    {
        return $this->belongsToMany(CuentaContable::class, 'cuenta_impuesto')
                    ->withPivot('aplicable_debito', 'aplicable_credito', 'activo')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorNaturaleza($query, $naturaleza)
    {
        return $query->where('naturaleza', $naturaleza);
    }

    // Métodos de ayuda
    public function obtenerTasaVigente($fecha = null)
    {
        $fecha = $fecha ?? now()->toDateString();
        
        return $this->tasas()
            ->where('fecha_vigencia_inicio', '<=', $fecha)
            ->where(function($query) use ($fecha) {
                $query->where('fecha_vigencia_fin', '>=', $fecha)
                      ->orWhereNull('fecha_vigencia_fin');
            })
            ->where('activo', true)
            ->orderBy('fecha_vigencia_inicio', 'desc')
            ->first();
    }
}