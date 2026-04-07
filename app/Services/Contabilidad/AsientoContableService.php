<?php

namespace App\Services\Contabilidad;

use App\Models\AsientoContable;
use App\Models\DetalleAsiento;
use App\Models\PeriodoContable;
use Illuminate\Support\Facades\DB;
use Exception;

class AsientoContableService
{
    /**
     * Create a new Journal Entry with its details.
     */
    public function crearAsiento(array $data): AsientoContable
    {
        return DB::transaction(function () use ($data) {
            $this->validarPeriodo($data['periodo_contable_id'], $data['fecha_asiento']);
            $this->validarCuadre($data['detalles']);

            $ultimoNumero = AsientoContable::where('empresa_id', $data['empresa_id'])->count() + 1;
            $numeroAsiento = 'AS-' . date('Ym') . '-' . str_pad($ultimoNumero, 6, '0', STR_PAD_LEFT);

            // Create the main entry
            $asiento = AsientoContable::create([
                'empresa_id' => $data['empresa_id'],
                'numero_asiento' => $data['numero_asiento'] ?? $numeroAsiento,
                'periodo_contable_id' => $data['periodo_contable_id'],
                'fecha_asiento' => $data['fecha_asiento'],
                'concepto' => $data['concepto'],
                'glosa' => $data['glosa'] ?? null,
                'referencia' => $data['referencia'] ?? null,
                'documento_soporte' => $data['documento_soporte'] ?? null,
                'origen' => $data['origen'] ?? 'MANUAL',
                'estado' => $data['estado'] ?? 'BORRADOR',
                'creado_por' => auth()->id() ?? 1,
            ]);

            // Create details
            $totalDebe = 0;
            $totalHaber = 0;

            foreach ($data['detalles'] as $detalle) {
                $asiento->detalles()->create([
                    'cuenta_contable_id' => $detalle['cuenta_contable_id'],
                    'tercero_id' => $detalle['tercero_id'] ?? null,
                    'debe' => $detalle['debe'] ?? 0,
                    'haber' => $detalle['haber'] ?? 0,
                    'concepto' => $detalle['concepto'] ?? $data['concepto'],
                    'referencia' => $detalle['referencia'] ?? null,
                    'tipo_cambio' => $detalle['tipo_cambio'] ?? 1,
                    'tipo_movimiento' => $detalle['tipo_movimiento'] ?? 'NORMAL',
                    'afecta_base_impuesto' => $detalle['afecta_base_impuesto'] ?? false,
                    'base_imponible' => $detalle['base_imponible'] ?? 0,
                ]);

                $totalDebe += ($detalle['debe'] ?? 0);
                $totalHaber += ($detalle['haber'] ?? 0);
            }

            // Actualizar totales calculados
            $asiento->update([
                'total_debe' => $totalDebe,
                'total_haber' => $totalHaber,
                'diferencia' => $totalDebe - $totalHaber,
            ]);

            return $asiento->load('detalles');
        });
    }

    /**
     * Update an existing Journal Entry.
     */
    public function actualizarAsiento(AsientoContable $asiento, array $data): AsientoContable
    {
        if (!$asiento->puedeSerEditado()) {
            throw new Exception("El asiento no puede ser modificado en su estado actual o el periodo está cerrado.");
        }

        return DB::transaction(function () use ($asiento, $data) {
            if (isset($data['periodo_contable_id']) || isset($data['fecha_asiento'])) {
                $periodo = $data['periodo_contable_id'] ?? $asiento->periodo_contable_id;
                $fecha = $data['fecha_asiento'] ?? $asiento->fecha_asiento;
                $this->validarPeriodo($periodo, $fecha);
            }

            if (isset($data['detalles'])) {
                $this->validarCuadre($data['detalles']);
                
                // Recreamos los detalles para simplificar (estrategia de reemplazo)
                $asiento->detalles()->delete();
                
                $totalDebe = 0;
                $totalHaber = 0;
                
                foreach ($data['detalles'] as $detalle) {
                    $asiento->detalles()->create([
                        'cuenta_contable_id' => $detalle['cuenta_contable_id'],
                        'tercero_id' => $detalle['tercero_id'] ?? null,
                        'debe' => $detalle['debe'] ?? 0,
                        'haber' => $detalle['haber'] ?? 0,
                        'concepto' => $detalle['concepto'] ?? ($data['concepto'] ?? $asiento->concepto),
                        'referencia' => $detalle['referencia'] ?? null,
                        'tipo_cambio' => $detalle['tipo_cambio'] ?? 1,
                        'tipo_movimiento' => $detalle['tipo_movimiento'] ?? 'NORMAL',
                        'afecta_base_impuesto' => $detalle['afecta_base_impuesto'] ?? false,
                        'base_imponible' => $detalle['base_imponible'] ?? 0,
                    ]);

                    $totalDebe += ($detalle['debe'] ?? 0);
                    $totalHaber += ($detalle['haber'] ?? 0);
                }
                
                $asiento->total_debe = (float) $totalDebe;
                $asiento->total_haber = (float) $totalHaber;
                $asiento->diferencia = (float) ($totalDebe - $totalHaber);
            }

            $asiento->fill(array_diff_key($data, ['detalles' => true]));
            $asiento->save();

            return $asiento->load('detalles');
        });
    }

    /**
     * Approve a Journal Entry.
     */
    public function aprobarAsiento(AsientoContable $asiento, int $userId): AsientoContable
    {
        if (!$asiento->puedeSerAprobado()) {
            throw new Exception("El asiento no cumple con los requisitos para ser aprobado o el periodo está cerrado.");
        }

        $asiento->estado = 'APROBADO';
        $asiento->aprobado_por = $userId;
        $asiento->fecha_aprobacion = now();
        $asiento->save();

        return $asiento;
    }

    /**
     * Validate that period is open and date matches.
     */
    private function validarPeriodo(int $periodoId, string $fecha): void
    {
        $periodo = PeriodoContable::findOrFail($periodoId);

        if ($periodo->cerrado) {
            throw new Exception("El período contable seleccionado está cerrado.");
        }

        $fechaInicio = $periodo->fecha_inicio->toDateString();
        $fechaFin = $periodo->fecha_fin->toDateString();

        if ($fecha < $fechaInicio || $fecha > $fechaFin) {
            throw new Exception("La fecha del asiento ($fecha) no está dentro del período contable seleccionado ($fechaInicio a $fechaFin).");
        }
    }

    /**
     * Validate double-entry integrity from raw payload details array.
     */
    private function validarCuadre(array $detalles): void
    {
        $debe = 0;
        $haber = 0;

        foreach ($detalles as $detalle) {
            $d = floatval($detalle['debe'] ?? 0);
            $h = floatval($detalle['haber'] ?? 0);
            
            if ($d > 0 && $h > 0) {
                throw new Exception("Un mismo detalle no puede tener débito y crédito simultáneamente.");
            }

            $debe += $d;
            $haber += $h;
        }

        // Usar epsilon para comparación de flotantes
        if (abs($debe - $haber) > 0.001) {
            throw new Exception("El asiento contable no cuadra. Total Debe: $debe, Total Haber: $haber");
        }
    }
}
