<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use App\Services\Contabilidad\ComprobanteService;
use App\Http\Requests\Contabilidad\StoreComprobanteRequest;
use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    protected $comprobanteService;

    public function __construct(ComprobanteService $comprobanteService)
    {
        $this->comprobanteService = $comprobanteService;
    }

    /**
     * Display a listing of vouchers.
     */
    public function index(Request $request)
    {
        $query = Comprobante::with(['tipoComprobante', 'tercero', 'asientoContable']);

        // Filtros
        if ($request->has('tipo_id')) {
            $query->where('tipo_comprobante_id', $request->tipo_id);
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('tercero_id')) {
            $query->where('tercero_id', $request->tercero_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('fecha_emision', 'desc')->paginate($request->get('limit', 15))
        ]);
    }

    /**
     * Store a newly created voucher.
     */
    public function store(StoreComprobanteRequest $request)
    {
        try {
            $data = $request->validated();
            // Inyectar empresa_id desde el contexto (session o request)
            $data['empresa_id'] = session('empresa_id') ?? 1; 

            $comprobante = $this->comprobanteService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Comprobante creado exitosamente en estado BORRADOR.',
                'data' => $comprobante
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el comprobante: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified voucher.
     */
    public function show($id)
    {
        $comprobante = Comprobante::with(['tipoComprobante', 'tercero', 'detalles', 'asientoContable.detalles'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $comprobante
        ]);
    }

    /**
     * Approve the voucher and trigger accounting entries.
     */
    public function aprobar($id)
    {
        try {
            $comprobante = $this->comprobanteService->aprobar($id);

            return response()->json([
                'success' => true,
                'message' => 'Comprobante aprobado y asiento contable generado exitosamente.',
                'data' => $comprobante
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el comprobante: ' . $e->getMessage()
            ], 422);
        }
    }
}
