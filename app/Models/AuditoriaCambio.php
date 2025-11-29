<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditoriaCambio extends Model
{
    use HasFactory;

    protected $table = 'auditoria_cambios';

    protected $fillable = [
        'tabla_afectada',
        'registro_id',
        'accion',
        'valores_anteriores',
        'valores_nuevos',
        'observaciones',
        'ip_address',
        'user_agent',
        'url',
        'usuario_id'
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Scopes
    public function scopePorTabla($query, $tabla)
    {
        return $query->where('tabla_afectada', $tabla);
    }

    public function scopePorRegistro($query, $tabla, $registroId)
    {
        return $query->where('tabla_afectada', $tabla)
                    ->where('registro_id', $registroId);
    }

    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('created_at', $fecha);
    }

    // Métodos
    public function obtenerCambiosResumen()
    {
        $camposModificados = [];
        
        if ($this->accion === 'UPDATE' && is_array($this->valores_anteriores) && is_array($this->valores_nuevos)) {
            foreach ($this->valores_nuevos as $campo => $valorNuevo) {
                $valorAnterior = $this->valores_anteriores[$campo] ?? null;
                if ($valorAnterior != $valorNuevo) {
                    $camposModificados[] = $campo;
                }
            }
        }
        
        return $camposModificados;
    }

    public function esCreacion(): bool
    {
        return $this->accion === 'CREATE';
    }

    public function esActualizacion(): bool
    {
        return $this->accion === 'UPDATE';
    }

    public function esEliminacion(): bool
    {
        return $this->accion === 'DELETE';
    }
}