<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoComprobante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_comprobante';

    protected $fillable = [
        'codigo',
        'nombre',
        'abreviatura',
        'naturaleza',
        'afecta_caja',
        'afecta_banco',
        'requiere_tercero',
        'activo',
        'configuracion'
    ];

    protected $casts = [
        'afecta_caja' => 'boolean',
        'afecta_banco' => 'boolean',
        'requiere_tercero' => 'boolean',
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    // Relaciones
    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class, 'tipo_comprobante_id');
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

    public function scopeAfectaCaja($query)
    {
        return $query->where('afecta_caja', true);
    }

    // Métodos
    public function esDeIngreso(): bool
    {
        return $this->naturaleza === 'INGRESO';
    }

    public function esDeEgreso(): bool
    {
        return $this->naturaleza === 'EGRESO';
    }
}