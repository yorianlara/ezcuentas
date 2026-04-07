<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contabilidad\StoreAsientoContableRequest;
use App\Http\Requests\Contabilidad\UpdateAsientoContableRequest;
use App\Models\AsientoContable;
use App\Services\Contabilidad\AsientoContableService;
use Illuminate\Http\JsonResponse;
use Exception;

class AsientoContableController extends Controller
{
    private AsientoContableService $service;

    public function __construct(AsientoContableService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the journal entries.
     */
    public function index(): JsonResponse
    {
        // EmpresaScope is automatically applied via the BelongsToEmpresa trait
        $asientos = AsientoContable::with('periodoContable')
            ->orderBy('fecha_asiento', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $asientos
        ]);
    }

    /**
     * Store a newly created journal entry in storage.
     */
    public function store(StoreAsientoContableRequest $request): JsonResponse
    {
        try {
            $asiento = $this->service->crearAsiento($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Asiento contable creado exitosamente.',
                'data' => $asiento
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified journal entry.
     */
    public function show($id): JsonResponse
    {
        $asiento = AsientoContable::with(['detalles.cuentaContable', 'periodoContable', 'creadoPor', 'aprobadoPor'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $asiento
        ]);
    }

    /**
     * Update the specified journal entry in storage.
     */
    public function update(UpdateAsientoContableRequest $request, $id): JsonResponse
    {
        try {
            $asiento = AsientoContable::findOrFail($id);
            $asiento = $this->service->actualizarAsiento($asiento, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Asiento contable actualizado exitosamente.',
                'data' => $asiento
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified journal entry from storage.
     */
    public function destroy($id): JsonResponse
    {
        $asiento = AsientoContable::findOrFail($id);

        if (!$asiento->puedeSerEditado()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar un asiento aprobado o en un periodo cerrado.'
            ], 422);
        }

        $asiento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Asiento contable eliminado exitosamente.'
        ]);
    }

    /**
     * Approve the specified journal entry.
     */
    public function aprobar($id): JsonResponse
    {
        try {
            $asiento = AsientoContable::findOrFail($id);
            $asiento = $this->service->aprobarAsiento($asiento, auth()->id());

            return response()->json([
                'success' => true,
                'message' => 'Asiento contable aprobado exitosamente.',
                'data' => $asiento
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
