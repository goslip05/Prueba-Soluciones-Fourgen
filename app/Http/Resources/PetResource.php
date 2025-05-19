<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PetResource",
 *     
 *     @OA\Property(property="person_id", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="Gordon"),
 *     @OA\Property(property="species", type="string", example="Perro"),
 *     @OA\Property(property="breed", type="string", example="Labrador"),
 *     @OA\Property(property="age", type="integer", example=5),
 * 
 *     
 * )
 */
class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $person = $this->person ? $this->person->name : null;
        $personId = $this->person ? $this->person->id : null;

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'species'  => $this->species,
            'breed' => $this->breed,
            'age' => $this->age,
            'image' => $this->image,
            'created_at' => $this->created_at->toDateTimeString(),
            'person' => [
                'id' => $personId,
                'name' => $person,
            ],
        ];
    }
}
