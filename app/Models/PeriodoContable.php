<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodoContable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periodos_contables';

    protected $fillable = [
        'ejercicio_fiscal_id',
        'nombre',
        'mes',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'cerrado',
        'fecha_cierre',
        'observaciones_cierre',
        'estado',
        'cerrado_por'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_cierre' => 'date',
        'activo' => 'boolean',
        'cerrado' => 'boolean',
        'mes' => 'integer',
    ];

    // Relaciones
    public function ejercicioFiscal()
    {
        return $this->belongsTo(EjercicioFiscal::class);
    }

    public function asientosContables()
    {
        return $this->hasMany(AsientoContable::class, 'periodo_contable_id');
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

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePorMes($query, $mes)
    {
        return $query->where('mes', $mes);
    }

    // Métodos
    public function puedeSerCerrado(): bool
    {
        return !$this->cerrado && 
               $this->asientosContables()->where('estado', '!=', 'APROBADO')->doesntExist();
    }

    public function estaAbierto(): bool
    {
        return !$this->cerrado && $this->activo;
    }

    public function obtenerTotalDebe()
    {
        return $this->asientosContables()
            ->where('estado', 'APROBADO')
            ->sum('total_debe');
    }

    public function obtenerTotalHaber()
    {
        return $this->asientosContables()
            ->where('estado', 'APROBADO')
            ->sum('total_haber');
    }
}