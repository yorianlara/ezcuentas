<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_empresas' => Empresa::count(),
            'empresas_activas' => Empresa::where('activo', true)->count(),
            'total_usuarios' => User::count(),
            'usuarios_activos' => User::where('activo', true)->count(),
        ];

        $empresasRecientes = Empresa::withCount('users')
            ->latest()
            ->take(5)
            ->get();

        $usuariosRecientes = User::withCount('empresas')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'empresasRecientes', 'usuariosRecientes'));
    }
}