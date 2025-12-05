<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('empresas')->latest()->get();
        return view('admin.usuarios.index', compact('users'));
    }

    public function list()
    {
        $users = User::withCount('empresas')->get();
        return response()->json($users);
    }

    public function create()
    {
        $empresas = Empresa::where('activo', true)->get();
        return view('admin.usuarios.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'es_admin' => 'boolean',
                'empresas' => 'nullable|array',
                'empresas.*' => 'exists:empresas,id'
            ]);

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'es_admin' => $request->es_admin ?? false,
                'activo' => true,
            ]);

            // Asignar empresas al usuario
            if ($request->empresas) {
                foreach ($request->empresas as $empresaId) {
                    $user->empresas()->attach($empresaId, [
                        'rol' => 'contador', // Rol por defecto
                        'activo' => true,
                        'fecha_inicio' => now()
                    ]);
                }
            }

            DB::commit();

            return  response()->json([
                'success' => 'success',
                'mensaje'=> 'Usuario creado exitosamente.',
                'user' => $user,
                'totalUsers' => User::count(),
                'totalActivos' => User::where('activo', true)->count(),
                'totalAdmin' => User::where('es_admin', true)->count()
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'success' => 'error',
                'mensaje'=> 'Error al crear el usuario.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show(User $user)
    {
        $user->load(['empresas' => function($query) {
            $query->withPivot('rol', 'activo', 'fecha_inicio');
        }]);
        
        return view('admin.usuarios.show', compact('user'));
    }

    public function edit(User $user)
    {
        $empresas = Empresa::where('activo', true)->get();
        $empresasUsuario = $user->empresas->pluck('id')->toArray();
        
        return view('admin.usuarios.edit', compact('user', 'empresas', 'empresasUsuario'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'es_admin' => 'boolean',
            'activo' => 'boolean',
            'empresas' => 'nullable|array',
            'empresas.*' => 'exists:empresas,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'es_admin' => $request->es_admin ?? false,
            'activo' => $request->activo ?? true,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sincronizar empresas
        if ($request->has('empresas')) {
            $empresasData = [];
            foreach ($request->empresas as $empresaId) {
                $empresasData[$empresaId] = [
                    'rol' => 'contador',
                    'activo' => true,
                    'fecha_inicio' => now()
                ];
            }
            $user->empresas()->sync($empresasData);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');

            // 'totalUsers' => User::count(),
            //     'totalActivos' => User::where('activo', true)->count(),
            //     'totalAdmin' => User::where('es_admin', true)->count()
    }

    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $user= User::findOrFail($id);

            if ($user->empresas()->count() > 0) {
                throw new \Exception('No se puede eliminar un usuario con empresas asociadas.');
            }

            $user->delete();

            DB::commit();

            return  response()->json([
                'success' => 'success',
                'mensaje'=> 'Usuario eliminado exitosamente.',
                'user' => $user,
                'totalUsers' => User::count(),
                'totalActivos' => User::where('activo', true)->count(),
                'totalAdmin' => User::where('es_admin', true)->count()
            ]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return  response()->json([
                'success' => 'error',
                'mensaje'=> 'Error al eliminar el usuario.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function asignarEmpresa(Request $request, User $user)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'rol' => 'required|in:admin,contador,auditor,lector'
        ]);

        $user->empresas()->attach($request->empresa_id, [
            'rol' => $request->rol,
            'activo' => true,
            'fecha_inicio' => now()
        ]);

        return back()->with('success', 'Usuario asignado a la empresa exitosamente.');
    }

    public function removerEmpresa(User $user, Empresa $empresa)
    {
        $user->empresas()->detach($empresa->id);

        return back()->with('success', 'Usuario removido de la empresa exitosamente.');
    }
}