<?php

namespace App\Docs;

/**
 * @OA\Schema(
 *     schema="PeopleWithPetsResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="document", type="string", example="123456789"),
 *     @OA\Property(property="email", type="string", example="juan@example.com"),
 *     @OA\Property(property="phone", type="string", example="3101234567"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01 10:00:00"),
 *     @OA\Property(
 *         property="pets",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PetResource")
 *     )
 * )
 */
class PeopleWithPetsResourceDoc {}
