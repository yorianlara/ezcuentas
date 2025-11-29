<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar si el usuario es administrador
        // Asegúrate de que tu modelo User tenga el campo 'es_admin'
        if (!auth()->user()->es_admin) {
            // Si no es admin, redirigir según tenga empresas o no
            if (auth()->user()->empresas()->count() > 0) {
                return redirect()->route('seleccionar-empresa')
                    ->with('error', 'No tienes permisos para acceder al panel administrativo');
            } else {
                return redirect()->route('home')
                    ->with('error', 'No tienes permisos para acceder al panel administrativo');
            }
        }

        return $next($request);
    }
}