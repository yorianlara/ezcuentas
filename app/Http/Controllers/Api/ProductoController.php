<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Inventario\InventarioService;

class ProductoController extends Controller
{
    protected $inventarioService;

    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

    /**
     * List all products for the enterprise.
     */
    public function index(Request $request)
    {
        $empresaId = session('empresa_id') ?? 1;
        $productos = DB::table('productos')
            ->leftJoin('categorias_producto', 'productos.categoria_id', '=', 'categorias_producto.id')
            ->where('productos.empresa_id', $empresaId)
            ->where('productos.activo', true)
            ->select('productos.*', 'categorias_producto.nombre as categoria_nombre')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }

    /**
     * Create a new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'sku' => 'nullable|string|max:50',
            'categoria_id' => 'nullable|exists:categorias_producto,id',
            'unidad_medida' => 'required|string',
            'precio_venta' => 'required|numeric',
            'es_servicio' => 'boolean'
        ]);

        $empresaId = session('empresa_id') ?? 1;

        $id = DB::table('productos')->insertGetId([
            'empresa_id' => $empresaId,
            'categoria_id' => $request->categoria_id,
            'nombre' => $request->nombre,
            'sku' => $request->sku,
            'unidad_medida' => $request->unidad_medida,
            'precio_venta' => $request->precio_venta,
            'es_servicio' => $request->es_servicio ?? false,
            'stock_actual' => 0,
            'costo_promedio' => 0,
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado correctamente',
            'id' => $id
        ]);
    }

    /**
     * Get stock history (Kardex).
     */
    public function kardex($id)
    {
        $movimientos = DB::table('movimientos_inventario')
            ->where('producto_id', $id)
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $movimientos
        ]);
    }
}
