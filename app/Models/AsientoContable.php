<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsientoContable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asientos_contables';

    protected $fillable = [
        'periodo_contable_id',
        'empresa_id',
        'numero_asiento',
        'fecha_asiento',
        'concepto',
        'glosa',
        'total_debe',
        'total_haber',
        'diferencia',
        'estado',
        'origen',
        'referencia',
        'documento_soporte',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion'
    ];

    protected $casts = [
        'fecha_asiento' => 'date',
        'total_debe' => 'decimal:2',
        'total_haber' => 'decimal:2',
        'diferencia' => 'decimal:2',
        'fecha_aprobacion' => 'datetime',
    ];

    // Relaciones
    public function periodoContable()
    {
        return $this->belongsTo(PeriodoContable::class);
    }

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleAsiento::class, 'asiento_contable_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    // Scopes
    public function scopeAprobado($query)
    {
        return $query->where('estado', 'APROBADO');
    }

    public function scopePorPeriodo($query, $periodoId)
    {
        return $query->where('periodo_contable_id', $periodoId);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        $fechaFin = $fechaFin ?? $fechaInicio;
        return $query->whereBetween('fecha_asiento', [$fechaInicio, $fechaFin]);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Métodos de validación
    public function cuadra(): bool
    {
        return $this->total_debe === $this->total_haber && $this->diferencia == 0;
    }

    public function puedeSerAprobado(): bool
    {
        return $this->estado === 'PENDIENTE' && 
               $this->cuadra() && 
               !$this->periodoContable->cerrado;
    }

    public function puedeSerEditado(): bool
    {
        return in_array($this->estado, ['BORRADOR', 'PENDIENTE']) && 
               !$this->periodoContable->cerrado;
    }

    public function actualizarTotales()
    {
        $totales = $this->detalles()
            ->selectRaw('SUM(debe) as total_debe, SUM(haber) as total_haber')
            ->first();

        $this->total_debe = $totales->total_debe ?? 0;
        $this->total_haber = $totales->total_haber ?? 0;
        $this->diferencia = $this->total_debe - $this->total_haber;
        $this->save();
    }

    // Eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($asiento) {
            if ($asiento->periodoContable->cerrado) {
                throw new \Exception('No se pueden modificar asientos en períodos cerrados.');
            }

            // Validar que la fecha del asiento esté dentro del período
            if ($asiento->fecha_asiento < $asiento->periodoContable->fecha_inicio || 
                $asiento->fecha_asiento > $asiento->periodoContable->fecha_fin) {
                throw new \Exception('La fecha del asiento está fuera del rango del período contable.');
            }
        });

        static::created(function ($asiento) {
            // Generar número de asiento automático si no se proporcionó
            if (empty($asiento->numero_asiento)) {
                $asiento->numero_asiento = 'AS-' . str_pad($asiento->id, 6, '0', STR_PAD_LEFT);
                $asiento->save();
            }
        });
    }
}