<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetCollection;
use App\Http\Resources\PetResource;
use App\Models\Log;
use App\Repositories\PetRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Mascotas",
 *     description="Endpoints para el CRUD de mascotas"
 * )
 */
class PetController extends Controller
{

    protected $petRepository;

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/pets",
     *     summary="Listar todas las mascotas con paginación",
     *     tags={"Mascotas"},
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
     *         description="Listado paginado de mascotas",
     *         @OA\JsonContent(ref="#/components/schemas/PetCollection")
     *     )
     * )
     */

    public function getPets()
    {
        try {

            return new PetCollection($this->petRepository->all(10));
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para obtener todas la mascotas", "pets", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para obtener todas la mascotas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/pets",
     *     summary="Registrar una nueva mascota",
     *     tags={"Mascotas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"person_id","name","species", "breed", "age","image"},
     *             @OA\Property(property="person_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Gordon"),
     *             @OA\Property(property="species", type="string", example="Perro"),
     *             @OA\Property(property="breed", type="string", example="Labrador"),
     *             @OA\Property(property="age", type="integer", example=5),
     *       
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mascota creada",
     *         @OA\JsonContent(ref="#/components/schemas/PetResource")
     *     )
     * )
     */

    public function store(RegisterPetRequest $request)
    {
        try {
            //validar el request
            $data = $request->validated();

            $person = $this->petRepository->create($data);
            return (new PetResource($person))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para registrar una mascota", "pets", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para para registrar una mascota',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/pets/{id}",
     *     summary="Mostrar los datos de una mascota",
     *     tags={"Mascotas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la mascota",
     *         @OA\JsonContent(ref="#/components/schemas/PetResource")
     *     )
     * )
     */

    public function show($id)
    {
        try {

            return new PetResource($this->petRepository->find($id));
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para obtner la información de una mascota", "pets", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para obtner la información de una mascota',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/pets/{id}",
     *     summary="Actualizar datos de una mascota",
     *     tags={"Mascotas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"person_id","name","species", "breed", "age","image"},
     *             @OA\Property(property="person_id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Gordon"),
     *             @OA\Property(property="species", type="string", example="Perro"),
     *             @OA\Property(property="breed", type="string", example="Labrador"),
     *             @OA\Property(property="age", type="integer", example=5),
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/PetResource")
     *     )
     * )
     */

    public function update(UpdatePetRequest $request, $id)
    {
        try {
            //validar el request
            $data = $request->validated();

            $person = $this->petRepository->update($id, $data);
            return new PetResource($person);
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para actualizar una mascota", "pets", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para actualizar una mascota',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/pets/{id}",
     *     summary="Eliminar una mascota",
     *     tags={"Mascotas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mascota eliminada correctamente")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        try {

            $this->petRepository->delete($id);
            return response()->json(['message' => 'Mascota eliminada correctamente']);
        } catch (\Exception $e) {
            $this->logError("Error en el metodo para eliminar una mascota", "pets", $e->getMessage());
            return response()->json([
                'status' => 500,
                'info' => 'Opss, Error en el metodo para eliminar una mascota',
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
