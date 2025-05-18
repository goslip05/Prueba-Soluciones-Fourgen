<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePersonRequest extends FormRequest
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
            'document' => ['required', 'integer'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'integer'],
            'birthday' => ['required', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El Nombre es obligatorio',
            'name.string' => 'El Nombre debe ser una cadena de texto',
            'email.required' => 'El Email es obligatorio',
            'email.email' => 'El Email no es Valido',
            'document.required' => 'El Documento es obligatorio',
            'document.integer' => 'El Documento  debe ser un numero',
            'phone.required' => 'El Telefono es obligatorio',
            'phone.integer' => 'El Telefono  debe ser un numero',
            'birthday.required' => 'El Telefono es obligatorio',
            'birthday.date' => 'El Telefono  debe ser un una fecha',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
