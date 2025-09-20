<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:45',
                Rule::unique('departments')->ignore($this->route('department'))
            ],
            'parent_id' => 'sometimes|nullable|exists:departments,id',
            'level' => 'sometimes|integer|min:1',
            'employee_count' => 'sometimes|integer|min:1',
            'ambassador_name' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ya existe un departamento con ese nombre',
            'name.max' => 'El nombre no puede exceder los 45 caracteres',
            'parent_id.exists' => 'El departamento padre seleccionado no existe',
            'level.min' => 'El nivel debe ser mayor a 0',
            'employee_count.min' => 'La cantidad de empleados debe ser mayor a 0',
        ];
    }
}