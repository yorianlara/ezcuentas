<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CuentaContable;
use Illuminate\Http\Request;

class CuentaContableController extends Controller
{
    /**
     * Get a tree view of the chart of accounts.
     */
    public function index(Request $request)
    {
        $cuentas = CuentaContable::orderBy('codigo', 'asc')->get();
        
        $tree = $this->buildTree($cuentas);

        return response()->json([
            'success' => true,
            'data' => $tree
        ]);
    }

    /**
     * Get only leaves (accounts that allow entries).
     */
    public function leaves(Request $request)
    {
        $cuentas = CuentaContable::where('es_cuenta_hoja', true)
            ->where('activo', true)
            ->orderBy('codigo', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cuentas
        ]);
    }

    /**
     * Recursive helper to build tree.
     */
    private function buildTree($cuentas, $parentId = null)
    {
        $branch = [];

        foreach ($cuentas as $cuenta) {
            if ($cuenta->cuenta_padre_id == $parentId) {
                $children = $this->buildTree($cuentas, $cuenta->id);
                $node = $cuenta->toArray();
                if ($children) {
                    $node['children'] = $children;
                }
                $branch[] = $node;
            }
        }

        return $branch;
    }
}
