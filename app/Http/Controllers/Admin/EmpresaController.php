<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use App\Services\EsquemaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    protected $esquemaService;

    public function __construct(EsquemaService $esquemaService)
    {
        $this->esquemaService = $esquemaService;
    }

    public function index()
    {
        $empresas = Empresa::withCount('users')->latest()->get();
        
        return view('admin.empresas.index', compact('empresas'));
    }

    public function listar(Request $request)
    {
        if ($request->has('activo')) {
            $empresas = Empresa::where('activo', $request->activo)->get();
        }else{
            $empresas = Empresa::all();
        }
        
        return response()->json($empresas);
    }

    public function create()
    {
        $usuarios = User::where('activo', true)->get();
        return view('admin.empresas.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:empresas,codigo',
            'nombre' => 'required|string|max:150',
            'razon_social' => 'required|string|max:200',
            'tipo_documento_fiscal_id' => 'nullable|exists:tipos_documento_fiscal,id',
            'numero_documento' => 'required|string|max:30|unique:empresas,numero_documento',
            'pais' => 'required|string|size:3',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'email' => 'required|email|max:100',
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();

        try {
            // Crear empresa
            $empresa = Empresa::create([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'razon_social' => $request->razon_social,
                'tipo_documento_fiscal_id' => $request->tipo_documento_fiscal_id,
                'numero_documento' => $request->numero_documento,
                'pais' => $request->pais,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'esquema' => 'empresa_' . Str::slug($request->numero_documento, '_'),
                'activo' => true,
            ]);

            // Crear esquema y tablas contables
            $this->esquemaService->crearEsquemaEmpresa($empresa);

            // Asociar usuarios a la empresa
            $usuarios = $request->usuarios ?? [];
            
            // Siempre asociar al usuario administrador actual
            if (!in_array(auth()->id(), $usuarios)) {
                $usuarios[] = auth()->id();
            }

            foreach ($usuarios as $usuarioId) {
                $empresa->users()->attach($usuarioId, [
                    'rol' => 'admin', // o definir lógica de roles
                    'activo' => true,
                    'fecha_inicio' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa creada exitosamente con su esquema contable.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log del error
            \Log::error('Error al crear empresa: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Error al crear la empresa: ' . $e->getMessage());
        }
    }

    public function show(Empresa $empresa)
    {
        $empresa->load(['users', 'tipoDocumentoFiscal']);
        
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        $usuarios = User::where('activo', true)->get();
        $usuariosEmpresa = $empresa->users->pluck('id')->toArray();
        
        return view('admin.empresas.edit', compact('empresa', 'usuarios', 'usuariosEmpresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('empresas')->ignore($empresa->id)
            ],
            'nombre' => 'required|string|max:150',
            'razon_social' => 'required|string|max:200',
            'tipo_documento_fiscal_id' => 'nullable|exists:tipos_documento_fiscal,id',
            'numero_documento' => [
                'required',
                'string',
                'max:30',
                Rule::unique('empresas')->ignore($empresa->id)
            ],
            'pais' => 'required|string|size:3',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'email' => 'required|email|max:100',
            'activo' => 'boolean',
        ]);

        try {
            $empresa->update([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'razon_social' => $request->razon_social,
                'tipo_documento_fiscal_id' => $request->tipo_documento_fiscal_id,
                'numero_documento' => $request->numero_documento,
                'pais' => $request->pais,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'activo' => $request->activo ?? true,
            ]);

            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa actualizada exitosamente.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar la empresa: ' . $e->getMessage());
        }
    }

    public function destroy(Empresa $empresa)
    {
        DB::beginTransaction();

        try {
            // Eliminar relaciones primero
            $empresa->users()->detach();
            
            // Eliminar empresa
            $empresa->delete();

            DB::commit();

            return redirect()->route('admin.empresas.index')
                ->with('success', 'Empresa eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar la empresa: ' . $e->getMessage());
        }
    }

    public function crearEsquema(Empresa $empresa)
    {
        try {
            $this->esquemaService->crearEsquemaEmpresa($empresa);
            
            return back()->with('success', 'Esquema contable creado exitosamente para la empresa.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el esquema: ' . $e->getMessage());
        }
    }

    public function migrarEsquema(Empresa $empresa)
    {
        try {
            $this->esquemaService->migrarEsquemaEmpresa($empresa);
            
            return back()->with('success', 'Migración ejecutada exitosamente en el esquema de la empresa.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al ejecutar migraciones: ' . $e->getMessage());
        }
    }

    public function asignarUsuarios(Request $request, Empresa $empresa)
    {
        $request->validate([
            'usuarios' => 'required|array',
            'usuarios.*' => 'exists:users,id',
            'rol' => 'required|in:admin,contador,auditor,lector'
        ]);

        try {
            foreach ($request->usuarios as $usuarioId) {
                $empresa->users()->syncWithoutDetaching([
                    $usuarioId => [
                        'rol' => $request->rol,
                        'activo' => true,
                        'fecha_inicio' => now()
                    ]
                ]);
            }

            return back()->with('success', 'Usuarios asignados exitosamente a la empresa.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar usuarios: ' . $e->getMessage());
        }
    }

    public function removerUsuario(Empresa $empresa, User $user)
    {
        try {
            $empresa->users()->detach($user->id);

            return back()->with('success', 'Usuario removido exitosamente de la empresa.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al remover usuario: ' . $e->getMessage());
        }
    }
}