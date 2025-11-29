<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empresas';

    protected $fillable = [
        'codigo',
        'nombre',
        'rif',
        'direccion',
        'telefono',
        'email',
        'activo',
        'configuracion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    // Relaciones
    public function cuentasContables()
    {
        return $this->hasMany(CuentaContable::class, 'empresa_id');
    }

    public function ejerciciosFiscales()
    {
        return $this->hasMany(EjercicioFiscal::class, 'empresa_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'empresa_user')
                    ->withPivot('rol', 'activo', 'fecha_inicio', 'fecha_fin')
                    ->withTimestamps()
                    ->wherePivot('activo', true);
    }
}