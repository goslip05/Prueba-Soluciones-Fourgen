<?php

namespace App\Repositories;

use App\Models\People;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\Interfaces\PeopleRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class PeopleRepository implements PeopleRepositoryInterface
{
    public function all(int $perPage = 10)
    {
        return People::paginate($perPage);
    }

    public function find($id)
    {
        return People::findOrFail($id);
    }

    public function create(array $data)
    {
        return People::create($data);
    }

    public function update($id, array $data)
    {
        $person = People::findOrFail($id);
        $person->update($data);
        return $person;
    }

    public function delete($id)
    {
        $person = People::findOrFail($id);
        $person->delete();
    }

    public function pets($id)
    {
        return People::with('petsOfPerson')->findOrFail($id);
    }
}
