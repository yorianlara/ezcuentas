<?php

namespace App\Models\Traits;

use App\Models\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Session;

trait BelongsToEmpresa
{
    /**
     * Boot the BelongsToEmpresa trait for a model.
     */
    protected static function bootBelongsToEmpresa()
    {
        // Añadir el scope global
        static::addGlobalScope(new EmpresaScope);

        // Al crear un modelo, inyectar el tenant_id (empresa_id) si no existe
        static::creating(function ($model) {
            if (!$model->empresa_id) {
                $empresaId = Session::get('empresa_id');
                
                if (!$empresaId && request()->attributes->has('empresa_actual')) {
                    $empresaId = request()->attributes->get('empresa_actual')->id ?? null;
                }

                if ($empresaId) {
                    $model->empresa_id = $empresaId;
                }
            }
        });
    }

    /**
     * Get the empresa that owns the model.
     */
    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class, 'empresa_id');
    }
}
