<?php

namespace App\Http\Requests\Contabilidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTerceroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empresaId = session('empresa_id') ?? request()->attributes->get('empresa_actual')?->id;
        $id = $this->route('id');

        return [
            'tipo' => ['required', Rule::in(['CLIENTE', 'PROVEEDOR', 'EMPLEADO', 'OTRO'])],
            'codigo' => [
                'nullable', 
                'string', 
                'max:50', 
                Rule::unique('terceros')->where('empresa_id', $empresaId)->ignore($id)
            ],
            'razon_social' => 'required|string|max:200',
            'nombre_comercial' => 'nullable|string|max:200',
            'tipo_documento' => 'required|string|max:10', // RIF, CI, etc.
            'numero_documento' => [
                'required', 
                'string', 
                'max:20', 
                Rule::unique('terceros')
                    ->where('empresa_id', $empresaId)
                    ->ignore($id)
            ],
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:500',
            'contribuyente' => 'boolean',
            'condicion_iva' => 'nullable|string|max:50',
            'activo' => 'boolean',
            'bloqueado' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'numero_documento.unique' => 'Este número de documento ya está registrado para otro tercero en esta empresa.',
            'codigo.unique' => 'Este código ya está asignado a otro tercero.',
            'tipo.in' => 'El tipo de tercero no es válido.',
        ];
    }
}
