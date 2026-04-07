<?php

namespace App\Services\Contabilidad;

use App\Models\Comprobante;
use App\Models\DetalleComprobante;
use App\Models\AsientoContable;
use App\Models\TipoComprobante;
use App\Models\PeriodoContable;
use App\Models\TasaImpuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Contabilidad\TaxService;
use App\Services\Inventario\InventarioService;

class ComprobanteService
{
    protected $asientoService;
    protected $taxService;
    protected $inventarioService;

    public function __construct(AsientoContableService $asientoService, TaxService $taxService, InventarioService $inventarioService)
    {
        $this->asientoService = $asientoService;
        $this->taxService = $taxService;
        $this->inventarioService = $inventarioService;
    }

    /**
     * Create a new business document (Voucher).
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tipo = TipoComprobante::findOrFail($data['tipo_comprobante_id']);
            $empresaId = $data['empresa_id'];

            // Generar numeración
            $prefijo = $tipo->configuracion['prefijo'] ?? $tipo->abreviatura;
            $numero = $this->getNextNumber($empresaId, $prefijo);
            
            $comprobante = Comprobante::create([
                'empresa_id' => $empresaId,
                'tipo_comprobante_id' => $tipo->id,
                'tercero_id' => $data['tercero_id'],
                'prefijo' => $prefijo,
                'numero' => $numero,
                'numero_completo' => $prefijo . '-' . str_pad($numero, 8, '0', STR_PAD_LEFT),
                'fecha_emision' => $data['fecha_emision'],
                'fecha_vencimiento' => $data['fecha_vencimiento'] ?? $data['fecha_emision'],
                'concepto' => $data['concepto'],
                'subtotal' => $data['subtotal'] ?? 0,
                'total_impuestos' => $data['total_impuestos'] ?? 0,
                'total_retenciones' => $data['total_retenciones'] ?? 0,
                'total' => $data['total'] ?? 0,
                'saldo_pendiente' => $data['total'] ?? 0,
                'estado' => 'BORRADOR',
                'creado_por' => Auth::id() ?? 1
            ]);

            foreach ($data['detalles'] as $d) {
                $detalle = $comprobante->detalles()->create([
                    'producto_id' => $d['producto_id'] ?? null,
                    'cuenta_contable_id' => $d['cuenta_contable_id'],
                    'descripcion' => $d['descripcion'],
                    'cantidad' => $d['cantidad'] ?? 1,
                    'precio_unitario' => $d['precio_unitario'],
                    'subtotal' => $d['subtotal'],
                    'total_impuestos' => $d['total_impuestos'] ?? 0,
                    'total' => $d['total']
                ]);

                // Guardar impuestos por detalle si existen
                if (!empty($d['impuestos'])) {
                    foreach ($d['impuestos'] as $imp) {
                        DB::table('impuestos_detalle_comprobante')->insert([
                            'detalle_comprobante_id' => $detalle->id,
                            'tasa_impuesto_id' => $imp['tasa_impuesto_id'],
                            'base_imponible' => $imp['base_imponible'],
                            'monto_impuesto' => $imp['monto_impuesto'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            return $comprobante;
        });
    }

    /**
     * Approve a voucher and generate the accounting entry.
     */
    public function aprobar($id)
    {
        return DB::transaction(function () use ($id) {
            $comprobante = Comprobante::with(['detalles', 'tipoComprobante', 'tercero'])->findOrFail($id);

            if ($comprobante->estado !== 'BORRADOR') {
                throw new \Exception('Solo se pueden aprobar comprobantes en estado BORRADOR.');
            }

            $tipo = $comprobante->tipoComprobante;
            $config = $tipo->configuracion;

            // Resolver periodo contable
            $periodo = PeriodoContable::where('empresa_id', $comprobante->empresa_id)
                ->where('fecha_inicio', '<=', $comprobante->fecha_emision)
                ->where('fecha_fin', '>=', $comprobante->fecha_emision)
                ->where('activo', true)
                ->first();

            if (!$periodo) {
                throw new \Exception('No existe un periodo contable abierto para la fecha ' . $comprobante->fecha_emision);
            }

            // Preparar datos para el asiento contable
            $datosAsiento = [
                'empresa_id' => $comprobante->empresa_id,
                'periodo_contable_id' => $periodo->id,
                'fecha_asiento' => $comprobante->fecha_emision,
                'concepto' => $comprobante->concepto,
                'glosa' => $comprobante->concepto . ' (' . $comprobante->numero_completo . ')',
                'estado' => 'PENDIENTE',
                'detalles' => []
            ];

            // 1. Líneas de detalle (Cuentas de Ingreso/Gasto)
            foreach ($comprobante->detalles as $detalle) {
                $esIngreso = ($tipo->naturaleza === 'INGRESO');
                
                $datosAsiento['detalles'][] = [
                    'cuenta_contable_id' => $detalle->cuenta_contable_id,
                    'tercero_id' => $comprobante->tercero_id,
                    'descripcion' => $detalle->descripcion,
                    'debe' => $esIngreso ? 0 : $detalle->subtotal, // Usar subtotal sin impuestos
                    'haber' => $esIngreso ? $detalle->subtotal : 0
                ];

                // 1.1 Líneas de impuestos asociadas al detalle
                $impuestosDetalle = DB::table('impuestos_detalle_comprobante')
                    ->where('detalle_comprobante_id', $detalle->id)
                    ->get();

                foreach ($impuestosDetalle as $imp) {
                    $tasa = TasaImpuesto::with('tipoImpuesto')->find($imp->tasa_impuesto_id);
                    $cuentaTax = $this->taxService->getTaxAccount($tasa->tipo_impuesto_id, $comprobante->empresa_id);

                    if (!$cuentaTax) {
                        throw new \Exception('No se ha configurado una cuenta contable para el impuesto ' . $tasa->tipoImpuesto->nombre);
                    }

                    $datosAsiento['detalles'][] = [
                        'cuenta_contable_id' => $cuentaTax->id,
                        'tercero_id' => $comprobante->tercero_id,
                        'descripcion' => 'Impuesto: ' . $tasa->tipoImpuesto->nombre . ' (' . ($tasa->tasa*1) . '%)',
                        'debe' => $esIngreso ? 0 : $imp->monto_impuesto,
                        'haber' => $esIngreso ? $imp->monto_impuesto : 0
                    ];
                }
            }

            // 2. Línea de contrapartida (Cartera o Pasivo o Caja)
            $cuentaContraId = $config['cuenta_defecto_id'] ?? null;
            if (!$cuentaContraId) {
                throw new \Exception('El tipo de comprobante no tiene configurada una cuenta de contrapartida por defecto.');
            }

            $esIngreso = ($tipo->naturaleza === 'INGRESO');
            $datosAsiento['detalles'][] = [
                'cuenta_contable_id' => $cuentaContraId,
                'tercero_id' => $comprobante->tercero_id,
                'descripcion' => 'Contrapartida: ' . $comprobante->numero_completo,
                'debe' => $esIngreso ? $comprobante->total : 0,
                'haber' => $esIngreso ? 0 : $comprobante->total
            ];

            // Crear el asiento contable
            $asiento = $this->asientoService->crearAsiento($datosAsiento);
            
            // Aprobar el asiento automáticamente
            $this->asientoService->aprobarAsiento($asiento, Auth::id() ?? 1);

            // Actualizar comprobante
            $comprobante->update([
                'estado' => 'APROBADO',
                'asiento_contable_id' => $asiento->id,
                'aprobado_por' => Auth::id() ?? 1,
                'fecha_aprobacion' => now()
            ]);

            // Movimientos de Inventario para cada detalle con producto
            foreach ($comprobante->detalles as $detalle) {
                if ($detalle->producto_id) {
                    $esIngreso = ($tipo->naturaleza === 'INGRESO');
                    
                    $this->inventarioService->registrarMovimiento([
                        'producto_id' => $detalle->producto_id,
                        'tipo_movimiento' => $esIngreso ? 'SALIDA' : 'ENTRADA',
                        'descripcion' => ($esIngreso ? 'Venta' : 'Compra') . ': ' . $comprobante->numero_completo,
                        'cantidad' => $detalle->cantidad,
                        'costo_unitario' => $detalle->precio_unitario, // En compras este es el costo
                        'referencia_tipo' => 'COMPROBANTE',
                        'referencia_id' => $comprobante->id,
                        'fecha' => $comprobante->fecha_emision
                    ]);
                }
            }

            return $comprobante;
        });
    }

    /**
     * Get the next number for the prefix.
     */
    private function getNextNumber($empresaId, $prefijo)
    {
        $last = Comprobante::where('empresa_id', $empresaId)
            ->where('prefijo', $prefijo)
            ->max('numero');

        return ($last ?? 0) + 1;
    }
}
