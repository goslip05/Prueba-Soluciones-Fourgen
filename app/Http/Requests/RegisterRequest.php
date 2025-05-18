<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El Nombre es obligatorio',
            'name.string' => 'El Nombre debe ser una cadena de texto',
            'email.required' => 'El Email es obligatorio',
            'email.email' => 'El Email no es Valido',
            'email.unique' => 'El Email ya esta registrado',
            'password' => 'El Password debe contener al menos 8 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
