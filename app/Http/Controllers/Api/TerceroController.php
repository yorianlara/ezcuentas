<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tercero;
use App\Services\Contabilidad\TerceroService;
use App\Http\Requests\Contabilidad\StoreTerceroRequest;
use Illuminate\Http\Request;

class TerceroController extends Controller
{
    protected $terceroService;

    public function __construct(TerceroService $terceroService)
    {
        $this->terceroService = $terceroService;
    }

    /**
     * Display a listing of entities.
     */
    public function index(Request $request)
    {
        $query = Tercero::query();

        // Filtros
        if ($request->has('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->has('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('razon_social', 'LIKE', "%$search%")
                  ->orWhere('numero_documento', 'LIKE', "%$search%")
                  ->orWhere('codigo', 'LIKE', "%$search%");
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate($request->get('limit', 15))
        ]);
    }

    /**
     * Store a newly created entity.
     */
    public function store(StoreTerceroRequest $request)
    {
        try {
            $tercero = $this->terceroService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tercero creado exitosamente',
                'data' => $tercero
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el tercero: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified entity with balance.
     */
    public function show($id)
    {
        $tercero = Tercero::with('contactos')->findOrFail($id);
        
        $balance = $this->terceroService->getSaldo($id);

        return response()->json([
            'success' => true,
            'data' => $tercero,
            'meta' => [
                'saldo_actual' => $balance
            ]
        ]);
    }

    /**
     * Update the specified entity.
     */
    public function update(StoreTerceroRequest $request, $id)
    {
        try {
            $tercero = $this->terceroService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tercero actualizado exitosamente',
                'data' => $tercero
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tercero: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified entity.
     */
    public function destroy($id)
    {
        try {
            $this->terceroService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Tercero eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
