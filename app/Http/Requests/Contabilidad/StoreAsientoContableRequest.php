<?php

namespace App\Http\Requests\Contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsientoContableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'periodo_contable_id' => 'required|exists:periodos_contables,id',
            'fecha_asiento' => 'required|date',
            'concepto' => 'required|string|max:1000',
            'glosa' => 'nullable|string',
            'referencia' => 'nullable|string|max:255',
            'documento_soporte' => 'nullable|string|max:255',
            'origen' => 'nullable|in:MANUAL,SISTEMA,COMPROBANTE',
            'estado' => 'nullable|in:BORRADOR,PENDIENTE',
            
            // Detalles rules
            'detalles' => 'required|array|min:2',
            'detalles.*.cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'detalles.*.tercero_id' => 'nullable|exists:terceros,id',
            'detalles.*.debe' => 'required_without:detalles.*.haber|numeric|min:0',
            'detalles.*.haber' => 'required_without:detalles.*.debe|numeric|min:0',
            'detalles.*.concepto' => 'nullable|string|max:1000',
            'detalles.*.referencia' => 'nullable|string|max:255',
            'detalles.*.tipo_cambio' => 'nullable|numeric|min:0.0001',
            'detalles.*.tipo_movimiento' => 'nullable|in:NORMAL,AJUSTE,CIERRE',
            'detalles.*.afecta_base_impuesto' => 'nullable|boolean',
            'detalles.*.base_imponible' => 'nullable|numeric|min:0',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $detalles = $this->input('detalles', []);
            if (is_array($detalles) && count($detalles) > 0) {
                $debe = 0;
                $haber = 0;
                foreach ($detalles as $index => $detalle) {
                    $d = floatval($detalle['debe'] ?? 0);
                    $h = floatval($detalle['haber'] ?? 0);

                    if ($d > 0 && $h > 0) {
                        $validator->errors()->add("detalles.{$index}", 'Un detalle no puede tener débito y crédito.' );
                    }
                    
                    $debe += $d;
                    $haber += $h;
                }
                
                if (abs($debe - $haber) > 0.001) {
                    $validator->errors()->add('detalles', "Total Debe ({$debe}) debe ser igual a Total Haber ({$haber}).");
                }
            }
        });
    }
}
