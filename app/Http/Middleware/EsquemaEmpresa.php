<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EsquemaEmpresa
{
    public function handle(Request $request, Closure $next): Response
    {
        // Excluir rutas administrativas del cambio de esquema
        if ($this->esRutaAdministrativa($request)) {
            // Para rutas admin, asegurarnos de usar el esquema público
            DB::statement("SET search_path TO public");
            return $next($request);
        }

        // Solo aplicar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            
            // Obtener empresa de la sesión
            $empresaId = Session::get('empresa_id');
            
            if ($empresaId) {
                $empresa = $user->empresas()
                    ->where('empresas.id', $empresaId)
                    ->where('empresa_user.activo', true)
                    ->first();
                
                if ($empresa) {
                    // Cambiar al esquema de la empresa
                    DB::statement("SET search_path TO {$empresa->esquema}");
                    $request->attributes->set('empresa_actual', $empresa);
                } else {
                    // Si no tiene acceso, redirigir a selección
                    return redirect()->route('seleccionar-empresa')
                        ->with('error', 'No tienes acceso a la empresa seleccionada');
                }
            } else {
                // Si no hay empresa en sesión, redirigir a selección
                if (!$request->is('seleccionar-empresa')) {
                    return redirect()->route('seleccionar-empresa');
                }
            }
        }
        
        return $next($request);
    }

    private function esRutaAdministrativa(Request $request): bool
    {
        return $request->is('admin/*') || 
               $request->is('api/admin/*') ||
               ($request->is('seleccionar-empresa') && !$request->isMethod('post'));
    }
}