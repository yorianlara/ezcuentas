<?php

namespace App\Http\Requests\Contabilidad;

use Illuminate\Foundation\Http\FormRequest;

class StoreComprobanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_comprobante_id' => 'required|exists:tipos_comprobante,id',
            'tercero_id' => 'required|exists:terceros,id',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_emision',
            'concepto' => 'required|string|max:500',
            'subtotal' => 'required|numeric|min:0',
            'total_impuestos' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'detalles' => 'required|array|min:1',
            'detalles.*.cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'detalles.*.descripcion' => 'required|string|max:255',
            'detalles.*.cantidad' => 'required|numeric|gt:0',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
            'detalles.*.subtotal' => 'required|numeric|min:0',
            'detalles.*.total' => 'required|numeric|min:0',
        ];
    }
}
