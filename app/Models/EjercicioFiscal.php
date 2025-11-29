<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EjercicioFiscal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ejercicios_fiscales';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'anio',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'cerrado',
        'fecha_cierre',
        'observaciones_cierre',
        'cerrado_por'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_cierre' => 'date',
        'activo' => 'boolean',
        'cerrado' => 'boolean',
    ];

    // Relaciones
    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    public function periodosContables()
    {
        return $this->hasMany(PeriodoContable::class, 'ejercicio_fiscal_id');
    }

    public function cerradoPor()
    {
        return $this->belongsTo(User::class, 'cerrado_por');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeCerrado($query)
    {
        return $query->where('cerrado', true);
    }

    public function scopePorUnidadNegocio($query, $unidadNegocioId)
    {
        return $query->where('empresa_id', $unidadNegocioId);
    }

    // Métodos
    public function puedeSerCerrado(): bool
    {
        return !$this->cerrado && 
               $this->periodosContables()->where('cerrado', false)->doesntExist();
    }

    public function obtenerPeriodoPorFecha($fecha)
    {
        return $this->periodosContables()
            ->where('fecha_inicio', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha)
            ->first();
    }
}