<?php

namespace App\Http\Resources;

use App\Http\Resources\PetResource;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @OA\Schema(
 *     schema="PeopleResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="document", type="string", example="123456789"),
 *     @OA\Property(property="email", type="string", example="juan@example.com"),
 *     @OA\Property(property="phone", type="string", example="3101234567")
 * )
 */


class PeopleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'document'  => $this->document,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at->toDateTimeString(),
            'pets' => PetResource::collection($this->whenLoaded('petsOfPerson')),
        ];
    }
}
