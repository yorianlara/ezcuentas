<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactoTercero extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contactos_tercero';

    protected $fillable = [
        'tercero_id',
        'nombre',
        'apellido',
        'cargo',
        'email',
        'telefono',
        'celular',
        'observaciones',
        'contacto_principal',
        'activo'
    ];

    protected $casts = [
        'contacto_principal' => 'boolean',
        'activo' => 'boolean',
    ];

    // Relaciones
    public function tercero()
    {
        return $this->belongsTo(Tercero::class);
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePrincipal($query)
    {
        return $query->where('contacto_principal', true);
    }

    // Métodos
    public function obtenerNombreCompleto()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}