<?php

namespace App\Services\Contabilidad;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Comprobante;
use App\Models\TipoComprobante;
use App\Services\Contabilidad\AsientoContableService;

class PagoService
{
    protected $asientoService;

    public function __construct(AsientoContableService $asientoService)
    {
        $this->asientoService = $asientoService;
    }

    /**
     * Record a payment against a voucher.
     */
    public function registrarPago(array $data)
    {
        return DB::transaction(function () use ($data) {
            $comprobante = Comprobante::with('tipoComprobante')->findOrFail($data['comprobante_id']);
            $monto = (float) $data['monto'];

            if ($monto > $comprobante->saldo_pendiente) {
                throw new \Exception("El monto del pago ($monto) no puede ser superior al saldo pendiente (" . $comprobante->saldo_pendiente . ")");
            }

            // 1. Obtener Periodo Contable para la fecha del pago
            $periodo = \App\Models\PeriodoContable::where('empresa_id', $comprobante->empresa_id)
                ->where('fecha_inicio', '<=', $data['fecha'])
                ->where('fecha_fin', '>=', $data['fecha'])
                ->first();
            
            if (!$periodo) {
                throw new \Exception("No existe un período contable configurado para la fecha del pago (" . $data['fecha'] . ")");
            }

            // 2. Crear el Asiento Contable del Pago
            $esIngreso = ($comprobante->tipoComprobante->naturaleza === 'INGRESO');
            
            $cuentaCarteraPasivoId = $data['cuenta_cartera_pasivo_id'] ?? null;
            if (!$cuentaCarteraPasivoId) {
                // Intentar obtener la cuenta del tipo de comprobante (contrapartida)
                $config = $comprobante->tipoComprobante->configuracion ?? [];
                $cuentaCarteraPasivoId = $config['cuenta_defecto_id'] ?? null;
            }

            if (!$cuentaCarteraPasivoId) {
                throw new \Exception("No se ha especificado la cuenta contable de cartera/pasivo.");
            }

            $asientoData = [
                'empresa_id' => $comprobante->empresa_id,
                'periodo_contable_id' => $periodo->id,
                'fecha_asiento' => $data['fecha'],
                'concepto' => 'Pago comprobante ' . $comprobante->numero_completo . ': ' . ($data['referencia'] ?? ''),
                'estado' => 'PENDIENTE',
                'detalles' => [
                    [
                        'cuenta_contable_id' => $data['cuenta_banco_caja_id'],
                        'tercero_id' => $comprobante->tercero_id,
                        'debe' => $esIngreso ? $monto : 0,
                        'haber' => $esIngreso ? 0 : $monto,
                        'descripcion' => 'Pago recibido/realizado'
                    ],
                    [
                        'cuenta_contable_id' => $cuentaCarteraPasivoId,
                        'tercero_id' => $comprobante->tercero_id,
                        'debe' => $esIngreso ? 0 : $monto,
                        'haber' => $esIngreso ? $monto : 0,
                        'descripcion' => 'Abono a saldo'
                    ]
                ]
            ];

            $asiento = $this->asientoService->crearAsiento($asientoData);
            $this->asientoService->aprobarAsiento($asiento, Auth::id() ?? 1);

            // 2. Registrar el Pago
            $pagoId = DB::table('pagos_comprobante')->insertGetId([
                'empresa_id' => $comprobante->empresa_id,
                'comprobante_id' => $comprobante->id,
                'fecha' => $data['fecha'],
                'monto' => $monto,
                'metodo_pago' => $data['metodo_pago'] ?? 'BANCO',
                'referencia' => $data['referencia'] ?? null,
                'cuenta_contable_id' => $data['cuenta_banco_caja_id'],
                'asiento_contable_id' => $asiento->id,
                'creado_por' => Auth::id() ?? 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 3. Actualizar Saldo del Comprobante
            $nuevoTotalPagado = $comprobante->total_pagado + $monto;
            $nuevoSaldo = $comprobante->total - $nuevoTotalPagado;
            
            $estadoPago = 'PENDIENTE';
            if ($nuevoSaldo <= 0) {
                $estadoPago = 'PAGADO';
            } elseif ($nuevoTotalPagado > 0) {
                $estadoPago = 'PARCIAL';
            }

            $comprobante->update([
                'total_pagado' => $nuevoTotalPagado,
                'saldo_pendiente' => $nuevoSaldo,
                'estado_pago' => $estadoPago,
                'estado' => ($estadoPago === 'PAGADO') ? 'PAGADO' : (($estadoPago === 'PARCIAL') ? 'PAGADO_PARCIAL' : $comprobante->estado)
            ]);

            return $pagoId;
        });
    }

    /**
     * Get pending debts to suppliers.
     */
    public function getDeudasPendientes($empresaId)
    {
        return Comprobante::with('tercero')
            ->where('empresa_id', $empresaId)
            ->where('saldo_pendiente', '>', 0)
            ->whereIn('estado', ['APROBADO', 'PAGADO_PARCIAL'])
            ->whereHas('tipoComprobante', function($q) {
                $q->where('naturaleza', 'EGRESO');
            })
            ->get();
    }
}
