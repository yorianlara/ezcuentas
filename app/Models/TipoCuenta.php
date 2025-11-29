<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoCuenta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_cuenta';

    protected $fillable = [
        'codigo',
        'nombre',
        'naturaleza',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relaciones
    public function cuentasContables()
    {
        return $this->hasMany(CuentaContable::class, 'tipo_cuenta_id');
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
}