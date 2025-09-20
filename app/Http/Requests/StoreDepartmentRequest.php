<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:45|unique:departments,name',
            'parent_id' => 'nullable|exists:departments,id',
            'level' => 'nullable|integer|min:1',
            'employee_count' => 'nullable|integer|min:1',
            'ambassador_name' => 'nullable|string|max:255',
            'parent_department_id' => 'nullable|exists:departments,id',
            'ambassador_first_name' => 'nullable|string|max:255',
            'ambassador_last_name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del departamento es obligatorio',
            'name.unique' => 'Ya existe un departamento con ese nombre',
            'name.max' => 'El nombre no puede exceder los 45 caracteres',
            'parent_id.exists' => 'El departamento padre seleccionado no existe',
            'parent_department_id.exists' => 'El departamento padre seleccionado no existe',
            'level.min' => 'El nivel debe ser mayor a 0',
            'employee_count.min' => 'La cantidad de empleados debe ser mayor a 0',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('parent_department_id')) {
            $this->merge([
                'parent_id' => $this->parent_department_id
            ]);
        }

        if ($this->has('ambassador_first_name') && $this->has('ambassador_last_name')) {
            $this->merge([
                'ambassador_name' => trim($this->ambassador_first_name . ' ' . $this->ambassador_last_name)
            ]);
        } elseif ($this->has('ambassador_first_name')) {
            $this->merge([
                'ambassador_name' => $this->ambassador_first_name
            ]);
        }
    }
}