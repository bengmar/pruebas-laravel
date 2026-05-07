<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class QueriesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'nombre' => 'required|string|max:30',
            'email' => 'required|email',
            'asunto' => 'required',
            'mensaje' => 'required|string|min:10'
        ];
    }
    #[Override]
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'Se admiten 30 caracteres como máximo',
            'email.email' => 'Debe ingresar un correo válido',
            'email.required' => 'Se requiere un correo',
            'asunto.required'=> 'Debe elegir una opción',
            'mensaje.min' => 'Mensaje muy corto',
            'mensaje.required' => 'Debe escribir un mensaje'
        ];
    }
}
