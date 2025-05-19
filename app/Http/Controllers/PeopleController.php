<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PeopleCollection;
use App\Http\Resources\PeopleResource;
use App\Http\Resources\PetResource;
use App\Models\Log;
use App\Repositories\PeopleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Personas",
 *     description="Endpoints para el CRUD de personas"
 * )
 */

class PeopleController extends Controller
{

    protected $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/people/all",
     *     summary="Listar todas las personas con paginación",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado paginado de personas",
     *         @OA\JsonContent(ref="#/components/schemas/PeopleCollection")
     *     )
     * )
     */

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

    /**
     * @OA\Post(
     *     path="/api/people",
     *     summary="Registrar una nueva persona",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","documento", "email", "phone","birthday"},
     *             @OA\Property(property="document", type="integer", example="123456789"),
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="phone", type="string", example="3101234567"),
     *             @OA\Property(property="birthday", type="string", format="date", example="1990-01-01")
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Persona creada",
     *         @OA\JsonContent(ref="#/components/schemas/PeopleResource")
     *     )
     * )
     */

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


    /**
     * @OA\Get(
     *     path="/api/people/{id}",
     *     summary="Mostrar los datos de una persona",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la persona",
     *         @OA\JsonContent(ref="#/components/schemas/PeopleResource")
     *     )
     * )
     */

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

    /**
     * @OA\Put(
     *     path="/api/people/{id}",
     *     summary="Actualizar datos de una persona",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","documento", "email", "phone","birthday"},
     *             @OA\Property(property="document", type="integer", example="123456789"),
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="phone", type="string", example="3101234567"),
     *             @OA\Property(property="birthday", type="string", format="date", example="1990-01-01")
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Persona actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/PeopleResource")
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/people/{id}",
     *     summary="Eliminar una persona",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Persona eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Persona eliminada correctamente")
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/api/people/pets/{id}",
     *     summary="Obtener una persona con sus mascotas",
     *     tags={"Personas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la persona",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información de la persona con sus mascotas",
     *         @OA\JsonContent(ref="#/components/schemas/PeopleWithPetsResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="info", type="string", example="Opss, no se pudieron obtener las mascotas de la persona"),
     *             @OA\Property(property="message", type="string", example="Detalles del error")
     *         )
     *     )
     * )
     */

    public function getPetsByPerson($id)
    {
        try {
            $person = $this->peopleRepository->pets($id);
            return new PeopleResource($person);
        } catch (\Exception $e) {
            $this->logError("Error al obtener mascotas de la persona", "people", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, no se pudieron obtener las mascotas de la persona',
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
