<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'empresa_id',
        'clave',
        'valor',
        'tipo',
        'categoria',
        'descripcion',
        'opciones',
        'editable',
        'requerido'
    ];

    protected $casts = [
        'opciones' => 'array',
        'editable' => 'boolean',
        'requerido' => 'boolean',
    ];

    // Relaciones
    public function unidadNegocio()
    {
        return $this->belongsTo(UnidadNegocio::class);
    }

    // Scopes
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeEditables($query)
    {
        return $query->where('editable', true);
    }

    public function scopeGlobales($query)
    {
        return $query->whereNull('empresa_id');
    }

    // Métodos
    public function obtenerValorConvertido()
    {
        return match ($this->tipo) {
            'integer' => (int) $this->valor,
            'boolean' => (bool) $this->valor,
            'decimal' => (float) $this->valor,
            'json' => json_decode($this->valor, true),
            default => $this->valor,
        };
    }

    public function establecerValor($valor)
    {
        $this->valor = match ($this->tipo) {
            'integer', 'boolean', 'decimal' => (string) $valor,
            'json' => json_encode($valor),
            default => $valor,
        };
    }

    // Método estático para obtener configuración fácilmente
    public static function obtener($clave, $unidadNegocioId = null, $default = null)
    {
        $config = static::where('clave', $clave)
            ->where('empresa_id', $unidadNegocioId)
            ->first();

        if (!$config && $unidadNegocioId !== null) {
            // Buscar configuración global
            $config = static::where('clave', $clave)
                ->whereNull('empresa_id')
                ->first();
        }

        return $config ? $config->obtenerValorConvertido() : $default;
    }
}