<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMissionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'drone_id' => ['required', 'integer', 'exists:drones,id'],
            'pilot_id' => ['required', 'integer', 'exists:pilots,id'],
            'wind_speed_avg' => ['nullable', 'numeric', 'min:0', 'max:200'],
            'status' => ['required', Rule::in(['success', 'failed', 'pending', 'in_progress'])],
            'flight_time_minutes' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la misión es obligatorio',
            'drone_id.required' => 'Debe seleccionar un dron',
            'drone_id.exists' => 'El dron seleccionado no existe',
            'pilot_id.required' => 'Debe seleccionar un piloto',
            'pilot_id.exists' => 'El piloto seleccionado no existe',
            'status.required' => 'El estado de la misión es obligatorio',
            'status.in' => 'El estado debe ser uno de: success, failed, pending, in_progress',
            'flight_time_minutes.required' => 'El tiempo de vuelo es obligatorio',
            'flight_time_minutes.integer' => 'El tiempo de vuelo debe ser un número entero',
            'flight_time_minutes.min' => 'El tiempo de vuelo no puede ser negativo',
        ];
    }
}
