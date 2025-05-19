<?php

namespace App\Services\External\CatAPI\CatsInfo;

use App\Models\Log;
use App\Services\External\CatAPI\CatApiService;
use Carbon\Carbon;


class GetBreedInfoService
{
    protected $catApiService;


    public function __construct(CatApiService $catApiService)
    {
        $this->catApiService = $catApiService;
    }


    public function getRandomBreed()
    {
        try {
            $response = $this->catApiService->catApiRequest('GET', '/breeds');
            if (empty($response)) {
                return null;
            }
            return $response[array_rand($response)];

        } catch (\Exception $e) {
            $this->logError("Error en el metodo getRandomBreed para obtener informacion de TheCatAPI", "pets", $e->getMessage());
            return [
                'status' => 500,
                'info' => 'Opss, Error en el metodo getRandomBreed para obtener informacion de TheCatAPI',
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
