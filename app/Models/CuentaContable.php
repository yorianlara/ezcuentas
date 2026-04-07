<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\BelongsToEmpresa;

class CuentaContable extends Model
{
    use HasFactory, SoftDeletes, BelongsToEmpresa;

    protected $table = 'cuentas_contables';

    protected $fillable = [
        'empresa_id',
        'tipo_cuenta_id',
        'cuenta_padre_id',
        'codigo',
        'nombre',
        'descripcion',
        'nivel',
        'es_cuenta_hoja',
        'acepta_movimientos',
        'activo',
        'es_banco',
        'es_efectivo',
        'es_tercero',
        'saldo_inicial',
        'fecha_saldo_inicial'
    ];

    protected $casts = [
        'es_cuenta_hoja' => 'boolean',
        'acepta_movimientos' => 'boolean',
        'activo' => 'boolean',
        'es_banco' => 'boolean',
        'es_efectivo' => 'boolean',
        'es_tercero' => 'boolean',
        'saldo_inicial' => 'decimal:2',
        'fecha_saldo_inicial' => 'date',
    ];

    // Relaciones


    public function tipoCuenta(): BelongsTo
    {
        return $this->belongsTo(TipoCuenta::class);
    }

    public function cuentaPadre(): BelongsTo
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_padre_id');
    }

    public function cuentasHijas(): HasMany
    {
        return $this->hasMany(CuentaContable::class, 'cuenta_padre_id');
    }

    public function impuestos()
    {
        return $this->belongsToMany(TipoImpuesto::class, 'cuenta_impuesto')
                    ->withPivot('aplicable_debito', 'aplicable_credito', 'activo')
                    ->withTimestamps();
    }

    // Métodos para manejo jerárquico
    public function obtenerCuentasDescendientes()
    {
        return $this->cuentasHijas()->with('obtenerCuentasDescendientes');
    }

    public function obtenerArbolCompleto()
    {
        return $this->load('cuentasHijas.obtenerArbolCompleto');
    }

    public function esDescendienteDe(CuentaContable $cuenta): bool
    {
        $current = $this;
        while ($current->cuenta_padre_id) {
            if ($current->cuenta_padre_id === $cuenta->id) {
                return true;
            }
            $current = $current->cuentaPadre;
        }
        return false;
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeCuentasHoja($query)
    {
        return $query->where('es_cuenta_hoja', true);
    }

    public function scopeAceptaMovimientos($query)
    {
        return $query->where('acepta_movimientos', true);
    }

    public function scopePorUnidadNegocio($query, $unidadNegocioId)
    {
        return $query->where('empresa_id', $unidadNegocioId);
    }

    public function scopePorTipoCuenta($query, $tipoCuentaId)
    {
        return $query->where('tipo_cuenta_id', $tipoCuentaId);
    }
}