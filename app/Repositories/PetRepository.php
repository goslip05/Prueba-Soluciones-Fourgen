<?php

namespace App\Repositories;

use App\Models\Pet;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\Interfaces\PetRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class PetRepository implements PetRepositoryInterface
{
    public function all(int $perPage = 10)
    {
        return Pet::paginate($perPage);
    }

    public function find($id)
    {
        return Pet::findOrFail($id);
    }

    public function create(array $data)
    {
        return Pet::create($data);
    }

    public function update($id, array $data)
    {
        $person = Pet::findOrFail($id);
        $person->update($data);
        return $person;
    }

    public function delete($id)
    {
        $person = Pet::findOrFail($id);
        $person->delete();
    }
}
