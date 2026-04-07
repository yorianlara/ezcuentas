<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Traits\BelongsToEmpresa;

class Tercero extends Model
{
    use HasFactory, SoftDeletes, BelongsToEmpresa;

    protected $table = 'terceros';

    protected $fillable = [
        'empresa_id',
        'tipo',
        'codigo',
        'razon_social',
        'nombre_comercial',
        'tipo_documento',
        'numero_documento',
        'email',
        'telefono',
        'direccion',
        'contribuyente',
        'condicion_iva',
        'activo',
        'bloqueado'
    ];

    protected $casts = [
        'contribuyente' => 'boolean',
        'activo' => 'boolean',
        'bloqueado' => 'boolean',
    ];

    // Relaciones


    public function contactos()
    {
        return $this->hasMany(ContactoTercero::class, 'tercero_id');
    }

    public function detallesAsiento()
    {
        return $this->hasMany(DetalleAsiento::class, 'tercero_id');
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeCliente($query)
    {
        return $query->where('tipo', 'CLIENTE');
    }

    public function scopeProveedor($query)
    {
        return $query->where('tipo', 'PROVEEDOR');
    }

    // Métodos
    public function contactoPrincipal()
    {
        return $this->contactos()->where('contacto_principal', true)->first();
    }

    public function obtenerSaldo($fecha = null)
    {
        // Implementar cálculo de saldo según movimientos
        $query = $this->detallesAsiento()
            ->join('asientos_contables', 'detalles_asiento.asiento_contable_id', '=', 'asientos_contables.id')
            ->where('asientos_contables.estado', 'APROBADO');

        if ($fecha) {
            $query->where('asientos_contables.fecha_asiento', '<=', $fecha);
        }

        $totales = $query->selectRaw('SUM(debe) as total_debe, SUM(haber) as total_haber')
            ->first();

        return ($totales->total_debe ?? 0) - ($totales->total_haber ?? 0);
    }
}