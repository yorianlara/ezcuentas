<?php
// app/Models/TipoDocumentoFiscal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumentoFiscal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_documento_fiscal';

    protected $fillable = [
        'codigo', 
        'nombre', 
        'pais', 
        'formato', 
        'descripcion', 
        'activo', 
        'longitud', 
        'configuracion'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    // Relaciones
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'tipo_documento_fiscal_id');
    }

    // Scopes
    public function scopePorPais($query, $pais)
    {
        return $query->where('pais', $pais)->where('activo', true);
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Métodos de ayuda
    public function validarFormato($numero): bool
    {
        if (!$this->formato) {
            return true; // Sin formato definido
        }

        return preg_match($this->formato, $numero) === 1;
    }

    public function obtenerEjemplo(): string
    {
        return match($this->codigo) {
            'RIF' => 'J-123456789-0',
            'NIF' => 'A12345678',
            'CUIT' => '20-12345678-9',
            'VAT' => 'GB123456789',
            'NIT' => '123456789-0',
            'RFC' => 'XAXX010101000',
            default => 'Consultar formato'
        };
    }
}