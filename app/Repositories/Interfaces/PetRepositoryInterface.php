<?php

namespace App\Repositories\Interfaces;

interface PetRepositoryInterface
{
    public function all(int $perPage = 10);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
