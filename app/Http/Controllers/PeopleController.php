<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PeopleCollection;
use App\Http\Resources\PeopleResource;
use App\Models\Log;
use App\Repositories\PeopleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeopleController extends Controller
{

    protected $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function getPeople()
    {
        try {

            return new PeopleCollection($this->peopleRepository->all(10));
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para obtener todas la personas", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para obtener todas la personas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(RegisterPersonRequest $request)
    {
        try {
            //validar el request
            $data = $request->validated();

            $person = $this->peopleRepository->create($data);
            return (new PeopleResource($person))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para registrar una persona", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para para registrar una persona',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function show($id)
    {
        try {

            return new PeopleResource($this->peopleRepository->find($id));
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para obtner la información de una persona", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para obtner la información de una persona',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdatePersonRequest $request, $id)
    {
        try {
            //validar el request
            $data = $request->validated();

            $person = $this->peopleRepository->update($id, $data);
            return new PeopleResource($person);
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para actualizar una persona", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para actualizar una persona',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $this->peopleRepository->delete($id);
            return response()->json(['message' => 'Persona eliminada correctamente']);

        } catch (\Exception $e) {
            $this->logError("Error en el metodo para eliminar una persona", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para eliminar una persona',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logError($process, $table, $message)
    {
        return Log::insert([
            'process' => $process,
            'table' => $table,
            'message' => $message,
            'date' => Carbon::now('America/Bogota'),
        ]);
    }
}
