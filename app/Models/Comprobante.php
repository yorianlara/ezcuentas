<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comprobante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comprobantes';

    protected $fillable = [
        'tipo_comprobante_id',
        'empresa_id',
        'tercero_id',
        'asiento_contable_id',
        'prefijo',
        'numero',
        'numero_completo',
        'fecha_emision',
        'fecha_vencimiento',
        'fecha_recepcion',
        'subtotal',
        'total_impuestos',
        'total_retenciones',
        'total',
        'total_pagado',
        'saldo_pendiente',
        'estado',
        'estado_pago',
        'concepto',
        'observaciones',
        'referencia_externa',
        'documento_soporte',
        'creado_por',
        'aprobado_por',
        'fecha_aprobacion'
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_recepcion' => 'date',
        'subtotal' => 'decimal:2',
        'total_impuestos' => 'decimal:2',
        'total_retenciones' => 'decimal:2',
        'total' => 'decimal:2',
        'total_pagado' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'fecha_aprobacion' => 'datetime',
        'numero' => 'integer',
    ];

    // Relaciones
    public function tipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class);
    }

    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    public function tercero()
    {
        return $this->belongsTo(Tercero::class);
    }

    public function asientoContable()
    {
        return $this->belongsTo(AsientoContable::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleComprobante::class, 'comprobante_id');
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

    public function scopePorTipo($query, $tipoId)
    {
        return $query->where('tipo_comprobante_id', $tipoId);
    }

    public function scopePorTercero($query, $terceroId)
    {
        return $query->where('tercero_id', $terceroId);
    }

    public function scopePendientePago($query)
    {
        return $query->where('estado_pago', 'PENDIENTE')
                    ->orWhere('estado_pago', 'PARCIAL');
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        $fechaFin = $fechaFin ?? $fechaInicio;
        return $query->whereBetween('fecha_emision', [$fechaInicio, $fechaFin]);
    }

    // Métodos
    public function actualizarTotales()
    {
        $totales = $this->detalles()
            ->selectRaw('SUM(subtotal) as subtotal, SUM(total_impuestos) as impuestos, SUM(total_retenciones) as retenciones, SUM(total) as total')
            ->first();

        $this->subtotal = $totales->subtotal ?? 0;
        $this->total_impuestos = $totales->impuestos ?? 0;
        $this->total_retenciones = $totales->retenciones ?? 0;
        $this->total = $totales->total ?? 0;
        $this->saldo_pendiente = $this->total - $this->total_pagado;
        
        // Actualizar estado de pago
        if ($this->total_pagado >= $this->total) {
            $this->estado_pago = 'PAGADO';
        } elseif ($this->total_pagado > 0) {
            $this->estado_pago = 'PARCIAL';
        } else {
            $this->estado_pago = 'PENDIENTE';
        }

        $this->save();
    }

    public function puedeSerAprobado(): bool
    {
        return $this->estado === 'PENDIENTE' && 
               $this->total > 0 &&
               $this->detalles()->count() > 0;
    }

    public function generarAsientoContable()
    {
        // Lógica para generar asiento contable automático
        // Esto se implementaría según las reglas de negocio
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comprobante) {
            if (empty($comprobante->numero_completo)) {
                $comprobante->numero_completo = $comprobante->prefijo . '-' . str_pad($comprobante->numero, 8, '0', STR_PAD_LEFT);
            }
        });

        static::saving(function ($comprobante) {
            if ($comprobante->requiere_tercero && empty($comprobante->tercero_id)) {
                throw new \Exception('Este tipo de comprobante requiere un tercero.');
            }
        });
    }
}