<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TasaImpuesto extends Model
{
    use HasFactory;

    protected $table = 'tasas_impuesto';

    protected $fillable = [
        'tipo_impuesto_id',
        'tasa',
        'fecha_vigencia_inicio',
        'fecha_vigencia_fin',
        'observaciones',
        'activo',
        'creado_por'
    ];

    protected $casts = [
        'tasa' => 'decimal:4',
        'fecha_vigencia_inicio' => 'date',
        'fecha_vigencia_fin' => 'date',
        'activo' => 'boolean',
    ];

    // Relaciones
    public function tipoImpuesto()
    {
        return $this->belongsTo(TipoImpuesto::class, 'tipo_impuesto_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeVigente($query, $fecha = null)
    {
        $fecha = $fecha ?? now()->toDateString();
        
        return $query->where('fecha_vigencia_inicio', '<=', $fecha)
                    ->where(function($query) use ($fecha) {
                        $query->where('fecha_vigencia_fin', '>=', $fecha)
                              ->orWhereNull('fecha_vigencia_fin');
                    });
    }

    public function scopePorTipoImpuesto($query, $tipoImpuestoId)
    {
        return $query->where('tipo_impuesto_id', $tipoImpuestoId);
    }

    // Validaciones
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tasa) {
            // Validar que no se solapen vigencia para el mismo tipo de impuesto
            $solapada = static::where('tipo_impuesto_id', $tasa->tipo_impuesto_id)
                ->where('id', '!=', $tasa->id)
                ->where(function($query) use ($tasa) {
                    $query->where(function($q) use ($tasa) {
                        $q->where('fecha_vigencia_inicio', '<=', $tasa->fecha_vigencia_inicio)
                          ->where(function($q2) use ($tasa) {
                              $q2->where('fecha_vigencia_fin', '>=', $tasa->fecha_vigencia_inicio)
                                 ->orWhereNull('fecha_vigencia_fin');
                          });
                    })->orWhere(function($q) use ($tasa) {
                        $q->where('fecha_vigencia_inicio', '<=', $tasa->fecha_vigencia_fin ?? $tasa->fecha_vigencia_inicio)
                          ->where(function($q2) use ($tasa) {
                              $q2->where('fecha_vigencia_fin', '>=', $tasa->fecha_vigencia_fin ?? $tasa->fecha_vigencia_inicio)
                                 ->orWhereNull('fecha_vigencia_fin');
                          });
                    });
                })
                ->exists();

            if ($solapada) {
                throw new \Exception('Existe una tasa vigente que se solapa con las fechas especificadas.');
            }
        });
    }
}