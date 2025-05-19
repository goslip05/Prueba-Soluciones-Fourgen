<?php

namespace App\Services\External\CatAPI\CatsInfo;

use App\Models\Log;
use App\Services\External\CatAPI\CatApiService;
use Carbon\Carbon;

class GetImageForBreedService
{
    protected $catApiService;


    public function __construct(CatApiService $catApiService)
    {
        $this->catApiService = $catApiService;
    }


    public function getBreedImage($breedId)
    {
        try {
            $queryParams = [
                'breed_id' => $breedId,
                'limit' => 1
            ];
            $response = $this->catApiService->catApiRequest('GET', '/images/search', $queryParams);

            return $response[0]['url'] ?? null;

        } catch (\Exception $e) {
            $this->logError("Error en el metodo getBreedImage para obtener informacion de TheCatAPI", "pets", $e->getMessage());
            return [
                'status' => 500,
                'info' => 'Opss, Error en el metodo getBreedImage para obtener informacion de TheCatAPI',
                'message' => $e->getMessage()
            ];
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
