<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SeleccionarEmpresaController extends Controller
{
    /**
     * Mostrar el formulario de selección de empresa
     */
    public function index()
    {
        $user = Auth::user();
        
        // Si es administrador, redirigir al dashboard administrativo
        if ($user->es_admin) {
            return redirect()->route('admin.dashboard')
                ->with('info', 'Acceso al panel administrativo');
        }

        // Obtener empresas activas del usuario
        $empresas = $user->empresas()
            ->where('empresa_user.activo', true)
            ->where('empresas.activo', true)
            ->orderBy('empresas.nombre')
            ->get();

        // Si no tiene empresas, redirigir con error
        if ($empresas->count() === 0) {
            Auth::logout(); // Cerrar sesión si no tiene empresas
            return redirect()->route('login')
                ->with('error', 'No tienes empresas asignadas. Contacta al administrador.');
        }

        // Si solo tiene una empresa, redirigir automáticamente
        if ($empresas->count() === 1) {
            return $this->seleccionar($empresas->first());
        }

        return view('empresa.seleccionar', compact('empresas'));
    }

    /**
     * Procesar la selección de empresa
     */
    public function seleccionar(Request $request, Empresa $empresa = null)
    {
        $user = Auth::user();

        // Si es administrador, no permitir seleccionar empresa
        if ($user->es_admin) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Los administradores no necesitan seleccionar empresa.');
        }

        // Si se pasa la empresa por parámetro (selección automática)
        if ($empresa) {
            $empresaSeleccionada = $empresa;
        } else {
            // Validar si se envió por formulario
            $request->validate([
                'empresa_id' => 'required|exists:empresas,id'
            ]);
            $empresaSeleccionada = Empresa::findOrFail($request->empresa_id);
        }

        // Verificar que el usuario tiene acceso a la empresa
        if (!$this->usuarioTieneAcceso($user, $empresaSeleccionada)) {
            return redirect()->route('seleccionar-empresa')
                ->with('error', 'No tienes acceso a esta empresa.');
        }

        // Verificar que la empresa está activa
        if (!$empresaSeleccionada->activo) {
            return redirect()->route('seleccionar-empresa')
                ->with('error', 'La empresa seleccionada no está activa.');
        }

        // Guardar empresa en sesión
        $this->guardarEmpresaEnSesion($empresaSeleccionada);

        // Redirigir al dashboard de la empresa
        return redirect()->route('dashboard.empresa')
            ->with('success', "Has seleccionado la empresa: {$empresaSeleccionada->nombre}");
    }

    /**
     * Cambiar de empresa (para usuarios con múltiples empresas)
     */
    public function cambiar(Request $request, Empresa $empresa)
    {
        $user = Auth::user();

        // Si es administrador, no permitir cambiar empresa
        if ($user->es_admin) {
            return back()->with('error', 'Los administradores no pueden cambiar de empresa.');
        }

        if (!$this->usuarioTieneAcceso($user, $empresa)) {
            return back()->with('error', 'No tienes acceso a esta empresa.');
        }

        if (!$empresa->activo) {
            return back()->with('error', 'La empresa seleccionada no está activa.');
        }

        // Guardar nueva empresa en sesión
        $this->guardarEmpresaEnSesion($empresa);

        return back()->with('success', "Has cambiado a la empresa: {$empresa->nombre}");
    }

    /**
     * Verificar si el usuario tiene acceso a la empresa
     */
    private function usuarioTieneAcceso($user, Empresa $empresa): bool
    {
        return $user->empresas()
            ->where('empresa_id', $empresa->id)
            ->where('empresa_user.activo', true)
            ->exists();
    }

    /**
     * Guardar información de la empresa en la sesión
     */
    private function guardarEmpresaEnSesion(Empresa $empresa): void
    {
        Session::put([
            'empresa_id' => $empresa->id,
            'empresa_nombre' => $empresa->nombre,
            'empresa_rif' => $empresa->rif,
            'empresa_esquema' => $empresa->esquema,
            'empresa_seleccionada' => true
        ]);
    }

    /**
     * Cerrar sesión de empresa (volver a selección)
     */
    public function cerrar()
    {
        $user = Auth::user();

        // Si es administrador, no permitir cerrar empresa
        if ($user->es_admin) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Los administradores no tienen sesión de empresa.');
        }

        // Limpiar sesión de empresa
        Session::forget([
            'empresa_id',
            'empresa_nombre', 
            'empresa_rif',
            'empresa_esquema',
            'empresa_seleccionada'
        ]);

        return redirect()->route('seleccionar-empresa')
            ->with('info', 'Sesión de empresa cerrada. Selecciona una empresa para continuar.');
    }

    /**
     * API: Listar empresas del usuario (para AJAX)
     */
    public function listarEmpresasUsuario()
    {
        $user = Auth::user();
        
        // Si es administrador, devolver todas las empresas activas
        if ($user->es_admin) {
            $empresas = Empresa::where('activo', true)
                ->select('id', 'nombre', 'rif', 'codigo')
                ->orderBy('nombre')
                ->get();
        } else {
            $empresas = $user->empresas()
                ->where('empresa_user.activo', true)
                ->where('empresas.activo', true)
                ->select('empresas.id', 'empresas.nombre', 'empresas.rif', 'empresas.codigo')
                ->orderBy('empresas.nombre')
                ->get();
        }

        return response()->json($empresas);
    }
}