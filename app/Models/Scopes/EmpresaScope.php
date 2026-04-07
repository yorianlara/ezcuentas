<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class EmpresaScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // En aplicaciones por consola o donde no aplique tenant o usuario
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        // Si tenemos un id de empresa en sesión o en un contexto global (en caso de APIs)
        $empresaId = Session::get('empresa_id');
        
        // En un entorno de API puro no tendremos session() si usamos Sanctum, 
        // pero podemos tener request()->attributes->get('empresa_actual')
        if (!$empresaId && request()->attributes->has('empresa_actual')) {
            $empresaId = request()->attributes->get('empresa_actual')->id ?? null;
        }

        if ($empresaId) {
            $builder->where($model->getTable() . '.empresa_id', $empresaId);
        }
    }
}
