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
        // Excluir rutas que no requieren esquema de empresa
        if ($this->shouldSkipMiddleware($request)) {
            return $next($request);
        }

        // Solo aplicar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            
            // Si es administrador, usar siempre el esquema público
            if ($user->es_admin) {
                DB::statement("SET search_path TO public");
                return $next($request);
            }
            
            // Para usuarios normales: obtener empresa de la sesión
            $empresaId = Session::get('empresa_id');
            
            if (!$empresaId) {
                // Si no hay empresa seleccionada, redirigir a selección
                if (!$request->is('seleccionar-empresa') && !$request->is('logout')) {
                    return redirect()->route('seleccionar-empresa')
                        ->with('info', 'Por favor, selecciona una empresa para continuar.');
                }
                return $next($request);
            }

            // Verificar que la empresa existe y el usuario tiene acceso
            $empresa = $user->empresas()
                ->where('empresas.id', $empresaId)
                ->where('empresa_user.activo', true)
                ->first();

            if ($empresa) {
                // Cambiar al esquema de la empresa
                DB::statement("SET search_path TO {$empresa->esquema}");
                $request->attributes->set('empresa_actual', $empresa);
            } else {
                // Si no tiene acceso, limpiar sesión y redirigir
                Session::forget(['empresa_id', 'empresa_nombre', 'empresa_esquema']);
                return redirect()->route('seleccionar-empresa')
                    ->with('error', 'No tienes acceso a la empresa seleccionada.');
            }
        }
        
        return $next($request);
    }

    /**
     * Determinar si el middleware debe saltarse
     */
    private function shouldSkipMiddleware(Request $request): bool
    {
        $skipRoutes = [
            'admin/*',
            'api/admin/*',
            'seleccionar-empresa',
            'logout',
            'login',
            'register'
        ];

        foreach ($skipRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }
}