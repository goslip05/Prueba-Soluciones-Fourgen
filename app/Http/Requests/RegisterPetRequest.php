<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterPetRequest extends FormRequest
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
            'person_id' => ['required','integer','exists:people,id'],
            'name' => ['required', 'string'],
            'species' => ['string'],
            'breed' => ['string'],
            'age' => ['required', 'integer'],
            'image' => ['string'],
        ];
    }

    public function messages()
    {
        return [
            'person_id.integer' => 'El id de la persona debe ser un numero',
            'person_id.required' => 'El id de la persona es obligatorio',
            'person_id.exists' => 'El id de la persona debe existir en la base de datos',
            'name' => 'El Nombre es obligatorio',
            'name.string' => 'El Nombre debe ser una cadena de texto',
            'species.string' => 'La especie debe ser una cadena de texto',
            'breed.string' => 'La raza debe ser una cadena de texto',
            'age.required' => 'La edad de la mascota es obligatorio',
            'age.integer' => 'El edad de la mascota  debe ser un numero',
            'image.string' => 'La imagen debe ser una cadena de texto',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
